<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Requerimento - {{ $requerimento->id }}</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
        margin: 0;
        padding: 0;
    }

    .header {
        text-align: center;
        margin-bottom: 15px;
    }

    .header img {
        height: 80px;
        margin-bottom: 5px;
    }

    .header h3 {
        margin: 5px 0;
        font-size: 14px;
    }

    .header p {
        margin: 5px 0;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
        vertical-align: top;
    }

    .section {
        margin-bottom: 15px;
    }

    .checkbox {
        width: 15px;
        height: 15px;
        border: 1px solid black;
        display: inline-block;
        margin-right: 5px;
        vertical-align: middle;
    }

    .checked {
        background-color: black;
    }

    .observacoes {
        margin-top: 20px;
    }

    .footer {
        margin-top: 30px;
        font-size: 10px;
        text-align: center;
    }

    .page-break {
        page-break-after: always;
    }

    .text-center {
        text-align: center;
    }

    .text-uppercase {
        text-transform: uppercase;
    }
    </style>
</head>

<body>
    <!-- Cabeçalho -->
    <div class="header">
        <img src="{{ public_path('img/Logo-Garanhuns.png') }}" alt="IFPE Campus Garanhuns">
        <h3>PRODEN / CGA</h3>
        <p>Formulário nº: {{ $requerimento->id }}</p>
    </div>

    <!-- Dados do discente -->
    <div class="section">
        <table>
            <tr>
                <th width="20%">CAMPUS</th>
                <th width="40%">NOME DO(A) ALUNO(A) (letra de forma)</th>
                <th width="20%">Nº DE MATRÍCULA</th>
            </tr>
            <tr>
                <td>{{ $requerimento->discente->campus->nome ?? '' }}</td>
                <td class="text-uppercase">{{ $requerimento->discente->nome ?? '' }}</td>
                <td>{{ $requerimento->discente->matricula ?? '' }}</td>
            </tr>
            <tr>
                <th>PER/MOD/SÉRIE</th>
                <th>CURSO / MODALIDADE</th>
                <th>TURNO</th>
                <th>TELEFONE FIXO / TELEFONE CELULAR / E-MAIL</th>
            </tr>
            <tr>
                <td>{{ $requerimento->discente->periodo ?? '' }}</td>
                <td>{{ $requerimento->discente->curso->nome ?? '' }}</td>
                <td>{{ $requerimento->discente->turno ?? '' }}</td>
                <td>
                    {{ $requerimento->discente->telefone ?? '' }} /
                    {{ $requerimento->discente->celular ?? '' }} /
                    {{ $requerimento->discente->email ?? '' }}
                </td>
            </tr>
            <tr>
                <th>CPF</th>
                <th>IDENTIDADE</th>
                <th>ÓRGÃO EXPED</th>
                <th>Matriculado Graduado Desvinculado</th>
            </tr>
            <tr>
                <td>{{ $requerimento->discente->cpf ?? '' }}</td>
                <td>{{ $requerimento->discente->rg ?? '' }}</td>
                <td>{{ $requerimento->discente->orgao_expedidor ?? '' }}</td>
                <td>{{ ucfirst($requerimento->discente->situacao ?? '') }}</td>
            </tr>
        </table>
    </div>

    <!-- Itens do requerimento -->
    <div class="section">
        <h4 class="text-center">Marque a sua opção desejada abaixo</h4>
        <table>
            <tr>
                <th width="5%"></th>
                <th width="45%">ITENS</th>
                <th width="20%">ANEXOS</th>
                <th width="30%">DOCUMENTAÇÃO EXIGIDA (ANEXOS)</th>
            </tr>

            @foreach($tipos as $tipo)
            <tr>
                <td class="text-center">
                    <div class="checkbox {{ $requerimento->tipo_requerimento_id === $tipo->id ? 'checked' : '' }}">
                    </div>
                </td>
                <td>{{ $tipo->descricao }}</td>
                <td>{{ $tipo->anexo ?? 'Nenhum anexo específico' }}</td>
                <td>{{ $tipo->infor_complementares ?? 'Verifique os documentos padrão' }}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <!-- Observações -->
    <div class="observacoes">
        <p><strong>OBSERVAÇÕES:</strong> {{ $requerimento->observacoes }}</p>
        @if($requerimento->informacaoComplementar)
        <p><strong>INFORMAÇÕES COMPLEMENTARES:</strong> {{ $requerimento->informacaoComplementar->descricao }}</p>
        @endif
    </div>

    <!-- Assinaturas -->
    <div class="section">
        <table>
            <tr>
                <td width="30%">Data: {{ now()->format('d/m/Y') }}</td>
                <td width="40%">PROTOCOLO Nº CGCA / CRE / SRE</td>
                <td width="30%">Em: _______________</td>
            </tr>
            <tr>
                <td colspan="2">Assinatura digital do(a) Requerente</td>
                <td>Assinatura digital do(a) servidor(a) responsável</td>
            </tr>
        </table>
    </div>

    <!-- Comprovante de entrega -->
    <div class="section">
        <h4 class="text-center">COMPROVANTE DE ENTREGA DE REQUERIMENTO</h4>
        <table>
            <tr>
                <th width="40%">CURSO / TURNO</th>
                <th width="30%">Nº MATRÍCULA</th>
                <th width="30%">Em: Visto</th>
            </tr>
            <tr>
                <td>{{ $requerimento->discente->curso->nome ?? '' }} / {{ $requerimento->discente->turno ?? '' }}</td>
                <td>{{ $requerimento->discente->matricula ?? '' }}</td>
                <td></td>
            </tr>
        </table>
    </div>

    <!-- Segunda página -->
    <div class="page-break"></div>

    <!-- Cabeçalho segunda página -->
    <div class="header">
        <img src="{{ public_path('img/Logo-Garanhuns.png') }}" alt="IFPE Campus Garanhuns">
        <h3>INFORMAÇÕES COMPLEMENTARES (USO IFPE)</h3>
    </div>

    <!-- Débito com biblioteca -->
    <div class="section">
        <h4>Débito com a BIBLIOTECA</h4>
        <p>SIM ☐ &nbsp;&nbsp;&nbsp; NÃO ☐</p>
    </div>

    <!-- Quadro de disciplinas -->
    <div class="section">
        <h4>QUADRO</h4>
        <table>
            <tr>
                <th width="15%">Código Disciplina</th>
                <th width="30%">Nome da Disciplina</th>
                <th width="10%">Turma</th>
                <th width="15%">Registro Matrícula</th>
                <th width="15%">Solicitação Cancelada</th>
                <th width="15%">Rubrica Coordenador</th>
            </tr>
            @for($i = 0; $i < 5; $i++) <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
                @endfor
        </table>
    </div>

    <!-- Despachos -->
    <div class="section">
        <h4>DESPACHOS</h4>
        <p>________________________________________________________________________</p>
        <p>________________________________________________________________________</p>
        <p>________________________________________________________________________</p>
    </div>

    <!-- Rodapé -->
    <div class="footer">
        <p><strong>ATENÇÃO:</strong> A solicitação não procurada no prazo de 90 (noventa) dias perderá a validade.</p>
        <p>O documento só será entregue com o PROTOCOLO DE ENTREGA.</p>
        <p>INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA PERNAMBUCO</p>
    </div>
</body>

</html>