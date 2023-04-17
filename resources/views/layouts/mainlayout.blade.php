<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Web-Har | @yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/favicon/favicon.png') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

    <link rel="stylesheet" href="{{ asset('/assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Page CSS -->
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Helpers -->
    <script src="{{ asset('/assets/vendor/js/helpers.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.5.1/sweetalert2.all.min.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/assets/js/config.js')}}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    @include('sweetalert::alert')
    @livewireStyles
    
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar" style="z-index: 1">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..."
                  />
                </div>
              </div>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item">
                  <img src="{{ asset('/assets/img/illustrations/PLNNP.png') }}" height="140" alt="" srcset="">
                </li>
                <li class="nav-item lh-1 me-3">
                  <a
                    class="github-button"
                    href="https://github.com/herwin20"
                    data-icon="octicon-star"
                    data-size="large"
                    data-show-count="true"
                    aria-label="Star themeselection/sneat-html-admin-template-free on GitHub"
                    >Star</a
                  >
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="https://ui-avatars.com/api/?name={{ auth()->user()->nama }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"></span>{{ auth()->user()->nama }}
                            <small class="text-muted">{{ auth()->user()->bidang }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="logout">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          @yield('content')

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/assets/js/dashboards-analytics.js') }}"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Page JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    @livewireScripts

    <!-- Data Table Pekerjaan Harian 1-2 -->
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('.report_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reportpekerjaan/reportpekerjaan.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'week',
                        name: 'week'
                    },
                    {
                        data: 'nama_pekerjaan',
                        name: 'nama_pekerjaan'
                    },
                    {
                        data: 'uraian_pekerjaan',
                        name: 'uraian_pekerjaan'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'temuan',
                        name: 'temuan'
                    },
                    {
                        data: 'rekomendasi',
                        name: 'rekomendasi'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '#create_record', function() {
                $('#history_form')[0].reset();
                $('.modal-title').text('Add New Record 12');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result').html('');
                $('#formModal').modal('show');
            });

            $('#history_form').on('submit', function(event) { //Hati2 Nama Formnya
                event.preventDefault();
                var action_url = '';

                if ($('#action_button').val() == 'Add') {
                    action_url = "{{ route('reportpekerjaan/reportpekerjaan.store') }}";
                }

                if ($('#action_button').val() == 'Update') {
                    action_url = "{{ route('reportpekerjaan/reportpekerjaan.update') }}";
                }

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: action_url,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        console.log('success: ' + data);
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            Swal.fire({
                                target: document.getElementById(
                                    'formModal'),
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: data.errors,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success +
                                '</div>';
                            Swal.fire({
                                target: document.getElementById(
                                    'formModal'),
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(function() {
                                $('#history_form')[0].reset();
                                $('.report_datatable').DataTable().ajax.reload();
                                $('#formModal').modal('toggle');
                            }, 3000);
                        }
                        $('#form_result').html(html);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });

            $(document).on('click', '.edit', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                //alert(id);
                $('#form_result').html('');

                $.ajax({
                    url: "/report-pekerjaan/edit/" + id + "/",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log('success: ' + data);
                        // --------- Retrive Data ------------------------------
                        $('#week').val(data.result.week);
                        $('#nama_pekerjaan').val(data.result.nama_pekerjaan);
                        $('#tipe_pekerjaan').val(data.result.tipe_pekerjaan);
                        $('#uraian_pekerjaan').val(data.result.uraian_pekerjaan);
                        $('#lokasi').val(data.result.lokasi);
                        $('#unit').val(data.result.unit);
                        $('#subsistem').val(data.result.subsistem);
                        $('#pic').val(data.result.pic);
                        $('#temuan').val(data.result.temuan);
                        $('#material').val(data.result.material);
                        $('#rekomendasi').val(data.result.rekomendasi);
                        $('#status').val(data.result.status);
                        //$('#photo').val(data.result.photo);
                        //-------------------------------------------------------
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record');
                        $('#action_button').val('Update');
                        $('#action').val('Edit');
                        $('#formModal').modal('show');
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });
        });
    </script>

    <script type="text/javascript">
        var user_id;

        $(document).on('click', '.delete', function() {
            user_id = $(this).attr('id');
            $('.modal-title').text('Confirmation');
            $('#confirmModal').modal('show');

        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "report-pekerjaan/destroy/" + user_id,
                beforeSend: function() {
                    $('#ok_button').text('Deleting...');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal').modal('hide');
                        $('.report_datatable').DataTable().ajax.reload();
                        //alert('Data Deleted');
                    }, 2000);
                }
            })
        });
    </script>

    <!-- Data Table Pekerjaan Harian 3-4 -->
    <script>
        $(document).ready(function() {
            var table = $('.report_datatable34').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reportpekerjaan/reportpekerjaan34.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'week',
                        name: 'week'
                    },
                    {
                        data: 'nama_pekerjaan',
                        name: 'nama_pekerjaan'
                    },
                    {
                        data: 'uraian_pekerjaan',
                        name: 'uraian_pekerjaan'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'temuan',
                        name: 'temuan'
                    },
                    {
                        data: 'rekomendasi',
                        name: 'rekomendasi'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '#create_record34', function() {
                $('#history_form34')[0].reset();
                $('.modal-title').text('Add New Record 34');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result34').html('');
                $('#formModal34').modal('show');
            });

            $('#history_form34').on('submit', function(event) { //Hati2 Nama Formnya
                event.preventDefault();
                var action_url = '';

                if ($('#action_button34').val() == 'Add Blok 34') {
                    action_url = "{{ route('reportpekerjaan/reportpekerjaan34.store') }}";
                }

                if ($('#action_button34').val() == 'Update Blok 34') {
                    action_url = "{{ route('reportpekerjaan/reportpekerjaan34.update') }}";
                }

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: action_url,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        console.log('success 34: ' + data);
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            Swal.fire({
                                target: document.getElementById(
                                    'formModal34'),
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: data.errors,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success +
                                '</div>';
                            Swal.fire({
                                target: document.getElementById(
                                    'formModal34'),
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(function() {
                                $('#history_form34')[0].reset();
                                $('.report_datatable34').DataTable().ajax.reload();
                                $('#formModal34').modal('toggle');
                            }, 3000);
                        }
                        $('#form_result34').html(html);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });

            $(document).on('click', '.edit34', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                //alert(id);
                $('#form_result34').html('');

                $.ajax({
                    url: "/report-pekerjaan34/edit/" + id + "/",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log('success 34: ' + data);
                        // --------- Retrive Data ------------------------------
                        $('#week').val(data.result.week);
                        $('#nama_pekerjaan').val(data.result.nama_pekerjaan);
                        $('#tipe_pekerjaan').val(data.result.tipe_pekerjaan);
                        $('#uraian_pekerjaan').val(data.result.uraian_pekerjaan);
                        $('#lokasi').val(data.result.lokasi);
                        $('#unit').val(data.result.unit);
                        $('#subsistem').val(data.result.subsistem);
                        $('#pic').val(data.result.pic);
                        $('#temuan').val(data.result.temuan);
                        $('#material').val(data.result.material);
                        $('#rekomendasi').val(data.result.rekomendasi);
                        $('#status').val(data.result.status);
                        //$('#photo').val(data.result.photo);
                        //-------------------------------------------------------
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record 34');
                        $('#action_button34').val('Update Blok 34');
                        $('#action').val('Edit');
                        $('#formModal34').modal('show');
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });
        });
    </script>

    <script type="text/javascript">
        var user_id;

        $(document).on('click', '.delete34', function() {
            user_id = $(this).attr('id');
            $('.modal-title').text('Confirmation Delete Report Blok 3-4');
            $('#confirmModal34').modal('show');

        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "report-pekerjaan34/destroy/" + user_id,
                beforeSend: function() {
                    $('#ok_button').text('Deleting...');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal34').modal('hide');
                        $('.report_datatable34').DataTable().ajax.reload();
                        //alert('Data Deleted');
                    }, 2000);
                }
            })
        });
    </script>

    <!-- Data Table Pekerjaan Harian 5 -->
    <script>
        $(document).ready(function() {
            var table = $('.report_datatable5').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reportpekerjaan/reportpekerjaan5.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'week',
                        name: 'week'
                    },
                    {
                        data: 'nama_pekerjaan',
                        name: 'nama_pekerjaan'
                    },
                    {
                        data: 'uraian_pekerjaan',
                        name: 'uraian_pekerjaan'
                    },
                    {
                        data: 'lokasi',
                        name: 'lokasi'
                    },
                    {
                        data: 'temuan',
                        name: 'temuan'
                    },
                    {
                        data: 'rekomendasi',
                        name: 'rekomendasi'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $(document).on('click', '#create_record5', function() {
                $('#history_form5')[0].reset();
                $('.modal-title').text('Add New Record 5');
                $('#action_button').val('Add');
                $('#action').val('Add');
                $('#form_result5').html('');
                $('#formModal5').modal('show');
            });

            $('#history_form5').on('submit', function(event) { //Hati2 Nama Formnya
                event.preventDefault();
                var action_url = '';

                if ($('#action_button5').val() == 'Add Blok 5') {
                    action_url = "{{ route('reportpekerjaan/reportpekerjaan5.store') }}";
                }

                if ($('#action_button5').val() == 'Update Blok 5') {
                    action_url = "{{ route('reportpekerjaan/reportpekerjaan5.update') }}";
                }

                $.ajax({
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: action_url,
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        console.log('success 5: ' + data);
                        var html = '';
                        if (data.errors) {
                            html = '<div class="alert alert-danger">';
                            for (var count = 0; count < data.errors.length; count++) {
                                html += '<p>' + data.errors[count] + '</p>';
                            }
                            html += '</div>';
                            Swal.fire({
                                target: document.getElementById(
                                    'formModal5'),
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: data.errors,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                        if (data.success) {
                            html = '<div class="alert alert-success">' + data.success +
                                '</div>';
                            Swal.fire({
                                target: document.getElementById(
                                    'formModal5'),
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: data.success,
                                showConfirmButton: false,
                                timer: 3000
                            });
                            setTimeout(function() {
                                $('#history_form5')[0].reset();
                                $('.report_datatable5').DataTable().ajax.reload();
                                $('#formModal5').modal('toggle');
                            }, 3000);
                        }
                        $('#form_result5').html(html);
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                });
            });

            $(document).on('click', '.edit5', function(event) {
                event.preventDefault();
                var id = $(this).attr('id');
                //alert(id);
                $('#form_result5').html('');

                $.ajax({
                    url: "/report-pekerjaan5/edit/" + id + "/",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log('success 5: ' + data);
                        // --------- Retrive Data ------------------------------
                        $('#week').val(data.result.week);
                        $('#nama_pekerjaan').val(data.result.nama_pekerjaan);
                        $('#tipe_pekerjaan').val(data.result.tipe_pekerjaan);
                        $('#uraian_pekerjaan').val(data.result.uraian_pekerjaan);
                        $('#lokasi').val(data.result.lokasi);
                        $('#unit').val(data.result.unit);
                        $('#subsistem').val(data.result.subsistem);
                        $('#pic').val(data.result.pic);
                        $('#temuan').val(data.result.temuan);
                        $('#material').val(data.result.material);
                        $('#rekomendasi').val(data.result.rekomendasi);
                        $('#status').val(data.result.status);
                        //$('#photo').val(data.result.photo);
                        //-------------------------------------------------------
                        $('#hidden_id').val(id);
                        $('.modal-title').text('Edit Record 5');
                        $('#action_button5').val('Update Blok 5');
                        $('#action').val('Edit');
                        $('#formModal5').modal('show');
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        console.log(errors);
                    }
                })
            });
        });
    </script>

    <script type="text/javascript">
        var user_id;

        $(document).on('click', '.delete5', function() {
            user_id = $(this).attr('id');
            $('.modal-title').text('Confirmation Delete Report Blok 5');
            $('#confirmModal34').modal('show');

        });

        $('#ok_button').click(function() {
            $.ajax({
                url: "report-pekerjaan5/destroy/" + user_id,
                beforeSend: function() {
                    $('#ok_button').text('Deleting...');
                },
                success: function(data) {
                    setTimeout(function() {
                        $('#confirmModal5').modal('hide');
                        $('.report_datatable5').DataTable().ajax.reload();
                        //alert('Data Deleted');
                    }, 2000);
                }
            })
        });
    </script>

  </body>
</html>
