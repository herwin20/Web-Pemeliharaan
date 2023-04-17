@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'PLTGU')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Equipment /</span> Motor</h4>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="javascript:void(0);"><i class='bx bx-line-chart'></i> Cooler
                                Fan</a>
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

                <div class="col-lg-12 col-md-6 order-0">
                    <div class="row px-2">
                        <div class="card mt-2 mb-3">
                            <div class="card-header text-center">
                                <h4>Upload File .csv untuk Data Arus Cooler Fan</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('analisis/motor.import') }}" method="POST"
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
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DATE</th>
                                                <th>ACTUAL</th>
                                                <th>FORECAST</th>
                                                <th>FORECAST LOWER</th>
                                                <th>FORECAST UPPER</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($c1f1 as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->date }}</td>
                                                    <td>{{ $item->actual }}</td>
                                                    <td>{{ $item->forecast }}</td>
                                                    <td>{{ $item->forecast_lower }}</td>
                                                    <td>{{ $item->forecast_upper }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col mt-3">
                                        {{ $c1f1->onEachSide(5)->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12 col-md-6 order-0">
                    <div class="row px-2">
                        <div class="card">
                            <div class="card-body">
                                {!! $chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}

@endsection
