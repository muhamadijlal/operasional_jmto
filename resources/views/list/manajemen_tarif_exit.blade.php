@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{ $judul }}
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/jquery.datetimepicker.min.css">
<style>
    .select2-container .select2-selection--single {
        display: block !important;
        width: 100% !important;
        height: calc(1.5em + 0.75rem + 2px) !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
        font-weight: 400 !important;
        line-height: 1.5 !important;
        color: #495057 !important;
        background-color: #fff !important;
        background-clip: padding-box !important;
        border: 1px solid #ced4da !important;
        border-radius: 0.25rem !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;

    }

    #loading-screen {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    #loading-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    #loading-content img {
        width: 50px;
        /* Sesuaikan ukuran gambar loading */
    }

    #loading-content p {
        margin-top: 10px;
    }

</style>
@endsection
@section('content')

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light"><b>{{ $judul }}</b>
</h4>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="gerbang">Gerbang</label>
                    <select name="gerbang" id="gerbang" class="select2 form-control"></select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-datatable table-responsive pt-0">
        <div class="card-body">

            @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif



            <button class="btn btn-info add-new " id="btnAddTarif"> <i class="fa fa-plus"></i> Tambah Tarif</button>
            <button class="btn btn-secondary  " id="btnRefeshDasarTarif"> <i class="fa fa-refresh"></i> Refresh</button>
            <button class="btn btn-primary  " id="btnExportTarif"> <i class="fa fa-print"></i> Export</button>
            <br>
            <br>

            <table id="tbl_list" class="datatables-basic table">
                <tr>
                    <?php foreach($Cloums as $row){ ?>


                    <th>{{$row['title']}}</td>

                        <?php } ?>
                </tr>
            </table>

        </div>
    </div>
</div>


