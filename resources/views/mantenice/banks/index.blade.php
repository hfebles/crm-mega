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
                            <a href="{{ route('home') }}" type="button" class="btn btn-dark btn-sm">Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Lista de bancos</h3>
                        </div>

                        <div class="w-10">

                            <button class="btn btn-success btn-sm" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                Nuevo
                            </button>
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
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase text-center">
                                <th width="4%">#</th>
                                <th>Nombre</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas) > 0)
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class="text-center">{{ $data->_id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <button class="btn btn-warning btn-sm" type="button"
                                                    onclick="editBanks({{ $data->_id }})" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasExampleEdit"
                                                    aria-controls="offcanvasExampleEdit">
                                                    Editar
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm">Eliminar</button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="3">No existen bancos registrados.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="col-12 mt-3 text-center">
                        {{ $datas->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nuevo Banco</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('banks.store') }}">
                @csrf
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre del Banco
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='name'
                            placeholder='Nombre del Banco' />
                    </div>
                    <div class='col-12 mt-4'>
                        <button class='btn btn-success btn-sm' type='submit'>Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExampleEdit"
        aria-labelledby="offcanvasExampleLabelEdit">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Editar Banco</h5>
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
        function editBanks(id) {
            fetch(`/mantenice/banks/${id}/edit`, {
                    method: 'GET',
                    params: {
                        id: id
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data.response)
                    document.querySelector('#content-update').innerHTML = data.response;
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
@endpush
