@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', 'Editar cliente')

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
                            <h3>Editar cliente</h3>
                        </div>
                        <div class="w-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-12">
            <form action="{{ route('clients.update', $client->_id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Pais</label>
                                    <select required onchange="searchCode(this.value);" class="form-control form-select-sm"
                                        name="country" id="country">
                                        <option value="{{ $client->country }}">{{ $client->country_name }}</option>
                                        @foreach ($countries as $kCountry => $Vcountry)
                                            <option value="{{ $kCountry }}">{{ $Vcountry }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Codigo:</label>
                                    <h4 id="codigo">
                                        {{ $client->country }}{{ str_pad($client->code, 4, '0', STR_PAD_LEFT) }}</h4>
                                    <input type="hidden" value="{{ $client->code }}" name="code" id="code">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input required autocomplete="off" type="text" class="form-control form-control-sm"
                                        value="{{ $client->names }}" name="name" id="name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">DNI</label>
                                    <input required value="{{ $client->dni }}" onkeyup="searchDNI(this)"
                                        autocomplete="off" type="text" class="form-control form-control-sm"
                                        name="dni" id="dni">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Telefono</label>
                                    <input required value="{{ $client->phone }}" required maxlength="11" minlength="11"
                                        onkeypress="return soloNumeros(event);" autocomplete="off" type="text"
                                        class="form-control form-control-sm" name="phone" id="phone">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Cedula</label>
                                    <input value="{{ $client->cedula }}" onkeyup="searchDNI(this)" autocomplete="off"
                                        type="text" class="form-control form-control-sm" name="dni" id="dni">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 bt-3">
                            <button class="btn btn-success btn-sm btn-block" type="submit">Guardar</button>
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
            if (!{{ $client->code }} || value != '{{ $client->country }}') {
                fetch(`/clients/search-code/${value}`, {
                        method: 'get',
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#code').value = data.lastCode;
                        document.querySelector('#codigo').innerHTML = data.code;
                    })
                    .catch(error => console.error('Error:', error));

                if (value === "VE") {
                    document.querySelector("#bank_account_number").setAttribute('minlength', "20");
                    document.querySelector("#bank_account_number").setAttribute('maxlength', "20");
                }
            } else {
                document.querySelector('#code').value = "{{ $client->code }}"

                document.querySelector('#codigo').innerHTML =
                    "{{ $client->country }}{{ str_pad($client->code, 4, '0', STR_PAD_LEFT) }}";
            }

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
