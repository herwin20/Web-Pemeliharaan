@extends('layouts.footer')

@extends('layouts.script')

@extends('layouts.mainlayout')

@section('title', 'Jadwal Kegiatan Mekanik')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 col-md-12 mb-2 order-0">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Jadwal Kegiatan {{ $namaunit }}</h2>
                            <form action="" method="get">
                                <div class="row justify-content-evenly">
                                    <div class="col-6 col-sm-6 align-self-center">
                                        <select class="form-select" name="bidang" id="bidang">
                                            <option selected value="TMECH">{{ $option }}</option>
                                            <option value="TMECH">TMECH</option>
                                            <option value="TMECH34">TMECH34</option>
                                            <option value="TMECH5">TMECH5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-6 mt-2 col-sm-12 align-self-center">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