<div class="modal" id="modalTambahTarifClose" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Tarif Close</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="gerbangmodal">Nama Gerbang :</label>
                            <select class="form-control" id="gerbangmodal" name="gerbangmodal" readonly="readonly">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="asal_gerbang">Asal Gerbang :</label>
                            <br>
                            <select style="width: 100%" class="form-control select2" id="asal_gerbang"
                                style="z-index: 1" name="asal_gerbang">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="dasartarifmodal">Dasar Tarif :</label>
                            <select class="form-control" id="dasartarifmodal" name="dasartarifmodal" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenis">Jenis Transaksi :</label>
                            <select class="form-control" id="jenis" name="jenis">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="waktu">Waktu Berlaku :</label>
                            <input type="text" class="form-control" name="waktu" id="waktu" aria-describedby="waktu"
                                placeholder="Waktu Berlaku" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 mt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="gol1-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol1-tab-pane" type="button" role="tab"
                                    aria-controls="gol1-tab-pane" aria-selected="true">Golongan 1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol2-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol2-tab-pane" type="button" role="tab"
                                    aria-controls="gol2-tab-pane" aria-selected="false">Golongan 2</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol3-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol3-tab-pane" type="button" role="tab"
                                    aria-controls="gol3-tab-pane" aria-selected="false">Golongan 3</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol4-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol4-tab-pane" type="button" role="tab"
                                    aria-controls="gol4-tab-pane" aria-selected="false">Golongan 4</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol5-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol5-tab-pane" type="button" role="tab"
                                    aria-controls="gol5-tab-pane" aria-selected="false">Golongan 5</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="gol1-tab-pane" role="tabpanel"
                                aria-labelledby="gol1-tab" tabindex="0">

                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalgol1"> Gol 1
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalgol1" id="totalgol1"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestor(1)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor1[]" id="investor1">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor1[]"
                                        id="total_investor1">
                                </div>
                                <hr>

                            </div>
                            <div class="tab-pane fade show " id="gol2-tab-pane" role="tabpanel"
                                aria-labelledby="gol2-tab" tabindex="0">


                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalgol2"> Gol 2
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalgol2" id="totalgol2"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestor(2)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor2[]" id="investor2">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor2[]"
                                        id="total_investor2">
                                </div>
                                <hr>

                            </div>

                            <div class="tab-pane fade show " id="gol3-tab-pane" role="tabpanel"
                                aria-labelledby="gol3-tab" tabindex="0">


                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalgol3"> Gol 3
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalgol3" id="totalgol3"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestor(3)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor3[]" id="investor3">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor3[]"
                                        id="total_investor3">
                                </div>
                                <hr>


                            </div>
                            <div class="tab-pane fade show " id="gol4-tab-pane" role="tabpanel"
                                aria-labelledby="gol4-tab" tabindex="0">



                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalgol4"> Gol 4
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalgol4" id="totalgol4"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestor(4)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor4[]" id="investor4">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor4[]"
                                        id="total_investor4">
                                </div>
                                <hr>

                            </div>
                            <div class="tab-pane fade show " id="gol5-tab-pane" role="tabpanel"
                                aria-labelledby="gol5-tab" tabindex="0">


                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalgol5"> Gol 5
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalgol5" id="totalgol5"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestor(5)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor5[]" id="investor5">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor5[]"
                                        id="total_investor5">
                                </div>
                                <hr>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnSimpanTarifExit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalEditTarifClose" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Tarif Close</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="gerbangEditmodal">Nama Gerbang :</label>
                            <input type="hidden" name="idTarif" id="idTarif">
                            <select class="form-control" id="gerbangEditmodal" name="gerbangEditmodal"
                                readonly="readonly">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="asal_edit_gerbang">Asal Gerbang :</label>
                            <br>
                            <select style="width: 100%" class="form-control select2" id="asal_edit_gerbang"
                                style="z-index: 1" name="asal_edit_gerbang">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="dasartarifeditmodal">Dasar Tarif :</label>
                            <select class="form-control" id="dasartarifeditmodal" name="dasartarifeditmodal" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="jenisEdit">Jenis Transaksi :</label>
                            <select class="form-control" id="jenisEdit" name="jenisEdit">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="waktuEdit">Waktu Berlaku :</label>
                            <input type="text" class="form-control" name="waktuEdit" id="waktuEdit"
                                aria-describedby="waktu" placeholder="Waktu Berlaku" required>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 mt-4">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="gol1-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol1-tab-pane-edit" type="button" role="tab"
                                    aria-controls="gol1-tab-pane-edit" aria-selected="true">Golongan 1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol2-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol2-tab-pane-edit" type="button" role="tab"
                                    aria-controls="gol2-tab-pane-edit" aria-selected="false">Golongan 2</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol3-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol3-tab-pane-edit" type="button" role="tab"
                                    aria-controls="gol3-tab-pane-edit" aria-selected="false">Golongan 3</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol4-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol4-tab-pane-edit" type="button" role="tab"
                                    aria-controls="gol4-tab-pane-edit" aria-selected="false">Golongan 4</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="gol5-tab" data-bs-toggle="tab"
                                    data-bs-target="#gol5-tab-pane-edit" type="button" role="tab"
                                    aria-controls="gol5-tab-pane-edit" aria-selected="false">Golongan 5</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="gol1-tab-pane-edit" role="tabpanel"
                                aria-labelledby="gol1-tab" tabindex="0">

                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalEditgol1"> Gol 1
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalEditgol1" id="totalEditgol1"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestorEdit(1)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor_edit1[]" id="investor_edit1">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor_edit1[]"
                                        id="total_investor_edit1">
                                </div>
                                <hr>

                            </div>
                            <div class="tab-pane fade show " id="gol2-tab-pane-edit" role="tabpanel"
                                aria-labelledby="gol2-tab" tabindex="0">


                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalEditgol2"> Gol 2
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalEditgol2" id="totalEditgol2"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestorEdit(2)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor_edit2[]" id="investor_edit2">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor_edit2[]"
                                        id="total_investor_edit2">
                                </div>
                                <hr>

                            </div>

                            <div class="tab-pane fade show " id="gol3-tab-pane-edit" role="tabpanel"
                                aria-labelledby="gol3-tab" tabindex="0">


                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalEditgol3"> Gol 3
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalEditgol3" id="totalEditgol3"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestorEdit(3)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor_edit3[]" id="investor_edit3">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor_edit3[]"
                                        id="total_investor_edit3">
                                </div>
                                <hr>


                            </div>
                            <div class="tab-pane fade show " id="gol4-tab-pane-edit" role="tabpanel"
                                aria-labelledby="gol4-tab" tabindex="0">



                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalEditgol4"> Gol 4
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalEditgol4" id="totalEditgol4"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestorEdit(4)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor_edit4[]" id="investor_edit4">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor_edit4[]"
                                        id="total_investor_edit4">
                                </div>
                                <hr>

                            </div>
                            <div class="tab-pane fade show " id="gol5-tab-pane-edit" role="tabpanel"
                                aria-labelledby="gol5-tab" tabindex="0">


                                <b>Tarif</b>
                                <hr>
                                <div class="form-group">
                                    <label class="col-sm-3" for="totalEditgol5"> Gol 5
                                        :</label>
                                    <div class="form-group col-sm-9">
                                        <input type="text" class="form-control" name="totalEditgol5" id="totalEditgol5"
                                            placeholder="">
                                    </div>
                                </div>

                                <br>
                                <b>investor</b>
                                <hr>

                                <a class="btn btn-primary" href="#" onclick="tambahInvestorEdit(5)">Tambah Investor</a>
                                <div class="form-group mt-3">
                                    <label for="investor">investor 1</label>
                                    <input type="text" class="form-control" name="investor_edit5[]" id="investor_edit5">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="total_investor">Tarif investor</label>
                                    <input type="number" class="form-control" name="totalinvestor_edit5[]"
                                        id="total_investor_edit5">
                                </div>
                                <hr>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" id="btnEditTarifExit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modalDetailInvestor">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tableDetailInvestor">
                        <thead>
                            <tr>
                                <td>Investor</td>
                                <td>Golongan 1</td>
                                <td>Golongan 2</td>
                                <td>Golongan 3</td>
                                <td>Golongan 4</td>
                                <td>Golongan 5</td>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


@endsection

{{-- @extends('admin.modal.manajemen_tarif') --}}


