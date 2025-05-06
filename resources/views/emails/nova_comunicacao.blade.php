<h2>Olá, {{ $discente->nome }}!</h2>

<p>Você recebeu uma nova comunicação sobre seu requerimento <strong>#{{ $comunicacao->requerimento->id }}</strong>:</p>

<div style="background: #f5f5f5; padding: 15px; border-radius: 5px; margin: 15px 0;">
    {!! nl2br(e($comunicacao->mensagem)) !!}
</div>

@if($comunicacao->observacao)
<p style="color: #666; font-size: 0.9em;">
    <strong>Observação:</strong> {{ $comunicacao->observacao }}
</p>
@endif

<p style="margin-top: 20px;">
    Acesse o sistema para mais detalhes.<br>
    <a href="{{ url('/admin/comunicacoes/'.$comunicacao->id) }}" style="color: #3490dc;">
        Ver meu requerimento
    </a>
</p>

<p style="margin-top: 30px; font-size: 0.8em; color: #999;">
    Mensagem enviada em: {{ $comunicacao->created_at->format('d/m/Y H:i') }}
</p>