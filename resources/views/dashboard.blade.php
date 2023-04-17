@extends('layouts.footer')

@extends('layouts.script')

@extends('layouts.mainlayout')

@section('title', 'Dashboard')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Welcome to Dashboard Web - Har 🎉</h5>
                                    <p class="mb-4">
                                        Dashboard berisi pencapaian <span class="fw-bold">Key Performance Index, Data
                                            Historical Pekerjaan, Data Analisis System, dan Data All Work Order</span> yang
                                        bertujuan untuk
                                        memudahkan
                                        memonitoring Proses Bisnis Pemeliharaan agar bisa menjalankan pemeliharaan
                                        yang lebih Efisien.
                                    </p>

                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">PLN NP</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ asset('/assets/img/illustrations/PLN.png')}}" height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 mb-2 order-0">
                    <div id="carouselExampleSlidesOnly" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="col-lg-12 col-md-4 order-0">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">PM Compliance Blok 1-2</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $pmcompliancefix }} %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Reactive Work Blok 1-2</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $reactiveworkfix }} %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Rework Blok 1-2</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $reworkfix }} %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Wrench Time Blok 1-2</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $wrenchtimefix }} %</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-lg-12 col-md-4 order-0">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">PM Compliance Blok 3-4</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $pmcompliancefix3 }} %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Reactive Work Blok 3-4</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $reactiveworkfix3 }} %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Rework Blok 3-4</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $reworkfix3 }} %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Wrench Time Blok 3-4</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">{{ $wrenchtimefix3 }} %</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="col-lg-12 col-md-4 order-0">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">PM Compliance Blok 5</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">0 %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Reactive Work Blok 5</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">0 %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Rework Blok 5</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">0 %</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="fw-semibold d-block mb-1">Wrench Time Blok 5</span>
                                                    <span class="fw-semibold d-block mb-1">Periode
                                                        {{ date('M Y') }}</span>
                                                    <h3 class="card-title mb-2 text-primary">0 %</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card text-white" id="cardgt11">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">GT11</span>
                            <span class="fw-semibold d-block mb-1" id="statusgt11"></span>
                            <h3 class="card-title mb-2 text-white" id="mwgt11">-</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card text-white" id="cardgt12">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">GT12</span>
                            <span class="fw-semibold d-block mb-1" id="statusgt12"></span>
                            <h3 class="card-title mb-2 text-white" id="mwgt12">-</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card text-white" id="cardgt13">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">GT13</span>
                            <span class="fw-semibold d-block mb-1" id="statusgt13"></span>
                            <h3 class="card-title mb-2 text-white" id="mwgt13">-</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card text-white" id="cardgt21">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">GT21</span>
                            <span class="fw-semibold d-block mb-1" id="statusgt21"></span>
                            <h3 class="card-title mb-2 text-white" id="mwgt21">-</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card text-white" id="cardgt22">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">GT22</span>
                            <span class="fw-semibold d-block mb-1" id="statusgt22"></span>
                            <h3 class="card-title mb-2 text-white" id="mwgt22">-</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card text-white" id="cardst">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">ST14</span>
                            <span class="fw-semibold d-block mb-1" id="statusst14"></span>
                            <h3 class="card-title mb-2 text-white" id="mwst14">-</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-2 order-0">
                    <div class="card">
                        <div class="card-body">
                            {!! $dashboardChart1->container() !!}
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-2 order-0">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title">Jadwal Kegiatan Listrik</h2>
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content Wrapper -->

    <script src="{{ $dashboardChart1->cdn() }}"></script>

    {{ $dashboardChart1->script() }}

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    setInterval(function() {
                        $.ajax({
                            url: 'dashboard',
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                //$('#mw').text(response.gt12powerfix);
                                $('#mwgt11').text(response.gt11power + ' MW');
                                $('#mwgt12').text(response.gt12power + ' MW');
                                $('#mwgt13').text(response.gt13power + ' MW');
                                $('#mwst14').text(response.st14power + ' MW');
                                $('#mwgt21').text(response.gt21power + ' MW');
                                $('#mwgt22').text(response.gt22power + ' MW');
                                if (response.st14power > 5) {
                                    $('#cardst').css('background-color','green');
                                    $('#statusst14').text('Online');
                                } else {
                                    $('#cardst').css('background-color','red');
                                    $('#statusst14').text('Shutdown');
                                }

                                if (response.gt11power > 5) {
                                    $('#cardgt11').css('background-color','green');
                                    $('#statusgt11').text('Online');
                                } else {
                                    $('#cardgt11').css('background-color','red');
                                    $('#statusgt11').text('Shutdown');
                                }

                                if (response.gt12power > 5) {
                                    $('#cardgt12').css('background-color','green');
                                    $('#statusgt12').text('Online');
                                } else {
                                    $('#cardgt12').css('background-color','red');
                                    $('#statusgt12').text('Shutdown');
                                }

                                if (response.gt13power > 5) {
                                    $('#cardgt13').css('background-color','green');
                                    $('#statusgt13').text('Online');
                                } else {
                                    $('#cardgt13').css('background-color','red');
                                    $('#statusgt13').text('Shutdown');
                                }

                                if (response.gt21power > 5) {
                                    $('#cardgt21').css('background-color','green');
                                    $('#statusgt21').text('Online');
                                } else {
                                    $('#cardgt21').css('background-color','red');
                                    $('#statusgt21').text('Shutdown');
                                }

                                if (response.gt22power > 5) {
                                    $('#cardgt22').css('background-color','green');
                                    $('#statusgt22').text('Online');
                                } else {
                                    $('#cardgt22').css('background-color','red');
                                    $('#statusgt22').text('Shutdown');
                                }
                            },
                            error: function(err) {}
                        })
                    }, 5000);
                });
            </script>

@endsection