@push('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/build/jquery.datetimepicker.full.min.js"
    integrity="sha256-ptCFteBa9gzHPnbHLsFaC6n2j+u9F60jtR6AwEKEaeM=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_jquery.validate.min.js">
</script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_additional-methods.min.js">
</script>
<script>
    baseUrl = '{{ url()->current() }}';

</script>

{{-- <script src="{{ asset('admin/js/manajemen_tarif.js') }}"></script> --}}



<script type="text/javascript">
var investorCounts = {};
var investorCountEdit = {};
    $(document).ready(function () {

        function sweetAlert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }


        $("#waktu").datetimepicker({
            format: 'Y-m-d H:i:s',
            theme: 'white'
        });


        var dt_filter_table = $('.datatables-basic');
        var dataObject = eval('<?php echo json_encode($Cloums); ?>');


        $('.datatables-basic-open thead tr').clone(true).appendTo('.datatables-basic-open thead');

        $('#gerbang').on('change', function () {


            if ($.fn.DataTable.isDataTable('#tbl_list')) {
                $('#tbl_list').DataTable().destroy();
            }

            var selectedVal = $("#gerbang option:selected").text();
            selectedVal = selectedVal.split('-').pop().split(')')[0]; // returns 'two'

            dt_filter = $('#tbl_list').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ url()->current() }}', // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: function (d) {
                        d.gerbang = $('#gerbang').val();
                        d.search = $('input[type="search"]').val()
                    },
                    error: function (xhr, error, code) {}

                },
                columns: dataObject,
                displayLength: 10,
                scrollX: true,
                scrollCollapse: true,
                order: [
                    [0, 'asc']
                ],
                orderCellsTop: true,
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
            
                language: {
                    emptyTable: "Tidak ada data yang tersedia",
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },


            });

        });


        $('.datatables-basic').on('click', '.delete', function () {
            var url = '{{ url()->current() }}/delete/' + $(this).data('url') + '/' + $('#gerbang')
                .val();
            Swal.fire({
                title: 'Peringatan?',
                text: "Apakah Anda Yakin Menghapus Data Ini??",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: "get",
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (response) {

                            document.getElementById('loading-screen').style
                                .display =
                                'block';
                            setTimeout(function () {
                                dt_filter.ajax.reload();
                                document.getElementById('loading-screen')
                                    .style
                                    .display = 'none';
                                sweetAlert('Berhasil!',
                                    'Data Berhasil Dihapus!', 'success')
                            }, 1000);
                        }

                    });
                }


            });
        })

        $('.datatables-basic').on('click', '#btnDetailInvestor', function () {
            $("#modalDetailInvestor tbody tr").remove();
            var gerbang = $("#gerbang").val();
            // console.log($(this).data('url'))
            var id = $(this).data('url')
            $.ajax({
                url: "{{ url()->current() }}/get-investor-by-id/" + id + '/' + gerbang,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {

                    inventor = split_array(response.model.tarif_inv)
                    totalInven1 = JSON.parse(response.model.gol1_d)
                    totalInven2 = JSON.parse(response.model.gol2_d)
                    totalInven3 = JSON.parse(response.model.gol3_d)
                    totalInven4 = JSON.parse(response.model.gol4_d)
                    totalInven5 = JSON.parse(response.model.gol5_d)

                    var table = $("#tableDetailInvestor tbody");
                    $.each(inventor, function (i, item) {
                        var newRow = $("<tr>");
                        newRow.append($("<td>").text(inventor[i]));
                        newRow.append($("<td>").text(formatRupiah(totalInven1[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven2[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven3[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven4[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven5[i])));
                        table.append(newRow);
                    })

                    $("#modalDetailInvestor").modal('show')

                }

            })

        })

        function split_array(string){

            var cleanedString = string.slice(1, -1);
            var arrayValue = cleanedString.split(',');
            return arrayValue
        }

        $('.datatables-basic').on('click', '.btnEditTarif', function () {

            var url = '{{ url()->current() }}/edit/' + $(this).data('url') + '/' + $('#gerbang').val();
            var id = $(this).data('url')

            var selectedVal = $("#gerbang option:selected").text();
            selectedVal = selectedVal.split('-').pop().split(')')[0]; // returns 'two'
            $(".dataInventor").remove();

            $.ajax({
                url: url,
                method: "get",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {

                    var data = response.model


                    // id

                    $("#idTarif").val(data.id)
                    // gerbang
                    $('#gerbangEditmodal').find('option').remove().end()
                    var optionValue = $("#gerbang option:selected").val();
                    var optionText = $("#gerbang option:selected").text();
                    $('#gerbangEditmodal').append(
                        `<option value="${optionValue}"> ${optionText}</option>`);


                    // asal gerbang
                    $('#asal_edit_gerbang').find('option').remove().end()
                    var optionAsalGerbang =
                        '<option value=""  > Pilih Gerbang Asal</option>';
                    $.ajax({
                        url: '/admin/get-gerbang-ajax/' + optionValue,
                        async: false,
                        method: "GET",

                        dataType: "JSON",
                        success: function (dataAsalGerbang) {

                            $.each(dataAsalGerbang, function (i, item) {

                                if (dataAsalGerbang[i].gerbang_id ==
                                    data.asal_gerbang) {
                                    optionAsalGerbang +=
                                        '<option selected value="' +
                                        dataAsalGerbang[i]
                                        .gerbang_id + '"  >' +
                                        dataAsalGerbang[i]
                                        .gerbang_nama + '</option>'

                                } else {
                                    optionAsalGerbang +=
                                        '<option  value="' +
                                        dataAsalGerbang[i]
                                        .gerbang_id + '"  >' +
                                        dataAsalGerbang[i]
                                        .gerbang_nama + '</option>'
                                }
                            });
                        }
                    });
                    $('#asal_edit_gerbang').append(optionAsalGerbang)


                    // dasarTarif
                    $('#dasartarifeditmodal').find('option').remove().end();
                    var gerbang = $("#gerbang").val();
                    var optionDasarTarif =
                        '<option value=""  > Pilih  Dasar Tarif</option>';
                    $.ajax({
                        url: '/admin/get-dasar-tarif',
                        async: false,
                        method: "POST",
                        data: {
                            gerbang: gerbang,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (dataDasarTarif) {
                            $.each(dataDasarTarif, function (i, item) {
                                if (dataDasarTarif[i].id_dasar_tarif ==
                                    data
                                    .id_dasar_tarif) {

                                    optionDasarTarif +=
                                        '<option selected value="' +
                                        dataDasarTarif[i]
                                        .id_dasar_tarif + '"  >' +
                                        dataDasarTarif[
                                            i]
                                        .dasar_tarif + '</option>'

                                } else {

                                    optionDasarTarif +=
                                        '<option value="' +
                                        dataDasarTarif[i]
                                        .id_dasar_tarif + '"  >' +
                                        dataDasarTarif[
                                            i]
                                        .dasar_tarif + '</option>'

                                }
                            });

                        }
                    });
                    $('#dasartarifeditmodal').append(optionDasarTarif);

                    // jenis
                    $('#jenis').find('option').remove().end();
                    var optionJenis = '<option value="" > Pilih  Jenis</option>'

                    optionJenis += (data.jenis == 'khl') ?
                        "<option selected value='khl' >khl</option>" :
                        "<option value='khl' >khl</option>"
                    optionJenis += (data.jenis == 'ags') ?
                        "<option selected value='ags' >ags</option>" :
                        "<option value='ags' >ags</option>"
                    optionJenis += (data.jenis == 'normal') ?
                        "<option selected value='normal' >normal</option>" :
                        "<option value='normal' >normal</option>"
                    $('#jenisEdit').append(optionJenis)

                    // waktu
                    $("#waktuEdit").val(data.tgl_berlaku)

                    // total
                    $("#totalEditgol1").val(data.gol1)
                    $("#totalEditgol2").val(data.gol2)
                    $("#totalEditgol3").val(data.gol3)
                    $("#totalEditgol4").val(data.gol4)
                    $("#totalEditgol5").val(data.gol5)

                    // investor

                    // var fixedJsonString = data.tarif_inv.replace(/'/g, '"');
                    var inventor = split_array(data.tarif_inv);
                    totalInven1 = JSON.parse(data.gol1_d)
                    totalInven2 = JSON.parse(data.gol2_d)
                    totalInven3 = JSON.parse(data.gol3_d)
                    totalInven4 = JSON.parse(data.gol4_d)
                    totalInven5 = JSON.parse(data.gol5_d)


                    $("#investor_edit1").val(inventor[0]);
                    $("#investor_edit2").val(inventor[0]);
                    $("#investor_edit3").val(inventor[0]);
                    $("#investor_edit4").val(inventor[0]);
                    $("#investor_edit5").val(inventor[0]);
                    $("#total_investor_edit1").val(totalInven1[0]);
                    $("#total_investor_edit2").val(totalInven2[0]);
                    $("#total_investor_edit3").val(totalInven3[0]);
                    $("#total_investor_edit4").val(totalInven4[0]);
                    $("#total_investor_edit5").val(totalInven5[0]);


                    investorCountEdit = {}
                    $.each(inventor, function (i, item) {

                        if (i > 0) {
                            tambahInvestorEdit(1, inventor[i], totalInven1[i])
                            tambahInvestorEdit(2, inventor[i], totalInven2[i])
                            tambahInvestorEdit(3, inventor[i], totalInven3[i])
                            tambahInvestorEdit(4, inventor[i], totalInven4[i])
                            tambahInvestorEdit(5, inventor[i], totalInven5[i])
                        }

                    })

                    $("#modalEditTarifClose").modal('show')


                }

            });






        })


        $('#gerbang').select2({
            ajax: {
                url: '/admin/get-gerbang-data-exit', // Ganti dengan URL yang sesuai untuk mengambil data Gerbang dari server
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.gerbang_nama + '-' + item.jenis_gerbang,
                                id: item.gerbang_id,
                            };
                        }),
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Gerbang',
        });



        $('#btnAddTarif').click(function () {
            investorCounts = {};

            if ($('#gerbang').val() == null) {
                sweetAlert('Gagal!', 'Gagal Tambah Data, Gerbang Belum Dipilih!', 'error')
            } else {


                // gerbang
                $('#gerbangmodal').find('option').remove().end()
                var optionValue = $("#gerbang option:selected").val();
                var optionText = $("#gerbang option:selected").text();
                $('#gerbangmodal').append(`<option value="${optionValue}"> ${optionText}</option>`);


                // asal gerbang
                $('#asal_gerbang').find('option').remove().end()
                var optionAsalGerbang = '<option value="" Selected > Pilih Gerbang Asal</option>';
                $.ajax({
                    url: '/admin/get-gerbang-ajax/' + optionValue,
                    async: false,
                    method: "GET",

                    dataType: "JSON",
                    success: function (response) {

                        $.each(response, function (i, item) {
                            optionAsalGerbang += '<option value="' + response[i]
                                .gerbang_id + '"  >' + response[i]
                                .gerbang_nama + '</option>'
                        });
                    }
                });
                $('#asal_gerbang').append(optionAsalGerbang);

                // dasarTarif
                $('#dasartarifmodal').find('option').remove().end();
                var gerbang = $("#gerbang").val();
                var optionDasarTarif = '<option value="" Selected > Pilih  Dasar Tarif</option>';
                $.ajax({
                    url: '/admin/get-dasar-tarif',
                    async: false,
                    method: "POST",
                    data: {
                        gerbang: gerbang,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: "JSON",
                    success: function (response) {

                        $.each(response, function (i, item) {

                            optionDasarTarif += '<option value="' + response[i]
                                .id_dasar_tarif + '"  >' + response[i]
                                .dasar_tarif + '</option>'
                        });
                    }
                });
                $('#dasartarifmodal').append(optionDasarTarif);

                // jenis
                $('#jenis').find('option').remove().end();
                var optionJenis = '<option value="" Selected > Pilih  Jenis</option>'
                optionJenis += "<option value='khl' >khl</option>"
                optionJenis += "<option value='ags' >ags</option>"
                optionJenis += "<option value='normal' >normal</option>"
                $('#jenis').append(optionJenis)


                // waktu
                $("#waktu").val('')

                // investor
                $(".dataInventor").remove();
                $('#investor1').val('')
                $('#total_investor1').val('')
                $('#investor2').val('')
                $('#total_investor2').val('')
                $('#investor3').val('')
                $('#total_investor3').val('')
                $('#investor4').val('')
                $('#total_investor4').val('')
                $('#investor5').val('')
                $('#total_investor5').val('')



                // harga
                $('#totalgol1').val('')
                $('#totalgol2').val('')
                $('#totalgol3').val('')
                $('#totalgol4').val('')
                $('#totalgol5').val('')

                $("#modalTambahTarifClose").modal('show')
            }



        });


        $('#btnSimpanTarifExit').click(function () {

            var gerbangmodal = $('#gerbangmodal').val()
            var asal_gerbang = $('#asal_gerbang').val()
            var dasartarifmodal = $('#dasartarifmodal').val()
            var jenis = $('#jenis').val()
            var waktu = $('#waktu').val()
            var totalgol1 = $('#totalgol1').val()
            var totalgol2 = $('#totalgol2').val()
            var totalgol3 = $('#totalgol3').val()
            var totalgol4 = $('#totalgol4').val()
            var totalgol5 = $('#totalgol5').val()
            var totalInvestorValues1 = getNumeric('input[name="totalinvestor1[]"]')
            var sumTotal1 = sumNumeric(totalInvestorValues1)
            var totalInvestorValues2 = getNumeric('input[name="totalinvestor2[]"]')
            var sumTotal2 = sumNumeric(totalInvestorValues2)
            var totalInvestorValues3 = getNumeric('input[name="totalinvestor3[]"]')
            var sumTotal3 = sumNumeric(totalInvestorValues3)
            var totalInvestorValues4 = getNumeric('input[name="totalinvestor4[]"]')
            var sumTotal4 = sumNumeric(totalInvestorValues4)
            var totalInvestorValues5 = getNumeric('input[name="totalinvestor5[]"]')
            var sumTotal5 = sumNumeric(totalInvestorValues5)
            var investor1 = getString('input[name="investor1[]"]')
            var investor2 = getString('input[name="investor2[]"]')
            var investor3 = getString('input[name="investor3[]"]')
            var investor4 = getString('input[name="investor4[]"]')
            var investor5 = getString('input[name="investor5[]"]')



            if (
                validateField(gerbangmodal, 'Nama Gerbang Harus Di isi') &&
                validateField(asal_gerbang, 'Asal Gerbang Harus Di isi') &&
                validateField(dasartarifmodal, 'Dasar TarifHarus Di isi') &&
                validateField(jenis, 'Jenis Harus Di isi') &&
                validateField(waktu, 'Waktu Berlaku Harus Di isi') &&
                validateField(totalgol1, 'Gol 1 Harus Di isi') &&
                validateField(totalgol2, 'Gol 2 Harus Di isi') &&
                validateField(totalgol3, 'Gol 3 Harus Di isi') &&
                validateField(totalgol4, 'Gol 4 Harus Di isi') &&
                validateField(totalgol5, 'Gol 5 Harus Di isi') &&
                validateSum(totalgol1, sumTotal1,
                    'Tarif GOl 1 tidak Sesuai dengan Total Nominal Investor GOL 1') &&
                validateSum(totalgol2, sumTotal2,
                    'Tarif GOl 2 tidak Sesuai dengan Total Nominal Investor GOL 2') &&
                validateSum(totalgol3, sumTotal3,
                    'Tarif GOl 3 tidak Sesuai dengan Total Nominal Investor GOL 3') &&
                validateSum(totalgol4, sumTotal4,
                    'Tarif GOl 4 tidak Sesuai dengan Total Nominal Investor GOL 4') &&
                validateSum(totalgol5, sumTotal5,
                    'Tarif GOl 5 tidak Sesuai dengan Total Nominal Investor GOL 5')
            ) {
                var formData = new FormData();
                formData.append('gerbangmodal', gerbangmodal);
                formData.append('asal_gerbang', asal_gerbang);
                formData.append('dasartarifmodal', dasartarifmodal);
                formData.append('jenis', jenis);
                formData.append('waktu', waktu);
                formData.append('totalgol1', totalgol1);
                formData.append('totalgol2', totalgol2);
                formData.append('totalgol3', totalgol3);
                formData.append('totalgol4', totalgol4);
                formData.append('totalgol5', totalgol5);
                formData.append('totalInvestorValues1', JSON.stringify(totalInvestorValues1));
                formData.append('totalInvestorValues2', JSON.stringify(totalInvestorValues2));
                formData.append('totalInvestorValues3', JSON.stringify(totalInvestorValues3));
                formData.append('totalInvestorValues4', JSON.stringify(totalInvestorValues4));
                formData.append('totalInvestorValues5', JSON.stringify(totalInvestorValues5));
                formData.append('investor1', JSON.stringify(investor1));
                formData.append('investor2', JSON.stringify(investor2));
                formData.append('investor3', JSON.stringify(investor3));
                formData.append('investor4', JSON.stringify(investor4));
                formData.append('investor5', JSON.stringify(investor5));
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: baseUrl + '/tambah',
                    async: false,
                    beforeSend: function () {
                        document.getElementById('loading-screen').style.display =
                            'block';
                    },
                    success: function (response) {
                        if (response.code == 200) {

                            $("#modalTambahTarifClose").modal('hide')
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                response.message, 'success')

                        } else {
                            $("#modalTambahTarifClose").modal('hide')
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Gagal!',
                                response.message, 'error')
                        }

                    }
                });
            }

        })


        $('#btnEditTarifExit').click(function () {

            var id = $('#idTarif').val()
            var gerbangmodal = $('#gerbangEditmodal').val()
            var asal_gerbang = $('#asal_edit_gerbang').val()
            var dasartarifmodal = $('#dasartarifeditmodal').val()
            var jenis = $('#jenisEdit').val()
            var waktu = $('#waktuEdit').val()
            var totalgol1 = $('#totalEditgol1').val()
            var totalgol2 = $('#totalEditgol2').val()
            var totalgol3 = $('#totalEditgol3').val()
            var totalgol4 = $('#totalEditgol4').val()
            var totalgol5 = $('#totalEditgol5').val()
            var totalInvestorValues1 = getNumeric('input[name="totalinvestor_edit1[]"]')
            var sumTotal1 = sumNumeric(totalInvestorValues1)
            var totalInvestorValues2 = getNumeric('input[name="totalinvestor_edit2[]"]')
            var sumTotal2 = sumNumeric(totalInvestorValues2)
            var totalInvestorValues3 = getNumeric('input[name="totalinvestor_edit3[]"]')
            var sumTotal3 = sumNumeric(totalInvestorValues3)
            var totalInvestorValues4 = getNumeric('input[name="totalinvestor_edit4[]"]')
            var sumTotal4 = sumNumeric(totalInvestorValues4)
            var totalInvestorValues5 = getNumeric('input[name="totalinvestor_edit5[]"]')
            var sumTotal5 = sumNumeric(totalInvestorValues5)
            var investor1 = getString('input[name="investor_edit1[]"]')
            var investor2 = getString('input[name="investor_edit2[]"]')
            var investor3 = getString('input[name="investor_edit3[]"]')
            var investor4 = getString('input[name="investor_edit4[]"]')
            var investor5 = getString('input[name="investor_edit5[]"]')



            if (
                validateField(gerbangmodal, 'Nama Gerbang Harus Di isi') &&
                validateField(asal_gerbang, 'Asal Gerbang Harus Di isi') &&
                validateField(dasartarifmodal, 'Dasar TarifHarus Di isi') &&
                validateField(jenis, 'Jenis Harus Di isi') &&
                validateField(waktu, 'Waktu Berlaku Harus Di isi') &&
                validateField(totalgol1, 'Gol 1 Harus Di isi') &&
                validateField(totalgol2, 'Gol 2 Harus Di isi') &&
                validateField(totalgol3, 'Gol 3 Harus Di isi') &&
                validateField(totalgol4, 'Gol 4 Harus Di isi') &&
                validateField(totalgol5, 'Gol 5 Harus Di isi') &&
                validateSum(totalgol1, sumTotal1,
                    'Tarif GOl 1 tidak Sesuai dengan Total Nominal Investor GOL 1') &&
                validateSum(totalgol2, sumTotal2,
                    'Tarif GOl 2 tidak Sesuai dengan Total Nominal Investor GOL 2') &&
                validateSum(totalgol3, sumTotal3,
                    'Tarif GOl 3 tidak Sesuai dengan Total Nominal Investor GOL 3') &&
                validateSum(totalgol4, sumTotal4,
                    'Tarif GOl 4 tidak Sesuai dengan Total Nominal Investor GOL 4') &&
                validateSum(totalgol5, sumTotal5,
                    'Tarif GOl 5 tidak Sesuai dengan Total Nominal Investor GOL 5')
            ) {
                var formData = new FormData();
                formData.append('id', id);
                formData.append('gerbangmodal', gerbangmodal);
                formData.append('asal_gerbang', asal_gerbang);
                formData.append('dasartarifmodal', dasartarifmodal);
                formData.append('jenis', jenis);
                formData.append('waktu', waktu);
                formData.append('totalgol1', totalgol1);
                formData.append('totalgol2', totalgol2);
                formData.append('totalgol3', totalgol3);
                formData.append('totalgol4', totalgol4);
                formData.append('totalgol5', totalgol5);
                formData.append('totalInvestorValues1', JSON.stringify(totalInvestorValues1));
                formData.append('totalInvestorValues2', JSON.stringify(totalInvestorValues2));
                formData.append('totalInvestorValues3', JSON.stringify(totalInvestorValues3));
                formData.append('totalInvestorValues4', JSON.stringify(totalInvestorValues4));
                formData.append('totalInvestorValues5', JSON.stringify(totalInvestorValues5));
                formData.append('investor1', JSON.stringify(investor1));
                formData.append('investor2', JSON.stringify(investor2));
                formData.append('investor3', JSON.stringify(investor3));
                formData.append('investor4', JSON.stringify(investor4));
                formData.append('investor5', JSON.stringify(investor5));
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: baseUrl + '/update',
                    async: false,
                    beforeSend: function () {
                        document.getElementById('loading-screen').style.display =
                            'block';
                    },
                    success: function (response) {
                        if (response.code == 200) {

                            $("#modalEditTarifClose").modal('hide')
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                response.message, 'success')

                        } else {
                            $("#modalEditTarifClose").modal('hide')
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Gagal!',
                                response.message, 'error')
                        }

                    }
                });

            }

        })

        $('#btnRefeshDasarTarif').click(function () {
            if ($('#gerbang').val() == null) {
                sweetAlert('Gagal!', 'Gagal Refresh Data, Gerbang Belum Dipilih!', 'error')
            } else {
                document.getElementById('loading-screen').style.display = 'block';
                setTimeout(function () {
                    dt_filter.ajax.reload();
                    document.getElementById('loading-screen').style.display = 'none';
                }, 1000);
            }
        });

        $('#btnExportTarif').click(function(){
            var gerbang = $('#gerbang').val()
            // var gerbang = '01'
            if ( gerbang == null) {
                sweetAlert('Gagal!', 'Gagal Export Data, Gerbang Belum Dipilih!', 'error')
            } else {
                $.ajax({
                type: "GET",
                url: '/admin/manajemen-tarif/close/export/' + gerbang,
                xhrFields: {
                    responseType: 'blob' // Set responseType to 'blob'
                },
                beforeSend: function () {
                    document.getElementById('loading-screen').style.display =
                            'block';
                },
                success: function (response,status, xhr) {

                    var contentDisposition = xhr.getResponseHeader('content-disposition');
                    var fileName = '';

                    if (contentDisposition) {
                        var matches = contentDisposition.match(/filename="(.+)"/);
                        if (matches && matches.length > 1) {
                            fileName = matches[1];
                        }
                    }

                    // Buat objek blob dari respons
                    var blob = new Blob([response], {
                        type: 'application/pdf'
                    });
                

                    // Buat URL objek blob
                    var blobUrl = URL.createObjectURL(blob);

                    // Buat elemen <a> untuk mengunduh file
                    var link = document.createElement('a');
                    link.href = blobUrl;
                    link.download = fileName || 'Rekap_tarif.pdf';

                    // Sisipkan elemen <a> ke dokumen dan klik otomatis
                    document.body.appendChild(link);
                    link.click();

                    // Hapus elemen <a> setelah di-klik
                    document.body.removeChild(link);
                    
                    document.getElementById('loading-screen').style
                        .display =
                        'none';
                },
                error: function (xhr, textStatus, errorThrown) {
                    // Handle the error
                    console.error(errorThrown);
                    
                    document.getElementById('loading-screen').style
                        .display =
                        'none';
                }
            });
            }
        })



        function validateField(fieldValue, errorMessage) {
            if (fieldValue === '') {
                sweetAlert('Gagal!', errorMessage, 'error');
                return false;
            }
            return true;
        }

        function validateSum(fieldValue1, fieldValue2, errorMessage) {
            if (fieldValue1 != fieldValue2) {
                sweetAlert('Gagal!', errorMessage, 'error');
                return false;
            }
            return true;
        }

        function getNumeric(selector) {
            return $(selector).map(function () {
                return parseFloat($(this).val()) || 0;
            }).get();
        }

        function getString(selector) {
            return $(selector).map(function () {
                return $(this).val();
            }).get();
        }

        function sumNumeric(values) {
            return values.reduce(function (accumulator, currentValue) {
                return accumulator + currentValue;
            }, 0);
        }




    });


