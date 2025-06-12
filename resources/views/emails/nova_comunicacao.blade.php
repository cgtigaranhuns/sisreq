<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>IFPE Campus Garanhuns - Comunicação de Requerimento</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        text-align: center;
        border-bottom: 2px solid #006633;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .logo {
        max-width: 150px;
        height: auto;
    }

    .content {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .footer {
        text-align: center;
        font-size: 12px;
        color: #666;
        border-top: 1px solid #ddd;
        padding-top: 15px;
        margin-top: 20px;
    }

    h2 {
        color: #006633;
    }

    .protocolo {
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 5px 10px;
        display: inline-block;
        border-radius: 3px;
        margin-bottom: 15px;
    }

    .mensagem {
        background: #f5f5f5;
        padding: 15px;
        border-radius: 5px;
        margin: 15px 0;
        border-left: 3px solid #006633;
    }

    .observacao {
        color: #666;
        font-size: 0.9em;
        font-style: italic;
    }

    .botao {
        display: inline-block;
        padding: 10px 15px;
        background-color: #006633;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 15px;
    }

    .data-envio {
        margin-top: 30px;
        font-size: 0.8em;
        color: #999;
    }

    .status {
        color: rgb(190, 48, 13);
        font-weight: bold;
    }

    /* Cores para os status */
    .status-pendente {
        color: #BE301D;
        font-weight: bold;
    }

    .status-em_analise {
        color: #FFC107;
        font-weight: bold;
    }

    .status-finalizado {
        color: #28A745;
        font-weight: bold;
    }

    .status-outro {
        color: #006633;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <div class="header">
        <img src="https://sisreq.garanhuns.ifpe.edu.br/img/Logo-Garanhuns.png" alt="IFPE Campus Garanhuns" class="logo"
            style="max-width:300px; width:auto; height:auto;">
        <h1>Instituto Federal de Pernambuco</h1>
        <h2>Campus Garanhuns</h2>
    </div>

    <div class="content">
        <h2>Olá, {{ $discente->nome }}!</h2>

        <p>Você recebeu uma nova comunicação sobre seu requerimento no IFPE Campus Garanhuns:</p>

        <div class="protocolo">ID: #{{ $comunicacao->requerimento->id }}</div><br>
        <div class="protocolo">Requerimento: {{ $comunicacao->requerimento->tipo_requerimento->descricao }}</div>

        <div class="mensagem">
            <strong>Mensagem:</strong> {!! nl2br(e($comunicacao->mensagem)) !!}
        </div>

        @if($comunicacao->observacao)
        <p class="observacao">
            <strong>Observação:</strong> {{ $comunicacao->observacao }}
        </p>
        @endif

        <p style="margin-top: 20px;">
            <strong>Status atual:</strong>
            <span class="status-{{ str_replace(' ', '_', strtolower($comunicacao->requerimento->status)) }}">
                @if(strtolower($comunicacao->requerimento->status) == 'finalizado')
                Finalizado
                @elseif(strtolower($comunicacao->requerimento->status) == 'em_analise')
                Em Análise
                @elseif(strtolower($comunicacao->requerimento->status) == 'pendente')
                Pendente
                @else
                {{ $comunicacao->requerimento->status ?? 'N/A' }}
                @endif
            </span>
        </p>

        <p class="data-envio">
            Mensagem enviada em: {{ $comunicacao->created_at->format('d/m/Y H:i') }}
        </p>
    </div>

    <div class="footer">
        <p><em><span style="color:rgb(190, 48, 13);">Esta é uma mensagem automática do sistema de requerimentos do IFPE
                    Campus Garanhuns.</span></em></p>
        <p>Por favor, não responda este e-mail. Em caso de dúvidas, entre em contato com a secretaria acadêmica.</p>
        <p>IFPE Campus Garanhuns | R. Francisco Braga - Indiano, Garanhuns - PE, CEP: 55.298-320</p>
    </div>
</body>

</html>