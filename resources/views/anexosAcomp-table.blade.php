<div x-data="{ open: false, fileUrl: '' }">
    <style>
    .fi-ta {
        width: 100%;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        margin-bottom: 1.5rem;
        padding: 1rem;
        background-color: white;
    }

    .fi-ta table {
        width: 100%;
        border-collapse: collapse;
    }

    .fi-ta th,
    .fi-ta td {
        text-align: left;
        padding: 0.75rem 1rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .fi-ta th {
        background-color: #f9fafb;
        font-weight: 500;
        color: #374151;
    }

    .fi-ta tr:hover {
        background-color: #f3f4f6;
    }

    .fi-ta a {
        text-decoration: none;
        font-weight: 400;
        padding: 0.25rem;
        border-radius: 0.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .fi-ta a:hover {
        background-color: #e0e7ff;
    }
    </style>

    @if(!empty($anexos))
    <div class="fi-ta">
        <div class="overflow-x-auto w-full">
            <table class="w-full">
                <thead>
                    <tr>
                        <th>Anexo(s)</th>
                        <th>Tamanho</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($anexos as $anexo)
                    <tr>
                        <td>{{ $anexo['nome_original'] }}</td>
                        <td>{{ round(filesize(storage_path('app/public/' . $anexo['caminho'])) / 1024, 2) }} KB</td>
                        <td class="text-center">
                            <div class="flex justify-center space-x-2">
                                <!-- Botão Visualizar -->
                                <button type="button"
                                    @click="fileUrl = '{{ asset('storage/' . $anexo['caminho']) }}'; open = true"
                                    class="text-primary-600 hover:text-primary-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <!-- Botão Download -->
                                <a href="{{ asset('storage/' . $anexo['caminho']) }}" download
                                    class="text-green-600 hover:text-green-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Visualização - Altura Aumentada -->
    <div x-show="open" style="display: none;"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[999] p-4" x-transition>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-4xl w-full flex flex-col" style="height: 85vh;">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Visualizar Anexo</h2>
                <button @click="open = false" class="text-gray-500 hover:text-gray-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Área de Conteúdo -->
            <div class="flex-1 overflow-hidden bg-gray-50">
                <iframe :src="fileUrl" class="w-full h-full border-0" style="min-height: calc(85vh - 64px);"></iframe>
            </div>

            <!-- Rodapé -->
            <div class="flex justify-end items-center p-3 border-t bg-white">
                <a :href="fileUrl" download
                    class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download
                </a>
                <button @click="open = false"
                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                    Fechar
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="p-4 text-center text-gray-500">
        Nenhum anexo encontrado para este acompanhamento.
    </div>
    @endif
</div>