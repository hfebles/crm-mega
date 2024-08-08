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
                            <h3>Editar nuevo grupo</h3>
                        </div>

                        <div class="w-10">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <form action="{{ route('roles.update', $role->id) }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>

                                    <input required autocomplete="off" type="text" name="name" placeholder="Nombre"
                                        class="form-control form-control-sm" value="{{ $role->name }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Permisos:</label>
                                    <div class="row">
                                        @foreach ($permission as $value)
                                            <div class="col-3">
                                                <label><input type="checkbox" name="permission[{{ $value->id }}]"
                                                        value="{{ $value->id }}" class="name"
                                                        {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                    {{ $value->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

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
