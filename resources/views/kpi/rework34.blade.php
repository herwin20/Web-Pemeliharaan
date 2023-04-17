@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Rework')

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
                                    <h5 class="card-title text-primary">KPI Rework Listrik 3-4 📖</h5>
                                    <p class="mb-4">
                                        Rework adalah Rasio WO berulang(kerusakan yang sama) pada aset/equip dalam waktu
                                        satu bulan dibagi Total WO (CR dan EM)
                                    </p>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">% Rework = Jumlah
                                        WO CR yg sama Tiap Bulan / Jumlah WO CR dan EM Tiap Bulan</a>
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

                <!-- Striped Rows -->
                <div class="card mb-4">
                    <h5 class="card-header">Daftar Peralatan Rework tahun {{ $thisyear }}</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>KKS</th>
                                    <th>Informasi</th>
                                    <th>Tanggal Terbit</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($tablereworktahun as $item)
                                    <tr>
                                        <td>{{ $item->equip_no }}</td>
                                        <td>{{ $item->wo_desc }}</td>
                                        <td>{{ $item->creation_date }}</td>
                                        <td>{{ $item->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col mt-3">
                            {{ $tablereworktahun->links() }}
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->

                <!-- Order Statistics -->
                <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Rework Listrik 3-4</h5>
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
                                    <h2 class="mt-3 mb-2">{{ $jumlahreworktahun }}</h2>
                                    <span>Total Rework</span>
                                </div>
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="text-success mt-3 mb-2">{{ $totalreworkfix }} %</h2>
                                    <span>Rework</span>
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
                                            <small class="text-muted"> {{ $reworkjan }} / {{ $jumlahwocrjan }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixjan }} %</small>
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
                                            <small class="text-muted">{{ $reworkfeb }} /
                                                {{ $jumlahwocrfeb }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixfeb }} %</small>
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
                                            <small class="text-muted">{{ $reworkmar }} /
                                                {{ $jumlahwocrmar }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixmar }} %</small>
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
                                            <small class="text-muted">{{ $reworkapr }} /
                                                {{ $jumlahwocrapr }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixapr }} %</small>
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
                                            <small class="text-muted"> {{ $reworkmay }} / {{ $jumlahwocrmay }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixmay }} %</small>
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
                                            <small class="text-muted">{{ $reworkjun }} /
                                                {{ $jumlahwocrjun }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixjun }} %</small>
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
                                            <small class="text-muted">{{ $reworkjul }} /
                                                {{ $jumlahwocrjul }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixjul }} %</small>
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
                                            <small class="text-muted">{{ $reworkaug }} /
                                                {{ $jumlahwocraug }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixaug }} %</small>
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
                                            <small class="text-muted"> {{ $reworksep }} / {{ $jumlahwocrsep }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixsep }} %</small>
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
                                            <small class="text-muted">{{ $reworkoct }} /
                                                {{ $jumlahwocroct }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixoct }} %</small>
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
                                            <small class="text-muted">{{ $reworknov }} /
                                                {{ $jumlahwocrnov }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixnov }} %</small>
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
                                            <small class="text-muted">{{ $reworkdes }} /
                                                {{ $jumlahwocrdes }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $rasioreworkfixdes }} %</small>
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
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between pb-0">
                            <div class="card-title mb-0">
                                <h5 class="m-0 me-2">Grafik Rework Listrik 3-4</h5>
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
                                <h5 class="m-0 me-2">Grafik Jumlah Rework Tiap Tahun</h5>
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
                            <canvas id="reworkperYear"></canvas>
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
                    ['Jan', '{{ $rasioreworkfixjan }} %'],
                    ['Feb', '{{ $rasioreworkfixfeb }} %'],
                    ['Mar', '{{ $rasioreworkfixmar }} %'],
                    ['Apr', '{{ $rasioreworkfixapr }} %'],
                    ['Mei', '{{ $rasioreworkfixmay }} %'],
                    ['Jun', '{{ $rasioreworkfixjun }} %'],
                    ['Jul', '{{ $rasioreworkfixjul }} %'],
                    ['Aug', '{{ $rasioreworkfixaug }} %'],
                    ['Sep', '{{ $rasioreworkfixsep }} %'],
                    ['Oct', '{{ $rasioreworkfixoct }} %'],
                    ['Nov', '{{ $rasioreworkfixnov }} %'],
                    ['Des', '{{ $rasioreworkfixdes }} %']
                ],
                datasets: [{
                        label: 'Total Rework Tiap Bulan',
                        data: [
                            {{ $reworkjan }}, {{ $reworkfeb }},
                            {{ $reworkmar }}, {{ $reworkapr }},
                            {{ $reworkmay }}, {{ $reworkjun }},
                            {{ $reworkjul }}, {{ $reworkaug }},
                            {{ $reworksep }}, {{ $reworkoct }},
                            {{ $reworknov }}, {{ $reworkdes }}
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Total WO (CR dan EM)',
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
        const ctx1 = document.getElementById('reworkperYear');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: [
                    ['{{ $year3 }}', '{{ $rasioreworkfix5 }} %'],
                    ['{{ $year4 }}', '{{ $rasioreworkfix4 }} %'],
                    ['{{ $year5 }}', '{{ $rasioreworkfix3 }} %'],
                    ['{{ $year6 }}', '{{ $rasioreworkfix2 }} %'],
                    ['{{ $year7 }}', '{{ $rasioreworkfix1 }} %'],
                    ['{{ $thisyear }}', '{{ $totalreworkfix }} %']
                ],
                datasets: [{
                    label: 'Total Reactive Work Tiap Tahun',
                    data: [
                        {{ $rasioreworkfix5 }},
                        {{ $rasioreworkfix4 }},
                        {{ $rasioreworkfix3 }},
                        {{ $rasioreworkfix2 }},
                        {{ $rasioreworkfix1 }},
                        {{ $totalreworkfix }}
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
