@if ($destinatario === 'admin')
<h2>📄 Status do Requerimento Atualizado</h2>
<p>O requerimento do discente <strong>{{ $discente->nome }}</strong> (Matrícula: {{ $discente->matricula }}) foi
    atualizado:</p>
<ul>
    <li><strong>Novo Status:</strong> {{ $requerimento->status }}</li>
    <li><strong>Protocolo:</strong> #{{ $requerimento->id }}</li>
    <li><strong>Acompanhamento:</strong> {{ $acompanhamento->descricao ?? 'N/A' }}</li>
    <li><strong>Data:</strong> {{ $requerimento->updated_at->format('d/m/Y H:i') }}</li>
</ul>
@else
<h2>Olá, {{ $discente->nome }}! 👋</h2>
<p>O status do seu requerimento foi atualizado:</p>
<ul>
    <li><strong>Acompanhamento:</strong> {{ $acompanhamento->descricao ?? 'N/A' }}</li>
    <li><strong>Status:</strong> {{ $requerimento->status }}</li>
    <li><strong>Protocolo:</strong> #{{ $requerimento->id }}</li>
</ul>
<p>Dúvidas? Entre em contato conosco.</p>
@endif