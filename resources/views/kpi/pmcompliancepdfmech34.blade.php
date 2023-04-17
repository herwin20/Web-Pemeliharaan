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
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
            <div class="text-center">
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
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
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
        <div class="page-break"></div>
        <div class="col-md-12 col-lg-12 col-xl-12 order-0 mt-3">
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
    </div>
</body>

</html>
