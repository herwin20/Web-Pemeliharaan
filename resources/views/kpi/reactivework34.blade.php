@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Reactive Work Blok 3-4')

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
                                    <h5 class="card-title text-primary">KPI Work Reactive Listrik 3-4 📖</h5>
                                    <p class="mb-4">
                                        Reactive Work adalah jumlah perbandingan antara WO Non Tactical (WO CR & EM) dengan
                                        WO Tactical (WO PM, PDM, PD, OH, EJ)
                                    </p>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">% Reactive Work = Jumlah
                                        WO Non Tactical Tiap Bulan / Jumlah WO Tactical Tiap Bulan</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ asset('/assets/img/illustrations/girl-doing-yoga-light.png') }}"
                                        height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                                        data-app-light-img="illustrations/girl-doing-yoga-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Work Reactive Listrik 1-2</h5>
                                <small class="text-muted">Periode Januari - Desember {{ $thisyear }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="mt-3 mb-2">{{ $jumlahwocryear }}</h2>
                                    <span>Total WO CR</span>
                                </div>
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="text-success mt-3 mb-2">{{ $totalreactiveworkfix }} %</h2>
                                    <span>Reactive Work</span>
                                </div>
                            </div>
                            <ul class="p-0 m-0">
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class='bx bx-calendar'></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Januari</h6>
                                            <small class="text-muted"> {{ $jumlahwocrjan }} / {{ $jumlahwojan }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkjanfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class='bx bx-calendar'></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Februari</h6>
                                            <small class="text-muted">{{ $jumlahwocrfeb }} /
                                                {{ $jumlahwofeb }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkfebfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-info"><i
                                                class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Maret</h6>
                                            <small class="text-muted">{{ $jumlahwocrmar }} /
                                                {{ $jumlahwomar }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkmarfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex  mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-secondary"><i
                                                class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">April</h6>
                                            <small class="text-muted">{{ $jumlahwocrapr }} /
                                                {{ $jumlahwoapr }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkaprfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class='bx bx-calendar'></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Mei</h6>
                                            <small class="text-muted"> {{ $jumlahwocrmay }} / {{ $jumlahwomay }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkmayfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class='bx bx-calendar'></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Juni</h6>
                                            <small class="text-muted">{{ $jumlahwocrjun }} /
                                                {{ $jumlahwojun }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkjunfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-info"><i
                                                class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Juli</h6>
                                            <small class="text-muted">{{ $jumlahwocrjul }} /
                                                {{ $jumlahwojul }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkjulfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-secondary"><i
                                                class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Agustus</h6>
                                            <small class="text-muted">{{ $jumlahwocraug }} /
                                                {{ $jumlahwoaug }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkaugfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary">
                                            <i class='bx bx-calendar'></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">September</h6>
                                            <small class="text-muted"> {{ $jumlahwocrsep }} / {{ $jumlahwosep }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworksepfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-success">
                                            <i class='bx bx-calendar'></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Oktober</h6>
                                            <small class="text-muted">{{ $jumlahwocroct }} /
                                                {{ $jumlahwooct }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkoctfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-4 pb-1">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-info"><i
                                                class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">November</h6>
                                            <small class="text-muted">{{ $jumlahwocrnov }} /
                                                {{ $jumlahwonov }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworknovfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="d-flex mb-2">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <span class="avatar-initial rounded bg-label-primary"><i
                                                class="bx bx-calendar"></i></span>
                                    </div>
                                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                        <div class="me-2">
                                            <h6 class="mb-0">Desember</h6>
                                            <small class="text-muted">{{ $jumlahwocrdes }} /
                                                {{ $jumlahwodes }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $reactiveworkdesfix }} %</small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/ Order Statistics -->

                <!-- Chart -->
                <div class="col-md-6 col-lg-6 col-xl-8 order-0 mb-4">
                    <div class="card h-50">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Grafik Reactive Work Listrik 3-4</h5>
                                <small class="text-muted">Periode Januari - Desember {{ $thisyear }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pmComplaince"></canvas>
                        </div>
                    </div>
                    <div class="card h-50 mt-1">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Grafik Jumlah Reactive Work Tiap Tahun</h5>
                                <small class="text-muted">Periode {{ $year3 }} - {{ $thisyear }}</small>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                    <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Share</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas id="pmComplaincePerYear"></canvas>
                        </div>
                    </div>
                </div>
                <!--/Chart -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('pmComplaince');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    ['Jan', '{{ $reactiveworkjanfix }} %'],
                    ['Feb', '{{ $reactiveworkfebfix }} %'],
                    ['Mar', '{{ $reactiveworkmarfix }} %'],
                    ['Apr', '{{ $reactiveworkaprfix }} %'],
                    ['Mei', '{{ $reactiveworkmayfix }} %'],
                    ['Jun', '{{ $reactiveworkjunfix }} %'],
                    ['Jul', '{{ $reactiveworkjulfix }} %'],
                    ['Aug', '{{ $reactiveworkaugfix }} %'],
                    ['Sep', '{{ $reactiveworksepfix }} %'],
                    ['Oct', '{{ $reactiveworkoctfix }} %'],
                    ['Nov', '{{ $reactiveworknovfix }} %'],
                    ['Des', '{{ $reactiveworkdesfix }} %']
                ],
                datasets: [{
                        label: 'Total WO Tactical',
                        data: [
                            {{ $jumlahwojan }}, {{ $jumlahwofeb }},
                            {{ $jumlahwomar }}, {{ $jumlahwoapr }},
                            {{ $jumlahwomay }}, {{ $jumlahwojun }},
                            {{ $jumlahwojul }}, {{ $jumlahwoaug }},
                            {{ $jumlahwosep }}, {{ $jumlahwooct }},
                            {{ $jumlahwonov }}, {{ $jumlahwodes }}
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Total WO Non Tactical',
                        data: [
                            {{ $jumlahwocrjan }}, {{ $jumlahwocrfeb }},
                            {{ $jumlahwocrmar }}, {{ $jumlahwocrapr }},
                            {{ $jumlahwocrmay }}, {{ $jumlahwocrjun }},
                            {{ $jumlahwocrjul }}, {{ $jumlahwocraug }},
                            {{ $jumlahwocrsep }}, {{ $jumlahwocroct }},
                            {{ $jumlahwocrnov }}, {{ $jumlahwocrdes }}
                        ],
                        borderWidth: 1
                    },
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            animation: {
                duration: 1,
                onComplete: function() {
                    var chartInstance = this.chart,
                        ctx = chartInstance.ctx;

                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults
                        .global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'bottom';

                    this.data.datasets.forEach(function(dataset, i) {
                        var meta = chartInstance.controller.getDatasetMeta(i);
                        meta.data.forEach(function(bar, index) {
                            var data = dataset.data[index];
                            ctx.fillText(data, bar._model.x, bar._model.y - 5);
                        });
                    });
                }
            }
        });
    </script>

    <script>
        const ctx1 = document.getElementById('pmComplaincePerYear');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [
                    ['{{ $year3 }}', '{{ $fiveyearagoreactivefix }} %'],
                    ['{{ $year4 }}', '{{ $fouryearagoreactivefix }} %'],
                    ['{{ $year5 }}', '{{ $threeyearagoreactivefix }} %'],
                    ['{{ $year6 }}', '{{ $twoyearagoreactivefix }} %'],
                    ['{{ $year7 }}', '{{ $oneyearagoreactivefix }} %'],
                    ['{{ $thisyear }}', '{{ $totalreactiveworkfix }} %']
                ],
                datasets: [{
                    label: 'Total Reactive Work Tiap Tahun',
                    data: [
                        {{ $fiveyearagoreactivefix }},
                        {{ $fouryearagoreactivefix }}, {{ $threeyearagoreactivefix }},
                        {{ $twoyearagoreactivefix }},
                        {{ $oneyearagoreactivefix }}, {{ $totalreactiveworkfix }}
                    ],
                    borderWidth: 1
                }, ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    </script>
@endsection
