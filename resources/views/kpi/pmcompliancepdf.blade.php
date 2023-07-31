<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/public/assets/img/favicon/favicon.png" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
    <title>Print Out !</title>
</head>

<body>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <h1 class="text-center">Resume KPI Pemeliharaan {{ $namaunit }}</h1>
            <br>
            <br>
            <div class="text-center">
                <img src="assets/img/illustrations/plnnpjoss.png" height="100" width="360" alt="">
            </div>
            <br>
            <br>
            <h3 class="text-center">Periode Januari - Desember {{ $thisyear }}</h3>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <div class="card">
                <div class="card-header text-center">
                    <div class="card-title mb-0">
                        <h4 class="m-0 me-2">Report PM Compliance {{ $namaunit }}</h4>
                        <small class="text-muted">Periode Januari - Desember {{ $thisyear }}</small>
                        <div class="text-center">
                            <img src="assets/img/illustrations/PLNNPnew.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-wrap">
                        <table class="table">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold">Bulan</th>
                                    <th class="fw-bold">Jan</th>
                                    <th class="fw-bold">Feb</th>
                                    <th class="fw-bold">Mar</th>
                                    <th class="fw-bold">Apr</th>
                                    <th class="fw-bold">May</th>
                                    <th class="fw-bold">Jun</th>
                                    <th class="fw-bold">Jul</th>
                                    <th class="fw-bold">Aug</th>
                                    <th class="fw-bold">Sep</th>
                                    <th class="fw-bold">Oct</th>
                                    <th class="fw-bold">Nov</th>
                                    <th class="fw-bold">Des</th>
                                </tr>
                            </thead>
                            <tbody class="table-border">
                                <tr>
                                    <td class="fw-bold">PM Comply</td>
                                    <td>{{ $jumlahwopmclosedjan }}</td>
                                    <td>{{ $jumlahwopmclosedfeb }}</td>
                                    <td>{{ $jumlahwopmclosedmar }}</td>
                                    <td>{{ $jumlahwopmclosedapr }}</td>
                                    <td>{{ $jumlahwopmclosedmay }}</td>
                                    <td>{{ $jumlahwopmclosedjun }}</td>
                                    <td>{{ $jumlahwopmclosedjul }}</td>
                                    <td>{{ $jumlahwopmclosedaug }}</td>
                                    <td>{{ $jumlahwopmclosedsep }}</td>
                                    <td>{{ $jumlahwopmclosedoct }}</td>
                                    <td>{{ $jumlahwopmclosednov }}</td>
                                    <td>{{ $jumlahwopmcloseddes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">PM Not Comply</td>
                                    <td>{{ $pmnotcomplyjan }}</td>
                                    <td>{{ $pmnotcomplyfeb }}</td>
                                    <td>{{ $pmnotcomplymar }}</td>
                                    <td>{{ $pmnotcomplyapr }}</td>
                                    <td>{{ $pmnotcomplymay }}</td>
                                    <td>{{ $pmnotcomplyjun }}</td>
                                    <td>{{ $pmnotcomplyjul }}</td>
                                    <td>{{ $pmnotcomplyaug }}</td>
                                    <td>{{ $pmnotcomplysep }}</td>
                                    <td>{{ $pmnotcomplyoct }}</td>
                                    <td>{{ $pmnotcomplynov }}</td>
                                    <td>{{ $pmnotcomplydes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Total</td>
                                    <td>{{ $jumlahwopmjan }}</td>
                                    <td>{{ $jumlahwopmfeb }}</td>
                                    <td>{{ $jumlahwopmmar }}</td>
                                    <td>{{ $jumlahwopmapr }}</td>
                                    <td>{{ $jumlahwopmmay }}</td>
                                    <td>{{ $jumlahwopmjun }}</td>
                                    <td>{{ $jumlahwopmjul }}</td>
                                    <td>{{ $jumlahwopmaug }}</td>
                                    <td>{{ $jumlahwopmsep }}</td>
                                    <td>{{ $jumlahwopmoct }}</td>
                                    <td>{{ $jumlahwopmnov }}</td>
                                    <td>{{ $jumlahwopmdes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Persen (%)</td>
                                    <td>{{ $pmcompliancejanfix }}</td>
                                    <td>{{ $pmcompliancefebfix }}</td>
                                    <td>{{ $pmcompliancemarfix }}</td>
                                    <td>{{ $pmcomplianceaprfix }}</td>
                                    <td>{{ $pmcompliancemayfix }}</td>
                                    <td>{{ $pmcompliancejunfix }}</td>
                                    <td>{{ $pmcompliancejulfix }}</td>
                                    <td>{{ $pmcomplianceaugfix }}</td>
                                    <td>{{ $pmcompliancesepfix }}</td>
                                    <td>{{ $pmcomplianceoctfix }}</td>
                                    <td>{{ $pmcompliancenovfix }}</td>
                                    <td>{{ $pmcompliancedesfix }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-1 mt-10">
            <h5>PM Compliance : {{ $totalkpifix }} %</h5>
            <h5>Min Target : 100 % </h5>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
            <div class="text-center">
                <h4 class="m-0 me-2">Grafik PM Compliance {{ $namaunit }}</h4>
                <img src="https://quickchart.io/chart?v=2.9.4&c={ type: 'bar', data: { labels: [
                    ['Jan', '{{ $pmcompliancejanfix }}'],
                    ['Feb', '{{ $pmcompliancefebfix }}'],
                    ['Mar', '{{ $pmcompliancemarfix }}'],
                    ['Apr', '{{ $pmcomplianceaprfix }}'],
                    ['Mei', '{{ $pmcompliancemayfix }}'],
                    ['Jun', '{{ $pmcompliancejunfix }}'],
                    ['Jul', '{{ $pmcompliancejulfix }}'],
                    ['Aug', '{{ $pmcomplianceaugfix }}'],
                    ['Sep', '{{ $pmcompliancesepfix }}'],
                    ['Oct', '{{ $pmcomplianceoctfix }}'],
                    ['Nov', '{{ $pmcompliancenovfix }}'],
                    ['Des', '{{ $pmcompliancedesfix }}']
                ], datasets: [ { 
                    label: 'Total WO PM', data: [
                        {{ $jumlahwopmjan }}, {{ $jumlahwopmfeb }},
                        {{ $jumlahwopmmar }}, {{ $jumlahwopmapr }},
                        {{ $jumlahwopmmay }}, {{ $jumlahwopmjun }},
                        {{ $jumlahwopmjul }}, {{ $jumlahwopmaug }},
                        {{ $jumlahwopmsep }}, {{ $jumlahwopmoct }},
                        {{ $jumlahwopmnov }}, {{ $jumlahwopmdes }}
                        ] }, 
                    { label: 'Total WO PM Closed', data: [
                        {{ $jumlahwopmclosedjan }}, {{ $jumlahwopmclosedfeb }},
                        {{ $jumlahwopmclosedmar }}, {{ $jumlahwopmclosedapr }},
                        {{ $jumlahwopmclosedmay }}, {{ $jumlahwopmclosedjun }},
                        {{ $jumlahwopmclosedjul }}, {{ $jumlahwopmclosedaug }},
                        {{ $jumlahwopmclosedsep }}, {{ $jumlahwopmclosedoct }},
                        {{ $jumlahwopmclosednov }}, {{ $jumlahwopmcloseddes }}
                        ] }, ], }, }"
                    class="img-fluid" alt="">
            </div>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <h4 class="m-0 me-2 mb-5 text-center">Table PM Not Comply {{ $namaunit }}</h4>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Work Order</th>
                            <th>Desc</th>
                            <th>Group</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($tablepmnotcomply as $item)
                            <tr>
                                <td>{{ $item->plan_fin_date }}</td>
                                <td>{{ $item->work_order }}</td>
                                <td>{{ $item->wo_task_desc }}</td>
                                <td>{{ $item->work_group }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <div class="card">
                <div class="card-header text-center">
                    <div class="card-title mb-0">
                        <h4 class="m-0 me-2">Report Reactive Work {{ $namaunit }}</h4>
                        <small class="text-muted">Periode Januari - Desember {{ $thisyear }}</small>
                        <div class="text-center">
                            <img src="assets/img/illustrations/PLNNPnew.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-wrap">
                        <table class="table">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold">Bulan</th>
                                    <th class="fw-bold">Jan</th>
                                    <th class="fw-bold">Feb</th>
                                    <th class="fw-bold">Mar</th>
                                    <th class="fw-bold">Apr</th>
                                    <th class="fw-bold">May</th>
                                    <th class="fw-bold">Jun</th>
                                    <th class="fw-bold">Jul</th>
                                    <th class="fw-bold">Aug</th>
                                    <th class="fw-bold">Sep</th>
                                    <th class="fw-bold">Oct</th>
                                    <th class="fw-bold">Nov</th>
                                    <th class="fw-bold">Des</th>
                                </tr>
                            </thead>
                            <tbody class="table-border">
                                <tr>
                                    <td class="fw-bold">Wo Tactical</td>
                                    <td>{{ $jumlahwojan }}</td>
                                    <td>{{ $jumlahwofeb }}</td>
                                    <td>{{ $jumlahwomar }}</td>
                                    <td>{{ $jumlahwoapr }}</td>
                                    <td>{{ $jumlahwomay }}</td>
                                    <td>{{ $jumlahwojun }}</td>
                                    <td>{{ $jumlahwojul }}</td>
                                    <td>{{ $jumlahwoaug }}</td>
                                    <td>{{ $jumlahwosep }}</td>
                                    <td>{{ $jumlahwooct }}</td>
                                    <td>{{ $jumlahwonov }}</td>
                                    <td>{{ $jumlahwodes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">WO Non Tactical</td>
                                    <td>{{ $jumlahwocrjan }}</td>
                                    <td>{{ $jumlahwocrfeb }}</td>
                                    <td>{{ $jumlahwocrmar }}</td>
                                    <td>{{ $jumlahwocrapr }}</td>
                                    <td>{{ $jumlahwocrmay }}</td>
                                    <td>{{ $jumlahwocrjun }}</td>
                                    <td>{{ $jumlahwocrjul }}</td>
                                    <td>{{ $jumlahwocraug }}</td>
                                    <td>{{ $jumlahwocrsep }}</td>
                                    <td>{{ $jumlahwocroct }}</td>
                                    <td>{{ $jumlahwocrnov }}</td>
                                    <td>{{ $jumlahwocrdes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Reactive Work (%)</td>
                                    <td>{{ $reactiveworkjanfix }}</td>
                                    <td>{{ $reactiveworkfebfix }}</td>
                                    <td>{{ $reactiveworkmarfix }}</td>
                                    <td>{{ $reactiveworkaprfix }}</td>
                                    <td>{{ $reactiveworkmayfix }}</td>
                                    <td>{{ $reactiveworkjunfix }}</td>
                                    <td>{{ $reactiveworkjulfix }}</td>
                                    <td>{{ $reactiveworkaugfix }}</td>
                                    <td>{{ $reactiveworksepfix }}</td>
                                    <td>{{ $reactiveworkoctfix }}</td>
                                    <td>{{ $reactiveworknovfix }}</td>
                                    <td>{{ $reactiveworkdesfix }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-1 mt-10">
            <h5>Reactive Work : {{ $totalreactiveworkfix }} %</h5>
            <h5>Min Target : 5 % </h5>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
            <h4 class="m-0 me-2 mb-5 text-center">Grafik Reactive Work {{ $namaunit }}</h4>
            <div class="text-center">
                <img src="https://quickchart.io/chart?v=2.9.4&c={ type: 'bar', data: { labels: [
                    ['Jan', '{{ $reactiveworkjanfix }} '],
                    ['Feb', '{{ $reactiveworkfebfix }} '],
                    ['Mar', '{{ $reactiveworkmarfix }} '],
                    ['Apr', '{{ $reactiveworkaprfix }} '],
                    ['Mei', '{{ $reactiveworkmayfix }} '],
                    ['Jun', '{{ $reactiveworkjunfix }} '],
                    ['Jul', '{{ $reactiveworkjulfix }} '],
                    ['Aug', '{{ $reactiveworkaugfix }} '],
                    ['Sep', '{{ $reactiveworksepfix }} '],
                    ['Oct', '{{ $reactiveworkoctfix }} '],
                    ['Nov', '{{ $reactiveworknovfix }} '],
                    ['Des', '{{ $reactiveworkdesfix }} ']
                ], datasets: [ { 
                    label: 'Total WO Tactical', data: [
                        {{ $jumlahwojan }}, {{ $jumlahwofeb }},
                            {{ $jumlahwomar }}, {{ $jumlahwoapr }},
                            {{ $jumlahwomay }}, {{ $jumlahwojun }},
                            {{ $jumlahwojul }}, {{ $jumlahwoaug }},
                            {{ $jumlahwosep }}, {{ $jumlahwooct }},
                            {{ $jumlahwonov }}, {{ $jumlahwodes }}
                        ] }, 
                    { label: 'Total WO Non Tactical', data: [
                        {{ $jumlahwocrjan }}, {{ $jumlahwocrfeb }},
                            {{ $jumlahwocrmar }}, {{ $jumlahwocrapr }},
                            {{ $jumlahwocrmay }}, {{ $jumlahwocrjun }},
                            {{ $jumlahwocrjul }}, {{ $jumlahwocraug }},
                            {{ $jumlahwocrsep }}, {{ $jumlahwocroct }},
                            {{ $jumlahwocrnov }}, {{ $jumlahwocrdes }}
                        ] }, ], }, }"
                    class="img-fluid" alt="">
            </div>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <div class="card">
                <div class="card-header text-center">
                    <div class="card-title mb-0">
                        <h4 class="m-0 me-2">Report ReWork {{ $namaunit }}</h4>
                        <small class="text-muted">Periode Januari - Desember {{ $thisyear }}</small>
                        <div class="text-center">
                            <img src="assets/img/illustrations/PLNNPnew.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive text-wrap">
                        <table class="table">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold">Bulan</th>
                                    <th class="fw-bold">Jan</th>
                                    <th class="fw-bold">Feb</th>
                                    <th class="fw-bold">Mar</th>
                                    <th class="fw-bold">Apr</th>
                                    <th class="fw-bold">May</th>
                                    <th class="fw-bold">Jun</th>
                                    <th class="fw-bold">Jul</th>
                                    <th class="fw-bold">Aug</th>
                                    <th class="fw-bold">Sep</th>
                                    <th class="fw-bold">Oct</th>
                                    <th class="fw-bold">Nov</th>
                                    <th class="fw-bold">Des</th>
                                </tr>
                            </thead>
                            <tbody class="table-border">
                                <tr>
                                    <td class="fw-bold">WO CR</td>
                                    <td>{{ $jumlahwocrjan }}</td>
                                    <td>{{ $jumlahwocrfeb }}</td>
                                    <td>{{ $jumlahwocrmar }}</td>
                                    <td>{{ $jumlahwocrapr }}</td>
                                    <td>{{ $jumlahwocrmay }}</td>
                                    <td>{{ $jumlahwocrjun }}</td>
                                    <td>{{ $jumlahwocrjul }}</td>
                                    <td>{{ $jumlahwocraug }}</td>
                                    <td>{{ $jumlahwocrsep }}</td>
                                    <td>{{ $jumlahwocroct }}</td>
                                    <td>{{ $jumlahwocrnov }}</td>
                                    <td>{{ $jumlahwocrdes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">WO Rework</td>
                                    <td>{{ $reworkjan }}</td>
                                    <td>{{ $reworkfeb }}</td>
                                    <td>{{ $reworkmar }}</td>
                                    <td>{{ $reworkapr }}</td>
                                    <td>{{ $reworkmay }}</td>
                                    <td>{{ $reworkjun }}</td>
                                    <td>{{ $reworkjul }}</td>
                                    <td>{{ $reworkaug }}</td>
                                    <td>{{ $reworksep }}</td>
                                    <td>{{ $reworkoct }}</td>
                                    <td>{{ $reworknov }}</td>
                                    <td>{{ $reworkdes }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Rework (%)</td>
                                    <td>{{ $rasioreworkfixjan }}</td>
                                    <td>{{ $rasioreworkfixfeb }}</td>
                                    <td>{{ $rasioreworkfixmar }}</td>
                                    <td>{{ $rasioreworkfixapr }}</td>
                                    <td>{{ $rasioreworkfixmay }}</td>
                                    <td>{{ $rasioreworkfixjun }}</td>
                                    <td>{{ $rasioreworkfixjul }}</td>
                                    <td>{{ $rasioreworkfixaug }}</td>
                                    <td>{{ $rasioreworkfixsep }}</td>
                                    <td>{{ $rasioreworkfixoct }}</td>
                                    <td>{{ $rasioreworkfixnov }}</td>
                                    <td>{{ $rasioreworkfixdes }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-1 mt-10">
            <h5>ReWork : {{ $totalreworkfix }} %</h5>
            <h5>Min Target : 5 % </h5>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
            <h4 class="m-0 me-2 mb-5 text-center">Grafik Rework {{ $namaunit }}</h4>
            <div class="text-center">
                <img src="https://quickchart.io/chart?v=2.9.4&c={ type: 'bar', data: { labels: [
                    ['Jan', '{{ $rasioreworkfixjan }} '],
                    ['Feb', '{{ $rasioreworkfixfeb }} '],
                    ['Mar', '{{ $rasioreworkfixmar }} '],
                    ['Apr', '{{ $rasioreworkfixapr }} '],
                    ['Mei', '{{ $rasioreworkfixmay }} '],
                    ['Jun', '{{ $rasioreworkfixjun }} '],
                    ['Jul', '{{ $rasioreworkfixjul }} '],
                    ['Aug', '{{ $rasioreworkfixaug }} '],
                    ['Sep', '{{ $rasioreworkfixsep }} '],
                    ['Oct', '{{ $rasioreworkfixoct }} '],
                    ['Nov', '{{ $rasioreworkfixnov }} '],
                    ['Des', '{{ $rasioreworkfixdes }} ']
                ], datasets: [ { 
                    label: 'Total Rework', data: [
                        {{ $reworkjan }}, {{ $reworkfeb }},
                            {{ $reworkmar }}, {{ $reworkapr }},
                            {{ $reworkmay }}, {{ $reworkjun }},
                            {{ $reworkjul }}, {{ $reworkaug }},
                            {{ $reworksep }}, {{ $reworkoct }},
                            {{ $reworknov }}, {{ $reworkdes }}
                        ] }, 
                    { label: 'Total WO Non Tactical', data: [
                        {{ $jumlahwocrjan }}, {{ $jumlahwocrfeb }},
                            {{ $jumlahwocrmar }}, {{ $jumlahwocrapr }},
                            {{ $jumlahwocrmay }}, {{ $jumlahwocrjun }},
                            {{ $jumlahwocrjul }}, {{ $jumlahwocraug }},
                            {{ $jumlahwocrsep }}, {{ $jumlahwocroct }},
                            {{ $jumlahwocrnov }}, {{ $jumlahwocrdes }}
                        ] }, ], }, }"
                    class="img-fluid" alt="">
            </div>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <h4 class="m-0 me-2 mb-5 text-center">Daftar Peralatan Rework {{ $namaunit }} tahun
                {{ $thisyear }}</h4>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>KKS</th>
                            <th>Informasi</th>
                            <th>Tanggal Terbit</th>
                            <th>Total Rework</th>
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
            </div>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <div class="card">
                <div class="card-header text-center">
                    <div class="card-title mb-0">
                        <h4 class="m-0 me-2">Report Wrenchtime {{ $namaunit }}</h4>
                        <small class="text-muted">Periode Januari - Desember {{ $thisyear }}</small>
                        <div class="text-center">
                            <img src="assets/img/illustrations/PLNNPnew.png" alt="">
                        </div>
                    </div>
                </div>
                @foreach ($getWrenchtime as $item)
                    @php
                        $item->start_repair_date;
                        if (str_contains($item->start_repair_date, '202301')) {
                            $janhandonrepairs += $item->on_hand_repairs;
                            $jantimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202302')) {
                            $febhandonrepairs += $item->on_hand_repairs;
                            $febtimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202303')) {
                            $marhandonrepairs += $item->on_hand_repairs;
                            $martimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202304')) {
                            $aprhandonrepairs += $item->on_hand_repairs;
                            $aprtimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202305')) {
                            $mayhandonrepairs += $item->on_hand_repairs;
                            $maytimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202306')) {
                            $junhandonrepairs += $item->on_hand_repairs;
                            $juntimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202307')) {
                            $julhandonrepairs += $item->on_hand_repairs;
                            $jultimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202308')) {
                            $aughandonrepairs += $item->on_hand_repairs;
                            $augtimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202309')) {
                            $sephandonrepairs += $item->on_hand_repairs;
                            $septimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '2023010')) {
                            $octhandonrepairs += $item->on_hand_repairs;
                            $octtimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202311')) {
                            $novhandonrepairs += $item->on_hand_repairs;
                            $novtimeonrepairs += $item->time_to_repairs;
                        }
                        if (str_contains($item->start_repair_date, '202312')) {
                            $desbhandonrepairs += $item->on_hand_repairs;
                            $destimeonrepairs += $item->time_to_repairs;
                        }
                    @endphp
                @endforeach

                @php
                    if ($jantimeonrepairs == 0) {
                        $jantimeonrepairs = 0.001;
                    }
                    if ($janhandonrepairs == 0) {
                        $janhandonrepairs = 0.001;
                    }
                    $janwrenchtime = number_format((float) ($janhandonrepairs / $jantimeonrepairs) * 100, 1, '.', '');
                    if ($febtimeonrepairs == 0) {
                        $febtimeonrepairs = 0.001;
                    }
                    if ($febhandonrepairs == 0) {
                        $febhandonrepairs = 0.001;
                    }
                    $febwrenchtime = number_format((float) ($febhandonrepairs / $febtimeonrepairs) * 100, 1, '.', '');
                    if ($martimeonrepairs == 0) {
                        $martimeonrepairs = 0.001;
                    }
                    if ($marhandonrepairs == 0) {
                        $marhandonrepairs = 0.001;
                    }
                    $marwrenchtime = number_format((float) ($marhandonrepairs / $martimeonrepairs) * 100, 1, '.', '');
                    if ($aprtimeonrepairs == 0) {
                        $aprtimeonrepairs = 0.001;
                    }
                    if ($aprhandonrepairs == 0) {
                        $aprhandonrepairs = 0.001;
                    }
                    $aprwrenchtime = number_format((float) ($aprhandonrepairs / $aprtimeonrepairs) * 100, 1, '.', '');
                    if ($maytimeonrepairs == 0) {
                        $maytimeonrepairs = 0.001;
                    }
                    if ($mayhandonrepairs == 0) {
                        $mayhandonrepairs = 0.001;
                    }
                    $maywrenchtime = number_format((float) ($mayhandonrepairs / $maytimeonrepairs) * 100, 1, '.', '');
                    if ($juntimeonrepairs == 0) {
                        $juntimeonrepairs = 0.001;
                    }
                    if ($junhandonrepairs == 0) {
                        $junhandonrepairs = 0.001;
                    }
                    $junwrenchtime = number_format((float) ($junhandonrepairs / $juntimeonrepairs) * 100, 1, '.', '');
                    if ($jultimeonrepairs == 0) {
                        $jultimeonrepairs = 0.001;
                    }
                    if ($julhandonrepairs == 0) {
                        $julhandonrepairs = 0.001;
                    }
                    $julwrenchtime = number_format((float) ($julhandonrepairs / $jultimeonrepairs) * 100, 1, '.', '');
                    if ($augtimeonrepairs == 0) {
                        $augtimeonrepairs = 0.001;
                    }
                    if ($aughandonrepairs == 0) {
                        $aughandonrepairs = 0.001;
                    }
                    $augwrenchtime = number_format((float) ($aughandonrepairs / $augtimeonrepairs) * 100, 1, '.', '');
                    if ($septimeonrepairs == 0) {
                        $septimeonrepairs = 0.001;
                    }
                    if ($sephandonrepairs == 0) {
                        $sephandonrepairs = 0.001;
                    }
                    $sepwrenchtime = number_format((float) ($sephandonrepairs / $septimeonrepairs) * 100, 1, '.', '');
                    if ($octtimeonrepairs == 0) {
                        $octtimeonrepairs = 0.001;
                    }
                    if ($octhandonrepairs == 0) {
                        $octhandonrepairs = 0.001;
                    }
                    $octwrenchtime = number_format((float) ($octhandonrepairs / $octtimeonrepairs) * 100, 1, '.', '');
                    if ($novtimeonrepairs == 0) {
                        $novtimeonrepairs = 0.001;
                    }
                    if ($novhandonrepairs == 0) {
                        $novhandonrepairs = 0.001;
                    }
                    $novwrenchtime = number_format((float) ($novhandonrepairs / $novtimeonrepairs) * 100, 1, '.', '');
                    if ($destimeonrepairs == 0) {
                        $destimeonrepairs = 0.001;
                    }
                    if ($deshandonrepairs == 0) {
                        $deshandonrepairs = 0.001;
                    }
                    $deswrenchtime = number_format((float) ($deshandonrepairs / $destimeonrepairs) * 100, 1, '.', '');
                    
                    $totalwrenchtime = $janwrenchtime + $febwrenchtime + $marwrenchtime + $aprwrenchtime + $maywrenchtime + $junwrenchtime + $julwrenchtime + $augwrenchtime + $sepwrenchtime + $octwrenchtime + $novwrenchtime + $deswrenchtime;
                    
                    $fixtotalwrenchtime = number_format((float) $totalwrenchtime / 12, 1, '.', '');
                    
                    if ($fixtotalwrenchtime > 55) {
                        $status = 'Good';
                    } else {
                        $status = 'Not Good';
                    }
                    
                @endphp
                <div class="card-body">
                    <div class="table-responsive text-wrap">
                        <table class="table">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold">Bulan</th>
                                    <th class="fw-bold">Jan</th>
                                    <th class="fw-bold">Feb</th>
                                    <th class="fw-bold">Mar</th>
                                    <th class="fw-bold">Apr</th>
                                    <th class="fw-bold">May</th>
                                    <th class="fw-bold">Jun</th>
                                    <th class="fw-bold">Jul</th>
                                    <th class="fw-bold">Aug</th>
                                    <th class="fw-bold">Sep</th>
                                    <th class="fw-bold">Oct</th>
                                    <th class="fw-bold">Nov</th>
                                    <th class="fw-bold">Des</th>
                                </tr>
                            </thead>
                            <tbody class="table-border">
                                <tr>
                                    <td class="fw-bold">Hand On Repairs</td>
                                    <td>{{ $janhandonrepairs }}</td>
                                    <td>{{ $febhandonrepairs }}</td>
                                    <td>{{ $marhandonrepairs }}</td>
                                    <td>{{ $aprhandonrepairs }}</td>
                                    <td>{{ $mayhandonrepairs }}</td>
                                    <td>{{ $junhandonrepairs }}</td>
                                    <td>{{ $julhandonrepairs }}</td>
                                    <td>{{ $aughandonrepairs }}</td>
                                    <td>{{ $sephandonrepairs }}</td>
                                    <td>{{ $octhandonrepairs }}</td>
                                    <td>{{ $novhandonrepairs }}</td>
                                    <td>{{ $deshandonrepairs }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Time On Repairs</td>
                                    <td>{{ $jantimeonrepairs }}</td>
                                    <td>{{ $febtimeonrepairs }}</td>
                                    <td>{{ $martimeonrepairs }}</td>
                                    <td>{{ $aprtimeonrepairs }}</td>
                                    <td>{{ $maytimeonrepairs }}</td>
                                    <td>{{ $juntimeonrepairs }}</td>
                                    <td>{{ $jultimeonrepairs }}</td>
                                    <td>{{ $augtimeonrepairs }}</td>
                                    <td>{{ $septimeonrepairs }}</td>
                                    <td>{{ $octtimeonrepairs }}</td>
                                    <td>{{ $novtimeonrepairs }}</td>
                                    <td>{{ $destimeonrepairs }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Wrenchtime (%)</td>
                                    <td>{{ $janwrenchtime }}</td>
                                    <td>{{ $febwrenchtime }}</td>
                                    <td>{{ $marwrenchtime }}</td>
                                    <td>{{ $aprwrenchtime }}</td>
                                    <td>{{ $maywrenchtime }}</td>
                                    <td>{{ $junwrenchtime }}</td>
                                    <td>{{ $julwrenchtime }}</td>
                                    <td>{{ $augwrenchtime }}</td>
                                    <td>{{ $sepwrenchtime }}</td>
                                    <td>{{ $octwrenchtime }}</td>
                                    <td>{{ $novwrenchtime }}</td>
                                    <td>{{ $deswrenchtime }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-1 mt-10">
            <h5>Wrench time : {{ $fixtotalwrenchtime }} %</h5>
            <h5>Min Target : 55 % </h5>
            <h5>Status : {{ $status }}</h5>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
            <h4 class="m-0 me-2 mb-5 text-center">Grafik Wrenchtime {{ $namaunit }}</h4>
            <div class="text-center">
                <img src="https://quickchart.io/chart?v=2.9.4&c={ type: 'bar', data: { labels: [
                    ['Jan', '{{ $janwrenchtime }} '],
                    ['Feb', '{{ $febwrenchtime }} '],
                    ['Mar', '{{ $marwrenchtime }} '],
                    ['Apr', '{{ $aprwrenchtime }} '],
                    ['Mei', '{{ $maywrenchtime }} '],
                    ['Jun', '{{ $junwrenchtime }} '],
                    ['Jul', '{{ $julwrenchtime }} '],
                    ['Aug', '{{ $augwrenchtime }} '],
                    ['Sep', '{{ $sepwrenchtime }} '],
                    ['Oct', '{{ $octwrenchtime }} '],
                    ['Nov', '{{ $novwrenchtime }} '],
                    ['Des', '{{ $deswrenchtime }} ']
                ], datasets: [ { 
                    label: 'Hand On Repairs', data: [
                        {{ $janhandonrepairs }}, {{ $febhandonrepairs }},
                            {{ $marhandonrepairs }}, {{ $aprhandonrepairs }},
                            {{ $mayhandonrepairs }}, {{ $junhandonrepairs }},
                            {{ $julhandonrepairs }}, {{ $aughandonrepairs }},
                            {{ $sephandonrepairs }}, {{ $octhandonrepairs }},
                            {{ $novhandonrepairs }}, {{ $deshandonrepairs }}
                        ] }, 
                    { label: 'Time On Repairs', data: [
                        {{ $jantimeonrepairs }}, {{ $febtimeonrepairs }},
                            {{ $martimeonrepairs }}, {{ $aprtimeonrepairs }},
                            {{ $maytimeonrepairs }}, {{ $juntimeonrepairs }},
                            {{ $jultimeonrepairs }}, {{ $augtimeonrepairs }},
                            {{ $septimeonrepairs }}, {{ $octtimeonrepairs }},
                            {{ $novtimeonrepairs }}, {{ $destimeonrepairs }}
                        ] }, ], }, }"
                    class="img-fluid" alt="">
            </div>
        </div>
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mb-1">
            <h4 class="m-0 me-2 mb-5 text-center">Table Wrenchtime {{ $namaunit }}</h4>
            <div class="table-fit text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>WO NUMBER</th>
                            <th>DESCRIPTION</th>
                            <th>WORK DAYS</th>
                            <th>AVG HOURS</th>
                            <th>ON HAND REPAIR</th>
                            <th>TIME TO REPAIR</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($getWrenchtime as $item)
                            <tr>
                                <td>{{ $item->wo_number }}</td>
                                <td>{{ $item->description_wo }}</td>
                                <td>{{ $item->working_days }}</td>
                                <td>{{ $item->average_hours }}</td>
                                <td>{{ $item->on_hand_repairs }}</td>
                                <td>{{ $item->time_to_repairs }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
