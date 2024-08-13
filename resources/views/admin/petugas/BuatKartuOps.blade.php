@extends('admin.master')

@section('title')

@endsection

@section('css')
<style>
    .select2-container .select2-selection--single {
        display: block !important;
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
</style>
@endsection

@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex align-items-center justify-content-between">
      <div class="form-group mr-auto">
        <label for="gerbang">Pilih Gerbang : </label>
        <select name="gerbang" id="gerbang" style="width: 300px;" class="select2 form-control"></select>
      </div>
    
      <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-light d-flex gap-2">
          <i class="fa-regular fa-credit-card"></i>
          <span>UID</span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2">
          <i class="fa-solid fa-circle text-danger"></i>
          <span>CST</span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2">
          <i class="fa-solid fa-circle text-danger"></i>
          <span>Service</span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2">
          <i class="fa-solid fa-plug text-danger" style="transform: rotate(45deg);"></i>
          <span>COM ?</span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2">
          <i class="fa-solid fa-download"></i>
          <span>Service</span>
        </button>
      </div>
    </div>
    

    <hr class="my-5">

    <form>
      <div class="row ">
        <div class="col-lg-4">
          
          <div class="form-group mb-3">
            <label for="kartu_opr">Karu Operasional : </label>
            <select class="form-control" id="kartu_opr" required>
              <option value="" disabled selected>-- Pilih Kartu Operasional --</option>
              <option value="teknisi">Teknisi</option>
              <option value="plt">PLT</option>
              <option value="kspt">KSPT</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="shift">Shift : </label>
            <select class="form-control" id="shift" required>
              <option value="" disabled selected>-- Pilih Shift --</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="tanggal_laporan">Tanggal Laporan :</label>
            <input type="date" class="form-control" id="tanggal_laporan">
          </div>

          <div class="form-group">
            <label for="tanggal_kadaluarsa">Tanggal Kadaluarsa :</label>
            <input type="date" class="form-control" id="tanggal_kadaluarsa">
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group mb-3">           
            <label for="nama_kspt">Nama KSPT : </label>
            <select name="nama_kspt" id="nama_kspt" class="select2 form-control"></select>
          </div>

          <div class="form-group mb-3">
            <label for="npp_kspt">NPP KSPT :</label>
            <input type="text" disabled maxlength="15" class="form-control " id="npp_kspt" placeholder="NPP Petugas KSPT Maksimal 6 Karakter">
          </div>

          <div class="form-group mb-3">
            <label for="nama_personil">Nama Personil :</label>
            <select name="nama_personil" id="nama_personil" class="select2 form-control"></select>
          </div>

          <div class="form-group">
            <label for="npp_personil">NPP Personil :</label>
            <input type="text" disabled maxlength="15" class="form-control " id="npp_personil" placeholder="NPP Petugas PLT Maksimal 6 Karakter">
          </div>
        </div>

        <div class="col-lg-4">
          <div class="form-group mb-3">
            <label for="penempatan_gardu_1">Penempatan Gardu 1 :</label>
            <input type="number" min="0" max="99" class="form-control" id="penempatan_gardu_1" placeholder="Maksimal 2 Karakter">
          </div>

          <div class="form-group mb-3">
            <label for="penempatan_gardu_2">Penempatan Gardu 2 :</label>
            <input type="number" min="0" max="99" class="form-control" id="penempatan_gardu_2" placeholder="Maksimal 2 Karakter">
          </div>

          <div class="form-group mb-3">
            <label for="penempatan_gardu_3">Penempatan Gardu 3 :</label>
            <input type="number" min="0" max="99" class="form-control" id="penempatan_gardu_3" placeholder="Maksimal 2 Karakter">
          </div>

          <div class="form-group">
            <label for="penempatan_gardu_4">Penempatan Gardu 4 :</label>
            <input type="number" min="0" max="99" class="form-control" id="penempatan_gardu_4" placeholder="Maksimal 2 Karakter">
          </div>
        </div>

        <div class="row mt-5 gap-2 justify-content-center">
          <button type="button" disabled class="col-4 btn btn-primary">Tulis Kartu</button>
          <button type="button" disabled class="col-4 btn btn-danger">Baca Kartu</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/petugas.js') }}"></script>
@endsection
