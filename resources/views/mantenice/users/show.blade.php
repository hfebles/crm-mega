@extends('layouts.app')

@section('subtitle', 'Usuarios')
@section('content_header_title', 'Configuraciones')
@section('content_header_subtitle', 'Usuarios')

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="w-10">
                            <a href="{{ route('users.index') }}" type="button" class="btn btn-dark btn-sm"><i
                                    class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Ver usuario</h3>
                        </div>

                        <div class="w-10">
                            @can('user-edit')
                                <a type="button" class="btn btn-warning btn-sm" href="{{ route('users.edit', $user->id) }}">
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
                    <h5 class="mb-0">Perfil</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-0 table-bordered">

                        <tr class="text-uppercase ">
                            <td>Nombres y apellidos</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr class="text-uppercase ">
                            <td>Email</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr class="text-uppercase ">
                            <td>Grupo de usuario</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>

    </div>

@stop
