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
        max-width: 300px;
        height: auto;
        width: auto;
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

        background-color: #f0f0f0;
        padding: 5px 10px;
        display: inline-block;
        border-radius: 3px;
        margin-bottom: 10px;
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

    .anexos {
        margin: 20px 0;
        padding: 15px;
        background-color: #f0f0f0;
        border-radius: 5px;
    }

    .anexos ul {
        padding-left: 20px;
        margin: 10px 0 0 0;
    }

    .anexos li {
        margin-bottom: 8px;
        word-break: break-all;
    }

    .anexo-link {
        color: #006633;
        text-decoration: none;
    }

    .anexo-link:hover {
        text-decoration: underline;
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
        @if ($destinatario === 'admin')
        <h2>📋 {{ $assuntoBase }} - Requerimento #{{ $requerimento->id }}</h2>
        @else
        <h2>Olá, {{ $discente->nome }}!</h2>
        @endif

        <div class="protocolo"><strong>ID:</strong> #{{ $requerimento->id }}<br>
            <strong>Discente:</strong> {{ $requerimento->discente->nome }} ({{ $requerimento->discente->matricula }})
            <br>
            <strong>Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}<br>

            <strong> Status:</strong>
            <span class="status-{{ str_replace(' ', '_', strtolower($requerimento->status)) }}">
                @if(strtolower($requerimento->status) == 'finalizado')
                Finalizado
                @elseif(strtolower($requerimento->status) == 'em_analise')
                Em Análise
                @elseif(strtolower($requerimento->status) == 'pendente')
                Pendente
                @else
                {{ $requerimento->status ?? 'N/A' }}
                @endif
            </span>
        </div>

        <div class="mensagem">
            <strong>Mensagem:</strong> {{$acompanhamento->descricao ?? ''}}
        </div>
        @if ($destinatario === 'admin')
        <strong>Responsável:</strong> {{$acompanhamento->user->nome ?? ''}}
        @else

        @endif

        @if(isset($anexos) && $anexos->isNotEmpty())
        <div class="anexos">
            <p><strong>Anexos disponíveis:</strong></p>
            <ul>
                @foreach($anexos as $anexo)
                <li>
                    {{ $anexo->nome_original }} ({{ round($anexo->tamanho / 1024, 2) }} KB )
                    <a href="{{ asset('storage/' . $anexo->caminho) }}" class="anexo-link"
                        target="_blank">Visualizar</a>
                </li>
                @endforeach
            </ul>
        </div>
        @else
        <p class="observacao"><em>Nenhum anexo disponível.</em></p>
        @endif

        <p class="data-envio">
            Mensagem enviada em: {{ now()->format('d/m/Y H:i') }}
        </p>
    </div>

    <div class="footer">
        <p><em><span style="color:rgb(190, 48, 13);">Esta é uma mensagem automática do sistema de requerimentos do IFPE
                    -
                    Campus Garanhuns.</span></em></p>
        <p>Por favor, não responda este e-mail. Em caso de dúvidas, entre em contato com o Setor de Atendimento.</p>
        <p>IFPE - Campus Garanhuns | R. Francisco Braga - Indiano, Garanhuns - PE, CEP: 55.298-320</p>
    </div>
</body>

</html>