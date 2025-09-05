<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>IFPE Campus Garanhuns - Requerimento Excluído</title>
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
        <h2>Requerimento Excluído</h2>
        <p><strong>Discente:</strong> {{ $discente->nome }} ({{ $discente->matricula }})</p>
        <p><strong>Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}</p>
        <p><strong>Observações:</strong> {{ $requerimento->observacoes ?? 'N/A' }}</p>
        <p><strong>Informações complementares:</strong> {{ $requerimento->informacaoComplementar->descricao ?? 'N/A' }}
        </p>
        <p><strong>Status:</strong> <span style="color:rgb(190, 48, 13);">Excluído</span></p>
        <p><strong>Data da exclusão:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        @else
        {{-- Conteúdo para o DISCENTE --}}
        <h2>Olá, {{ $discente->nome }}!</h2>
        <p>Seu requerimento foi excluído do sistema do IFPE Campus Garanhuns:</p>
        <div class="protocolo">ID: #{{ $requerimento->id }}</div>
        <ul>
            <li><strong>Requerimento:</strong> {{ $requerimento->tipo_requerimento->descricao ?? 'N/A' }}</li>
            <li><strong>Observações:</strong> {{ $requerimento->observacoes ?? 'N/A' }}</li>
            <li><strong>Informações complementares:</strong>
                {{ $requerimento->informacaoComplementar->descricao ?? 'N/A' }}</li>
            <li><strong>Status:</strong> <span style="color:rgb(190, 48, 13);">Excluído</span></li>
        </ul>
        <p>Em caso de dúvidas, entre em contato com o Setor de Atendimento.</p>
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