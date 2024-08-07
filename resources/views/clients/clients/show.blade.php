@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', $client->names)

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
                            <h3>Cliente: {{ $client->names }} -
                                {{ $client->country }}{{ str_pad($client->code, 4, '0', STR_PAD_LEFT) }}</h3>
                        </div>
                        <div class="w-10">
                            <a class="btn btn-warning btn-sm" type="button" onclick=""
                                href="{{ route('clients.edit', $client->_id) }}">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-header p-2 text-center">
                    <h5 class="mb-0">Perfil</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0 table-bordered">
                        <tr class="text-uppercase bg-dark ">
                            <td width="40%">Codigo</td>
                            <td> {{ $client->country }}{{ str_pad($client->code, 4, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr class="text-uppercase ">
                            <td>Nombres y apellidos</td>
                            <td>{{ $client->names }}</td>
                        </tr>
                        <tr class="text-uppercase ">
                            <td>DNI</td>
                            <td>{{ $client->dni }}</td>
                        </tr>
                        <tr class="text-uppercase ">
                            <td>Telefono</td>
                            <td>{{ $client->phone }}</td>
                        </tr>
                        <tr class="text-uppercase ">
                            <td>Pais</td>
                            <td>{{ $client->country }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-header p-2 text-center">
                    <h5 class="mb-0">Cuentas asociadas</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0 table-bordered">
                        <tr class="text-uppercase bg-dark text-center">
                            <td>Nombre titular</td>
                            <td>DNI Titular</td>
                            <td>Numero de Cuenta</td>
                            <td>Banco</td>
                        </tr>
                        @foreach ($clientAccounts as $account)
                            <tr class="text-uppercase text-center">
                                <td> {{ $account->headline }}</td>
                                <td>{{ $account->headline_dni }}</td>
                                <td>{{ $account->bank_account_number }}</td>
                                <td>{{ $account->bank_name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header p-2 text-center">
                    <h5 class="mb-0">Operaciones realizadas</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered mb-0">
                        <tr class="text-uppercase bg-dark text-center">
                            <td width=10%>Fecha</td>
                            <td width=15%>Importe</td>
                            <td width=7%>Tasa</td>
                            <td>Titular</td>
                            <td>Nro. Cuenta</td>
                            <td width=15%>Importe recibido</td>
                            <td width=10%>Banco</td>
                        </tr>
                        @foreach ($transfers as $transfer)
                            <tr class="text-uppercase">
                                <td class="text-center">{{ date('d/m/Y', strtotime($transfer->date)) }}</td>
                                <td class="text-right">
                                    ${{ number_format($transfer->client_amount, 2, ',', '.') }}
                                </td>
                                <td class="text-right">{{ number_format($transfer->rate_amount, 5, ',', '.') }}</td>
                                <td class="text-center">{{ $transfer->headline }}</td>
                                <td class="text-center">{{ $transfer->bank_account_number }}</td>
                                <td class="text-right">{{ $client->country != 'VE' ? '$' : '' }}
                                    {{ number_format($transfer->headline_amount, 2, ',', '.') }}
                                    {{ $client->country == 'VE' ? 'Bss' : "$" }}</td>
                                <td class="text-center">{{ $transfer->bank_name }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop
