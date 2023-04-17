@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'ILS Urgent')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row px-3">
                <!-- Striped Rows -->
                <div class="card">
                    <h5 class="card-header">List ILS Urgent Today</h5>
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
                                @foreach ($ilsurgenttabletoday as $item)
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
                            {{ $ilsurgenttabletoday->links() }}
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->

                <!-- Striped Rows -->
                <div class="card mt-4">
                    <h5 class="card-header">List ILS Urgent Yesterday</h5>
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
                                @foreach ($ilsurgenttableyesterday as $item)
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
                            {{ $ilsurgenttableyesterday->links() }}
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>
        </div>
    </div>
@endsection
