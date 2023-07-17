@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'PLTGU')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Equipment /</span> PLTGU </h4>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills flex-column flex-md-row mb-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ asset('/pltgu') }}"><i class='bx bxs-buildings'></i> BLOK
                                1-2</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ asset('/notification-pltgu') }}"><i
                                    class="bx bx-bell me-1"></i> Notifications</a>
                        </li><span class="badge text-danger">{{ $countnotification }}</span>
                        <li class="nav-item">
                            <a class="nav-link" href="pages-account-settings-connections.html"><i
                                    class="bx bx-link-alt me-1"></i> Connections</a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-12 col-md-6 order-0">
                    <div class="row px-2">
                        <div class="card mt-2 mb-3">
                            <div class="card-body">
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>DATE</th>
                                                <th>ANOMALY</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-border-bottom-0">
                                            @foreach ($tablenotification as $item)
                                                @if ($item->action == 'not normal')
                                                    <tr class="table-danger">
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>{{ $item->anomaly }}</td>
                                                        <td>{{ $item->action }}</td>
                                                    </tr>
                                                @endif
                                                @if ($item->action == 'normal')
                                                    <tr class="table-success">
                                                        <td>{{ $item->id }}</td>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>{{ $item->anomaly }}</td>
                                                        <td>{{ $item->action }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col mt-3">
                                        {{ $tablenotification->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
