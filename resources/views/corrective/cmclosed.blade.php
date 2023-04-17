@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'WO CR Closed')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row px-3">
                <!-- Striped Rows -->
                <div class="card">
                    <h5 class="card-header">Work Order CM Closed</h5>
                    <form action="" method="get">
                        <div class="row justify-content-end">
                            <div class="col-6 col-sm-6 start-end">
                                <div class="input-group mb-3">
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
                                    <th>No WO</th>
                                    <th>Creation Date</th>
                                    <th>Plan Date</th>
                                    <th>WO Description</th>
                                    <th>Status</th>
                                    <th>Closed Date</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($viewcmclosed as $item)
                                    <tr>
                                        <td>{{ $item->work_order }}</td>
                                        <td>{{ $item->creation_date }}</td>
                                        <td>{{ $item->plan_str_date }}</td>
                                        <td>{{ $item->wo_desc }}</td>
                                        <td>{{ $item->wo_status_m }}</td>
                                        <td>{{ $item->closed_dt }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="col mt-3">
                            {{ $viewcmclosed->links() }}
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>
        </div>
    </div>
@endsection
