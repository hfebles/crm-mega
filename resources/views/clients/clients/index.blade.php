@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', $config['content_header_subtitle'])

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="w-10">
                            <a href="{{ route('home') }}" type="button" class="btn btn-dark btn-sm"><i
                                    class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Lista de clientes</h3>
                        </div>

                        <div class="w-10">
                            @can('client-create')
                                <a class="btn btn-success btn-sm" type="button" href="{{ route('clients.create') }}">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body mb-0">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-6">
                                    <input class="form-control form-control-sm" type="text" placeholder="Buscar"
                                        name="search" id="search" onkeyup="search(this.value);">
                                </div>
                                <div class="col-6">
                                    <select class="form-select form-select-sm" name="campo" id="campo">
                                        <option value="names">Nombre</option>
                                        <option value="code">Codigo</option>
                                        <option value="dni">Dni</option>
                                        <option value="phone">Telefono</option>
                                    </select>
                                </div>
                            </div>


                        </div>
                        <div class="col-12">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <tr class="text-uppercase text-center thead-dark">
                                    <th width="4%">codigo</th>
                                    <th width="10%">dni</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th width="10%">Acciones</th>
                                </tr>
                                <tbody id="client-list">
                                    @include('clients.clients.partials.client_list')
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination" style="justify-content: flex-end" class="col-12 mt-3 mb-0 d-flex">
                            @include('clients.clients.partials.pagination')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('plugins.Boostrap5', true)

@push('js')
    <script>
        const csrfToken = "{{ csrf_token() }}";

        function search(value) {
            var campo = document.querySelector('#campo').value;
            fetch(`/clients?value=${encodeURIComponent(value)}&campo=${encodeURIComponent(campo)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    document.getElementById('client-list').innerHTML = data.clients;
                    document.getElementById('pagination').innerHTML = data.pagination;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endpush
