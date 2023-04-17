@extends('layouts.footer')

@extends('layouts.mainlayout')

@section('title', 'Report')

@extends('layouts.sidebarlayout')

@section('content')
    <!-- Content wrapper -->
    <div class="content-wrapper">

        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row px-3">
                <!-- Striped Rows -->
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center bold">LIST PEKERJAAN HARIAN 3-4</h2>
                        <div class="text-start mb-3">
                            <button type="button" name="create_record34" id="create_record34" data-bs-target="#formModal"
                                class="btn rounded-pill btn-primary">
                                <span class="tf-icons bx bx-plus"></span> Add</button>
                            <button onclick="location.href='report-analyze34'" type="button" id="analyzereport"
                                data-bs-target="#formModal" class="btn rounded-pill btn-danger">
                                <span class="tf-icons bx bx-chart"></span> Analyze</button>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-striped report_datatable34">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Week</th>
                                        <th>Pekerjaan</th>
                                        <th>Uraian</th>
                                        <th>Lokasi</th>
                                        <th>Temuan</th>
                                        <th>Rekomendasi</th>
                                        <th>Status</th>
                                        <th style="width:150px">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/ Striped Rows -->
            </div>
        </div>

        <div class="modal fade" id="confirmModal34" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true"
            data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="sample_form" class="form-horizontal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h4 class="text-center" style="margin:0;">Are you sure you want to remove this data?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" name="ok_button" id="ok_button" class="btn btn-danger">OK</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="formModal34" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true"
            data-bs-keyboard="false" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="post" id="history_form34" class="form-horizontal">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalLabel">Add New Record</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-fullname">This Week</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-calendar"></i></span>
                                    <input type="text" name="week" id="week" class="form-control"
                                        id="basic-icon-default-fullname" placeholder="6" aria-label="6"
                                        aria-describedby="basic-icon-default-fullname2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Nama Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class='bx bx-briefcase'></i></span>
                                    <input type="text" name="nama_pekerjaan" id="nama_pekerjaan" class="form-control"
                                        placeholder="PM Motor-motor AC" aria-label="PM Motor-motor AC"
                                        aria-describedby="basic-icon-default-company2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Tipe Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class='bx bx-wrench'></i></span>
                                    <select class="form-select" name="tipe_pekerjaan" id="tipe_pekerjaan">
                                        <option selected value="PM">PM</option>
                                        <option value="CM">CM</option>
                                        <option value="Pdm">Pdm</option>
                                        <option value="OH">OH</option>
                                        <option value="Lembur">Lembur</option>
                                        <option value="Piket">Piket</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label class="input-group-text" for="tipe_pekerjaan">Tipe</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-email">Uraian Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class='bx bx-notepad'></i></span>
                                    <textarea name="uraian_pekerjaan" id="uraian_pekerjaan" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-text"> Tulis sesuai pekerjaan yang dilakukan </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-phone">Lokasi</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i
                                            class='bx bx-location-plus'></i></span>
                                    <input type="text" name="lokasi" id="lokasi" class="form-control phone-mask"
                                        placeholder="Depan MCR 12" aria-label="Depan MCR 12"
                                        aria-describedby="basic-icon-default-phone2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Unit</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class="bx bx-buildings"></i></span>
                                    <select class="form-select" name="unit" id="unit">
                                        <option selected value="GT11">GT11</option>
                                        <option value="GT12">GT12</option>
                                        <option value="GT13">GT13</option>
                                        <option value="ST14">ST14</option>
                                        <option value="BOP12">BOP12</option>
                                        <option value="GT21">GT21</option>
                                        <option value="GT22">GT22</option>
                                        <option value="ST20">ST20</option>
                                        <option value="GT31">GT31</option>
                                        <option value="GT32">GT32</option>
                                        <option value="GT33">GT33</option>
                                        <option value="ST30">ST30</option>
                                        <option value="GT41">GT41</option>
                                        <option value="GT42">GT42</option>
                                        <option value="GT43">GT43</option>
                                        <option value="ST40">ST40</option>
                                        <option value="GT51">GT51</option>
                                        <option value="ST58">ST58</option>
                                        <option value="BOP5">BOP5</option>
                                        <option value="BOP34">BOP34</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <label class="input-group-text" for="unit">Unit</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-phone">Sub Sistem</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i
                                            class='bx bx-data'></i></span>
                                    <input type="text" name="subsistem" id="subsistem"
                                        class="form-control phone-mask" placeholder="Breaker" aria-label="Breaker"
                                        aria-describedby="basic-icon-default-phone2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-phone">PIC</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-phone2" class="input-group-text"><i
                                            class='bx bx-user'></i></i></span>
                                    <input type="text" name="pic" id="pic" class="form-control phone-mask"
                                        placeholder="Herwin,Hasan,Amin" aria-label="Herwin,Hasan,Amin"
                                        aria-describedby="basic-icon-default-phone2" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-message">Temuan</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class='bx bx-notepad'></i></span>
                                    <textarea name="temuan" id="temuan" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-text"> Temuan saat Pekerjaan </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-message">Rekomendasi</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class='bx bx-notepad'></i></span>
                                    <textarea name="rekomendasi" id="rekomendasi" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-text"> Rekomendasi Pekerjaan </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-message">Material</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-message2" class="input-group-text"><i
                                            class='bx bx-notepad'></i></i></span>
                                    <textarea name="material" id="material" rows="4" class="form-control"></textarea>
                                </div>
                                <div class="form-text"> Material Pekerjaan </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-company">Status Pekerjaan</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i
                                            class='bx bxs-keyboard'></i></span>
                                    <select class="form-select" name="status" id="status">
                                        <option selected value="Sudah dikerjakan">Sudah dikerjakan</option>
                                        <option value="Waiting Material">Waiting Material</option>
                                        <option value="Waiting Shutdown">Waiting Shutdown</option>
                                        <option value="Waiting Inspection">Waiting Inspection</option>
                                        <option value="Waiting Execution">Waiting Execution</option>
                                        <option value="Waiting Analisys">Waiting Analisys</option>
                                    </select>
                                    <label class="input-group-text" for="status">Status</label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-icon-default-phone">Upload</label>
                                <div class="input-group input-group-merge">
                                    <div class="input-group">
                                        <input type="file" name="photo" id="photo" class="form-control"
                                            id="inputGroupFile02">
                                        <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" name="action_button34" id="action_button34" value="Add Blok 34"
                                    class="btn btn-primary" />
                            </div>
                            <span id="form_result34"></span>
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
