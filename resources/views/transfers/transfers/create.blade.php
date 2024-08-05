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
                            <a href="{{ $config['back'] }}" type="button" class="btn btn-dark btn-sm">Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Nueva transferencia</h3>
                        </div>
                        <div class="w-10">

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
                                    <select class="form-select form-select-sm" name="rate" id="rate">
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
                                    <label for="name">Importe Pesos</label>
                                    <input onkeyup="calcularImporte(this.value);" autocomplete="off" type="text"
                                        class="form-control form-control-sm" name="client_amount" id="importe">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Importe Bs</label>
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




@stop
@section('plugins.Boostrap5', true)


@push('js')
    <script>
        const csrfToken = "{{ csrf_token() }}";

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
                    document.querySelector('#client_account_id').disabled = false
                    document.querySelector('#client_account_id').innerHTML = lines;

                })
                .catch(error => console.error('Error:', error));
        }

        function calcularImporte(amount) {
            const rateId = document.querySelector('#rate').value

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
                    console.log(data)
                    document.querySelector('#importe_bs').value = data.amount.toFixed(2);
                    document.querySelector('#importe_bs2').value = data.amount.toFixed(2);

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
    </script>
@endpush
