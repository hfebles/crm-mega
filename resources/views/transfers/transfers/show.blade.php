@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', 'Transferencia')

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="w-10">
                            <a href="{{ $config['back'] }}" type="button" class="btn btn-dark btn-sm"><i
                                    class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Transferencia {{ str_pad($data->transferId, 8, '0', STR_PAD_LEFT) }}</h3>
                        </div>
                        <div class="w-10">
                            <a target="_blank" href="{{ route('transfers.print-invoice', $data->transferId) }}"
                                type="button" class="btn btn-info btn-sm"> <i class="fas fa-print" aria-hidden="true"></i>
                                Imprimir</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <pre id="textCopy">

                        @if ($data->rate_type == 2)
*No. {{ str_pad($data->op_date, 8, '0', STR_PAD_LEFT) }} ({{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }})*
CBU: {{ $data->bank_account_number }}
Titular: {{ $data->headline }}
Banco: {{ $data->bankName }}
Env&iacute;a: ${{ number_format($data->headline_amount, 0, '', '.') }} 🇨🇴
Recibe: ${{ number_format($data->client_amount, 0, '', '.') }} 🇦🇷
*_V&iacute;a: {{ $data->payment_name }}_*
@else
*No. {{ str_pad($data->op_date, 8, '0', STR_PAD_LEFT) }} ({{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }})*
Cuenta: {{ $data->bank_account_number }}
Titular: {{ $data->headline }}
Cédula: {{ $data->headline_dni }}
Banco: {{ $data->bankName }}
@if ($data->country == 'VE')
Valor: {{ number_format($data->headline_amount, 0, '', '.') }} Bss. 🇻🇪
Env&iacute;a: ${{ number_format($data->client_amount, 0, '', '.') }} Ars. 🇦🇷
@else
Env&iacute;a: ${{ number_format($data->headline_amount, 0, '', '.') }} 🇦🇷
Recibe: ${{ number_format($data->client_amount, 0, '', '.') }} Pesos. 🇨🇴
@endif
*_V&iacute;a: {{ $data->payment_name }}_*
@endif
</pre>
                    <button class="btn btn-success" onclick="copiarTexto()">Copiar</button>

                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card">
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>
                                <strong>Transferencia No:</strong>
                            </td>
                            <td>
                                {{ str_pad($data->transferId, 8, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>C&oacute;digo De Cliente:</strong>
                            </td>
                            <td>
                                {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}
                            </td>
                        </tr>
                        <tr>
                            <td> <strong> Nombre Completo:</strong></td>
                            <td>{{ $data->headline }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Cédula :</strong>
                            </td>
                            <td>{{ $data->headline_dni }}</td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Banco :</strong>
                            </td>
                            <td>{{ $data->bankName }}</td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Número De Cuenta :</strong>
                            </td>
                            <td>{{ $data->bank_account_number }}</td>
                        </tr>

                        <tr>
                            <td width="60%">
                                <strong>Valor A Transferir :</strong>
                            </td>
                            <td width="40%"> Bss. {{ $data->headline_amount }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>



@stop
@push('js')
    <script>
        function copiarTexto() {
            const parrafo = document.querySelector('#textCopy');
            navigator.clipboard.writeText(parrafo.textContent);
            alert("Texto copiado al portapapeles.");
        }
    </script>
@endpush
