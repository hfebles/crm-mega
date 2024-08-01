@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', 'Nuevo cliente')

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
                            <h3>Nuevo cliente</h3>
                        </div>
                        <div class="w-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <form action="{{ route('clients.store') }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Pais</label>
                                    <select onchange="searchCode(this.value);" class="form-control form-select-sm"
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
                                    <input autocomplete="off" disabled type="text" class="form-control form-control-sm"
                                        name="name" id="name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">DNI</label>
                                    <input onkeyup="searchDNI(this)" autocomplete="off" disabled type="text"
                                        class="form-control form-control-sm" name="dni" id="dni">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Telefono</label>
                                    <input onkeypress="return soloNumeros(event);" autocomplete="off" disabled
                                        type="text" class="form-control form-control-sm" name="phone" id="phone">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Bancos:</label>
                                    <select class="form-control form-select-sm" name="bank_id" id="bank_id">
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
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        name="bank_account_number" id="bank_account_number">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre del titular</label>
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        name="headline" id="headline">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">DNI del titular</label>
                                    <input autocomplete="off" type="text" class="form-control form-control-sm"
                                        name="headline_dni" id="headline_dni">
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-success btn-sm" type="submit">Guardar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('js')
    <script>
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
            letras = "1234567890.";
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
