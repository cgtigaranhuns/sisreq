<?php

namespace App\Providers;

use Illuminate\Support\Str;
use App\Models\AdmUser;
use App\Models\LabsUser;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use LdapRecord\Laravel\Auth\LdapAuthenticatable;
use LdapRecord\Laravel\Auth\AuthenticatesWithLdap;

class MultiLdapUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        $user = User::find($identifier);
        
        // Verifica o status do usuário
        if ($user && $user->status != 1) {
            \Log::warning("Tentativa de login com usuário inativo", ['user_id' => $identifier]);
            return null;
        }
        
        return $user;
    }

    public function retrieveByToken($identifier, $token)
    {
        $user = User::where('id', $identifier)->first();
        
        // Verifica o status do usuário
        if ($user && $user->status != 1) {
            \Log::warning("Tentativa de login com usuário inativo via remember token", ['user_id' => $identifier]);
            return null;
        }
        
        return $user && $user->getRememberToken() && hash_equals($user->getRememberToken(), $token)
            ? $user : null;
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials['matricula']) || empty($credentials['password'])) {
            return null;
        }
    
        // Obtém a conexão selecionada no formulário (padrão: 'adm')
        $connection = $credentials['connection'] ?? 'adm';
        
        \Log::debug("Tentando autenticar na conexão: " . $connection);
    
        // Busca o usuário na conexão especificada
        $ldapUser = $this->findLdapUser($credentials['matricula'], $connection);
        
        if (!$ldapUser) {
            \Log::debug("Usuário não encontrado na conexão: " . $connection);
            return null;
        }
    
        return $this->getOrCreateLocalUser($ldapUser, $credentials);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if (!$user instanceof LdapAuthenticatable) {
            return false;
        }
    
        // Verifica o status do usuário local
        if ($user->status != 1) {
            \Log::warning("Tentativa de login com usuário local inativo", ['matricula' => $credentials['matricula']]);
            return false;
        }
    
        // Usa a conexão especificada no formulário
        $connection = $credentials['connection'] ?? 'adm';
        
        return $this->authenticateInLdap($user, $credentials, $connection);
    }

    protected function findLdapUser($matricula, $connection)
    {
        \Log::info("Iniciando busca LDAP", [
            'matricula' => $matricula,
            'base' => $connection
        ]);
        if ($connection === 'adm') {
            $model = AdmUser::class;
            $baseDn = 'cn=Users,dc=adm,dc=garanhuns,dc=ifpe';
            $query = $model::query()
                ->in($baseDn)
                ->where('samaccountname', '=', $matricula);
                $user = $query->first();

            if ($user) {
                \Log::info("Usuário encontrado", [
                    'dn' => $user->getDn(),
                    'base' => $connection
                ]);
                return $user;
            }

        } else {
            $model = LabsUser::class;
            $baseDn = 'ou=Discentes,dc=labs,dc=garanhuns,dc=ifpe';
            \Log::debug("Buscando usuário na conexão: {$connection}");
            $query = (new $model)->on($connection); // Cria instância com conexão correta
        
            $query2 = $query->where('samaccountname', '=', $matricula)
                        ->in($baseDn);
                        $user = $query2->first();
                      //   ->orWhere('userprincipalname', '=', $username);
              
            if ($user) {
                \Log::info("Usuário encontrado", [
                    'dn' => $user->getDn(),
                    'base' => $connection
                ]);
                return $user;
            }
        } 
       
    }
        
    protected function authenticateInLdap($user, $credentials, $connection)
    {
        \Log::info("Iniciando autenticação LDAP", [
            'matricula' => $credentials['matricula'],
            'connection' => $connection
        ]);

        $ldapUser = $this->findLdapUser($credentials['matricula'], $connection);
        
        if (!$ldapUser) {
            \Log::warning("Usuário LDAP não encontrado");
            return false;
        }

        \Log::debug("Tentando autenticar com DN", ['dn' => $ldapUser->getDn()]);
        $result = $ldapUser->getConnection()->auth()->attempt(
            $ldapUser->getDn(),
            $credentials['password']
        );

        \Log::info("Resultado da autenticação", ['sucesso' => $result]);
        return $result;
    }

    protected function getOrCreateLocalUser($ldapUser, $credentials)
    {
        \Log::info("Processando usuário local", [
            'matricula' => $credentials['matricula'],
            'email' => $ldapUser->getFirstAttribute('mail')
        ]);

        $user = User::where('email', $ldapUser->getFirstAttribute('mail'))
            ->orWhere('matricula', $credentials['matricula'])
            ->first();
            
        if ($user) {
            \Log::debug("Usuário local existente encontrado", ['id' => $user->id]);
            
            // Verifica o status do usuário
            if ($user->status != 1) {
                \Log::warning("Usuário local encontrado mas está inativo", ['id' => $user->id]);
                return null;
            }
            
            // Atualiza os dados do usuário existente com as informações do LDAP
            $updated = false;
            
            if ($user->nome !== $ldapUser->getFirstAttribute('description')) {
                $user->nome = $ldapUser->getFirstAttribute('description');
                $updated = true;
            }
            
            $ldapEmail = $ldapUser->getFirstAttribute('mail') ?? $credentials['matricula'] . '@garanhuns.ifpe';
            if ($user->email !== $ldapEmail) {
                $user->email = $ldapEmail;
                $updated = true;
            }
            
            if ($user->matricula !== $credentials['matricula']) {
                $user->matricula = $credentials['matricula'];
                $updated = true;
            }
            
            if ($updated) {
                $user->save();
                \Log::info("Dados do usuário atualizados", ['id' => $user->id]);
            } else {
                \Log::debug("Nenhuma alteração necessária nos dados do usuário", ['id' => $user->id]);
            }
            
            return $user;
        }
        
        \Log::info("Criando novo usuário local");
        $newUser = new User();
        $newUser->nome = $ldapUser->getFirstAttribute('description');
        $newUser->email = $ldapUser->getFirstAttribute('mail') ?? $credentials['matricula'] . '@garanhuns.ifpe';
        $newUser->matricula = $credentials['matricula'];
        $newUser->password = bcrypt(Str::random(16));
        $newUser->status = 1; // Define como ativo por padrão
        $newUser->save();
        
        \Log::info("Novo usuário criado com sucesso", ['id' => $newUser->id]);
        return $newUser;
    }
}