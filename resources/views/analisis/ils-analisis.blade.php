@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'ILS Analisys')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="container">
                <div class="row justify-content-evenly">
                    <!-- Striped Rows -->
                    <div class="card col-lg-5 col-md-12">
                        <h5 class="card-header">ILS Sering Terjadi</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>KKS</th>
                                        <th>WO Description</th>
                                        <th>Total ILS</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($tableilsfreq as $item)
                                        <tr>
                                            <td>{{ $item->equip_no }}</td>
                                            <td>{{ $item->short_desc }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col mt-3">
                                {{ $tableilsfreq->links() }}
                            </div>
                        </div>
                    </div>
                    <!--/ Striped Rows -->
                    <!-- Striped Rows -->
                    <div class="card col-lg-5 col-md-12">
                        <h5 class="card-header">ILS Sering Terjadi {{ $thisyear }}</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>KKS</th>
                                        <th>WO Description</th>
                                        <th>Total CR</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($tableilsyear as $item)
                                        <tr>
                                            <td>{{ $item->equip_no }}</td>
                                            <td>{{ $item->short_desc }}</td>
                                            <td>{{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col mt-3">
                                {{ $tableilsyear->links() }}
                            </div>
                        </div>
                    </div>
                    <!--/ Striped Rows -->
                </div>

                <div class="row mt-4">
                    <form action="" method="get">
                        <div class="row justify-content-evenly">
                            <div class="col-6 col-sm-6 align-self-center">
                                <div class="input-group mb-3">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Search">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                                <div class="row text-center">
                                    <small>Copy KKS untuk melihat apa saja ILS</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row justify-content-evenly">
                    <!-- Striped Rows -->
                    <div class="card col-lg-5 col-md-12 mb-3">
                        <h5 class="card-header">Corrective Maintenance Pada Wilayah {{ $equip }}</h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>KKS</th>
                                        <th>WO Description</th>
                                        <th>Raised Date</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($tableilsdetail as $item)
                                        <tr>
                                            <td>{{ $item->equip_no }}</td>
                                            <td>{{ $item->short_desc }}</td>
                                            <td>{{ $item->raised_date }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="col mt-3">
                                {{ $tableilsdetail->links() }}
                            </div>
                        </div>
                    </div>
                    <!--/ Striped Rows -->
                    <!-- Chart -->
                    <div class="col-md-12 col-lg-5 col-xl-8 order-0 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                                <div class="card-title mb-0">
                                    <h5 class="m-0 me-2">Grafik Total ILS Equip Pertahun</h5>
                                    <small class="text-muted">Periode {{ $nameofyear }}</small>
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
                                <canvas id="trackingILS"></canvas>
                            </div>
                        </div>
                    </div>
                    <!--/Chart -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('trackingILS');
        const total = @json($totalils);
        const year = @json($nameofyear);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: year,
                datasets: [{
                    label: 'Total ILS',
                    data: total, //[3, 5, 6, 4, 2, 4, 5, 2],
                    //borderWidth: 1,
                    borderWidth: 2,
                    borderRadius: 15,
                }, ]
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
