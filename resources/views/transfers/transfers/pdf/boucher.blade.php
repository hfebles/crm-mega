<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        html {
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        body {
            margin: 0
        }

        table {
            border-spacing: 0;
            border-collapse: collapse
        }

        td,
        th {
            padding: 0
        }

        thead {
            display: table-header-group
        }

        .table {
            border-collapse: collapse !important
        }

        .table td,
        .table th {
            background-color: #fff !important
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #ddd !important
        }
    </style>
</head>

<body>
    <table width='100%' style="text-align:center; border-collapse: collapse; border-spacing: 0;">
        <tr>
            <td style="text-align:center">
                <img
                    src='C:\Users\PC\Desktop\mega-envios-proyectos\crm-mega\public\vendor\adminlte\dist\img/1_logo.png' />
            </td>

        </tr>
        <tr>
            <td>

                <span style="line-height: 1.6;">
                    Av. Pueyrredón 1357 local 64, galería Americana, Recoleta.<br />
                    <span style="font-size: 10pt"> <strong> Transferencia No.
                            {{ str_pad($data->transferId, 8, '0', STR_PAD_LEFT) }} - Cliente No.
                            {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}</strong> <br />
                        Mega Env&iacute;os - Money Transfer<br />
                        Fecha: {{ date('d/m/Y', strtotime($data->transferDate)) }} - Hora:
                        {{ date('g:ia', strtotime($data->transferDate)) }}</span>
                </span>
            </td>
        </tr>
    </table>
    <table width='100%' style="border-collapse: collapse; border-spacing: 0; margin-top:40px">
        <tr>
            <td>
                <strong> facebook.com/megaenvios.ar</strong>
            </td>
            <td style="text-align: right;">
                <strong>Síguenos en Instagram @megaenvios.arg</strong>
            </td>
        </tr>
        <tr>
            <td>
                <span class="invoice-address">Av. Pueyrredón 1357 - L64, Galería Americana. </span><br>
                <span>L-V 10am - 20hrs | Sábados 10am - 16hrs </span><br>
            </td>
            <td style="text-align: right;">
                Mega Env&iacute;os | Money Transfer <br>
                Celular | Whatsapp : 11 2662-4688
            </td>
        </tr>
    </table>
    <table width='100%'
        style="background-color:#f5f5f5; border-collapse: collapse; border-spacing: 0; margin-top:20px;">
        <tr>
            <td style="text-align: right; padding:5px">
                <strong>C&oacute;digo De Cliente:</strong>
            </td>
            <td style="text-align: right; padding:5px">
                {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}
            </td>
        </tr>
        <tr class="active">
            <td style="text-align: right; padding:5px"> <strong> Nombre Completo:</strong></td>
            <td style="text-align: right; padding:5px">{{ $data->headline }}</td>
        </tr>
        <tr class="active">
            <td style="text-align: right; padding:5px">
                <strong>Cédula :</strong>
            </td>
            <td style="text-align: right; padding:5px">{{ $data->headline_dni }}</td>
        </tr>
        <tr class="active">
            <td style="text-align: right; padding:5px">
                <strong>Banco :</strong>
            </td>
            <td style="text-align: right; padding:5px">{{ $data->bankName }}</td>
        </tr>

        <tr class="active">
            <td style="text-align: right; padding:5px">
                <strong>Número De Cuenta :</strong>
            </td>
            <td style="text-align: right; padding:5px">{{ $data->bank_account_number }}</td>
        </tr>

        <tr class="active">
            <td width="60%" style="text-align: right; padding:5px">
                <strong>Valor A Transferir :</strong>
            </td>
            <td width="40%" style="text-align: right; padding:5px"> Bss. {{ $data->headline_amount }}
            </td>
        </tr>
    </table>

    <table width='100%'
        style="background-color:#f5f5f5; border-collapse: collapse; border-spacing: 0; margin-top: 20px">
        <tr>
            <td style="text-align: right; padding:5px">
                <strong>Pesos Argentinos ARS :</strong>
            </td>
            <td style="text-align: right; padding:5px">
                $ Pesos {{ $data->client_amount }} Ars.
            </td>
        </tr>
        <tr>
            <td width="70%" style="text-align: right;"><strong>Forma de Pago:</strong></td>
            <td width="30%" style="text-align: right; padding:5px">{{ $data->payment_name }}</td>
        </tr>
    </table>
    <table width='100%' style="border-collapse: collapse; border-spacing: 0; margin-top: 40px">
        <tr>
            <td style="text-align: center">
                <strong>
                    Nota: Las transferencias que se realizan de un banco a otro
                    pueden llegar a tardar hasta 48 horas en
                    hacerse efectivas. Por favor guarde este recibo hasta que su
                    dinero se vea reflejado en su cuenta.
                </strong>
            </td>
        </tr>
    </table>
    <table width='100%'
        style="background-color:#f5f5f5; border-collapse: collapse; border-spacing: 0; margin-top: 20px">
        <tr>
            <td style="text-align: right; padding:5px">
                Comprobante no v&aacute;lido como factura
            </td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>S&iacute;guenos en Instagram @megaenvios.arg</strong></td>
        </tr>
    </table>
</body>

</html>
