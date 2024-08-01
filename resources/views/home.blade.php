@extends('layouts.app')

@section('subtitle', 'Dashboard')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Dashboard')

@section('content_body')
    <div class="row">
        @foreach ($banks as $bank)
            <div class="col-3">
                <x-adminlte-small-box title="{{ $bank->transfers }}" text="{{ $bank->name }}"
                    icon="fas  fa-university text-light" theme="{{ $bank->color }}"
                    url="{{ route('transfers.bank-report', $bank->_id) }}" url-text="Reporte" />
            </div>
        @endforeach

        <div class="col-3">
            <x-adminlte-small-box title="{{ number_format($totalBs, 2, ',', '.') }}" text="Total Bolivares"
                icon="fas  fa-wallet text-light" theme="olive" />
        </div>
    </div>

    <div class="row">
        <div class="col-8"></div>
        <div class="col-4">
            <div class="row">
                @foreach ($rates as $rate)
                    <div class="col-12">

                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3 id="card-amount-{{ $rate->_id }}">{{ $rate->amount }}</h3>
                                <h5>{{ $rate->name }}</h5>
                            </div>
                            <div class="icon">
                                <i class="fas  fa-percent text-light"></i>
                            </div>
                            <a onclick="openModal({{ $rate->_id }})" href="#" class="small-box-footer">
                                Actualizar
                                <i class="fas fa-lg fa-arrow-circle-right"></i>
                            </a>
                            <div class="overlay d-none">
                                <i class="fas fa-2x fa-spin fa-sync-alt text-gray"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- <div class="col-12">
                    <x-adminlte-small-box title="424" text="Banesco" icon="fas  fa-percent text-light" theme="success"
                        url="#" url-text="Actualizar" />
                </div>
                <div class="col-12">
                    <x-adminlte-small-box title="424" text="Otros Bancos" icon="fas  fa-percent text-light"
                        theme="navy" url="#" url-text="Actualizar" />
                </div> --}}
            </div>
        </div>

        <x-adminlte-modal id="modalBanesco" title="Actualizar tasa Mercantil" size="md" theme="primary">

            <x-adminlte-input name="valor" id="valor" label="Nuevo valor de la tasa" placeholder="Valor de la tasa"
                fgroup-class="col-md-12" disable-feedback />

            <x-slot name="footerSlot">
                <x-adminlte-button onclick="updateRate()" id="btnSave" class="" theme="success"
                    label="Actualizar" />
                <x-adminlte-button onclick="cerrarModal()" theme="danger" label="Dismiss" />
            </x-slot>
        </x-adminlte-modal>
    </div>
@stop

@section('plugins.Boostrap5', true)

@push('css')
@endpush


@push('js')
    <script>
        const csrfToken = "{{ csrf_token() }}";

        const myModalAlternative = new bootstrap.Modal('#modalBanesco')

        function openModal(idRate) {
            document.querySelector('#btnSave').dataset.idRate = idRate;
            fetch(`/mantenice/rates/find-rate/${idRate}`, {
                    method: 'get',
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelector('#valor').value = data.amount
                })
                .catch(error => console.error('Error:', error));
            myModalAlternative.show()
        }


        function updateRate() {
            const rateId = document.querySelector('#btnSave').dataset.idRate;
            const valor = document.querySelector('#valor').value;
            fetch(`mantenice/rates/update-rate/${rateId}`, {
                    method: 'post',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({
                        amount: valor
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // console.log(data);
                    document.querySelector(`#card-amount-${rateId}`).innerHTML = data.amount;
                    cerrarModal();
                })
                .catch(error => console.error('Error:', error));
        }

        function cerrarModal() {
            myModalAlternative.hide()
        }
    </script>
@endpush
