@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Dashboard')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Content -->
        <div class="row">
            <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-primary">Analyze Report Pekerjaan Harian Blok 1-2 🎉</h5>
                                <p class="mb-4">
                                    Pekerjaan yang telah di kerjakan <span class="fw-bold">{{ $datastatusDone }}</span>.
                                    Selamat
                                    Bekerja Tim Listrik PLN Nusantara Power.
                                </p>

                                <a href="{{ asset('/report-pekerjaan')}}" class="btn btn-sm btn-outline-primary">Table Report</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('/assets/img/illustrations/man-with-laptop-light.png')}}" height="140"
                                    alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/assets/img/icons/unicons/chart-success.png')}}" alt="chart success"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">W. Material</span>
                                <h3 class="card-title mb-2">{{ $datastatusWM }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/assets/img/icons/unicons/wallet-info.png')}}" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">W. Execution</span>
                                <h3 class="card-title text-nowrap mb-1">{{ $datastatusWE }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Total Revenue -->
            <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
                <div class="card">
                    <div class="row row-bordered g-0">
                        <div class="col-md-8">
                            <h5 class="card-header m-0 me-2 pb-3">Total Pekerjaan</h5>
                            <div id="totalRevenueChart" class="px-2"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            2023
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                            <a class="dropdown-item" href="javascript:void(0);">2023</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2024</a>
                                            <a class="dropdown-item" href="javascript:void(0);">2025</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="growthChart"></div>
                            <div class="text-center fw-semibold pt-3 mb-2">{{ $datareport12 }} Total Pekerjaan</div>


                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Revenue -->
            <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
                <div class="row">
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/assets/img/icons/unicons/cc-success.png')}}" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="d-block mb-1">W. Shutdown</span>
                                <h3 class="card-title text-nowrap mb-2">{{ $datastatusWS }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('/assets/img/icons/unicons/cc-primary.png')}}" alt="Credit Card"
                                            class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                            <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                            <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                        </div>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">W. Inspection</span>
                                <h3 class="card-title mb-2">{{ $datastatusWI }}</h3>
                            </div>
                        </div>
                    </div>
                    <!-- </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <div class="row"> -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-sm-column flex-row justify-content-between">
                                    <div class="card-title text-center">
                                        <h3 class="text-nowrap mb-4">Total Hari Kerja</h3>
                                        <span class="badge bg-label-warning rounded-pill">Tahun 2023</span>
                                    </div>
                                    <div class="mt-sm-auto text-center">
                                        <small class="text-success text-nowrap fw-semibold"></small>
                                        <h1 class="mb-0">{{ $diff }}</h1>
                                    </div>
                                </div>
                                <!-- <div id="profileReportChart"></div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Striped Rows -->
        <div class="card col-lg-12 col-md-6">
            <h5 class="card-header">Kebutuhan Material</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Material</th>
                            <th>Total Kebutuhan</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($materialfreq as $item)
                            <tr>
                                <td>{{ $item->material }}</td>
                                <td>{{ $item->total }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col ms-3 mt-3 px-3">
                    {{ $materialfreq->onEachSide(2)->links() }}
                </div>
            </div>
        </div>
        <!--/ Striped Rows -->
        <!-- / Content -->
    </div>

    <script>
        let cardColor, headingColor, axisColor, shadeColor, borderColor;
        cardColor = config.colors.white;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;

        const growthChartEl = document.querySelector("#growthChart"),
            growthChartOptions = {
                series: [{{ $percentage }}],
                labels: ["Done Work"],
                chart: {
                    height: 240,
                    type: "radialBar",
                },
                plotOptions: {
                    radialBar: {
                        size: 150,
                        offsetY: 10,
                        startAngle: -150,
                        endAngle: 150,
                        hollow: {
                            size: "55%",
                        },
                        track: {
                            background: cardColor,
                            strokeWidth: "100%",
                        },
                        dataLabels: {
                            name: {
                                offsetY: 15,
                                color: headingColor,
                                fontSize: "15px",
                                fontWeight: "600",
                                fontFamily: "Public Sans",
                            },
                            value: {
                                offsetY: -25,
                                color: headingColor,
                                fontSize: "22px",
                                fontWeight: "500",
                                fontFamily: "Public Sans",
                            },
                        },
                    },
                },
                colors: [config.colors.primary],
                fill: {
                    type: "gradient",
                    gradient: {
                        shade: "dark",
                        shadeIntensity: 0.5,
                        gradientToColors: [config.colors.primary],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 0.6,
                        stops: [30, 70, 100],
                    },
                },
                stroke: {
                    dashArray: 5,
                },
                grid: {
                    padding: {
                        top: -35,
                        bottom: -10,
                    },
                },
                states: {
                    hover: {
                        filter: {
                            type: "none",
                        },
                    },
                    active: {
                        filter: {
                            type: "none",
                        },
                    },
                },
            };
        if (typeof growthChartEl !== undefined && growthChartEl !== null) {
            const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
            growthChart.render();
        }
    </script>

    <script>
        const totalRevenueChartEl = document.querySelector("#totalRevenueChart"),
            totalRevenueChartOptions = {
                series: [{
                    name: "2023",
                    data: [{{ $PM }}, {{ $CM }}, {{ $OnCall }}, {{ $lembur }},
                        {{ $other }}, {{ $OH }}
                    ],
                }, ],
                chart: {
                    height: 300,
                    stacked: true,
                    type: "bar",
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "50%",
                        borderRadius: 20,
                        startingShape: "rounded",
                        endingShape: "rounded",
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                colors: [config.colors.primary, config.colors.info],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: "smooth",
                    width: 6,
                    lineCap: "round",
                    colors: [cardColor],
                },
                legend: {
                    show: true,
                    horizontalAlign: "left",
                    position: "top",
                    markers: {
                        height: 8,
                        width: 8,
                        radius: 12,
                        offsetX: -3,
                    },
                    labels: {
                        colors: axisColor,
                    },
                    itemMargin: {
                        horizontal: 10,
                    },
                },
                grid: {
                    borderColor: borderColor,
                    padding: {
                        top: 0,
                        bottom: -8,
                        left: 20,
                        right: 20,
                    },
                },
                xaxis: {
                    categories: ["PM", "CM", "ON CALL", "LEMBUR", "OTHERS", "OH"],
                    labels: {
                        style: {
                            fontSize: "13px",
                            fontWeight: 900,
                            colors: axisColor,
                        },
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: "13px",
                            colors: axisColor,
                        },
                    },
                },
                responsive: [{
                        breakpoint: 1700,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "32%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1580,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "35%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1440,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "42%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1300,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "48%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1200,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "40%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 1040,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 11,
                                    columnWidth: "48%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 991,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "30%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 840,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "35%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 768,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "28%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 640,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "32%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 576,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "37%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 480,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "45%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 420,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "52%",
                                },
                            },
                        },
                    },
                    {
                        breakpoint: 380,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 10,
                                    columnWidth: "60%",
                                },
                            },
                        },
                    },
                ],
                states: {
                    hover: {
                        filter: {
                            type: "none",
                        },
                    },
                    active: {
                        filter: {
                            type: "none",
                        },
                    },
                },
            };
        if (
            typeof totalRevenueChartEl !== undefined &&
            totalRevenueChartEl !== null
        ) {
            const totalRevenueChart = new ApexCharts(
                totalRevenueChartEl,
                totalRevenueChartOptions
            );
            totalRevenueChart.render();
        }
    </script>

@endsection
