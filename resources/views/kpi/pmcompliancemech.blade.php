@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'PM Compliance Mekanik')

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
                                    <h5 class="card-title text-primary">KPI PM Compliance {{ $namaunit }} 📖</h5>
                                    <p class="mb-4">
                                        PM Compliance adalah metrik pemeliharaan yang menyatakan berapa banyak tugas
                                        pemeliharaan preventif
                                        terjadwal yang telah diselesaikan selama periode tertentu. PM Compliance dapat
                                        mengukur efektivitas
                                        program PM dan menunjukkan seberapa baik jadwal PM terlaksana.
                                    </p>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">% PM Compliance = Jumlah
                                        WO Closed PM Tiap Bulan / Jumlah WO PM Tiap Bulan</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="{{ asset('/assets/img/illustrations/man-with-laptop-light.png') }}"
                                        height="140" alt="View Badge User"
                                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
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
                        <div class="row mt-2 text-center">
                            <div class="col-6 mt-2 col-sm-12 align-self-center">
                                <button class="btn btn-primary" type="submit">Search</button>
                                @if ($option == 'TMECH')
                                    <button class="btn btn-danger "
                                        onclick="window.open('{{ asset('/pmcompliancepdfmech12/print_report') }}','_blank')"
                                        type="button" target="_blank">
                                        Print Report Blok 1-2
                                    </button>
                                @endif
                                @if ($option == 'TMECH34')
                                    <button class="btn btn-danger "
                                    onclick="window.open('{{ asset('/pmcompliancepdfmech34/print_report') }}','_blank')"
                                        type="button" target="_blank">
                                        Print Report Blok 3-4
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">PM Compliance {{ $namaunit }}</h5>
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
                                    <h2 class="mt-3 mb-2">{{ $jumlahwopmyear }}</h2>
                                    <span>Total WO PM</span>
                                </div>
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="text-success mt-3 mb-2">{{ $totalkpifix }} %</h2>
                                    <span>PM Compliance</span>
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
                                            <small class="text-muted"> {{ $jumlahwopmclosedjan }} / {{ $jumlahwopmjan }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancejanfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedfeb }} /
                                                {{ $jumlahwopmfeb }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancefebfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedmar }} /
                                                {{ $jumlahwopmmar }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancemarfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedapr }} /
                                                {{ $jumlahwopmapr }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcomplianceaprfix }} %</small>
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
                                            <small class="text-muted"> {{ $jumlahwopmclosedmay }} / {{ $jumlahwopmmay }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancemayfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedjun }} /
                                                {{ $jumlahwopmjun }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancejunfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedjul }} /
                                                {{ $jumlahwopmjul }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancejulfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedaug }} /
                                                {{ $jumlahwopmaug }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcomplianceaugfix }} %</small>
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
                                            <small class="text-muted"> {{ $jumlahwopmclosedsep }} / {{ $jumlahwopmsep }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancesepfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosedoct }} /
                                                {{ $jumlahwopmoct }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcomplianceoctfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmclosednov }} /
                                                {{ $jumlahwopmnov }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancenovfix }} %</small>
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
                                            <small class="text-muted">{{ $jumlahwopmcloseddes }} /
                                                {{ $jumlahwopmdes }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $pmcompliancedesfix }} %</small>
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
                                <h5 class="m-0 me-2">Grafik PM Compliance {{ $namaunit }}</h5>
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
                                <h5 class="m-0 me-2">Grafik Jumlah PM Tiap Tahun</h5>
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
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <!-- Striped Rows -->
                    <div class="card">
                        <h5 class="card-header">List PM Not Comply</h5>
                        @if ($option == 'TMECH')
                            <livewire:pm-comply-index-mech12>
                        @endif
                        @if ($option == 'TMECH34')
                            <livewire:pm-comply-index-mech34>
                        @endif
                    </div>
                    <!--/ Striped Rows -->
                </div>
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
                    ['Jan', '{{ $pmcompliancejanfix }} %'],
                    ['Feb', '{{ $pmcompliancefebfix }} %'],
                    ['Mar', '{{ $pmcompliancemarfix }} %'],
                    ['Apr', '{{ $pmcomplianceaprfix }} %'],
                    ['Mei', '{{ $pmcompliancemayfix }} %'],
                    ['Jun', '{{ $pmcompliancejunfix }} %'],
                    ['Jul', '{{ $pmcompliancejulfix }} %'],
                    ['Aug', '{{ $pmcomplianceaugfix }} %'],
                    ['Sep', '{{ $pmcompliancesepfix }} %'],
                    ['Oct', '{{ $pmcomplianceoctfix }} %'],
                    ['Nov', '{{ $pmcompliancenovfix }} %'],
                    ['Des', '{{ $pmcompliancedesfix }} %']
                ],
                datasets: [{
                        label: 'Total WO PM',
                        data: [
                            {{ $jumlahwopmjan }}, {{ $jumlahwopmfeb }},
                            {{ $jumlahwopmmar }}, {{ $jumlahwopmapr }},
                            {{ $jumlahwopmmay }}, {{ $jumlahwopmjun }},
                            {{ $jumlahwopmjul }}, {{ $jumlahwopmaug }},
                            {{ $jumlahwopmsep }}, {{ $jumlahwopmoct }},
                            {{ $jumlahwopmnov }}, {{ $jumlahwopmdes }}
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Total WO PM Closed',
                        data: [
                            {{ $jumlahwopmclosedjan }}, {{ $jumlahwopmclosedfeb }},
                            {{ $jumlahwopmclosedmar }}, {{ $jumlahwopmclosedapr }},
                            {{ $jumlahwopmclosedmay }}, {{ $jumlahwopmclosedjun }},
                            {{ $jumlahwopmclosedjul }}, {{ $jumlahwopmclosedaug }},
                            {{ $jumlahwopmclosedsep }}, {{ $jumlahwopmclosedoct }},
                            {{ $jumlahwopmclosednov }}, {{ $jumlahwopmcloseddes }}
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
                    '{{ $year3 }}', '{{ $year4 }}', '{{ $year5 }}',
                    '{{ $year6 }}', '{{ $year7 }}', '{{ $thisyear }}'
                ],
                datasets: [{
                        label: 'Total WO PM Per Tahun',
                        data: [
                            {{ $fiveyearagowopm }},
                            {{ $fouryearagowopm }}, {{ $threeyearagowopm }}, {{ $twoyearagowopm }},
                            {{ $oneyearagowopm }}, {{ $jumlahwopmyear }}
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Total WO PM Closed Per Tahun',
                        data: [
                            {{ $fiveyearagowopmclosed }},
                            {{ $fouryearagowopmclosed }}, {{ $threeyearagowopmclosed }},
                            {{ $twoyearagowopmclosed }},
                            {{ $oneyearagowopmclosed }}, {{ $nowyearagowopmclosed }}
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
        });
    </script>
@endsection
