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
                            <h3>Editar usuario</h3>
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

            <form action="{{ route('users.update', $user->id) }}" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>

                                    <input type="text" name="name" placeholder="Nombre"
                                        class="form-control form-control-sm" value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Email:</label>
                                    <input type="email" name="email" placeholder="Email"
                                        class="form-control form-control-sm" value="{{ $user->email }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Password</label>
                                    <input type="password" name="password" placeholder="Password"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Confirme el password</label>
                                    <input type="password" name="confirm-password" placeholder="Confirme el password"
                                        class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Grupo de usuario:</label>
                                    <select name="roles[]" class="form-control form-control-sm" multiple="multiple">
                                        @foreach ($roles as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ isset($userRole[$value]) ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
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
