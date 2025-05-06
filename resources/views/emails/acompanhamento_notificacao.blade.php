@if ($destinatario === 'admin')
<h2>📋 {{ $assuntoBase }} - Requerimento #{{ $requerimento->id }}</h2>
<p><strong>Discente:</strong> {{ $discente->nome }} ({{ $discente->matricula }})</p>
<p><strong>Tipo do Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao }}</p>
<p><strong>Data:</strong> {{ $requerimento->created_at->format('d/m/Y H:i') }}</p>
<p><strong>Status:</strong> {{ ucfirst($requerimento->status) }}</p>
<p><strong>Acompanhamento:</strong> {{ $acompanhamento->descricao }}</p>
<p><strong>Responsável:</strong> {{ $acompanhamento->user->name ?? 'Sistema' }}</p>
@else
<h2>Olá, {{ $discente->nome }}!</h2>
<p>{{ $assuntoBase }} para seu requerimento #{{ $requerimento->id }}:</p>
<ul>
    <li><strong>Status atual:</strong> {{ ucfirst($requerimento->status) }}</li>
    <li><strong>Tipo do Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao }}</li>
    <li><strong>Acompanhamento:</strong> {{ $acompanhamento->descricao }}</li>
    <li><strong>Responsável:</strong> {{ $acompanhamento->user->name ?? 'Sistema' }}</li>
</ul>
<p>Atenciosamente,<br>Equipe {{ config('app.name') }}</p><br>
<p>Dúvidas? Entre em contato conosco.</p>
@endif