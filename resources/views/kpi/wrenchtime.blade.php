@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Wrench Time')

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
                                    <h5 class="card-title text-primary">KPI Wrench Time Listrik 1-2 📖</h5>
                                    <p class="mb-4">
                                        Dentifikasi peluang untuk meningkatkan produktifitas dengan mengukur kualitas dan
                                        kuantitas kegiatan pemeliharaan,
                                        dengan cara mengukur (waktu netto teknisi benar-benar melakukan tindakan perbaikan
                                        dibanding total waktu pemeliharaan)
                                    </p>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">% Wrench Time = On Hand
                                        Repairs / Time to Repairs</a>
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
                    <div class="card mt-2 mb-3">
                        <div class="card-header text-center">
                            <h4>Upload File .csv untuk KPI Wrench Time</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('kpi/wrenchtime.import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @if (count($errors) > 0)
                                    @foreach ($errors->all() as $error)
                                        @php alert()->error('Failed', 'Data sudah terisi !'); @endphp
                                    @endforeach
                                @endif

                                @if (session('success'))
                                    @php alert()->success('Success', \Session::get('success')); @endphp
                                @endif

                                <input type="file" name="file" class="form-control">
                                <br>
                                <button class="btn btn-primary">Import .csv Data</button>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-2 mb-3">
                        <div class="row mt-4">
                            <form action="" method="get">
                                <div class="row justify-content-evenly">
                                    <div class="col-6 col-sm-6 align-self-center">
                                        <select class="form-select" name="bidang" id="bidang">
                                            <option selected value="TELECT">{{ $option }}</option>
                                            <option value="TELECT">TELECT</option>
                                            <option value="TELECT3">TELECT3</option>
                                            <option value="TELECT5">TELECT5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-6 mt-2 col-sm-12 align-self-center">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                        <button class="btn btn-danger" type="">Export</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>DESCRIPTION</th>
                                            <th>START DATE</th>
                                            <th>START TIME</th>
                                            <th>STOP DATE</th>
                                            <th>STOP TIME</th>
                                            <th>WORKING DAYS</th>
                                            <th>AVG HOURS</th>
                                            <th>ON HAND REPAIR</th>
                                            <th>TIME TO REPAIR</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach ($wrenchtime as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->description_wo }}</td>
                                                <td>{{ $item->start_repair_date }}</td>
                                                <td>{{ $item->start_repair_time }}</td>
                                                <td>{{ $item->stop_repair_date }}</td>
                                                <td>{{ $item->stop_repair_time }}</td>
                                                <td>{{ $item->working_days }}</td>
                                                <td>{{ $item->average_hours }}</td>
                                                <td>{{ $item->on_hand_repairs }}</td>
                                                <td>{{ $item->time_to_repairs }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="col mt-3">
                                    {{ $wrenchtime->onEachSide(5)->links() }}
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
                                <h5 class="m-0 me-2">Wrench Time {{ $namaunit }}</h5>
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
                                    <h2 class="mt-3 mb-2">{{ $totalwocr }}</h2>
                                    <span>Total Wo CR</span>
                                </div>
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="text-success mt-3 mb-2">{{ $totalfix }} %</h2>
                                    <span>Wrench Time</span>
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
                                            <small class="text-muted"> {{ $janhandrepair }} /
                                                {{ $jantimeonrepairs }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimejan }} %</small>
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
                                            <small class="text-muted">{{ $febhandrepair }} /
                                                {{ $febtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimefeb }} %</small>
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
                                            <small class="text-muted">{{ $marhandrepair }} /
                                                {{ $martimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimemar }} %</small>
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
                                            <small class="text-muted">{{ $aprhandrepair }} /
                                                {{ $aprtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimeapr }} %</small>
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
                                            <small class="text-muted"> {{ $mayhandrepair }} /
                                                {{ $maytimeonrepairs }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimemay }} %</small>
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
                                            <small class="text-muted">{{ $junhandrepair }} /
                                                {{ $juntimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimejun }} %</small>
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
                                            <small class="text-muted">{{ $julhandrepair }} /
                                                {{ $jultimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimejul }} %</small>
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
                                            <small class="text-muted">{{ $aughandrepair }} /
                                                {{ $augtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimeaug }} %</small>
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
                                            <small class="text-muted"> {{ $sephandrepair }} /
                                                {{ $septimeonrepairs }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimesep }} %</small>
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
                                            <small class="text-muted">{{ $octhandrepair }} /
                                                {{ $octtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimeoct }} %</small>
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
                                            <small class="text-muted">{{ $novhandrepair }} /
                                                {{ $novtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimenov }} %</small>
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
                                            <small class="text-muted">{{ $deshandrepair }} /
                                                {{ $destimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $wrenchtimedes }} %</small>
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
                                <h5 class="m-0 me-2">Grafik Wrench Time {{ $namaunit }}</h5>
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
                            <canvas id="pmWrenchtime"></canvas>
                        </div>
                    </div>
                </div>
                <!--/Chart -->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('pmWrenchtime');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [
                    ['Jan', '{{ $wrenchtimejan }} %'],
                    ['Feb', '{{ $wrenchtimefeb }} %'],
                    ['Mar', '{{ $wrenchtimemar }} %'],
                    ['Apr', '{{ $wrenchtimeapr }} %'],
                    ['Mei', '{{ $wrenchtimemay }} %'],
                    ['Jun', '{{ $wrenchtimejun }} %'],
                    ['Jul', '{{ $wrenchtimejul }} %'],
                    ['Aug', '{{ $wrenchtimeaug }} %'],
                    ['Sep', '{{ $wrenchtimesep }} %'],
                    ['Oct', '{{ $wrenchtimeoct }} %'],
                    ['Nov', '{{ $wrenchtimenov }} %'],
                    ['Des', '{{ $wrenchtimedes }} %']
                ],
                datasets: [{
                        label: 'Time Hand Repairs (Hours)',
                        data: [
                            {{ $janhandrepair }}, {{ $febhandrepair }},
                            {{ $marhandrepair }}, {{ $aprhandrepair }},
                            {{ $mayhandrepair }}, {{ $junhandrepair }},
                            {{ $julhandrepair }}, {{ $aughandrepair }},
                            {{ $sephandrepair }}, {{ $octhandrepair }},
                            {{ $novhandrepair }}, {{ $deshandrepair }}
                        ],
                        borderWidth: 1
                    },
                    {
                        label: 'Time On Repairs (Hours)',
                        data: [
                            {{ $jantimeonrepairs }}, {{ $febtimeonrepairs }},
                            {{ $martimeonrepairs }}, {{ $aprtimeonrepairs }},
                            {{ $maytimeonrepairs }}, {{ $juntimeonrepairs }},
                            {{ $jultimeonrepairs }}, {{ $augtimeonrepairs }},
                            {{ $septimeonrepairs }}, {{ $octtimeonrepairs }},
                            {{ $novtimeonrepairs }}, {{ $destimeonrepairs }}
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
@endsection
