@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'PLTGU')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Equipment /</span> PLTGU </h4>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class='bx bxs-buildings'></i> BLOK
                                1-2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-notifications.html"><i
                                    class="bx bx-bell me-1"></i> Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-connections.html"><i
                                    class="bx bx-link-alt me-1"></i> Connections</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-12 col-md-6 order-0">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-6 mb-4">
                            <div class="card h-100 text-white bg-primary">
                                <div class="card-body">
                                    <h3 class="card-title text-white fw-bold text-center mb-3">BLOK 1</h3>
                                    <div class="container">
                                        <div class="row align-items-center text-center mb-2">
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1">UNIT</p>
                                            </div>
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1">MW</p>
                                            </div>
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1">MVAR</p>
                                            </div>
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1">EXC</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center text-center">
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1">GT11</p>
                                                <p class="card-text fw-bold mt-1">GT12</p>
                                                <p class="card-text fw-bold mt-1">GT13</p>
                                                <p class="card-text fw-bold mt-1">ST14</p>
                                            </div>
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1" id="mwgt11">-</p>
                                                <p class="card-text fw-bold mt-1" id="mwgt12">-</p>
                                                <p class="card-text fw-bold mt-1" id="mwgt13">-</p>
                                                <p class="card-text fw-bold mt-1" id="mwst14">-</p>
                                            </div>
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1" id="vargt11">-</p>
                                                <p class="card-text fw-bold mt-1" id="vargt12">-</p>
                                                <p class="card-text fw-bold mt-1" id="vargt13">-</p>
                                                <p class="card-text fw-bold mt-1" id="varst14">-</p>
                                            </div>
                                            <div class="col-3">
                                                <p class="card-text fw-bold mt-1" id="excgt11">-</p>
                                                <p class="card-text fw-bold mt-1" id="excgt12">-</p>
                                                <p class="card-text fw-bold mt-1" id="excgt13">-</p>
                                                <p class="card-text fw-bold mt-1" id="excst14">-</p>
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
                                            <h1 class="text-center text-white fw-bold position-absolute top-50 start-50 translate-middle"
                                                id="freq">
                                                -</h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-6 mb-4">
                            <div class="card h-100 text-white bg-primary">
                                <div class="card-body">
                                    <h3 class="card-title text-white fw-bold text-center mb-3">NETWORK VOLT (KV)</h3>
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <h1
                                                class="text-center text-white fw-bold position-absolute top-50 start-50 translate-middle" id="hvcb">
                                                -</h1>
                                        </div>
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

            <script src="{{ $chart->cdn() }}"></script>
            <script src="{{ $chart2->cdn() }}"></script>

            {{ $chart->script() }}
            {{ $chart2->script() }}

            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
            <script>
                $(document).ready(function() {
                    setInterval(function() {
                        $.ajax({
                            url: 'pltgu',
                            type: 'get',
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                //$('#mw').text(response.gt12powerfix);
                                $('#mwgt11').text(response.gt11power + ' MW');
                                $('#mwgt12').text(response.gt12power + ' MW');
                                $('#mwgt13').text(response.gt13power + ' MW');
                                $('#mwst14').text(response.st14power + ' MW');

                                $('#vargt11').text(response.gt11var + ' MVAR');
                                $('#vargt12').text(response.gt12var + ' MVAR');
                                $('#vargt13').text(response.gt13var + ' MVAR');
                                $('#varst14').text(response.st14var + ' MVAR');

                                $('#excgt11').text(response.excgt11 + ' A');
                                $('#excgt12').text(response.excgt12 + ' A');
                                $('#excgt13').text(response.excgt13 + ' A');
                                $('#excst14').text(response.excst14 + ' A');
                                
                                $('#hvcb').text(response.HVCBfix);
                                $('#freq').text(response.freqfix);
                            },
                            error: function(err) {}
                        })
                    }, 5000);
                });
            </script>
        </div>
    </div>

@endsection
