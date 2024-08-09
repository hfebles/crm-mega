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
                            <a href="{{ $config['back'] }}" type="button" class="btn btn-dark btn-sm">
                                <i class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Nueva transferencia</h3>
                        </div>
                        <div class="w-10">
                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i> Nueva cuenta
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
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Cuenta de destino</label>
                                    <select required class="form-select form-select-sm" name="client_account_id"
                                        id="client_account_id" onchange="searchBank(this.value);">
                                        <option value="">Seleccione</option>
                                        @foreach ($datas['client_account'] as $data_client_account)
                                            <option value="{{ $data_client_account->_id }}">
                                                {{ $data_client_account->bank_account_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Banco:</label>
                                    <input disabled type="text" class="form-control form-control-sm" id="bank_name">
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
                                    <select required class="form-select form-select-sm" name="rate" id="rate">
                                        <option value="">Seleccione</option>
                                        @foreach ($ratex as $kRate => $vRate)
                                            <option value="{{ $kRate }}">{{ $vRate }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Metodo de pago</label>
                                    <select required class="form-select form-select-sm" name="pay_method" id="pay_method">
                                        <option value="">Seleccione</option>
                                        @foreach ($datas['methodPays'] as $kPay => $vPay)
                                            <option value="{{ $kPay }}">{{ $vPay }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Importe</label>
                                    <input required onkeypress="return soloNumeros(event);" onkeyup="calcularImporte(this);"
                                        autocomplete="off" type="text" class="form-control form-control-sm"
                                        name="client_amount" id="importe">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Importe</label>
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

                <input type="hidden" name="client_id" value="{{ $datas['client']->_id }}">
                <input type="hidden" name="headline_amount" id="importe_bs2" value="{{ $datas['client']->_id }}">
            </form>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('clients-accounts.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Nueva cuenta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
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
                                    <input required onkeypress="return soloNumeros(event);" autocomplete="off"
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
                        <input type="hidden" name="client_id" value="{{ $datas['client']->_id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="subnit" class="btn btn-success">Guardar</button>
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

        function calcularImporte(amount) {
            const rateId = document.querySelector('#rate')

            if (rateId.value == '') {
                Swal.fire({
                    title: "Error",
                    text: `Debe seleccionar una tasa`,
                });

                amount.value = ''
                rateId.focus()
                return;
            }

            fetch(`/mantenice/rates/calculate-amount`, {
                    method: 'post',
                    body: JSON.stringify({
                        rateId: rateId.value,
                        amount: amount.value,
                    }),
                    headers: {
                        'content-type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#importe_bs').value = data.amount.toFixed(2);
                    document.querySelector('#importe_bs2').value = data.amount.toFixed(2);

                })
                .catch(error => console.error('Error:', error));


        }

        function searchBank(accountId) {
            fetch(`/mantenice/banks/search/${accountId}`, {
                    method: 'get',
                })
                .then(response => response.json())
                .then(data => {
                    console.table(data)

                    document.querySelector('#bank_name').value = data.bank_name;
                    document.querySelector('#bank').value = data.bankId;
                    document.querySelector('#headline').value = data.headline;
                    document.querySelector('#headline_dni').value = data.headline_dni
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

        function soloNumerosComa(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = "1234567890,";
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
