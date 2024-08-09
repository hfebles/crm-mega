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
                            <h3>Lista de Tasas</h3>
                        </div>

                        <div class="w-10">
                            @can('rate-create')
                                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                                    <i class="fas fa-plus-circle" aria-hidden="true"></i>
                                </button>
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
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="thead-dark text-uppercase text-center">
                            <tr>
                                <th width="4%">#</th>
                                <th>Nombre</th>
                                <th width="7%">Monto</th>
                                <th>Pais</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas) > 0)
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class="text-center">{{ $data->_id }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td class="text-end">{{ number_format($data->amount, 5, ',', '.') }}</td>
                                        <td class="text-center">{{ $data->countryName }}</td>
                                        <td class="text-center">
                                            <div class="btn-group " role="group" aria-label="Basic example">
                                                @can('method-edit')
                                                    <button class="btn btn-warning btn-sm" type="button"
                                                        onclick="editRates({{ $data->_id }})" data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasExampleEdit"
                                                        aria-controls="offcanvasExampleEdit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endcan
                                                @can('method-delete')
                                                    <a href="{{ route('rates.delete', $data->_id) }}" type="button"
                                                        class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="5">No existen registros.</td>
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
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nueva Tasa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('rates.store') }}">
                @csrf
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre de la tasa
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='name'
                            placeholder='Nombre de la tasa' />
                    </div>
                    <label for='name'>
                        Monto
                    </label>
                    <div class='input-group'>
                        <input class='form-control form-control-sm' required name='amount' placeholder='Monto' />
                    </div>
                    <label for='name'>
                        Pais
                    </label>
                    <select class="form-select form-select-sm" name="country" id="country">
                        <option value="">Seleccione</option>
                        @foreach ($countries as $kContry => $vContry)
                            <option value="{{ $kContry }}">{{ $vContry }}</option>
                        @endforeach
                    </select>
                    <label for='name'>
                        Tipo de tasa
                    </label>
                    <select class="form-select form-select-sm" name="type" id="type">
                        <option value="1">Envio</option>
                        <option value="2">Recibe</option>
                    </select>
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
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Editar Tasa</h5>
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
        function editRates(id) {
            fetch(`/mantenice/rates/${id}/edit`, {
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
