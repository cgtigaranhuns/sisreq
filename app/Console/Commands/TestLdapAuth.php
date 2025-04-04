<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use LdapRecord\Container;
use LdapRecord\Connection;
use LdapRecord\Models\Entry;

class TestLdapAuth extends Command
{
    protected $signature = 'ldap:testauth {username} {password} {connection=adm}';
    protected $description = 'Test LDAP authentication';

    public function handle()
    {
        $username = $this->argument('username');
        $password = $this->argument('password');
        $connectionName = $this->argument('connection'); // Renomeado para evitar confusão

        $this->info("Testing LDAP authentication for user: $username on connection: $connectionName");

        try {
            // 1. Obtém a conexão LDAP configurada (não uma string)
            $ldapConnection = Container::getConnection($connectionName);
            
            // 2. Define a base DN (domínio principal)
            $baseDn = "dc=" . str_replace('default', 'adm', $connectionName) . ",dc=garanhuns,dc=ifpe";
            
            // 3. Busca o usuário em todas as OUs possíveis
            $user = Entry::query()
                ->setConnection($ldapConnection) // Agora passa o objeto Connection, não uma string
                ->in($baseDn)
                ->where('cn', '=', $username)
                ->first();
            
            if (!$user) {
                $this->error('Usuário não encontrado no LDAP.');
                return;
            }
            
            // 4. Tenta autenticar com o DN encontrado
            $result = $ldapConnection->auth()->attempt($user->getDn(), $password);
            
            if ($result) {
                $this->info('Autenticação bem-sucedida!');
            } else {
                $this->error('Falha na autenticação. Senha incorreta?');
            }
        } catch (\Exception $e) {
            $this->error('Erro LDAP: ' . $e->getMessage());
        }

        return 0;
    }
}