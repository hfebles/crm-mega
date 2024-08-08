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
                            @can('client-create')
                                <a class="btn btn-success btn-sm" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                    <i class="fas fa-plus-circle"></i> Nueva Cuenta
                                </a>
                            @endcan
                            @can('client-edit')
                                <a class="btn btn-warning btn-sm" type="button" onclick=""
                                    href="{{ route('clients.edit', $client->_id) }}">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                            @endcan
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
                            <td>Editar</td>
                        </tr>
                        @foreach ($clientAccounts as $account)
                            <tr class="text-uppercase text-center">
                                <td>{{ $account->headline }}</td>
                                <td>{{ $account->headline_dni }}</td>
                                <td>{{ $account->bank_account_number }}</td>
                                <td>{{ $account->bank_name }}</td>
                                <td><a class="btn btn-warning btn-sm" type="button"
                                        onclick="editClientAccount({{ $account->_id }});" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasExample2" aria-controls="offcanvasExample">
                                        <i class="fas fa-edit"></i></td>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nueva Cuenta asociada</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <form method="POST" action="{{ route('clients-accounts.store') }}">
                @csrf
                <input type="hidden" name="client_id" value="{{ $client->_id }}">
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Bancos:</label>
                        <select required class="form-select form-select-sm" name="bank_id" id="bank_id">
                            <option value="">Seleccione</option>
                            @foreach ($banks as $kBank => $VBank)
                                <option value="{{ $kBank }}">{{ $VBank }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Nro de cuenta:</label>
                        <input onkeypress="return soloNumeros(event);" required autocomplete="off" type="text"
                            class="form-control form-control-sm" name="bank_account_number" id="bank_account_number">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">Nombre del titular</label>
                        <input required autocomplete="off" type="text" class="form-control form-control-sm"
                            name="headline" id="headline">
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group">
                        <label for="name">DNI del titular</label>
                        <input required autocomplete="off" type="text" class="form-control form-control-sm"
                            name="headline_dni" id="headline_dni">
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-success btn-sm" type="submit">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample2" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nueva Cuenta asociada</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <div id="content-update"></div>
        </div>
    </div>

@stop
@section('plugins.Boostrap5', true)
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const variable = 'VE'
            if (variable == '{{ $client->country }}') {
                document.querySelector("#bank_account_number").setAttribute('minlength', "20");
                document.querySelector("#bank_account_number").setAttribute('maxlength', "20");
            }
        });

        function editClientAccount(value) {
            console.log(value)
            fetch(`/clients-accounts/edit-account/${value}`, {
                    method: 'GET',

                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.response)
                    document.querySelector('#content-update').innerHTML = data.response;
                    document.querySelector("#bank_account_number2").setAttribute('minlength', "20");
                    document.querySelector("#bank_account_number2").setAttribute('maxlength', "20");
                })
                .catch(error => console.error('Error:', error));
        }

        function soloNumeros(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = "1234567890";
            especiales = [];

            tecla_especial = false
            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial)
                return false;
        }
    </script>
@endpush
