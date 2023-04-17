@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Rework Dashboard')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <!-- Examples -->
            <div class="row mb-5">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{ asset('/assets/img/elements/5-0.jpg') }}" alt="Card image cap" />
                        <div class="card-body">
                            <h5 class="card-title">ReWork Blok 1-2</h5>
                            <p class="card-text">
                                Menampilkan ReWork Blok 1-2 Selama 1 Tahun, Untuk Memonitoring Proses Bisnis PLN.
                            </p>
                            <a href="{{ asset('/rework') }}" class="btn btn-outline-primary">Details</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{ asset('/assets/img/elements/5-0.jpg') }}" alt="Card image cap" />
                        <div class="card-body">
                            <h5 class="card-title">ReWork Blok 3-4</h5>
                            <p class="card-text">
                                Menampilkan ReWork Blok 3-4 Selama 1 Tahun, Untuk Memonitoring Proses Bisnis PLN.
                            </p>
                            <a href="{{ asset('/rework34') }}" class="btn btn-outline-primary">Details</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card h-100">
                        <img class="card-img-top" src="{{ asset('/assets/img/elements/5-0.jpg') }}" alt="Card image cap" />
                        <div class="card-body">
                            <h5 class="card-title">ReWork Blok 5</h5>
                            <p class="card-text">
                                Menampilkan ReWork Blok 5 Selama 1 Tahun, Untuk Memonitoring Proses Bisnis PLN.
                            </p>
                            <a href="{{ asset('/rework5') }}" class="btn btn-outline-primary">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
