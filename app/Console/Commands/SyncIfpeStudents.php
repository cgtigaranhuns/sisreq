<?php

namespace App\Console\Commands;

use App\Models\Discente;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncIfpeStudents extends Command
{
    protected $signature = 'ifpe:sync-students 
                            {--page=0 : Página inicial} 
                            {--size=50 : Quantidade por página} 
                            {--all : Sincronizar todas as páginas}
                            {--test : Testar conexão com a API}';

    protected $description = 'Sincroniza discentes com a API do IFPE (Spring Data format)';

    protected $apiBaseUrl = 'https://api.ifpe.edu.br/qacademico/';
    protected $apiToken = 'faBj4kkwVoJLsAnZOfAbwFvflyL5omG5';

    public function handle()
    {
        if ($this->option('test')) {
            return $this->testConnection();
        }

        return $this->syncData();
    }

    protected function testConnection()
    {
        $this->info('Testando conexão com a API...');

        $response = $this->makeApiRequest('students', ['page' => 0, 'size' => 1]);

        if ($response === null) {
            return 1;
        }

        $data = $response->json();
        
        $this->info('✅ Conexão bem-sucedida!');
        $this->line("Status: {$response->status()}");
        $this->line("Estrutura da resposta:");
        $this->line(json_encode(array_keys($data), JSON_PRETTY_PRINT));
        
        if (isset($data['content'])) {
            $this->line("\n📊 Estatísticas de paginação:");
            $this->line("- Página atual: ".($data['number'] ?? 'N/A'));
            $this->line("- Tamanho da página: ".($data['size'] ?? 'N/A'));
            $this->line("- Total de elementos: ".($data['totalElements'] ?? 'N/A'));
            $this->line("- Total de páginas: ".($data['totalPages'] ?? 'N/A'));
        }

        return 0;
    }

    protected function syncData()
    {
        $page = (int)$this->option('page');
        $size = (int)$this->option('size');
        $syncAll = $this->option('all');

        $this->info("Iniciando sincronização...");

        $totalCreated = 0;
        $totalUpdated = 0;
        $totalErrors = 0;
        $totalSkipped = 0;

        do {
            $this->info("📄 Página {$page} - Buscando {$size} registros...");

            $response = $this->makeApiRequest('students', [
                'page' => $page,
                'size' => $size
            ]);

            if ($response === null) {
                $this->error("Falha ao obter dados da página {$page}");
                break;
            }

            $responseData = $response->json();

            // Verifica se temos a estrutura Spring Data com content
            if (!isset($responseData['content']) || !is_array($responseData['content'])) {
                $this->error("Estrutura de dados inesperada na página {$page}");
                $this->line("Resposta completa: ".json_encode($responseData, JSON_PRETTY_PRINT));
                break;
            }

            $students = $responseData['content'];

            if (empty($students)) {
                $this->info("ℹ️ Nenhum dado encontrado na página {$page} - Fim dos dados");
                break;
            }

            $this->info("🔄 Processando ".count($students)." registros...");
            $bar = $this->output->createProgressBar(count($students));
            $bar->start();

            foreach ($students as $student) {
                try {
                    $result = $this->processStudent($student);
                    
                    if ($result === 'created') $totalCreated++;
                    elseif ($result === 'updated') $totalUpdated++;
                    else $totalSkipped++;
                    
                } catch (\Exception $e) {
                    Log::error("Erro ao processar estudante: ".$e->getMessage(), [
                        'student_data' => $student ?? null,
                        'error' => $e
                    ]);
                    $totalErrors++;
                }

                $bar->advance();
            }

            $bar->finish();
            $this->newLine();

            // Mostra estatísticas de paginação
            $this->line("📊 Estatísticas da página:");
            $this->line("- Total de elementos: ".($responseData['totalElements'] ?? 'N/A'));
            $this->line("- Páginas totais: ".($responseData['totalPages'] ?? 'N/A'));
            $this->line("- Última página: ".($responseData['last'] ? 'Sim' : 'Não'));

            if (!$syncAll || ($responseData['last'] ?? true)) {
                break;
            }

            $page++;
        } while (true);

        $this->info("\n🎉 Sincronização concluída!");
        $this->line("👉 Novos registros: {$totalCreated}");
        $this->line("🔄 Registros atualizados: {$totalUpdated}");
        $this->line("⏭️ Registros ignorados: {$totalSkipped}");
        $this->line("❌ Erros: {$totalErrors}");

        return $totalErrors > 0 ? 1 : 0;
    }

    protected function processStudent(array $studentData)
    {
        // Validação dos campos obrigatórios
        if (!isset($studentData['enrollment']) || empty($studentData['enrollment'])) {
            throw new \Exception("Matrícula não informada");
        }

        // Mapeamento seguro dos campos
        $data = [
            'nome' => $studentData['fullName'] ?? null,
            'email' => $studentData['email'] ?? null,
            'telefone' => $studentData['cellphone'] ?? null,
            'data_nascimento' => isset($studentData['birthday']) ? $this->parseDate($studentData['birthday']) : null,
            'cpf' => $studentData['brCPF'] ?? null,
            'rg' => $studentData['brRG'] ?? null,
            'campus' => $studentData['campusName'] ?? null,
            'curso' => $studentData['courseName'] ?? null,
            'situacao' => $studentData['enrollmentStatus'] ?? null,
            'periodo' => $studentData['currentPeriod'] ?? null,
            'turno' => $studentData['shift'] ?? null,
        ];

        // Remove valores nulos
        $data = array_filter($data, function($value) {
            return $value !== null;
        });

        $discente = Discente::updateOrCreate(
            ['matricula' => $studentData['enrollment']],
            $data
        );

        return $discente->wasRecentlyCreated ? 'created' : 'updated';
    }

    protected function makeApiRequest($endpoint, $params = [])
    {
        try {
            $response = Http::withOptions([
                'verify' => false, // SSL apenas para desenvolvimento
                'timeout' => 30,
            ])->withHeaders([
                'Authorization' => $this->apiToken,
                'Accept' => 'application/json',
            ])->get($this->apiBaseUrl.$endpoint, $params);

            if (!$response->successful()) {
                $this->handleApiError($response);
                return null;
            }

            return $response;
        } catch (\Exception $e) {
            $this->error("Erro na requisição: ".$e->getMessage());
            return null;
        }
    }

    protected function handleApiError($response)
    {
        $status = $response->status();
        $this->error("Erro na API: {$status}");

        $body = $response->body();
        $this->line("Resposta: ".(strlen($body) > 200 ? substr($body, 0, 200).'...' : $body));
    }

    protected function parseDate($dateString)
    {
        try {
            return \Carbon\Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::warning("Erro ao analisar data: {$dateString}");
            return null;
        }
    }
}