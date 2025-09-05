<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>IFPE Campus Garanhuns - Requerimento Atualizado</title>
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

    ul {
        padding-left: 20px;
    }

    li {
        margin-bottom: 8px;
    }

    .protocolo {
        font-weight: bold;
        background-color: #f0f0f0;
        padding: 5px 10px;
        display: inline-block;
        border-radius: 3px;
    }

    .btn-link {
        background-color: #d0d4d2ff;
        color: white;
        padding: 10px 20px;
        text-decoration: none;
        border-radius: 5px;
        display: inline-block;
        margin-top: 10px;
    }

    .btn-link:hover {
        background-color: #004d26;
    }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ asset('https://sisreq.garanhuns.ifpe.edu.br/img/Logo-Garanhuns.png') }}"
            alt="IFPE Campus Garanhuns" class="logo" style="max-width:300px; width:auto; height:auto;">
        <h1>Instituto Federal de Pernambuco</h1>
        <h2>Campus Garanhuns</h2>
    </div>

    <div class="content">
        @if ($destinatario === 'admin')
        {{-- Conteúdo para o ADMIN --}}
        <h2>Requerimento Atualizado - Anexo {{ $acao }}</h2>
        <p><strong>Discente:</strong> {{ $discente->nome }} ({{ $discente->matricula }})</p>
        <p><strong>Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}</p>

        @if($anexo)
        <p><strong>Anexo:</strong> {{ $anexo->nome_original }}</p>
        <p><strong>Ação:</strong>
            @if($acao === 'criado') Novo anexo adicionado
            @elseif($acao === 'atualizado') Anexo atualizado
            @elseif($acao === 'deletado') Anexo removido
            @endif
        </p>
        @endif

        <p><strong>Status:</strong> <span style="color:rgb(190, 48, 13);">
                @if(strtolower($requerimento->status) == 'finalizado')
                Finalizado
                @elseif(strtolower($requerimento->status) == 'em_analise')
                Em Análise
                @elseif(strtolower($requerimento->status) == 'pendente')
                Pendente
                @else
                {{ $requerimento->status ?? 'N/A' }}
                @endif
            </span></p>
        <p><strong>Data da atualização:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        <p>
            <a href="{{ url('/admin/requerimentos/' . $requerimento->id) }}" class="btn-link" target="_blank">
                Acessar Requerimento
            </a>
        </p>
        @else
        {{-- Conteúdo para o DISCENTE --}}
        <h2>Olá, {{ $discente->nome }}!</h2>
        <p>Seu requerimento foi atualizado no IFPE Campus Garanhuns:</p>
        <div class="protocolo">ID: #{{ $requerimento->id }}</div>

        @if($anexo)
        <p><strong>Anexo:</strong> {{ $anexo->nome_original }} -
            @if($acao === 'criado') foi adicionado
            @elseif($acao === 'atualizado') foi atualizado
            @elseif($acao === 'deletado') foi removido
            @endif
        </p>
        @endif

        <ul>
            <li><strong>Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}</li>
            <li><strong>Status atual:</strong> <span style="color:rgb(190, 48, 13);">
                    @if(strtolower($requerimento->status) == 'finalizado')
                    Finalizado
                    @elseif(strtolower($requerimento->status) == 'em_analise')
                    Em Análise
                    @elseif(strtolower($requerimento->status) == 'pendente')
                    Pendente
                    @else
                    {{ $requerimento->status ?? 'N/A' }}
                    @endif
                </span></li>
        </ul>

        <a href="{{ url('/admin/requerimentos/' . $requerimento->id) }}" class="btn-link" target="_blank">
            Acessar Meu Requerimento
        </a>

        @if($anexo && $anexo->caminho && $acao !== 'deletado')
        <p style="margin-top: 15px;">
            <a href="{{ $anexo->url }}" class="anexo-link" target="_blank">
                📎 Visualizar Anexo
            </a>
        </p>
        @endif
        @endif
    </div>

    <div class="footer">
        <p><em><span style="color:rgb(190, 48, 13);">Esta é uma mensagem automática do sistema de requerimentos do IFPE
                    - Campus Garanhuns.</span></em></p>
        <p>Por favor, não responda este e-mail. Em caso de dúvidas, entre em contato com o Setor de Atendimento.</p>
        <p>IFPE - Campus Garanhuns | R. Francisco Braga - Indiano, Garanhuns - PE, CEP: 55.298-320</p>
    </div>
</body>

</html>