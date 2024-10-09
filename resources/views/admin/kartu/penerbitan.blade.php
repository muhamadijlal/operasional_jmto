@extends('admin.master')

@section('title')
{{ $judul }}
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
<div class="d-flex flex-column gap-5">
  <div class="card">
    <div class="d-flex p-2 gap-4">
      <div class="form-group" style="width: 15%;">
        <select name="ruas" id="ruas" class="form-control select2"></select>
      </div>
      <div class="form-group" style="width: 15%;">
        <select name="jenis-ktp" id="jenis-ktp" class="form-control">
          <option value="" disabled selected>-- Pilih Jenis KTP --</option>
          <option value="999">ALL</option>                       
          <option value="1">KTP OPERASIONAL</option>
          <option value="2">KTP KARYAWAN</option>			
          <option value="3">KTP MITRA</option>  
        </select>
      </div>
      <div class="form-group" style="width: 15%;">
        <select name="status-ktp" id="status-ktp" class="form-control">
          <option value="" disabled selected>-- Pilih Status KTP --</option>
          <option value="999">ALL</option>                       
          <option value="1">AKTIF</option>	
          <option value="2">BLACKLIST</option>
          <option value="3">DRAFT</option>
        </select>
      </div>
      <div class="form-group" style="width: 20%;">
        <input type="text" name="tgl-terbit" id="tgl-terbit" class="form-control" placeholder="-- Pilih Tanggal Terbit --" onfocus="this.type=('date')" onblur="this.type=('text')">
      </div>
      <div class="form-group" style="width: 20%;">
        <input type="text" name="tgl-kadaluarsa" id="tgl-kadaluarsa" class="form-control" placeholder="-- Pilih Tanggal Kadaluarsa --" onfocus="this.type=('date')" onblur="this.type=('text')">
      </div>

      <div class="col">
        <button type="button" id="submit-btn" class="btn btn-primary">
          <i class="menu-icon tf-icons ti ti-filter"></i>
        </button>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="d-flex justify-content-between align-items-center m-2">
      <div class="form-group flex-grow-1">
        <input type="text" class="form-control" id="search" style="width: 35%;" placeholder="Search nama kartu">
      </div>
  
      <div class="d-flex flex-row gap-2">
          <button type="button" id="btnRefresh" class="btn btn-outline-info btn-sm" data-toggle="tooltip" title="Refresh tabel">
              <i class="menu-icon tf-icons ti ti-refresh"></i>
          </button>
          <button type="button" id="btnTambahKartu" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="Add Kartu">
              <i class="menu-icon tf-icons ti ti-plus"></i>
          </button>
      </div>
    </div>
  

    <div class="p-3 table-responsive">
      <table id="tbl_list" class="datatables-basic table table-striped table-bordered">
          <thead>
            <tr style="text-align: center !important">
              <?php foreach($Columns as $row){ ?>
                <th style="text-align: center !important">{{$row['name']}}</td>
              <?php } ?>
            </tr>
          </thead>
      </table>
    </div>
  </div>
</div>

<div class="modal" id="ModalTambahKartu">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Tambah Kartu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="form-group mt-3">
                <label for="nomor_kartu">Nomor kartu <span class="text-danger">*</span> (Generate Otomatis):</label>
                <input type="text" class="form-control " id="nomor_kartu" placeholder="XXXXXXXXXXXXX" disabled>
            </div>
              <div class="form-group mt-3">
                  <label for="no_ref">Nomor Referensi (Opsional)</label>
                  <input type="text" class="form-control " id="no_ref" placeholder="No Referensi">
              </div>
              <div class="form-group mt-3">
                  <label for="pemilik_kartu">Nama Pemegang Kartu <span class="text-danger">*</span></label>
                  <input type="text" class="form-control " id="pemilik_kartu" placeholder="Nama Pemegang Kartu">
              </div>
              <div class="form-group mt-3">
                <label for="ruas-ktp">Ruas<span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%" id="ruas-ktp"></select>
              </div>
              <div class="form-group mt-3">
                <label for="jenis_ktp">Jenis KTP <span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%" id="jenis_ktp"></select>
              </div>
              <div class="form-group mt-3">
                <label for="institusi">Institusi <span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%" id="institusi"></select>
              </div>
              <div class="form-group mt-3">
                <label for="unit">Unit <span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%" id="unit"></select>
              </div>
              <div class="form-group mt-3">
                <label for="tgl_kadaluarsa">Tanggal Kadaluarsa <span class="text-danger">*</span></label>
                <input type="text" id="tgl_kadaluarsa" class="form-control" placeholder="-- Pilih Tanggal Kadaluarsa --" onfocus="this.type=('date')" onblur="this.type=('text')">
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="btnSumbitTambahPetugas" class="btn btn-primary">Simpan</button>
          </div>
      </div>
  </div>
