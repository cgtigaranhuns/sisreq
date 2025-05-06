@if ($destinatario === 'admin')
{{-- Conteúdo para o ADMIN --}}
<h2>Novo Requerimento Registrado</h2>
<p><strong>Discente:</strong> {{ $discente->nome }} ({{ $discente->matricula }})</p>
<p><strong>Tipo:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}</p>
<p><strong>Observações:</strong> {{ $requerimento->observacoes ?? 'N/A' }}</p>
<p><strong>Informações complementares:</strong> {{ $requerimento->infor_complements->descricao ?? 'N/A' }}</p>
<p><strong>Status:</strong> {{ $requerimento->status }}</p>
<p><strong>Data:</strong> {{ $requerimento->created_at->format('d/m/Y H:i') }}</p>
@else
{{-- Conteúdo para o DISCENTE --}}
<h2>Olá, {{ $discente->nome }}!</h2>
<p>Seu requerimento foi registrado com sucesso:</p>
<ul>
    <li><strong>Tipo:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}</li>
    <li><strong>Observações:</strong> {{ $requerimento->observacoes ?? 'N/A' }}</li>
    <li><strong>Informações complementares:</strong> {{ $requerimento->infor_complements->descricao ?? 'N/A' }}</li>
    <li><strong>Status:</strong> {{ $requerimento->status }}</li>
    <li><strong>Protocolo:</strong> #{{ $requerimento->id }}</li>
</ul>
<p>Acompanhe atualizações pelo sistema.</p>
@endif