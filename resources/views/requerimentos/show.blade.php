@php
// Carrega os tipos de requerimentos do banco de dados
$tiposRequerimentos = App\Models\TipoRequerimento::all()->keyBy('id');
@endphp

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link type="text/css" rel="stylesheet" href="resources/sheet.css">
    <style type="text/css">
    .ritz .waffle a {
        color: inherit;
    }

    .ritz .waffle .s5 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s8 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 7pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s44 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
    }

    .ritz .waffle .s0 {
        background-color: #ffffff;
        text-align: right;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s31 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s2 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 10pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s37 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: top;
        white-space: normal;
        overflow: hidden;
        word-wrap: break-word;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s41 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: right;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s22 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 11pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s29 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s32 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s42 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s13 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s40 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s48 {
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s16 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 7pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 1px 2px 1px 2px;
    }

    .ritz .waffle .s30 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s3 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s20 {
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s45 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s7 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s19 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: normal;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: top;
        white-space: normal;
        direction: ltr;
        word-break: break-all;
        max-width: 200px;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s28 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 8pt;
        vertical-align: top;
        white-space: normal;
        overflow: hidden;
        word-wrap: break-word;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s27 {

        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #ff0000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s46 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 20pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s9 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        border-left: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 7pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s4 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 8pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s23 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 11pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s6 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 7pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 1px 2px 1px 2px;
    }

    .ritz .waffle .s26 {
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #ff0000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s43 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
    }

    .ritz .waffle .s12 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s21 {
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 8pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s38 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: bottom;
        white-space: normal;
        overflow: hidden;
        word-wrap: break-word;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s36 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: top;
        white-space: normal;
        overflow: hidden;
        word-wrap: break-word;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s15 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 7pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s33 {
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s47 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        color: #000000;
        font-family: Arial;
        font-size: 10pt;
        vertical-align: middle;
        white-space: normal;
        overflow: hidden;
        word-wrap: break-word;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s25 {

        background-color: #ffffff;
        text-align: right;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s17 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 8pt;
        vertical-align: bottom;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s18 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s35 {
        border-bottom: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 13pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s10 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 7pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s11 {
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s39 {
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 14pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s14 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        font-weight: bold;
        color: #000000;
        font-family: Arial;
        font-size: 8pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s24 {
        border-bottom: 1px SOLID #000000;
        border-right: 1px SOLID #000000;
        border-left: 1px SOLID #000000;
        background-color: #ffffff;
        text-align: center;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 7pt;
        vertical-align: top;
        white-space: normal;
        overflow: hidden;
        word-wrap: break-word;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s1 {
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: "Times New Roman";
        font-size: 10pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .ritz .waffle .s34 {
        background-color: #ffffff;
        text-align: left;
        font-weight: bold;
        color: #000000;
        font-family: "docs-Arial MT", Arial;
        font-size: 13pt;
        vertical-align: top;
        white-space: nowrap;
        direction: ltr;
        padding: 2px 3px 2px 3px;
    }

    .header img {
        height: 80px;
        margin-bottom: 5px;
    }
    </style>
    <style type="text/css" id="operaUserStyle"></style>
</head>

<body>
    <div class="ritz grid-container" dir="ltr">
        <table class="waffle" cellspacing="0" cellpadding="0">
            <thead>
                <tr>
                    <th class="row-header freezebar-origin-ltr"></th>
                    <th id="0C0" style="width:2px;" class="column-headers-background"></th>
                    <th id="0C1" style="width:23px;" class="column-headers-background"></th>
                    <th id="0C2" style="width:23px;" class="column-headers-background"></th>
                    <th id="0C3" style="width:23px;" class="column-headers-background"></th>
                    <th id="0C4" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C5" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C6" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C7" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C8" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C9" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C10" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C11" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C12" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C13" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C14" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C15" style="width:20px;" class="column-headers-background"></th>
                    <th id="0C16" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C17" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C18" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C19" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C20" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C21" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C22" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C23" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C24" style="width:22px;" class="column-headers-background"></th>
                    <th id="0C25" style="width:25px;" class="column-headers-background"></th>
                    <th id="0C26" style="width:25px;" class="column-headers-background"></th>
                    <th id="0C27" style="width:25px;" class="column-headers-background"></th>
                    <th id="0C28" style="width:25px;" class="column-headers-background"></th>
                    <th id="0C29" style="width:25px;" class="column-headers-background"></th>
                    <th id="0C30" style="width:25px;" class="column-headers-background"></th>
                    <th id="0C31" style="width:25px;" class="column-headers-background"></th>
                </tr>
            </thead>
            <tbody>

                <tr style="height: 20px">
                    <th id="0R0" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s0" dir="ltr"></td>
                    <td dir="ltr" colspan="25" style="align: left"> <img
                            src="{{ public_path('img/Logo-Garanhuns.png') }}" alt="IFPE Campus Garanhuns"
                            style="height: 55px; margin-bottom: 5px;  align: left;">
                    <td class="s0" dir="ltr" colspan="6">PRODEN / CGA</td>
                </tr>
                <tr style="height: 27px">
                    <th id="0R1" style="height: 27px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 27px"></div>
                    </th>
                    <td class="s1" dir="ltr"></td>
                    <td class="s2" dir="ltr" colspan="25">REQUERIMENTO - ALUNO(A) </td>
                    <td class="s3" dir="ltr" colspan="4">Formulário nº: {{ $requerimento->id }}</td>
                    <td class="s4" colspan="2"></td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R2" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="7">CAMPUS</td>
                    <td class="s6" dir="ltr" colspan="18">NOME DO(A) ALUNO(A) (letra de forma)</td>
                    <td class="s7" dir="ltr" colspan="6">Nº DE MATRÍCULA</td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R3" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s8"></td>
                    <td class="s9" colspan="7">{{ $requerimento->discente->campus->nome ?? '' }}</td>
                    <td class="s9" colspan="18">{{ strtoupper($requerimento->discente->nome ?? '') }}</td>
                    <td class="s9" colspan="6">{{ $requerimento->discente->matricula ?? '' }}</td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R4" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="3">PER/MOD/SÉRIE</td>
                    <td class="s6" dir="ltr" colspan="7">CURSO / MODALIDADE</td>
                    <td class="s6" dir="ltr" colspan="4">TURNO</td>
                    <td class="s6" dir="ltr" colspan="17">TELEFONE FIXO / TELEFONE CELULAR / E-MAIL</td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R5" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s8"></td>
                    <td class="s9" colspan="3">{{ $requerimento->discente->periodo ?? '' }}</td>
                    <td class="s9" colspan="7">{{ $requerimento->discente->curso->nome ?? '' }}</td>
                    <td class="s9" colspan="4">{{ $requerimento->discente->turno ?? '' }}</td>
                    <td class="s9" colspan="17">
                        {{ $requerimento->discente->telefone ?? '' }} /
                        {{ $requerimento->discente->celular ?? '' }} /
                        {{ $requerimento->discente->email ?? '' }}</td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R6" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="4">CPF</td>
                    <td class="s6" dir="ltr" colspan="6">IDENTIDADE</td>
                    <td class="s6" dir="ltr" colspan="4">ÓRGÃO EXPED</td>
                    <td class="s10" dir="ltr" colspan="17" rowspan="2">SITUAÇÃO -
                        {{ ucfirst($requerimento->discente->situacao ?? '') }}</td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R7" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s8"></td>
                    <td class="s9" colspan="4">{{ $requerimento->discente->cpf ?? '' }}</td>
                    <td class="s9" colspan="6">{{ $requerimento->discente->rg ?? '' }}</td>
                    <td class="s9" colspan="4">{{ $requerimento->discente->orgao_expedidor ?? '' }}</td>

                </tr>
                <tr style="height: 11px">
                    <th id="0R8" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s11" dir="ltr"></td>
                    <td class="s12" dir="ltr" colspan="31">Marque a sua opção desejada abaixo</td>
                </tr>
                <tr style="height: 15px">
                    <th id="0R9" style="height: 17px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 17px"></div>
                    </th>
                    <td class="s13" dir="ltr"></td>
                    <td class="s14" dir="ltr">X</td>
                    <td class="s14" dir="ltr" colspan="18">ITENS</td>
                    <td class="s15" dir="ltr" colspan="2">ANEXOS</td>
                    <td class="s15" dir="ltr" colspan="10">DOCUMENTAÇÃO EXIGIDA (ANEXOS)</td>
                </tr>
                <tr style="height: 11px">
                    <th id="0R10" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 1 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[1]->descricao ?? '' }}</td>
                    <td class="s16" dir="ltr" colspan="2">c,f,g,h,i</td>
                    <td class="s6" dir="ltr" colspan="10">a - Atestado Médico</td>
                </tr>
                <tr style="height: 11px">
                    <th id="0R11" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 2 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[2]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">b - Cópia da CTPS - Identificação e Contrato</td>
                </tr>
                <tr style="height: 112px">
                    <th id="0R12" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 3 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[3]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">c - Declaração de Transferência</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R13" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 4 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[4]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">d - Declaração da Empresa com o respectivo horário</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R14" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 5 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[5]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">e - Guia de Transferência</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R15" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 6 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[6]->descricao ?? '' }}
                        @if($requerimento->tipo_requerimento->id === 6)
                        - {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">f - Histórico Escolar do Ensino Fundamental (original)</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R16" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 7 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[7]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">g - Histórico Escolar do Ensino Médio (original)</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R17" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 8 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[8]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">h - Histórico Escolar do Ensino Superior (original)</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R18" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 9 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[9]->descricao ?? '' }}
                    </td>
                    <td class="s17" colspan="2"></td>
                    <td class="s6" dir="ltr" colspan="10">i - Ementas das disciplinas cursadas com Aprovação</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R19" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 10 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[10]->descricao ?? '' }}
                    </td>
                    <td class="s16" dir="ltr" colspan="2">a/b, d</td>
                    <td class="s6" dir="ltr" colspan="10">j - Declaração de Unidade Militar</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R20" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 11 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[11]->descricao ?? '' }}
                    </td>
                    <td class="s17" colspan="2"></td>
                    <td class="s9" colspan="10"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R21" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 12 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[12]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                    <td class="s18" dir="ltr" colspan="10" rowspan="2">OBSERVAÇÕES:</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R22" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 13 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[13]->descricao ?? '' }}
                        @if($requerimento->tipo_requerimento->id === 3)
                        - {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif
                    </td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R23" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ in_array($requerimento->tipo_requerimento->id, [14, 15]) ? 'X' : '' }}
                    </td>
                    <td class="s10" dir="ltr" colspan="18">
                        @if($requerimento->tipo_requerimento->id === 14 || $requerimento->tipo_requerimento->id === 15)
                        {{ $tiposRequerimentos[$requerimento->tipo_requerimento->id]->descricao }}
                        @if($requerimento->tipo_requerimento->id === 14 || $requerimento->tipo_requerimento->id === 15)
                        - {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif
                        @else
                        Diploma 1ª ou 2ª via
                        @endif</td>
                    <td class="s17" colspan="2">a/j</td>
                    <td class="s19" dir="ltr" colspan="10" rowspan="15">
                        {{ $requerimento->observacoes ?? '' }}</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R24" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 16 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[16]->descricao ?? '' }}</td>
                    <td class="s16" dir="ltr" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R25" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 17 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[17]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R26" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 18 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[18]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R27" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 19 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[19]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R28" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 20 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[20]->descricao ?? '' }}
                        @if($requerimento->tipo_requerimento->id === 20)
                        - {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif
                    </td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R29" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 21 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[21]->descricao ?? '' }}</td>
                    <td class="s16" dir="ltr" colspan="2">f/g/h,i</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R30" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 22 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[22]->descricao ?? '' }}</td>
                    <td class="s16" dir="ltr" colspan="2">a,d,i</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R31" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 23 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[23]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R32" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 24 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[24]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R33" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ in_array($requerimento->tipo_requerimento->id, [25, 26, 27]) ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18"> @if($requerimento->tipo_requerimento->id === 25 ||
                        $requerimento->tipo_requerimento->id === 26 || $requerimento->tipo_requerimento->id === 27)
                        {{ $tiposRequerimentos[$requerimento->tipo_requerimento->id]->descricao }}
                        @else
                        Reitegração - Estágio | Entrega do Relatório de Estágio | TCC @endif</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R34" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 28 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[28]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R35" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 29 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[29]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R36" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 30 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[30]->descricao ?? '' }}</td>
                    <td class="s17" colspan="2"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R37" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 31 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="18">{{ $tiposRequerimentos[31]->descricao ?? '' }}</td>
                    <td class="s16" dir="ltr" colspan="2">a/j</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R38" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ in_array($requerimento->tipo_requerimento->id, [32, 33, 34, 35, 36]) ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="30"
                        style="word-break: break-all; white-space: normal; max-width: 700px;">
                        @if($requerimento->tipo_requerimento->id === 32 ||
                        $requerimento->tipo_requerimento->id === 33 || $requerimento->tipo_requerimento->id === 34 ||
                        $requerimento->tipo_requerimento->id === 35 || $requerimento->tipo_requerimento->id === 36)
                        {{ $tiposRequerimentos[$requerimento->tipo_requerimento->id]->descricao }} |
                        @if($requerimento->tipo_requerimento->id === 32 || $requerimento->tipo_requerimento->id === 33
                        || $requerimento->tipo_requerimento->id === 34 || $requerimento->tipo_requerimento->id === 35 ||
                        $requerimento->tipo_requerimento->id === 36)
                        | {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif
                        @else
                        LANÇAMENTO DE NOTA: 1ª Unidade | 2ª Unidade | 3ª Unidade | 4ª Unidade | Exames Finais @endif
                    </td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R39" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ in_array($requerimento->tipo_requerimento->id, [37, 38, 39, 40, 41]) ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="30"
                        style="word-break: break-all; white-space: normal; max-width: 700px;">
                        @if($requerimento->tipo_requerimento->id === 37 ||
                        $requerimento->tipo_requerimento->id === 38 || $requerimento->tipo_requerimento->id === 39 ||
                        $requerimento->tipo_requerimento->id === 40 || $requerimento->tipo_requerimento->id === 41)
                        {{ $tiposRequerimentos[$requerimento->tipo_requerimento->id]->descricao }}
                        @if($requerimento->tipo_requerimento->id === 37 || $requerimento->tipo_requerimento->id === 38
                        || $requerimento->tipo_requerimento->id === 39 || $requerimento->tipo_requerimento->id === 40 ||
                        $requerimento->tipo_requerimento->id === 41)
                        | {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif
                        @else
                        REVISÃO DE NOTA: 1ª Unidade | 2ª Unidade | 3ª Unidade | 4ª Unidade | Exames Finais @endif
                    </td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R40" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ in_array($requerimento->tipo_requerimento->id, [42, 43, 44, 45, 46]) ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="30"
                        style="word-break: break-all; white-space: normal; max-width: 700px;">
                        @if($requerimento->tipo_requerimento->id === 42 ||
                        $requerimento->tipo_requerimento->id === 43 || $requerimento->tipo_requerimento->id === 44 ||
                        $requerimento->tipo_requerimento->id === 45 || $requerimento->tipo_requerimento->id === 46)
                        {{ $tiposRequerimentos[$requerimento->tipo_requerimento->id]->descricao }}
                        @if($requerimento->tipo_requerimento->id === 42 || $requerimento->tipo_requerimento->id === 43
                        || $requerimento->tipo_requerimento->id === 44 || $requerimento->tipo_requerimento->id === 45 ||
                        $requerimento->tipo_requerimento->id === 46)
                        | {{$requerimento->informacaoComplementar->descricao ?? ''}}
                        @else

                        @endif
                        @else
                        REVISÃO DE FALTAS: 1ª Unidade | 2ª Unidade | 3ª Unidade | 4ª Unidade | Exames Finais @endif
                    </td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R41" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 47 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="30">{{ $tiposRequerimentos[47]->descricao ?? '' }}</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R42" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td id="check" class="s9" style="text-align: center;  font-size: 7pt; padding: 1px 2px 1px 2px;">
                        {{ $requerimento->tipo_requerimento->id === 48 ? 'X' : '' }}</td>
                    <td class="s10" dir="ltr" colspan="30">{{ $tiposRequerimentos[48]->descricao ?? '' }}</td>
                </tr>

                <tr style="height: 12px">
                    <th id="0R55" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="31">OBSERVAÇÕES:</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R56" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td class="s9" colspan="31"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R57" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s5" dir="ltr" colspan="19" rowspan="3">Data:
                        {{ $requerimento->created_at->format('d/m/Y') }}</td>
                    <td class="s6" dir="ltr" colspan="8" rowspan="2">PROTOCOLO Nº</td>
                    <td class="s6" dir="ltr" colspan="4" rowspan="2">CGCA / CRE / SRE</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R58" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                </tr>
                <tr style="height: 7px">
                    <th id="0R59" style="height: 7px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 7px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s8" colspan="12"></td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R60" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="19" rowspan="2">Assinatura digital do(a) Requerente</td>
                    <td class="s20" dir="ltr" colspan="2">Em:</td>
                    <td class="s8" colspan="10"></td>
                </tr>
                <tr style="height: 10px">
                    <th id="0R61" style="height: 10px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="12">Assinatura digital do(a) servidor(a) responsável</td>
                </tr>
                <tr style="height: 10px">
                    <th id="0R62" style="height: 10px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s21"></td>
                    <td class="s4" colspan="31"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R63" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 26px"></div>
                    </th>
                    <td class="s22" dir="ltr"></td>
                    <td class="s23" dir="ltr" colspan="22">COMPROVANTE DE ENTREGA DE REQUERIMENTO</td>
                    <td class="s10" dir="ltr" colspan="9" rowspan="2">
                        Em:{{ $requerimento->created_at->format('d/m/Y') }}
                        <br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Visto
                    </td>
                </tr>
                <tr style="height: 14px">
                    <th id="0R64" style="height: 14px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 14px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="10">CURSO / TURNO</td>
                    <td class="s6" dir="ltr" colspan="12">Nº MATRÍCULA</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R65" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s8"></td>
                    <td class="s9" colspan="10">{{ $requerimento->discente->curso->nome ?? '' }} /
                        {{ $requerimento->discente->turno ?? '' }}</td>
                    <td class="s9" colspan="12">{{ $requerimento->discente->matricula ?? '' }}</td>
                    <td class="s24" dir="ltr" colspan="9" rowspan="3">Atenção<br>A solicitação não procurada no prazo
                        de
                        90 (noventa) dias perderá a validade. O documento só será entregue com o PROTOCOLO de ENTREGA.
                    </td>
                </tr>
                <tr style="height: 10px">
                    <th id="0R66" style="height: 10px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 10px"></div>
                    </th>
                    <td class="s5" dir="ltr"></td>
                    <td class="s6" dir="ltr" colspan="22" rowspan="1">NOME (letra de forma)</td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R67" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s8"></td>
                    <td class="s9" colspan="22">{{ $requerimento->discente->nome ?? '' }}</td>
                </tr>
                <tr style="height: 12px">
                    <th id="0R68" style="height: 12px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 12px"></div>
                    </th>
                    <td class="s25" dir="ltr"></td>
                    <td class="s25" dir="ltr" colspan="29">Formulário nº: {{ $requerimento->id }}</td>
                    <td class="s21" colspan="2"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R69" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s21"></td>
                    <td class="s21" colspan="31"><br><br></td>
                </tr>

                <tr style="height: 30px">
                    <th id="0R70" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s26" dir="ltr"></td>
                    <td class="s27" dir="ltr" colspan="31">INFORMAÇÕES COMPLEMENTARES (USO IFPE)</td>
                </tr>
                <tr style="height: 37px">
                    <th id="0R71" style="height: 37px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 37px"></div>
                    </th>
                    <td class="s28" dir="ltr"></td>
                    <td class="s28" dir="ltr" colspan="6" style="border-top: 1px SOLID #000000;">Débito com a BIBLIOTECA
                    </td>
                    <td class="s29"></td>
                    <td class="s5" dir="ltr" colspan="24" style="border-top: 1px SOLID #000000;">[Cidade/Data]</td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R72" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s30" dir="ltr"></td>
                    <td class="s30" dir="ltr" colspan="6">( ) SIM</td>
                    <td class="s30" dir="ltr"></td>
                    <td class="s29" colspan="24"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R73" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s30" dir="ltr"></td>
                    <td class="s30" dir="ltr" colspan="6"></td>
                    <td class="s30" dir="ltr"></td>
                    <td class="s29" colspan="24"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R74" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s30" dir="ltr"></td>
                    <td class="s31" dir="ltr" colspan="6">( ) NÃO</td>
                    <td class="s30" dir="ltr"></td>
                    <td class="s3" colspan="5"></td>
                    <td class="s32" dir="ltr" colspan="14" style="border-top: 1px SOLID #000000;">Responsável pela
                        Biblioteca</td>
                    <td class="s10" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R75" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s33" dir="ltr"></td>
                    <td class="s33" dir="ltr" colspan="31"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R76" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s34" dir="ltr"></td>
                    <td class="s35" dir="ltr" colspan="31">QUADRO</td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R77" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"><br>Código Disciplina</td>
                    <td class="s38" dir="ltr" colspan="9">Nome da Disciplina </td>
                    <td class="s38" dir="ltr" colspan="3">Turma </td>
                    <td class="s38" dir="ltr" colspan="5">Registro Matrícula</td>
                    <td class="s38" dir="ltr" colspan="5">Solicitação Cancelada</td>
                    <td class="s38" dir="ltr" colspan="5">Rubrica Coordenador</td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R78" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"></td>
                    <td class="s38" dir="ltr" colspan="9"></td>
                    <td class="s38" dir="ltr" colspan="3"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R79" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"></td>
                    <td class="s38" dir="ltr" colspan="9"></td>
                    <td class="s38" dir="ltr" colspan="3"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R80" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"></td>
                    <td class="s38" dir="ltr" colspan="9"></td>
                    <td class="s38" dir="ltr" colspan="3"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R81" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"></td>
                    <td class="s38" dir="ltr" colspan="9"></td>
                    <td class="s38" dir="ltr" colspan="3"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R82" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"></td>
                    <td class="s38" dir="ltr" colspan="9"></td>
                    <td class="s38" dir="ltr" colspan="3"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R83" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s36" dir="ltr"></td>
                    <td class="s37" dir="ltr" colspan="4"></td>
                    <td class="s38" dir="ltr" colspan="9"></td>
                    <td class="s38" dir="ltr" colspan="3"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                    <td class="s38" dir="ltr" colspan="5"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R84" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s21"></td>
                    <td class="s21" colspan="31"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R85" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s39" dir="ltr"></td>
                    <td class="s40" dir="ltr" colspan="16">DESPACHOS</td>
                    <td class="s41" dir="ltr" colspan="15"> IFPE</td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R86" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                    <td class="s10" colspan="16" rowspan="14"></td>
                    <td class="s42" colspan="15" rowspan="14"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R87" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R88" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R89" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R90" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R91" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R92" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R93" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R94" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R95" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R96" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R97" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R98" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R99" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td class="s29"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R100" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td></td>
                    <td class="s43" colspan="31"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R101" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                    <td class="s45" colspan="31"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R102" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                    <td class="s45" colspan="14" rowspan="6"></td>
                    <td class="s46" dir="ltr" colspan="16" rowspan="2" style="border-top: 1px SOLID #000000;">ATENÇÃO
                    </td>
                    <td class="s45" rowspan="6"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R103" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R104" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                    <td class="s47" dir="ltr" colspan="16" rowspan="4">A solicitação não procurada no prazo de 90
                        (noventa) dias perderá a validade.<br>O documento só será entregue com o PROTOCOLO DE ENTREGA.
                    </td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R105" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R106" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R107" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                </tr>
                <tr style="height: 16px">
                    <th id="0R108" style="height: 16px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 16px"></div>
                    </th>
                    <td class="s44"></td>
                    <td class="s42" colspan="31"></td>
                </tr>
                <tr style="height: 20px">
                    <th id="0R109" style="height: 20px;" class="row-headers-background">
                        <div class="row-header-wrapper" style="line-height: 20px"></div>
                    </th>
                    <td></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                    <td class="s48"></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>