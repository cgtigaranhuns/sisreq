@php
$anexos = $this->form->getRawState()['_anexos'] ?? [];
@endphp

<style>
.fi-ta {
    width: 100%;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    margin-bottom: 1.5rem;
    padding: 1rem;
    /* adiciona espaço interno */
    background-color: white;
    /* fundo branco igual ao Filament */
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
    /* hover suave */
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
                            <a href="{{ asset('storage/' . $anexo['caminho']) }}" target="_blank"
                                class="text-primary-600 hover:text-primary-700">
                                <x-heroicon-s-eye class="w-6 h-6" />
                            </a>
                            <a href="{{ asset('storage/' . $anexo['caminho']) }}" download
                                class="text-green-600 hover:text-green-700">
                                <x-heroicon-s-arrow-down-tray class="w-6 h-6" />
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif