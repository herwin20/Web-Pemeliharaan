@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Dashboard')

@extends('layouts.sidebarlayout')

<!-- Database Belum di Buat Yakkk -->

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-lg-12 col-md-6 mb-4 order-0">
                    <div class="card">
                        <div class="d-flex align-items-end row">
                            <div class="col-sm-7">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Feedback Bidang Lain 📖</h5>
                                    <p class="mb-4">
                                        Form ini bertujuan untuk memfasilitasi bidang selain Har untuk berkomunikasi ataupun
                                        memberi Feedback dan Input terhadap bidang Har. Seperti contoh mengisi Jobcard dan
                                        mengembalikan feedback PM
                                    </p>
                                    <a href="javascript:;" class="btn btn-sm btn-outline-primary">Daftar Feedback dan
                                        Input</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-center text-sm-left">
                                <div class="card-body pb-0 px-0 px-md-4">
                                    <img src="../assets/img/illustrations/man-with-laptop-light.png" height="140"
                                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-6 mb-4 order-0">
                    <div class="card">
                        <div class="card-header">
                            <form method="post" id="form_feedback" class="form-horizontal" enctype="multipart/form-data">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalLabel">Form Feedback dan Input</h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <span id="form_result"></span>
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-fullname">Nama</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                    class="bx bx-user"></i></span>
                                            <input type="text" name="nama" id="nama" class="form-control"
                                                id="basic-icon-default-fullname" placeholder="Herwin" aria-label="6"
                                                aria-describedby="basic-icon-default-fullname2" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-company">Bidang</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-company2" class="input-group-text"><i
                                                    class='bx bx-briefcase'></i></span>
                                            <input type="text" name="bidang" id="bidang" class="form-control"
                                                placeholder="Listrik" aria-label="" value="{{ auth()->user()->bidang }}"
                                                aria-describedby="basic-icon-default-company2" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">Sub Bidang</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-phone2" class="input-group-text"><i
                                                    class='bx bx-briefcase'></i></span>
                                            <input type="text" name="subbidang" id="subbidang"
                                                class="form-control phone-mask" placeholder="Rendal Har"
                                                aria-label="Depan MCR 12" aria-describedby="basic-icon-default-phone2" />
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-message">Feedback & Input</label>
                                        <div class="input-group input-group-merge">
                                            <span id="basic-icon-default-message2" class="input-group-text"><i
                                                    class='bx bx-notepad'></i></span>
                                            <textarea name="feedback" id="feedback" rows="4" class="form-control"></textarea>
                                        </div>
                                        <div class="form-text"> Temuan saat Pekerjaan </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="basic-icon-default-phone">File Pendukung</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group">
                                                <input type="file" name="file" id="file" class="form-control"
                                                    id="inputGroupFile02">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" name="action_button" id="action_button" value="Add"
                                            class="btn btn-primary" />
                                    </div>
                                    <input type="hidden" name="hidden_id" id="hidden_id" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
