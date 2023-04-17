@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Generator')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">

            <h2>Informasi Unit</h2>

            <div class="col-lg-12 col-md-6 order-0">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-6 mb-4">
                        <div class="card h-100 text-white bg-primary">
                            <div class="card-body">
                                <h3 class="card-title text-white fw-bold text-center mb-3">BLOK 1</h3>
                                <div class="container">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <p class="card-text fw-bold mt-1">GT11</p>
                                            <p class="card-text fw-bold mt-1">GT12</p>
                                            <p class="card-text fw-bold mt-1">GT13</p>
                                            <p class="card-text fw-bold mt-1">ST14</p>
                                        </div>
                                        <div class="col-4">
                                            <p class="card-text fw-bold mt-1">{{ $gt11power }} MW</p>
                                            <p class="card-text fw-bold mt-1">{{ $gt12power }} MW</p>
                                            <p class="card-text fw-bold mt-1">{{ $gt13power }} MW</p>
                                            <p class="card-text fw-bold mt-1">{{ $st14power }} MW</p>
                                        </div>
                                        <div class="col-4">
                                            <p class="card-text fw-bold mt-1">{{ $gt11var }} MVar</p>
                                            <p class="card-text fw-bold mt-1">{{ $gt12var }} MVar</p>
                                            <p class="card-text fw-bold mt-1">{{ $gt13var }} MVar</p>
                                            <p class="card-text fw-bold mt-1">{{ $st14var }} MVar</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <div class="card h-100 text-white bg-primary">
                            <div class="card-body">
                                <h3 class="card-title text-white fw-bold text-center mb-3">FREQUENCY (HZ)</h3>
                                <div class="container">
                                    <div class="row align-items-center">
                                        <h1
                                            class="text-center text-white fw-bold position-absolute top-50 start-50 translate-middle">
                                            {{ $freqfix }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <div class="card h-100 text-white bg-primary">
                            <div class="card-body">
                                <h3 class="card-title text-white fw-bold text-center mb-3">NETWORK VOLT</h3>
                                <div class="container">
                                    <div class="row align-items-center">
                                        <h1
                                            class="text-center text-white fw-bold position-absolute top-50 start-50 translate-middle">
                                            {{ $ntwkvoltfix }}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-6">
                <div class="row">
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="current">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionTwo" aria-expanded="false" aria-controls="accordionTwo">
                                    Grafik Arus GT Blok 1
                                </button>
                            </h2>
                            <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="current"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $chart->container() !!}
                                </div>
                            </div>
                        </div>
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="voltage">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#accordionVoltage" aria-expanded="false" aria-controls="accordionTwo">
                                    Grafik Tegangan GT Blok 1
                                </button>
                            </h2>
                            <div id="accordionVoltage" class="accordion-collapse collapse" aria-labelledby="voltage"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    {!! $chart2->container() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>
    <script src="{{ $chart2->cdn() }}"></script>

    {{ $chart->script() }}
    {{ $chart2->script() }}

@endsection
