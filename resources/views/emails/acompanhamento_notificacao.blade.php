@if ($destinatario === 'admin')
<h2>📋 {{ $assuntoBase }} - Requerimento #{{ $requerimento->id }}</h2>
@else
<h2>Olá, {{ $discente->nome }}!</h2>
@endif

{{-- DEBUG TEMPORÁRIO --}}
{{-- @dump($anexos) --}}

@if(isset($anexos) && $anexos->isNotEmpty())
<p><strong>Anexos:</strong></p>
<ul>
    @foreach($anexos as $anexo)
    <li>
        {{ $anexo->nome_original }} ({{ $anexo->tamanho }} bytes) —
        <a href="{{ asset('storage/' . $anexo->caminho) }}" target="_blank">Visualizar</a>
    </li>
    @endforeach
</ul>
@else
<p><em>Nenhum anexo disponível.</em></p>
@endif