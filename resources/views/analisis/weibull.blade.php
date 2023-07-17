@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Weibull Reliability')

@extends('layouts.sidebarlayout')

@section('content')

    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <livewire:reliability-weibull>
        </div>
    </div>

@endsection
