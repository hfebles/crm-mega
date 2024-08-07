@extends('layouts.app')

@section('subtitle', $config['subtitle'])
@section('content_header_title', $config['content_header_title'])
@section('content_header_subtitle', 'Lista de operaciones')

@section('content_body')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="w-10">
                            <a href="{{ route('home') }}" type="button" class="btn btn-dark btn-sm">
                                <i class="fas fa-chevron-circle-left" aria-hidden="true"></i> Regresar</a>
                        </div>
                        <div class="w-80">
                            <h3>Lista de Operaciones</h3>
                        </div>
                        <div class="w-10">
                            <a class="btn btn-success btn-sm" type="button" href="{{ $config['create'] }}">
                                <i class="fas fa-plus-circle" aria-hidden="true"></i>
                            </a>
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
                                <th width="4%">c&oacute;digo</th>
                                <th width="7%">Transacci&oacute;n</th>
                                <th>Nombre del cliente</th>
                                <th>Importes</th>
                                <th width="7%">Fecha</th>
                                <th width="10%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (count($datas) > 0)
                                @foreach ($datas as $data)
                                    <tr>
                                        <td class="text-center">
                                            {{ $data->country }}{{ str_pad($data->code, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td class="text-center">{{ str_pad($data->_id, 8, '0', STR_PAD_LEFT) }}</td>
                                        <td class="text-center">{{ $data->names }}</td>
                                        <td class="text-center">ARS$ {{ $data->client_amount }} / Bs.
                                            {{ $data->headline_amount }}</td>
                                        <td class="text-center">{{ date('d/m/Y', strtotime($data->date)) }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('transfers.show', $data->_id) }}"
                                                    class="btn btn-info btn-sm" type="button">
                                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a target="_blank"
                                                    href="{{ route('transfers.print-invoice', $data->_id) }}"
                                                    class="btn btn-warning btn-sm" type="button">
                                                    <i class="fas fa-print" aria-hidden="true"></i>
                                                </a>

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

@stop
@section('plugins.Boostrap5', true)
