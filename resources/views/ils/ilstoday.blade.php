@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'ILS Today')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="col-lg-12 col-md-4 order-0">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="fw-semibold d-block mb-1">ILS Hari Ini</span>
                                <h3 class="card-title mt-1">{{ $totalilstoday }}</h3>
                                @if ($totalilstoday > $totalilsyesterday)
                                    <small class="text-success fw-semibold"><i class="bx bx-down-arrow-alt"></i>
                                        Jumlah ILS Kemarin + {{ $totalilsyesterday }}
                                    </small>
                                @elseif ($totalilstoday < $totalilsyesterday)
                                    <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                        Jumlah ILS Kemarin + {{ $totalilsyesterday }}
                                    </small>
                                @endif
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ asset('/ilstoday') }}">More Info <i class='bx bxs-chevrons-right'></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="fw-semibold d-block mb-1">ILS Urgent Hari Ini</span>
                                <h3 class="card-title mt-1">{{ $totalilsurgenttoday }}</h3>
                                @if ($totalilsurgenttoday > $totalilsurgentyesterday)
                                    <small class="text-success fw-semibold"><i class="bx bx-down-arrow-alt"></i>
                                        Jumlah ILS Urgent Kemarin + {{ $totalilsurgentyesterday }}
                                    </small>
                                @elseif ($totalilsurgenttoday < $totalilsurgentyesterday)
                                    <small class="text-danger fw-semibold"><i class="bx bx-up-arrow-alt"></i>
                                        Jumlah ILS Urgent Kemarin + {{ $totalilsurgentyesterday }}
                                    </small>
                                @endif
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ asset('/ilsurgent') }}">More Info <i class='bx bxs-chevrons-right'></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="fw-semibold d-block mb-1">ILS Sudah Closed
                                    {{ $tahunini }}</span>
                                <h3 class="card-title mt-1">{{ $totalilsclosedyear }}</h3>
                                <small class="text-primary fw-semibold"><i class='bx bx-check-square'></i>
                                    ILS Masih berjalan sampai 31 Des
                                </small>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ asset('/ilsclosed') }}">More Info <i class='bx bxs-chevrons-right'></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-6 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <span class="fw-semibold d-block mb-1">ILS Masih Open {{ $tahunini }}</span>
                                <h3 class="card-title mt-1">{{ $totalilsopendyear }}</h3>
                                <small class="text-primary fw-semibold"><i class='bx bx-check-square'></i>
                                    ILS Masih berjalan sampai 31 Des
                                </small>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ asset('/ilsopen') }}">More Info <i class='bx bxs-chevrons-right'></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Striped Rows -->
            <div class="card">
                <h5 class="card-header">List ILS Today</h5>
                <form action="" method="get">
                    <div class="row justify-content-end">
                        <div class="col-6 col-sm-6 start-end">
                            <div class="input-group mb-3 px-3">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Search">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>KKS</th>
                                <th>Desc</th>
                                <th>Information</th>
                                <th>Priority</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($listilstoday as $item)
                                <tr>
                                    <td>{{ $item->raised_date }}</td>
                                    <td>{{ $item->equip_no }}</td>
                                    <td>{{ $item->short_desc }}</td>
                                    <td>{{ $item->corrective_desc }}</td>
                                    <td>{{ $item->priority_cde_541 }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col mt-3">
                        {{ $listilstoday->links() }}
                    </div>
                </div>
            </div>
            <!--/ Striped Rows -->
        </div>
    </div>
@endsection
