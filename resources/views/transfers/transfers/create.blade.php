@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', 'Nueva transferencia')

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
                            <h3>Nueva transferencia</h3>
                        </div>
                        <div class="w-10">
                            <button data-bs-toggle="modal" data-bs-target="#newUserModal" class="btn btn-success btn-sm"
                                type="button" href="">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i> Nuevo Cliente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <form action="{{ route('transfers.store') }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row align-middle">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Cliente</label>
                                    <select class="form-select form-select-sm" name="client_id" id="client_id"
                                        onchange="findClient(this.value);">
                                        <option value="">Seleccione</option>
                                        @foreach ($datas['clients'] as $kClient => $vClient)
                                            <option value="{{ $kClient }}">
                                                {{ $vClient }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Cuenta de destino</label>
                                    <select disabled onchange="searchBank(this.value);" class="form-select form-select-sm"
                                        name="client_account_id" id="client_account_id">
                                        <option value="">Seleccione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Banco:</label>
                                    <input disabled type="text" class="form-control form-control-sm" name="bank_name"
                                        id="bank_name">
                                    <input type="hidden" name="bank_id" id="bank">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Titlar</label>
                                    <input autocomplete="off" disabled type="text" class="form-control form-control-sm"
                                        name="headline" id="headline">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">DNI Titular</label>
                                    <input autocomplete="off" disabled type="text" class="form-control form-control-sm"
                                        name="headline_dni" id="headline_dni">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Tasa</label>
                                    <select class="form-select form-select-sm" name="rate" id="rates">
                                        <option value="">Seleccione</option>
                                        @foreach ($datas['rates'] as $kRate => $vRate)
                                            <option value="{{ $kRate }}">{{ $vRate }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Metodo de pago</label>
                                    <select class="form-select form-select-sm" name="pay_method" id="rate">
                                        <option value="">Seleccione</option>
                                        @foreach ($datas['method_pay'] as $kMP => $vMP)
                                            <option value="{{ $kMP }}">{{ $vMP }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Importe Envio</label>
                                    <input onkeyup="calcularImporte(this.value);" autocomplete="off" type="text"
                                        class="form-control form-control-sm" name="client_amount" id="importe">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Importe Recibe</label>
                                    <input disabled autocomplete="off" type="text" class="form-control form-control-sm"
                                        name="importe_bs" id="importe_bs">
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success btn-sm" type="submit">Guardar</button>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="headline_amount" id="importe_bs2">
            </form>
        </div>
    </div>

    <div class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <form action="{{ route('clients.store') }}" method="post">

                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Cliente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="clientNew" value="2">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Pais</label>
                                    <select required onchange="searchCode(this.value);" class="form-select form-select-sm"
                                        name="country" id="country">
                                        <option value="">Seleccione</option>
                                        @foreach ($countries as $kCountry => $Vcountry)
                                            <option value="{{ $kCountry }}">{{ $Vcountry }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="code" id="code">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Codigo:</label>
                                    <h4 id="codigo"></h4>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input required autocomplete="off" disabled type="text"
                                        class="form-control form-control-sm" name="name" id="name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">DNI</label>
                                    <input required onkeyup="searchDNI(this)" autocomplete="off" disabled type="text"
                                        class="form-control form-control-sm" name="dni" id="dni">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Telefono</label>
                                    <input required maxlength="11" minlength="11" onkeypress="return soloNumeros(event);"
                                        autocomplete="off" disabled type="text" class="form-control form-control-sm"
                                        name="phone" id="phone">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Cedula</label>
                                    <input onkeypress="return soloNumeros(event);" autocomplete="off" type="text"
                                        class="form-control form-control-sm" name="cedula" id="cedula">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-6">
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nro de cuenta:</label>
                                    <input onkeypress="return soloNumeros(event);" required autocomplete="off"
                                        type="text" class="form-control form-control-sm" name="bank_account_number"
                                        id="bank_account_number">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre del titular</label>
                                    <input required autocomplete="off" type="text"
                                        class="form-control form-control-sm" name="headline" id="headline">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">DNI del titular</label>
                                    <input required autocomplete="off" type="text"
                                        class="form-control form-control-sm" name="headline_dni" id="headline_dni">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-success">Nuevo Cliente</button>
                    </div>
            </form>

        </div>
    </div>
    </div>

@stop
@section('plugins.Boostrap5', true)


@push('js')
    <script>
        const csrfToken = "{{ csrf_token() }}";

        function searchCode(value) {
            fetch(`/clients/search-code/${value}`, {
                    method: 'get',
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#code').value = data.lastCode;
                    document.querySelector('#codigo').innerHTML = data.code;
                    document.querySelector('#name').disabled = false
                    document.querySelector('#dni').disabled = false
                    document.querySelector('#phone').disabled = false
                    document.querySelector('#name').focus()
                })
                .catch(error => console.error('Error:', error));
        }

        function findClient(idClient) {
            fetch(`/clients/find-client/${idClient}`, {
                    method: 'get',
                })
                .then(response => response.json())
                .then(data => {
                    const accounts = data.clientAccounts;
                    var lines = '<option value="">Seleccione</option>';
                    for (let i in data.clientAccounts) {
                        lines += `<option value="${accounts[i]._id}">${accounts[i].bank_account_number}</option>`;
                    }
                    var lines2 = '<option value="">Seleccione</option>';

                    document.querySelector('#client_account_id').disabled = false
                    document.querySelector('#client_account_id').innerHTML = lines;


                })
                .catch(error => console.error('Error:', error));
        }

        function calcularImporte(amount) {
            const rateId = document.querySelector('#rates').value
            fetch(`/mantenice/rates/calculate-amount`, {
                    method: 'post',
                    body: JSON.stringify({
                        rateId: rateId,
                        amount: amount,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#importe_bs').value = data.amount.toFixed(0);
                    document.querySelector('#importe_bs2').value = data.amount.toFixed(0);

                })
                .catch(error => console.error('Error:', error));

        }

        function searchBank(bankId) {
            fetch(`/mantenice/banks/search/${bankId}`, {
                    method: 'get',
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#bank_name').value = data.bank_name;
                    document.querySelector('#headline').value = data.headline;
                    document.querySelector('#bank').value = data.bankId;
                    document.querySelector('#headline_dni').value = data.headline_dni
                })
                .catch(error => console.error('Error:', error));
        }

        function searchDNI(input) {
            fetch(`/clients/search-dni/${input.value}`, {
                    method: 'get',
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.result == 'true') {
                        Swal.fire({
                            title: "Error",
                            text: `El DNI: ${input.value} ¡Ya existe!`,
                        });
                        input.value = ''
                    }
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
