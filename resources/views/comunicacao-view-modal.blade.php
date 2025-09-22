<div class="space-y-6">
    <!-- Cabeçalho com Informações Principais -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Informações da Comunicação -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-3">Informações da Comunicação</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="text-sm text-gray-900">#{{ $comunicacao->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Data/Hora</dt>
                    <dd class="text-sm text-gray-900">{{ $comunicacao->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Enviado por</dt>
                    <dd class="text-sm text-gray-900">{{ $comunicacao->user->name ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>



        <!-- Status do Requerimento -->
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-3">Status do Requerimento</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status Atual</dt>
                    <dd class="text-sm">
                        @php
                        $status = $comunicacao->requerimento->status ?? 'pendente';
                        $statusColors = [
                        'pendente' => 'bg-red-100 text-red-800',
                        'em_analise' => 'bg-yellow-100 text-yellow-800',
                        'finalizado' => 'bg-green-100 text-green-800'
                        ];
                        @endphp
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ match($status) {
                                'pendente' => 'Pendente',
                                'em_analise' => 'Em Análise',
                                'finalizado' => 'Finalizado',
                                default => $status
                            } }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Discente</dt>
                    <dd class="text-sm text-gray-900">{{ $comunicacao->requerimento->discente->nome ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Matrícula</dt>
                    <dd class="text-sm text-gray-900">{{ $comunicacao->requerimento->discente->matricula ?? 'N/A' }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Mensagem Principal -->
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="font-semibold text-gray-700">Mensagem</h3>
        </div>
        <div class="p-6">
            @if($comunicacao->mensagem)
            <div class="prose max-w-none bg-white p-4 rounded border">
                {!! nl2br(e($comunicacao->mensagem)) !!}
            </div>
            @else
            <p class="text-gray-500 italic">Nenhuma mensagem fornecida.</p>
            @endif
        </div>
    </div>

    <!-- Anexos -->
    @if($comunicacao->anexos_count > 0)
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="font-semibold text-gray-700">Anexos ({{ $comunicacao->anexos_count }})</h3>
        </div>
        <div class="p-4">
            <div class="space-y-3">
                @foreach($comunicacao->anexos as $anexo)
                <div class="flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg border">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            @if(str($anexo->mime_type)->contains('image'))
                            <x-heroicon-o-photo class="w-6 h-6 text-blue-500" />
                            @elseif(str($anexo->mime_type)->contains('pdf'))
                            <x-heroicon-o-document-text class="w-6 h-6 text-red-500" />
                            @else
                            <x-heroicon-o-document class="w-6 h-6 text-gray-500" />
                            @endif
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700">{{ $anexo->nome_original }}</span>
                            <p class="text-xs text-gray-500">{{ $anexo->mime_type }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ asset('storage/' . $anexo->caminho) }}" target="_blank"
                            class="text-primary-600 hover:text-primary-700 text-sm font-medium px-3 py-1 border border-primary-600 rounded hover:bg-primary-50 transition-colors">
                            Visualizar
                        </a>
                        <a href="{{ asset('storage/' . $anexo->caminho) }}" download
                            class="text-green-600 hover:text-green-700 text-sm font-medium px-3 py-1 border border-green-600 rounded hover:bg-green-50 transition-colors">
                            Download
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Observações ou Resposta -->
    @if($comunicacao->observacoes || $comunicacao->resposta)
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
            <h3 class="font-semibold text-gray-700">
                {{ $comunicacao->resposta ? 'Resposta' : 'Observações' }}
            </h3>
        </div>
        <div class="p-6">
            <div class="prose max-w-none bg-gray-50 p-4 rounded border">
                {!! nl2br(e($comunicacao->resposta ?? $comunicacao->observacoes)) !!}
            </div>

            @if($comunicacao->resposta_em && $comunicacao->resposta_por)
            <div class="mt-3 text-xs text-gray-500">
                Respondido por: {{ $comunicacao->resposta_por }} em {{ $comunicacao->resposta_em->format('d/m/Y H:i') }}
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<style>
.prose {
    line-height: 1.6;
    color: #374151;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.prose p {
    margin-bottom: 1em;
}
</style>