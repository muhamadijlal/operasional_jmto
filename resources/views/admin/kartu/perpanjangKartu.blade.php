@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{-- {{ $judul }} --}}
Perpanjang Kartu
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
    <div class="d-flex align-items-center flex-row-reverse">
      {{-- <div class="form-group mr-auto">
        <label for="gerbang">Pilih Gerbang : </label>
        <select name="gerbang" id="gerbang" style="width: 300px;" class="select2 form-control"></select>
      </div> --}}
    
      <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-light d-flex gap-2" id="uid">
          <i class="fa-regular fa-credit-card"></i>
          <span>
            UID
            <span id="uid"></span>
          </span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2" id="cst">
          <i class="fa-solid fa-circle text-danger"></i>
          <span>
            CST
            <span id="cst_type">
          </span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2" id="service">
          <i class="fa-solid fa-circle text-danger"></i>
          <span>Service</span>
        </button>
        <button type="button" class="btn btn-light d-flex gap-2" id="com">
          <i class="fa-solid fa-plug text-danger" style="transform: rotate(45deg);"></i>
          <span>COM ?</span>
        </button>
        <button class="btn btn-light d-flex gap-2" id="btnService">
          <i class="fa-solid fa-download"></i>
          <span>Service</span>
        </button>
      </div>
    </div>
    

    <hr class="my-4">

    <form>
      <div class="row col-12">
          <div class="form-group mb-3">
            <label for="uid">UID Kartu :</label>
            <input type="text" class="form-control" id="uid" disabled placeholder="UID Kartu">
          </div>

          <div class="form-group mb-3">
            <label for="no_ktp">No KTP :</label>
            <input type="text" class="form-control" id="no_ktp" disabled placeholder="No KTP">
          </div>

          <div class="form-group mb-3">
            <label for="kode_ruas">Kode Ruas :</label>
            <input type="text" class="form-control" id="kode_ruas" placeholder="Kode Ruas" disabled>
          </div>

          <div class="form-group mb-3">
            <label for="tipe_ktp">Tipe KPT :</label>
            <select class="form-control" id="tipe_ktp" disabled>
              <option value="" disabled selected>Pilih Jenis KTP</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="masa_berlaku">Masa Berlaku :</label>
            <input type="date" min="0" max="99" class="form-control" id="masa_berlaku" placeholder="Tanggal Berlaku" disabled>
          </div>

          <div class="d-flex justify-content-center">
            <button id="updateKartu" disabled type="button" class="col-4 btn btn-primary mx-2 mt-5" disabled>Update Kartu</button>
            <button id="bacaKartu" disabled type="button" class="col-4 btn btn-danger mx-2 mt-5" disabled>Baca Kartu</button>
          </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/kartu.js') }}"></script>
{{-- <script>
  baseUrl = '{{ url()->current() }}'


  var dataObject = eval('<?php echo json_encode($Columns); ?>')
  var table = ''
  var ModalTambahKartu = $("#ModalTambahKartu");

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
        d.kategori_id = $("#kategori").val();
      }
    },
    columns: dataObject,
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
    //console.log(join);
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
    var pemilik_kartu = $("#pemilik_kartu").val()
    var ruas = $("#ruas-ktp").val()
    var jenis_ktp = $("#jenis_ktp").val()
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
        // document.getElementById('loading-screen').style.display = 'block';
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
          success: function (response) {
            // document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function () {
                table.ajax.reload();
                // document.getElementById('loading-screen').style.display = 'none';
                sweetAlert('Berhasil!', response.message, 'success')
            }, 1000);
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
          success: function (response) {
            // document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function () {
                table.ajax.reload();
                // document.getElementById('loading-screen').style.display = 'none';
                sweetAlert('Berhasil!', response.message, 'success')
            }, 1000);
          }
        });
      }
    });
  })
</script> --}}
@endsection