// Objek untuk menyimpan investorCount untuk setiap tabIndex


function tambahInvestor(tabIndex, value = null, totalinven = null) {
    // Inisialisasi investorCount jika belum ada untuk tabIndex tertentu
    if (!investorCounts.hasOwnProperty(tabIndex)) {
        investorCounts[tabIndex] = 2; // Mulai dari 2 atau nilai yang sesuai
    }

    // Temukan elemen tab-pane yang sesuai berdasarkan tabIndex
    var tabPane = document.getElementById('gol' + tabIndex + '-tab-pane');

    // Buat elemen form group untuk input investor
    var formGroup = document.createElement('div');
    formGroup.className = 'form-group dataInventor';

    // Label untuk input investor
    var label = document.createElement('label');
    label.textContent = 'Investor ' + investorCounts[tabIndex];
    label.setAttribute('for', 'investor' + tabIndex + '_' + investorCounts[tabIndex]);

    // Input untuk investor
    var input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control';
    input.name = 'investor' + tabIndex + '[]';
    input.id = 'investor' + tabIndex + '_' + investorCounts[tabIndex];
    if (value != null) {
        input.value = value;
    }

    // Tombol "Delete" untuk menghapus investor
    var deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.className = 'btn btn-danger btn-sm mt-2 mb-2';
    deleteButton.type = 'button';

    var hr = document.createElement('hr');

    // Tambahkan event listener untuk tombol "Delete"
    deleteButton.addEventListener('click', function () {
        // Hapus elemen form group saat tombol "Delete" diklik
        formGroup.remove();

        // Kurangi nilai investorCount
        investorCounts[tabIndex]--;
        // Pastikan nilai investorCount tidak kurang dari 2
        investorCounts[tabIndex] = Math.max(investorCounts[tabIndex], 2);

        // Update label investor sesuai dengan nilai terbaru
        label.textContent = 'Investor ' + investorCounts[tabIndex];
        label.setAttribute('for', 'investor' + tabIndex + '_' + investorCounts[tabIndex]);
        input.id = 'investor' + tabIndex + '_' + investorCounts[tabIndex];
        totalLabel.setAttribute('for', 'total_investor' + tabIndex + '_' + investorCounts[tabIndex]);
        totalInput.id = 'total_investor' + tabIndex + '_' + investorCounts[tabIndex];
    });

    // Total Investor
    var totalLabel = document.createElement('label');
    totalLabel.textContent = 'Tarif Investor';
    totalLabel.setAttribute('for', 'total_investor' + tabIndex + '_' + investorCounts[tabIndex]);

    var totalInput = document.createElement('input');
    totalInput.type = 'number';
    totalInput.className = 'form-control';
    totalInput.name = 'totalinvestor' + tabIndex + '[]';
    totalInput.id = 'total_investor' + tabIndex + '_' + investorCounts[tabIndex];
    totalInput.value = totalinven;

    // Tambahkan elemen-elemen ini ke dalam tab-pane
    formGroup.appendChild(hr);
    formGroup.appendChild(label);
    formGroup.appendChild(input);
    formGroup.appendChild(totalLabel);
    formGroup.appendChild(totalInput);
    tabPane.appendChild(formGroup);
    formGroup.appendChild(deleteButton);

    formGroup.appendChild(hr); // Tambahkan tombol "Delete"

    investorCounts[tabIndex]++; // Inkrementasi hitungan investor untuk tabIndex tertentu
}



    function tambahInvestorEdit(tabIndex, value = null, totalinven = null) {
       
           // Inisialisasi investorCount jika belum ada untuk tabIndex tertentu
        if (!investorCountEdit.hasOwnProperty(tabIndex)) {
            investorCountEdit[tabIndex] = 2; // Mulai dari 2 atau nilai yang sesuai
        }
        // Temukan elemen tab-pane yang sesuai berdasarkan tabIndex
        var tabPane = document.getElementById('gol' + tabIndex + '-tab-pane-edit');

        // Buat elemen form group untuk input investor
        var formGroup = document.createElement('div');
        formGroup.className = 'form-group dataInventor';

    // Label untuk input investor
    var label = document.createElement('label');
    label.textContent = 'Investor ' + investorCountEdit[tabIndex];
    label.setAttribute('for', 'investor' + tabIndex + '_' + investorCountEdit[tabIndex]);

 // Input untuk investor
 var input = document.createElement('input');
    input.type = 'text';
    input.className = 'form-control';
    input.name = 'investor_edit' + tabIndex + '[]';
    input.id = 'investor_edit' + tabIndex + '_' + investorCountEdit[tabIndex];
    if (value != null) {
        input.value = value;
    }

        // Tombol "Delete" untuk menghapus investor
        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.className = 'btn btn-danger btn-sm mt-2 mb-2';
        deleteButton.type = 'button';

        var hr = document.createElement('hr');

 // Tambahkan event listener untuk tombol "Delete"
 deleteButton.addEventListener('click', function () {
        // Hapus elemen form group saat tombol "Delete" diklik
        formGroup.remove();

        // Kurangi nilai investorCount
        investorCountEdit[tabIndex]--;
        // Pastikan nilai investorCount tidak kurang dari 2
        investorCountEdit[tabIndex] = Math.max(investorCountEdit[tabIndex], 2);

        // Update label investor sesuai dengan nilai terbaru
        label.textContent = 'Investor ' + investorCountEdit[tabIndex];
        label.setAttribute('for', 'investor' + tabIndex + '_' + investorCountEdit[tabIndex]);
        input.id = 'investor' + tabIndex + '_' + investorCountEdit[tabIndex];
        totalLabel.setAttribute('for', 'total_investor' + tabIndex + '_' + investorCountEdit[tabIndex]);
        totalInput.id = 'total_investor' + tabIndex + '_' + investorCountEdit[tabIndex];
    });

        // Total Investor
        var totalLabel = document.createElement('label');
        totalLabel.textContent = 'Tarif Investor';
        totalLabel.setAttribute('for', 'total_investor' + tabIndex + '_' + investorCountEdit[tabIndex]);

        var totalInput = document.createElement('input');
    totalInput.type = 'number';
    totalInput.className = 'form-control';
    totalInput.name = 'totalinvestor_edit' + tabIndex + '[]';
    totalInput.id = 'total_investor_edit' + tabIndex + '_' + investorCountEdit[tabIndex];
    totalInput.value = totalinven;
        // Tambahkan elemen-elemen ini ke dalam tab-pane

        formGroup.appendChild(hr);
        formGroup.appendChild(label);
        formGroup.appendChild(input);
        formGroup.appendChild(totalLabel);
        formGroup.appendChild(totalInput);
        tabPane.appendChild(formGroup);
        formGroup.appendChild(deleteButton);

        formGroup.appendChild(hr); // Tambahkan tombol "Delete"
        investorCountEdit[tabIndex]++; // Inkrementasi hitungan investor untuk tabIndex tertentu
    }

    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp.' + ribuan + '.00';
    }

</script>

@endpush