</div>

<div class="modal" id="ModalEditKartu">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Update Kartu</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="form-group mt-3">
                <label for="pemilik_kartu_edit">Nama Pemegang Kartu <span class="text-danger">*</span></label>
                <input type="text" class="form-control " id="pemilik_kartu_edit" placeholder="Nama Pemegang Kartu">
              </div>
              <div class="form-group mt-3">
                <label for="jenis_ktp_edit">Jenis KTP <span class="text-danger">*</span></label>
                <select class="form-control select2" style="width: 100%" id="jenis_ktp_edit"></select>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="button" id="btnSumbitEditPetugas" class="btn btn-primary">Simpan</button>
          </div>
      </div>
  </div>
</div>
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/kartu.js') }}"></script>
<script>
  baseUrl = '{{ url()->current() }}'

  var dataObject = eval('<?php echo json_encode($Columns); ?>')
  var table = ''
  let search = ''
  var ModalTambahKartu = $("#ModalTambahKartu");
  var ModalEditKartu = $("#ModalEditKartu");

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

  $(document).ready(function () {
    $('#submit-btn').on('click', function () {
      table.ajax.reload();
    });
  });

  table = $('#tbl_list').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl, // Ganti dengan URL yang sesuai
      type: 'GET',
      data: function(d){
        d.search = $('#search').val();
        d.ruas = $("#ruas").val();
        d.ktp_jenis_id = $("#jenis-ktp").val();
        d.status = $("#status-ktp").val();
        d.tgl_terbit = $("#tgl-terbit").val();
        d.tgl_kadaluarsa = $("#tgl-kadaluarsa").val();
      },
      error: function (xhr, error, code) {}
    },
    columns: dataObject,
    searching: false,
    displayLength: 10,
    scrollX: true,
    scrollCollapse: true,
    order: [
      [4, 'desc']
    ],
    orderCellsTop: true,
    lengthMenu: [
      [10, 25, 50, -1],
      ['10 rows', '25 rows', '50 rows', 'Show all']
    ],
    language: {
      emptyTable: "Tidak ada data yang tersedia"
      // Atur pesan lain sesuai kebutuhan Anda
    }
  });

  $('#search').on('change', function(){
    console.log("searching..")
    table.draw()
  });

  $("#ruas-ktp").change(function(){
    var a = $("#ruas-ktp").val();
    var no_kartu = a[0];
    var fisik_kartu = a[1];
    
    var b = $("#nomor_kartu").val();
    if(a == '0'){return false;}

    showGenerateNoKartu();
 });

 $("#institusi").change(function(){ 
    var a = $("#ruas-ktp").val();
    var no_kartu = a[0];
    var fisik_kartu = a[1];
    
    var b = $("#nomor_kartu").val();
    if(a == '0'){return false;}

    showGenerateNoKartu();
 });

 $("#unit").change(function(){
    var a = $("#ruas-ktp").val();
    var no_kartu = a[0];
    var fisik_kartu = a[1];
    
    var b = $("#nomor_kartu").val();
    if(a == '0'){return false;}

    showGenerateNoKartu();
 });

 function showGenerateNoKartu()
  {
    var ruas = $('#ruas-ktp').val() || '';
    var institusi = $('#institusi').val() || '';
    var unit = $('#unit').val() || '';


    var join = institusi + ruas + unit;
    $('#nomor_kartu').val(join);

  }

  $("#btnRefresh").on('click', function() {
    table.draw();
  })

  $("#btnTambahKartu").on('click', function() {
    ModalTambahKartu.modal('show')
  })

  $("#btnSumbitTambahPetugas").on('click', function(){
    var nomor_kartu = $("#nomor_kartu").val()
    var no_ref = $("#no_ref").val()
    var ruas = $("#ruas-ktp").val()
    var jenis_ktp = $("#jenis_ktp").val()
    var pemilik_kartu = $("#pemilik_kartu").val()
    var institusi = $("#institusi").val()
    var unit = $("#unit").val()
    var tgl_kadaluarsa = $("#tgl_kadaluarsa").val()

    var formData = new FormData();

    formData.append('nomor_kartu', nomor_kartu);
    formData.append('no_ref', no_ref);
    formData.append('pemilik_kartu', pemilik_kartu);
    formData.append('ruas', ruas);
    formData.append('jenis_ktp', jenis_ktp);
    formData.append('institusi', institusi);
    formData.append('unit', unit);
    formData.append('tgl_kadaluarsa', tgl_kadaluarsa);
    formData.append('_token', '{{ csrf_token() }}');

    $.ajax({
      type: "POST",
      contentType: false,
      processData: false,
      data: formData,
      url: baseUrl + '/tambah',
      async: false,
      beforeSend: function () {
        document.getElementById('loading-screen').style.display = 'block';
      },
      success: function (response) {
        if (response.status == 200) {
          ModalTambahKartu.modal('hide')
          table.draw();
          document.getElementById('loading-screen').style.display = 'none';
          sweetAlert('Berhasil!', response.message, 'success')
        } else {
          document.getElementById('loading-screen').style.display = 'none';
          sweetAlert('Gagal!', response.message + " error : " + response.error, 'error')
        }
      },
    })
  })

  $('.datatables-basic').on('click', '#blacklist', function(){
    var ktp_id = $(this).data('id');

    Swal.fire({
      title: 'Blacklist KTP ?',
      text: "KTP akan diblacklist diseluruh gerbang.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Blacklist',
      cancelButtonText: 'Batal',
      customClass: {
        confirmButton: 'btn btn-danger me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if(result.isConfirmed){
        $.ajax({
          url: baseUrl+'/blacklist/'+ktp_id,
          method: "POST",
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function(){
            document.getElementById('loading-screen').style.display = 'block';
          },
          success: function (response) {
            document.getElementById('loading-screen').style.display = 'none';
            table.draw();
            sweetAlert('Berhasil!', response.message, 'success')
          }
        });
      }
    });
  })

  $('.datatables-basic').on('click', '#whitelist', function(){
    var ktp_id = $(this).data('id');

    Swal.fire({
      title: 'Whitelist KTP ?',
      text: "KTP akan diwhitelist diseluruh gerbang.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Whitelist',
      cancelButtonText: 'Batal',
      customClass: {
        confirmButton: 'btn btn-success me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if(result.isConfirmed){
        $.ajax({
          url: baseUrl+'/whitelist/'+ktp_id,
          method: "POST",
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function(){
            document.getElementById('loading-screen').style.display = 'block';
          },
          success: function (response) {
            document.getElementById('loading-screen').style.display = 'none';
            table.draw();
            sweetAlert('Berhasil!', response.message, 'success')
          }
        });
      }
    });
  })

  function handleEdit(id) {
    ModalEditKartu.modal("show");

    $("#btnSumbitEditPetugas").on('click', function(){
      var jenis_ktp = $("#jenis_ktp_edit").val()
      var pemilik_kartu = $("#pemilik_kartu_edit").val()

      var formData = new FormData();

      formData.append('id', id);
      formData.append('jenis_ktp', jenis_ktp);
      formData.append('pemilik_kartu', pemilik_kartu);
      formData.append('_token', '{{ csrf_token() }}');

      $.ajax({
        type: "POST",
        contentType: false,
        processData: false,
        data: formData,
        url: baseUrl + '/edit',
        async: false,
        beforeSend: function () {
          document.getElementById('loading-screen').style.display = 'block';
        },
        success: function (response) {
          if (response.status == 200) {
            ModalEditKartu.modal('hide')
            table.draw();
            document.getElementById('loading-screen').style.display = 'none';
            sweetAlert('Berhasil!', response.message, 'success')
          } else {
            document.getElementById('loading-screen').style.display = 'none';
            sweetAlert('Gagal!', response.message + " error : " + response.error, 'error')
          }
        },
      })
    })
  }
</script>
@endsection