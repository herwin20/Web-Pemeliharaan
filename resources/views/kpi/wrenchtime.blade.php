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
                </div>

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
                            <div class="col-6 col-sm-6 align-self-center">
                                <select class="form-select" name="tahun" id="tahun">
                                    <option selected value="{{$thisyear}}">{{ $optiontahun }}</option>
                                    <option value="{{$thisyear}}">{{$thisyear}}</option>
                                    <option value="{{$year1}}">{{$year1}}</option>
                                    <option value="{{$year2}}">{{$year2}}</option>
                                    <option value="{{$year3}}">{{$year3}}</option>
                                    <option value="{{$year3}}">{{$year4}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2 text-center">
                            <div class="col-6 mt-2 col-sm-12 align-self-center">
                                <button class="btn btn-primary" type="submit">Search</button>
                                @if ($option == 'TELECT')
                                    <button class="btn btn-danger "
                                        onclick="window.open('{{ asset('/pmcompliancepdf/print_report') }}','_blank')"
                                        type="button" target="_blank">
                                        Print Report Blok 1-2
                                    </button>
                                @endif
                                @if ($option == 'TELECT3')
                                    <button class="btn btn-danger "
                                    onclick="window.open('{{ asset('/pmcompliancepdf34/print_report') }}','_blank')"
                                        type="button" target="_blank">
                                        Print Report Blok 3-4
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                @foreach($getWrenchtime as $item)
                        @php
                        $item->start_repair_date;
                        if(str_contains($item->start_repair_date, '202301')) {
                            $janhandonrepairs += $item->on_hand_repairs;
                            $jantimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202302')) {
                            $febhandonrepairs += $item->on_hand_repairs;
                            $febtimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202303')) {
                            $marhandonrepairs += $item->on_hand_repairs;
                            $martimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202304')) {
                            $aprhandonrepairs += $item->on_hand_repairs;
                            $aprtimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202305')) {
                            $mayhandonrepairs += $item->on_hand_repairs;
                            $maytimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202306')) {
                            $junhandonrepairs += $item->on_hand_repairs;
                            $juntimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202307')) {
                            $julhandonrepairs += $item->on_hand_repairs;
                            $jultimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202308')) {
                            $aughandonrepairs += $item->on_hand_repairs;
                            $augtimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202309')) {
                            $sephandonrepairs += $item->on_hand_repairs;
                            $septimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '2023010')) {
                            $octhandonrepairs += $item->on_hand_repairs;
                            $octtimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202311')) {
                            $novhandonrepairs += $item->on_hand_repairs;
                            $novtimeonrepairs += $item->time_to_repairs;
                        }
                        if(str_contains($item->start_repair_date, '202312')) {
                            $desbhandonrepairs += $item->on_hand_repairs;
                            $destimeonrepairs += $item->time_to_repairs;
                        }
                        @endphp
                @endforeach
                
                @php
                    if($jantimeonrepairs == 0){$jantimeonrepairs = 0.001;}
                    if($janhandonrepairs == 0){$janhandonrepairs = 0.001;}
                    $janwrenchtime =  number_format((float)($janhandonrepairs / $jantimeonrepairs)*100, 1, '.', '');
                    if($febtimeonrepairs == 0){$febtimeonrepairs = 0.001;}
                    if($febhandonrepairs == 0){$febhandonrepairs = 0.001;}
                    $febwrenchtime =  number_format((float)($febhandonrepairs / $febtimeonrepairs)*100, 1, '.', '');
                    if($martimeonrepairs == 0){$martimeonrepairs = 0.001;}
                    if($marhandonrepairs == 0){$marhandonrepairs = 0.001;}
                    $marwrenchtime =  number_format((float)($marhandonrepairs / $martimeonrepairs)*100, 1, '.', '');
                    if($aprtimeonrepairs == 0){$aprtimeonrepairs = 0.001;}
                    if($aprhandonrepairs == 0){$aprhandonrepairs = 0.001;}
                    $aprwrenchtime =  number_format((float)($aprhandonrepairs / $aprtimeonrepairs)*100, 1, '.', '');
                    if($maytimeonrepairs == 0){$maytimeonrepairs = 0.001;}
                    if($mayhandonrepairs == 0){$mayhandonrepairs = 0.001;}
                    $maywrenchtime =  number_format((float)($mayhandonrepairs / $maytimeonrepairs)*100, 1, '.', '');
                    if($juntimeonrepairs == 0){$juntimeonrepairs = 0.001;}
                    if($junhandonrepairs == 0){$junhandonrepairs = 0.001;}
                    $junwrenchtime =  number_format((float)($junhandonrepairs / $juntimeonrepairs)*100, 1, '.', '');
                    if($jultimeonrepairs == 0){$jultimeonrepairs = 0.001;}
                    if($julhandonrepairs == 0){$julhandonrepairs = 0.001;}
                    $julwrenchtime =  number_format((float)($julhandonrepairs / $jultimeonrepairs)*100, 1, '.', '');
                    if($augtimeonrepairs == 0){$augtimeonrepairs = 0.001;}
                    if($aughandonrepairs == 0){$aughandonrepairs = 0.001;}
                    $augwrenchtime =  number_format((float)($aughandonrepairs / $augtimeonrepairs)*100, 1, '.', '');
                    if($septimeonrepairs == 0){$septimeonrepairs = 0.001;}
                    if($sephandonrepairs == 0){$sephandonrepairs = 0.001;}
                    $sepwrenchtime =  number_format((float)($sephandonrepairs / $septimeonrepairs)*100, 1, '.', '');
                    if($octtimeonrepairs == 0){$octtimeonrepairs = 0.001;}
                    if($octhandonrepairs == 0){$octhandonrepairs = 0.001;}
                    $octwrenchtime =  number_format((float)($octhandonrepairs / $octtimeonrepairs)*100, 1, '.', '');
                    if($novtimeonrepairs == 0){$novtimeonrepairs = 0.001;}
                    if($novhandonrepairs == 0){$novhandonrepairs = 0.001;}
                    $novwrenchtime =  number_format((float)($novhandonrepairs / $novtimeonrepairs)*100, 1, '.', '');
                    if($destimeonrepairs == 0){$destimeonrepairs = 0.001;}
                    if($deshandonrepairs == 0){$deshandonrepairs = 0.001;}
                    $deswrenchtime =  number_format((float)($deshandonrepairs / $destimeonrepairs)*100, 1, '.', '');

                    $totalwrenchtime = $janwrenchtime + $febwrenchtime + $marwrenchtime + $aprwrenchtime + $maywrenchtime + $junwrenchtime
                            + $julwrenchtime + $augwrenchtime + $sepwrenchtime + $octwrenchtime + $novwrenchtime + $deswrenchtime;

                    $fixtotalwrenchtime = number_format((float)$totalwrenchtime / 12, 1, '.', '');
                @endphp

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
                                    <h2 class="mt-3 mb-2">55%</h2>
                                    <span>Target Min Wrench Time</span>
                                </div>
                                <div class="d-flex flex-column align-items-center gap-1">
                                    <h2 class="text-success mt-3 mb-2"> {{ $fixtotalwrenchtime }} %</h2>
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
                                            <small class="text-muted"> {{ $janhandonrepairs }} /
                                                {{ $jantimeonrepairs }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $janwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $febhandonrepairs }} /
                                                {{ $febtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $febwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $marhandonrepairs }} /
                                                {{ $martimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $marwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $aprhandonrepairs }} /
                                                {{ $aprtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $aprwrenchtime }} %</small>
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
                                            <small class="text-muted"> {{ $mayhandonrepairs }} /
                                                {{ $maytimeonrepairs }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $maywrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $junhandonrepairs }} /
                                                {{ $juntimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $junwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $julhandonrepairs }} /
                                                {{ $jultimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $julwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $aughandonrepairs }} /
                                                {{ $augtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $augwrenchtime }} %</small>
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
                                            <small class="text-muted"> {{ $sephandonrepairs }} /
                                                {{ $septimeonrepairs }}
                                            </small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $sepwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $octhandonrepairs }} /
                                                {{ $octtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $octwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $novhandonrepairs }} /
                                                {{ $novtimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $novwrenchtime }} %</small>
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
                                            <small class="text-muted">{{ $deshandonrepairs }} /
                                                {{ $destimeonrepairs }}</small>
                                        </div>
                                        <div class="user-progress">
                                            <small class="fw-semibold">{{ $deswrenchtime }} %</small>
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
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card mt-2 mb-3">
                        <div class="card-body">
                            <div class="table-responsive text-nowrap">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>WO NUMBER</th>
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
                                        @foreach ($getWrenchtime as $item)
                                            <tr>
                                                <td>{{ $item->wo_number }}</td>
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
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                      ['Jan', '{{ $janwrenchtime }} %'],
                      ['Feb', '{{ $febwrenchtime }} %'],
                      ['Mar', '{{ $marwrenchtime }} %'],
                      ['Apr', '{{ $aprwrenchtime }} %'],
                      ['Mei', '{{ $maywrenchtime }} %'],
                      ['Jun', '{{ $junwrenchtime }} %'],
                      ['Jul', '{{ $julwrenchtime }} %'],
                      ['Aug', '{{ $augwrenchtime }} %'],
                      ['Sep', '{{ $sepwrenchtime }} %'],
                      ['Oct', '{{ $octwrenchtime }} %'],
                      ['Nov', '{{ $novwrenchtime }} %'],
                      ['Des', '{{ $deswrenchtime }} %']
                  ],
                  datasets: [{
                          label: 'Time Hand Repairs (Hours)',
                          data: [
                              {{ $janhandonrepairs }}, {{ $febhandonrepairs }},
                              {{ $marhandonrepairs }}, {{ $aprhandonrepairs }},
                              {{ $mayhandonrepairs }}, {{ $junhandonrepairs }},
                              {{ $julhandonrepairs }}, {{ $aughandonrepairs }},
                              {{ $sephandonrepairs }}, {{ $octhandonrepairs }},
                              {{ $novhandonrepairs }}, {{ $deshandonrepairs }}
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
