<?php

namespace App\Console\Commands;

use App\Models\Discente;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
        $query = Discente::where('situacao', 'Matriculado')
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

                // Criação do usuário
                if (!$dryRun) {
                    $password = Str::random(12); // Gera senha aleatória

                    User::create([
                        'nome' => $student->nome,
                        'matricula' => $student->matricula,
                        'email' => $student->email ?? ($student->matricula . '@garanhuns.ifpe'),
                        'password' => Hash::make($password),
                        'status' => '1',
                    ]);

                    // Log da criação (em produção, você pode querer enviar por email)
                    Log::info("Usuário criado para discente", [
                        'matricula' => $student->matricula,
                        'email' => $student->email,
                        'password' => '********' // Nunca logue senhas reais
                    ]);
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