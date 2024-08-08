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
                            <a href="{{ route('home') }}" type="button" class="btn btn-dark btn-sm"><i
                                    class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Lista de usuarios</h3>
                        </div>

                        <div class="w-10">
                            @can('user-create')
                                <a type="button" class="btn btn-success btn-sm" href="{{ route('users.create') }}">
                                    <i class="fas fa-plus-circle"></i>
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
                    <table class="table table-sm table-bordered align-middle mb-0">
                        <thead class="thead-dark text-uppercase text-center">
                            <tr>
                                <th width="4%">#</th>
                                <th>Nombre</th>
                                <th>correo</th>
                                <th>Grupo</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($data) > 0)
                                @foreach ($data as $key => $user)
                                    <tr>
                                        <td class="text-center">{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if (!empty($user->getRoleNames()))
                                                @foreach ($user->getRoleNames() as $v)
                                                    <span class="badge bg-success">{{ $v }}</sp>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @can('user-list')
                                                    <a class="btn btn-info btn-sm"
                                                        href="{{ route('users.show', $user->id) }}"><i class="fas fa-eye"
                                                            aria-hidden="true"></i></a>
                                                @endcan
                                                <a class="btn btn-warning btn-sm"
                                                    href="{{ route('users.edit', $user->id) }}"><i
                                                        class="fas fa-edit"></i></a>
                                                @can('user-delete')
                                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                                        style="display:inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
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

                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
