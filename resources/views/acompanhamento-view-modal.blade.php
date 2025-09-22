<div class="space-y-6">
    <!-- Informações Básicas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-2">Informações do Acompanhamento</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">ID</dt>
                    <dd class="text-sm text-gray-900">#{{ $acompanhamento->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Data do Registro</dt>
                    <dd class="text-sm text-gray-900">{{ $acompanhamento->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Registrado por</dt>
                    <dd class="text-sm text-gray-900">{{ $acompanhamento->user->name ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Finalizado</dt>
                    <dd class="text-sm">
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $acompanhamento->finalizador ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $acompanhamento->finalizador ? 'Sim' : 'Não' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-gray-50 p-4 rounded-lg">
            <h3 class="font-semibold text-gray-700 mb-2">Status do Requerimento</h3>
            <dl class="space-y-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Requerimento #</dt>
                    <dd class="text-sm text-gray-900">#{{ $acompanhamento->requerimento->id ?? 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Status Atual</dt>
                    <dd class="text-sm">
                        @php
                        $status = $acompanhamento->requerimento->status ?? 'pendente';
                        $colors = [
                        'pendente' => 'bg-red-100 text-red-800',
                        'em_analise' => 'bg-yellow-100 text-yellow-800',
                        'finalizado' => 'bg-green-100 text-green-800'
                        ];
                        @endphp
                        <span
                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $colors[$status] ?? 'bg-gray-100 text-gray-800' }}">
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
                    <dt class="text-sm font-medium text-gray-500">Quantidade de Anexos</dt>
                    <dd class="text-sm text-gray-900">{{ $acompanhamento->anexos_count ?? 0 }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Descrição Completa -->
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <h3 class="font-semibold text-gray-700">Descrição do Acompanhamento</h3>
        </div>
        <div class="p-4">
            @if($acompanhamento->descricao)
            <div class="prose max-w-none">
                {!! nl2br(e($acompanhamento->descricao)) !!}
            </div>
            @else
            <p class="text-gray-500 italic">Nenhuma descrição fornecida.</p>
            @endif
        </div>
    </div>

    <!-- Anexos Rápidos -->
    @if($acompanhamento->anexos_count > 0)
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <h3 class="font-semibold text-gray-700">Anexos ({{ $acompanhamento->anexos_count }})</h3>
        </div>
        <div class="p-4">
            <div class="space-y-2">
                @foreach($acompanhamento->anexos as $anexo)
                <div class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded">
                    <div class="flex items-center space-x-3">
                        <x-heroicon-o-document class="w-5 h-5 text-gray-400" />
                        <span class="text-sm text-gray-700">{{ $anexo->nome_original }}</span>
                    </div>
                    <a href="{{ asset('storage/' . $anexo->caminho) }}" target="_blank"
                        class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        Visualizar
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Observações Adicionais -->
    @if($acompanhamento->observacoes)
    <div class="bg-white border border-gray-200 rounded-lg">
        <div class="px-4 py-3 border-b border-gray-200">
            <h3 class="font-semibold text-gray-700">Observações Adicionais</h3>
        </div>
        <div class="p-4">
            <div class="prose max-w-none">
                {!! nl2br(e($acompanhamento->observacoes)) !!}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.prose {
    line-height: 1.6;
    color: #374151;
}

.prose p {
    margin-bottom: 1em;
}
</style>