<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
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
                                <!--<option value="EGATROL">EGATROL</option> -->
                                <option value="AIR INTAKE">AIR INTAKE</option>
                                <!--<option value="LUBE OIL">LUBE OIL</option> -->
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
        </div>
        <!--/ Striped Rows -->
    </div>

    <div class="col-lg-12 col-md-6 mt-4">
        <!-- Striped Rows -->
        <div class="card">
            <h5 class="card-header">Reliability {{ $option }} start at 2019-01-01 Weibull Distribution</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>WO DESC</th>
                            <th>START DATE CALC</th>
                            <th>PLAN DATE</th>
                            <th>FINISH</th>
                            <th>TOTAL TIME FAILURE</th>
                            <th>TOTAL TTF</th>
                            <th>MEDIAN RANK</th>
                            <th>LOG TTF(X)</th>
                            <th>LOG MEDIAN(Y)</th>
                            <th>X2</th>
                            <th>Y2</th>
                            <th>XY</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($pku as $item)
                            <tr>
                                <td>{{ $num += 1 }}</td>
                                <td>{{ $item->wo_desc }}</td>
                                <td>2019-01-01</td>
                                <td>{{ $item->creation_date }}</td>
                                <td>{{ $item->closed_dt }}</td>
                                <td>{{ $item->total_hari }}</td>
                                <td>{{ $runningtotal += $item->total_hari }}</td>
                                <td>{{ $median = number_format((float) ($num - 0.3) / (MAX([$countpku]) + 0.4), 2, '.', '') }}
                                </td>
                                <td>{{ $x = number_format((float) log($runningtotal), 2, '.', '') }}</td>
                                <td>{{ $y = number_format((float) log(-log(1 - $median)), 2, '.', '') }}
                                </td>
                                <td>{{ $x2 = number_format((float) pow($x, 2), 2, '.', '') }}</td>
                                <td>{{ $y2 = number_format((float) pow($y, 2), 2, '.', '') }}</td>
                                <td>{{ $xy = number_format((float) $x * $y, 2, '.', '') }}</td>
                            </tr>
                            <!-- Calculate in Here -->
                            @php
                                $sumxy += $xy;
                                $sumx += $x;
                                $sumy += $y;
                                $sumx2 += $x2;
                                $sumy2 += $y2;
                                
                                $intercept = ($sumy * $sumx2 - $sumx * $sumxy) / ($countpku * $sumx2 - $sumx * $sumx);
                                $slope = ($countpku * $sumxy - $sumx * $sumy) / ($countpku * $sumx2 - $sumx * $sumx);
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Striped Rows -->
    </div>

    <div class="col-lg-12 scol-md-6 mt-4">
        <div class="card">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header">Linear Regression Parameter</h5>
                    <h6 class="px-5 mt-3">\[Σxy = {{ $sumxy }}\]</h6>
                    <h6 class="px-5">\[Σx = {{ $sumx }}\]</h6>
                    <h6 class="px-5">\[Σy = {{ $sumy }}\]</h6>
                    <h6 class="px-5">\[Σx² = {{ $sumx2 }}\]</h6>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">Menghitung Intercept (a)</h5>
                    <p>
                        \[a = {(Σy) (Σx²) - (Σx) (Σxy) \over n(Σx²) - (Σx)²}\]
                    </p>
                    <p>
                        \[a = {({{ $sumy }}) ({{ $sumx2 }}) - ({{ $sumx }})
                        ({{ $sumxy }}) \over {{ $countpku }}({{ $sumx2 }}) -
                        ({{ $sumx }})²}\]
                    </p>
                    <p>
                        \[a = {{ number_format($intercept, 2, '.', '') }} \]
                    </p>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">Menghitung Slope (b)</h5>
                    <p>
                        \[b = {n(Σxy) - (Σx) (Σy) \over n(Σx²) - (Σx)²}\]
                    </p>
                    <p>
                        \[b ={({{ $countpku }})({{ $sumxy }}) - ({{ $sumx }})
                        ({{ $sumy }}) \over
                        {{ $countpku }}({{ $sumx2 }}) -
                        ({{ $sumx }})²} \]
                    </p>
                    <p>
                        \[b = {{ number_format($slope, 2, '.', '') }} \]
                    </p>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">Parameter Weibull</h5>
                    <p>
                        \[α = {{ number_format($slope, 2, '.', '') }}\]
                    </p>
                    <p>
                        \[\]
                    </p>
                    <p>
                        @php
                            $eta = 1 / exp($intercept / $slope);
                        @endphp
                        \[β = {{ number_format($eta, 2, '.', '') }} \]
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-6 mt-4">
        <div class="card">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">MTBF ACTUAL</h5>
                    <h6>\[ Actual = {Σx \over n} \]</h6>
                    <h6>\[ Actual = {({{ $totaldayoperation }}) \over ({{ $countpku }})} \]</h6>
                    @php
                        $mtbfactual = $totaldayoperation / $countpku;
                    @endphp
                    <h6>\[ Actual = {{ number_format($mtbfactual, 0, '.', '') }} days \]</h6>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">MTBF ESTIMASI</h5>
                    <h6>\[ Estimasi = {α*EXP(ln(1+{1 \over β}))} \]</h6>
                    <h6>\[ Estimasi = {({{ number_format($eta, 2, '.', '') }})*EXP(ln(1+{1 \over
                        ({{ number_format($slope, 2, '.', '') }})}))} \]
                    </h6>
                    @php
                        $mtbfestimasi = $eta * exp(log(1 + 1 / $slope));
                    @endphp
                    <h6>\[ Estimasi = {{ number_format($mtbfestimasi, 0, '.', '') }} days \]</h6>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">MTTR</h5>
                    <h6>\[ MTTR = {ΣDay Maintenance \over ΣTotal of CR} \]</h6>
                    <h6>\[ MTTR = {{ round($countdaypku / $countofcr, 0) }} days\]</h6>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">Failure Rate</h5>
                    <h6>\[ Failure Rate = {1 \over MTBF} \]</h6>
                    @php
                        $mtbfactual = $totaldayoperation / $countpku;
                    @endphp
                    <h6>\[ Failure Rate = {{ round((1 / $mtbfactual) * 100, 2) }} \% \]</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-md-6 mt-4">
        <div class="card">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">Reliability ({{ $closed_dt }} - Now)</h5>
                    @php
                        $eta = 1 / exp($intercept / $slope);
                    @endphp
                    <h6>\[ Reliability = {Exp(-({γ \over β }))^α} \]</h6>
                    <h6>\[ Reliability = {Exp(-({ {{ $dayafter }} \over {{ number_format($eta, 2, '.', '') }}
                        }))^{ {{ number_format($slope, 2, '.', '') }} }} \]</h6>
                    @php
                        $relia = exp(-pow($dayafter / $eta, $slope)) * 100;
                    @endphp
                    <h6>\[ Reliability = {{ number_format($relia, 0, '.', '') }} \% \]</h6>
                </div>
                <div class="col-lg-3 col-md-3">
                    <h5 class="card-header text-center">Reliability Next Year</h5>
                    @php
                        $eta = 1 / exp($intercept / $slope);
                    @endphp
                    <h6>\[ UnReliability = {Exp(-({γ \over β }))^α} \]</h6>
                    <h6>\[ UnReliability = {Exp(-({ {{ $dayafter }} + 365 \over
                        {{ number_format($eta, 2, '.', '') }}
                        }))^{ {{ number_format($slope, 2, '.', '') }} }} \]</h6>
                    @php
                        $relia = exp(-pow(($dayafter + 365) / $eta, $slope)) * 100;
                    @endphp
                    <h6>\[ UnReliability = {{ number_format($relia, 0, '.', '') }} \% \]</h6>
                </div>
                <div class="col-lg-6 col-md-3">
                    <h5 class="card-header text-center">Conditional Reliability</h5>
                    @php
                        $eta = 1 / exp($intercept / $slope);
                        $relia = exp(-pow($dayafter / $eta, $slope)) * 100;
                        $Unrelia = exp(-pow(($dayafter + 365) / $eta, $slope)) * 100;
                        $condRel = ($Unrelia / $relia) * 100;
                        $probFail = 100 - $condRel;
                    @endphp
                    <h5>\[ Conditional Reliability = {{ number_format($condRel, 0, '.', '') }} \% \] </h5>
                    <h5>\[ Conditional Probability of Failure = {{ number_format($probFail, 0, '.', '') }} \% \]</h5>
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
                            Grafik CDF(Cummulative Distribution Function)
                        </button>
                    </h2>
                    <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="current"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="chart" class="px-2"></div>
                        </div>
                    </div>
                </div>
                <div class="card accordion-item">
                    <h2 class="accordion-header" id="voltage">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#accordionVoltage" aria-expanded="false" aria-controls="accordionTwo">
                            Grafik PDF
                        </button>
                    </h2>
                    <div id="accordionVoltage" class="accordion-collapse collapse" aria-labelledby="voltage"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="chartPDF" class="px-2"></div>
                        </div>
                    </div>
                </div>
                <div class="card accordion-item">
                    <h2 class="accordion-header" id="hazard">
                        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                            data-bs-target="#accordionHazard" aria-expanded="false" aria-controls="accordionTwo">
                            Grafik HF (Hazard Function)
                        </button>
                    </h2>
                    <div id="accordionHazard" class="accordion-collapse collapse" aria-labelledby="hazard"
                        data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div id="chartHF" class="px-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let cardColor, headingColor, axisColor, shadeColor, borderColor;
    cardColor = config.colors.white;
    headingColor = config.colors.headingColor;
    axisColor = config.colors.axisColor;
    borderColor = config.colors.borderColor;
