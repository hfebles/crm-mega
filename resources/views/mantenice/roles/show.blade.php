@extends('layouts.app')

@section('subtitle', 'Grupo de Usuarios')
@section('content_header_title', 'Configuraciones')
@section('content_header_subtitle', 'Grupo de Usuarios')


@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="w-10">
                            <a href="{{ route('roles.index') }}" type="button" class="btn btn-dark btn-sm"><i
                                    class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Ver grupo de usuarios</h3>
                        </div>

                        <div class="w-10">
                            @can('roles-edit')
                                <a type="button" class="btn btn-warning btn-sm" href="{{ route('roles.edit', $role->id) }}">
                                    <i class="fas fa-edit"></i> Editar
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
            <div class="card">
                <div class="card-header p-2 text-center">
                    <h5 class="mb-0">{{ $role->name }}</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0 table-bordered">

                        <tr class="text-uppercase ">
                            <td>Nombre</td>
                            <td>{{ $role->name }}</td>
                        </tr>
                        <tr class="text-uppercase">
                            <td class="align-middle">Permisos</td>
                            <td>
                                <div class="row">

                                    @if (!empty($rolePermissions))
                                        @foreach ($rolePermissions as $v)
                                            <div class="col-3">
                                                <label class="label label-success">{{ $v->name }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>

@stop
