@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'PLTGU')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Equipment /</span> PKU</h4>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class='bx bxs-buildings'></i> GT11 &
                                HRSG</a>
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
            </div>

            <div class="col-lg-12 col-md-6">
                <!-- Striped Rows -->
                <div class="card">
                    <div class="row mt-4">
                        <form action="" method="get">
                            <div class="row justify-content-evenly">
                                <div class="col-6 col-sm-6 align-self-center">
                                    <select class="form-select" name="equip" id="equip">
                                        <option selected value="{{ $option }}">{{ $option }}</option>
                                        <option value="GENERATOR">GENERATOR</option>
                                        <option value="DC SYSTEMS">DC SYSTEMS</option>
                                        <option value="TRANSFORMATOR">TRANSFORMATOR</option>
                                        <option value="HV SYSTEMS">HV SYSTEMS</option>
                                        <option value="EXCITATION">EXCITATION</option>
                                        <option value="EGATROL">EGATROL</option>
                                        <option value="AIR INTAKE">AIR INTAKE</option>
                                        <option value="LUBE OIL">LUBE OIL</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-12 mt-2 col-sm-12 align-self-center">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <h5 class="card-header">LIST CR {{ $namaequip }}</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>WO DESC</th>
                                    <th>PLAN DATE</th>
                                    <th>FINISH DATE</th>
                                    <th>TOTAL DAYS</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($tablepku as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->wo_desc }}</td>
                                        <td>{{ $item->plan_str_date }}</td>
                                        <td>{{ $item->closed_dt }}</td>
                                        <td>{{ $item->Total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col mt-3">
                            {{ $tablepku->links() }}
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>

            <div class="row mt-4">
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Operating Time</span>
                            <h3 class="card-title mb-2 text-white">{{ $totaldayoperation }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Breakdown Time</span>
                            <h3 class="card-title mb-2 text-white">{{ $countdaypku }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-info text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">MTBF</span>
                            <h3 class="card-title mb-2 text-white">{{ $mtbf }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">MTTR</span>
                            <h3 class="card-title mb-2 text-white">{{ $mttr }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Failure Rate</span>
                            <h3 class="card-title mb-2 text-white">{{ $failurerate }} %</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-warning text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Repair Rate</span>
                            <h3 class="card-title mb-2 text-white">{{ $repairrate }}% </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2 justify-content-center">
                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Availibility</span>
                            <h3 class="card-title mb-2 text-white">{{ $availibility }} %</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Reliability</span>
                            <h3 class="card-title mb-2 text-white">{{ $reliability }} %</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <div class="card bg-primary text-white text-center">
                        <div class="card-body">
                            <span class="fw-semibold d-block mb-1">Maintainability</span>
                            <h3 class="card-title mb-2 text-white">{{ $maintainability }} %</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-6">
                <div class="card">
                    <h5 class="card-header">RELIABILITY {{ $option }} {{ $reliability }} %</h5>
                    <div class="row mt-4">
                        <div class="card-body">
                            <div id="reliabilityChart"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        // Income Chart - Area chart
        // --------------------------------------------------------------------
        let cardColor, headingColor, axisColor, shadeColor, borderColor;
        cardColor = config.colors.white;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;
        const incomeChartEl = document.querySelector("#reliabilityChart"),
            incomeChartConfig = {
                series: [{
                    data: [
                        {{ $reliability1 }}, {{ $reliability2 }}, {{ $reliability3 }}, {{ $reliability4 }},
                        {{ $reliability5 }}, {{ $reliability6 }}, {{ $reliability7 }}, {{ $reliability8 }},
                        {{ $reliability9 }}, {{ $reliability10 }}
                    ],
                }, ],
                chart: {
                    height: 350,
                    parentHeightOffset: 0,
                    parentWidthOffset: 0,
                    toolbar: {
                        show: false,
                    },
                    type: "area",
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 2,
                    curve: "smooth",
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 6,
                    colors: "transparent",
                    strokeColors: "transparent",
                    strokeWidth: 4,
                    discrete: [{
                        fillColor: config.colors.white,
                        seriesIndex: 0,
                        dataPointIndex: 9,
                        strokeColor: config.colors.primary,
                        strokeWidth: 2,
                        size: 6,
                        radius: 8,
                    }, ],
                    hover: {
                        size: 7,
                    },
                },
                colors: [config.colors.primary],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: shadeColor,
                        shadeIntensity: 0.6,
                        opacityFrom: 0.5,
                        opacityTo: 0.25,
                        stops: [0, 95, 100],
                    },
                },
                grid: {
                    borderColor: borderColor,
                    strokeDashArray: 3,
                    padding: {
                        top: -20,
                        bottom: -8,
                        left: -10,
                        right: 8,
                    },
                },
                xaxis: {
                    categories: [
                        "1",
                        "100",
                        "200",
                        "400",
                        "600",
                        "800",
                        "1000",
                        "1200",
                        "1400",
                        "{{ $totaldayoperation }}",
                    ],
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: true,
                        style: {
                            fontSize: "13px",
                            colors: axisColor,
                        },
                    },
                },
                yaxis: {
                    labels: {
                        show: true,
                    },
                    min: 10,
                    max: 100,
                    tickAmount: 4,
                },
            };
        if (typeof incomeChartEl !== undefined && incomeChartEl !== null) {
            const incomeChart = new ApexCharts(incomeChartEl, incomeChartConfig);
            incomeChart.render();
        }
    </script>

@endsection
