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
                            <h3>Lista de dinero ingresado</h3>
                        </div>

                        <div class="w-10">
                            @can('bs-create')
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
                                <th>Banco</th>
                                <th>Ingresado</th>
                                <th>Disponible</th>
                                <th>Fecha</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($datas) > 0)
                                @foreach ($datas as $keys => $data)
                                    <tr>
                                        <td class="text-center">{{ ++$keys }}</td>
                                        <td class="text-center">{{ $data->name }}</td>
                                        <td class="text-end">{{ number_format($data->amount, 2, ',', '.') }}</td>
                                        <td class="text-end">
                                            {{ $data->resto ? $data->resto : number_format($data->amount, 2, ',', '.') }}
                                        </td>
                                        <td class="text-center">{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @can('bs-create')
                                                    <button class="btn btn-warning btn-sm" type="button"
                                                        onclick="editBanks({{ $data->_id }})" data-bs-toggle="offcanvas"
                                                        data-bs-target="#offcanvasExampleEdit"
                                                        aria-controls="offcanvasExampleEdit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="text-center">
                                    <td colspan="6">No existen registros.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>


                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Nuevo registro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="POST" action="{{ route('bs.store') }}">
                @csrf
                <div class='form-group col-md-12'>
                    <label for='name'>
                        Nombre del Banco
                    </label>
                    <select class="form-select form-select-sm" name="bank_id" id="bank_id" required>
                        <option value="">Seleccione</option>
                        @foreach ($banks as $bKey => $bValue)
                            <option value="{{ $bKey }}">{{ $bValue }}</option>
                        @endforeach
                    </select>
                    <label class="mt-3" for='name'>
                        Monto
                    </label>
                    <input type="text" name="amount" required class="form-control form-control-sm">
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
            fetch(`/mantenice/bs/${id}/edit`, {
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