</script>

<script>
    var options = {
        series: [{
            name: "CDF",
            data: [
                @for ($i = 50; $i <= 5000; $i = $i + 50)
                    {{ $data = number_format(1 - EXP(-pow($i / $eta, $slope)), 4, '.', '') }},
                @endfor
            ]
        }, ],
        chart: {
            height: 450,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: '',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: [
                @for ($i = 50; $i <= 5000; $i = $i + 50)
                    {{ $i }},
                @endfor
                //'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'
            ],
            title: {
                text: 'Days'
            }
        },
        yaxis: {
            title: {
                text: 'Probability F(x)'
            },
            //min: 5,
            //max: 40
        },
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<script>
    var options = {
        series: [{
            name: "PDF",
            data: [
                @for ($i = 50; $i <= 5000; $i = $i + 50)
                    {{ $data = number_format(pow($slope / $eta, $slope) * pow($i, $slope - 1) * EXP(-pow($i / $eta, $slope)), 7, '.', '') }},
                @endfor
            ]
        }],
        chart: {
            height: 450,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: '',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: [
                @for ($i = 50; $i <= 5000; $i = $i + 50)
                    {{ $i }},
                @endfor
                //'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'
            ],
            title: {
                text: 'Days'
            }
        },
        yaxis: {
            title: {
                text: 'Probability F(x)'
            },
            //min: 5,
            //max: 40
        },
    };

    var chartPDF = new ApexCharts(document.querySelector("#chartPDF"), options);
    chartPDF.render();
</script>

<script>
    var options = {
        series: [{
            name: "HF",
            data: [
                @for ($i = 50; $i <= 5000; $i = $i + 50)
                    {{ $data = number_format(pow($slope / $eta, $slope) * pow($i / $slope, $slope - 1), 7, '.', '') }},
                @endfor
            ]
        }],
        chart: {
            height: 450,
            type: 'line',
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        title: {
            text: '',
            align: 'left'
        },
        grid: {
            row: {
                colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        xaxis: {
            categories: [
                @for ($i = 50; $i <= 5000; $i = $i + 50)
                    {{ $i }},
                @endfor
                //'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'
            ],
            title: {
                text: 'Days'
            }
        },
        yaxis: {
            title: {
                text: 'Probability F(x)'
            },
            //min: 5,
            //max: 40
        },
    };

    var chartHF = new ApexCharts(document.querySelector("#chartHF"), options);
    chartHF.render();
</script>
