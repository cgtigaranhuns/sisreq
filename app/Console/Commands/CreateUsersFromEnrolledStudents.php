<?php

namespace App\Console\Commands;

use App\Models\Discente;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Models\Role; // Adicione esta linha

class CreateUsersFromEnrolledStudents extends Command
{
    protected $signature = 'users:create-from-enrolled 
                            {--limit=0 : Limite de registros a processar (0 para todos)}
                            {--dry-run : Apenas simular, não criar usuários}';

    protected $description = 'Cria usuários para discentes matriculados';

    public function handle()
    {
        $limit = (int)$this->option('limit');
        $dryRun = $this->option('dry-run');

        $this->info("Iniciando processo de criação de usuários...");
        $this->line("Filtro: Situação = Matriculado");
        $this->line("Modo simulação: " . ($dryRun ? 'ATIVADO' : 'desativado'));
        $this->line("Limite: " . ($limit > 0 ? $limit : 'Todos'));
        $this->newLine();

        // Consulta os discentes matriculados
        $query = Discente::where('situacao', '!=', Null)
                    ->orderBy('nome');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $students = $query->get();

        if ($students->isEmpty()) {
            $this->warn("Nenhum discente matriculado encontrado!");
            return 0;
        }

        $this->info("📊 Total de discentes matriculados encontrados: " . $students->count());
        $this->newLine();

        $bar = $this->output->createProgressBar($students->count());
        $bar->start();

        $created = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($students as $student) {
            try {
                // Verifica se já existe um usuário com esta matrícula ou email
                $existingUser = User::where('matricula', $student->matricula)
                    ->orWhere('email', $student->email)
                    ->first();
        
                if ($existingUser) {
                    $bar->advance();
                    $skipped++;
                    continue;
                }
        
                // Determina o status baseado na situação
                $status = ($student->situacao === 'Matriculado') ? '1' : '0';
        
                // Criação do usuário
                if (!$dryRun) {
                    $password = Str::random(12);
                
                    $user = User::create([
                        'nome' => $student->nome,
                        'matricula' => $student->matricula,
                        'email' => $student->email ?? ($student->matricula . '@garanhuns.ifpe'),
                        'password' => Hash::make($password),
                        'status' => $status,
                    ]);
                
                    try {
                        // Verifica se o trait HasRoles está no modelo User
                        if (method_exists($user, 'assignRole')) {
                            $discenteRole = Role::firstOrCreate([
                                'name' => 'Discente',
                                'guard_name' => 'web' // Adicione esta linha
                            ]);
                            
                            $user->assignRole($discenteRole);
                            
                            $this->info("Role 'Discente' atribuída ao usuário {$user->matricula}");
                        } else {
                            Log::error("Trait HasRoles não está presente no modelo User");
                            throw new \Exception("Trait HasRoles não está presente no modelo User");
                        }
                    } catch (\Exception $e) {
                        Log::error("Erro ao atribuir role: " . $e->getMessage(), [
                            'matricula' => $student->matricula,
                            'error' => $e
                        ]);
                        $errors++;
                    }
                }
        
                $created++;
            } catch (\Exception $e) {
                Log::error("Erro ao criar usuário para discente: " . $e->getMessage(), [
                    'matricula' => $student->matricula,
                    'error' => $e
                ]);
                $errors++;
            }
        
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("✅ Processo concluído!");
        $this->line("👉 Usuários criados: " . $created);
        $this->line("⏭️ Usuários existentes (ignorados): " . $skipped);
        $this->line("❌ Erros: " . $errors);

        if ($dryRun) {
            $this->newLine();
            $this->warn("ATENÇÃO: Modo simulação ativado - nenhum usuário foi criado realmente");
        }

        return $errors > 0 ? 1 : 0;
    }
}