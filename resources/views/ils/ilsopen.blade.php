@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'ILS Open')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row px-3">
                <!-- Striped Rows -->
                <div class="card">
                    <h5 class="card-header">List ILS Open Tahun {{ $thisyear }}</h5>
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
                                    <th>Date</th>
                                    <th>KKS</th>
                                    <th>Desc</th>
                                    <th>Information</th>
                                    <th>Priority</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($tableilsopen as $item)
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
                            {{ $tableilsopen->links() }}
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>
        </div>
    </div>
@endsection
