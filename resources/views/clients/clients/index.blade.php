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
                            <a class="btn btn-success btn-sm" type="button" href="{{ route('clients.create') }}">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <input type="text" placeholder="Buscar" name="search" id="search" onkeyup="search(this.value);">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-0">
                <div class="card-body mb-0">
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase text-center">
                                <th width="4%">codigo</th>
                                <th width="10%">dni</th>

                                <th>Nombre</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="client-list">
                            @include('clients.clients.partials.client_list')
                            {{-- @if (count($datas) > 0)
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class="text-center">
                                            {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="text-center">{{ $data->dni }}</td>

                                        <td>{{ $data->names }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('transfers.new-transfer', $data->_id) }}"
                                                    class="btn btn-info btn-sm text-white" type="button">
                                                    <i class="fas fa-paper-plane"></i>
                                                </a>
                                                <button class="btn btn-warning btn-sm" type="button" onclick=""
                                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasExampleEdit"
                                                    aria-controls="offcanvasExampleEdit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm"><i
                                                        class="fas fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="3">No existen bancos registrados.</td>
                                </tr>
                            @endif --}}
                        </tbody>
                    </table>
                    <div id="pagination" class="col-12 mt-3 text-center ">
                        @include('clients.clients.partials.pagination')
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
            fetch(`/clients?value=${encodeURIComponent(value)}`, {
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
