@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{-- {{ $judul }} --}}
Buat Kartu
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

    <form id="form-tulis-kartu" name="form-tulis-kartu">
      <div class="row col-12">
          <div class="form-group mb-3">
            <label for="optionNama">Nama Lengkap : </label>
            <select class="form-control select2" id="optionNama"></select>
          </div>

          <div class="form-group mb-3">
            <label for="uid_ktp">UID Kartu :</label>
            <input type="text" class="form-control" id="uid_ktp" disabled placeholder="UID Kartu">
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
            <input type="text" class="form-control" id="tipe_ktp" placeholder="Tipe KTP" disabled>
          </div>

          <div class="form-group mb-3">
            <label for="masa_berlaku">Masa Berlaku :</label>
            <input type="date" min="0" max="99" class="form-control" id="masa_berlaku" placeholder="Tanggal Berlaku" disabled>
          </div>

          <div class="d-flex justify-content-center">
            <button id="btnTulis" disabled type="button" class="col-4 btn btn-primary mx-2 mt-5" disabled>Tulis Kartu</button>
          </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="kartuOperasionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" id="tombol-x-modal" aria-hidden="true">&times;</button>
      <h3 id="petugas-modal-tittle" class="modal-title">Tambah jadwal</h3>
    </div>
    <div class="modal-body">
      <form id="form-kartu-operasional">
        <div class="form-group">
          <label for="exampleFormControlTextarea1">Response :</label>
          <textarea class="form-control" id="response" rows="8" readonly></textarea>
        </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" id="tombol-close-modal" class="btn btn-primary" data-dismiss="modal">Tutup</button>
    </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/buat-kartu.js') }}"></script>
<script src="{{ asset('assets/js/admin/clientapi.js') }}"></script>

<script>
var baseUrl = '{{ url()->current() }}'

$(document).ready(function() {
  $('#btnTulis').prop('disabled', false);
  var api = IOTClientService;
  var status = false;
  var write_status = false;

  function write_aktif(s) {
    // $('#btnTulis').prop('disabled', !s);
    write_status = s;
  }

  // Set up callbacks
  api.onconnect = function() {
    console.log("WebSocket connected");
    status = true;
  };

  api.ondisconnect = function() {
    console.log("WebSocket disconnected");
    status = false;
  };

  api.onlog = function(log) {
    console.log("Log:", log);

    if(log == '[*] disconnected') {
      $("#com i").removeClass("text-success").addClass("text-danger");
      $("#cst i").removeClass("text-success").addClass("text-danger");
      $("#cst_type" ).html('');
      $("#service i").removeClass("text-success").addClass("text-danger");
      $("#uid").html('?');
      write_aktif(false);
    } else {
      $("#service i").removeClass("text-danger").addClass("text-success");
    }
  };

  var cst = false;
  var have_card = false;
  var com = '';
  var tipe_cst = '';
  var curr_uuid = '';

  api.onmessage = function(msg) {
    if ('active' in msg) {
      if (msg.active != cst) {
        cst = msg.active;
        if (cst){
          $("#cst i").removeClass("text-danger").addClass("text-success");
          $("#cst_type").html(': '+ msg.type);
        } else {
          $("#cst i").removeClass("text-success").addClass("text-danger");
          $("#cst_type" ).html('');
          $("#uid" ).html('?');
          write_aktif(false);
        }
      }
      if (!msg.active) {
        msg.havecard=false;
      }
    }

    if ('com' in msg) {
      if(msg.com != com) {
        $("#com i").removeClass("text-danger").addClass("text-success");
        $("#com i + span").text(msg.com)
      } else {
        $("#com i").removeClass("text-success").addClass("text-danger");
        $("#uid" ).html('?');
        write_aktif(false);
      }
    }

    if ('havecard' in msg) {
      if(msg.uid != curr_uuid) {
        curr_uuid = msg.uid;
        if(curr_uuid) {
          $("#uid").html('UID : ' + curr_uuid);
          document.getElementById('btnTulis').uid = curr_uuid;
          $('#btnTulis').prop('disabled', false);
          showKartuDinas();
          write_aktif(true);
        } else {
          write_aktif(false);
          $("#uid").html(' -');
          document.getElementById('btnTulis').uid = '';
          // $('#btnRead').prop('disabled',true);
          $('#btnTulis').prop('disabled', true);
        }
      }
    }
  }

  api.open();

  $("#optionNama").change(function() {
    var penerbitanKartuId = $('#optionNama').val();

    if (penerbitanKartuId == '') {
      $('#form-tulis-kartu').trigger("reset");
      return false;
    }

    $.ajax({
      url: baseUrl + '/getDetailData',
      method: "POST",
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: {
        id: penerbitanKartuId
      },
      beforeSend: function() {
        document.getElementById('loading-screen').style.display = 'block';
      },
      success: function(response) {
        $('#uid_ktp').val(response.ktp_id);
        $('#no_ktp').val(response.no_registrasi);
        $('#kode_ruas').val(response.ruas);
        $('#tipe_ktp').val(tipeKartu(response.ktp_jenis_id));
        $('#masa_berlaku').val(response.tgl_kadaluarsa);

        document.getElementById('loading-screen').style.display = 'none';
      }
    });
  });

  $("#btnTulis").click(function(e) {
    var uid = $('#uid_ktp').val();
    var no = $('#no_ktp').val();
    var nama = $("#optionNama").val();

    if (nama == null) {
      Swal.fire(
        'Kesalahan!',
        'Mohon Pilih Profil KTP.',
        'warning'
      )
      
      return false;
    }

    // var curr_uid = document.getElementById('btnTulis').uid;
    var curr_uid = document.getElementById('btnTulis').uid = uid;

    if (uid) {
      if (document.getElementById('btnTulis').uid != '') {
        if (uid != curr_uid) {
          Swal.fire('Terdapat Kesalahan !', 'Kartu tidak sesuai', 'error');

          return false;
        } else {
          var formData = new FormData();

          formData.append('uid_ktp', $('#uid_ktp').val());
          formData.append('no_ktp',  $('#no_ktp').val());
          formData.append('kode_ruas', $('#kode_ruas').val());
          formData.append('tipe_ktp', $('#tipe_ktp').val());
          formData.append('masa_berlaku', $('#masa_berlaku').val());

          $.ajax({
            url: baseUrl + '/generateDataKartu',
            method: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
              document.getElementById('loading-screen').style.display = 'block';
            },
            success: function(response) {
              var data = response.data;

              document.getElementById('loading-screen').style.display = 'none';

              var blok0 = data[0];
              var blok1 = data[1];
              var blok2 = data[2];

              (async function() {
                //init sector 5
                var init_sector5 = await api.auth(5, 'B', 'ffffffffffff');
                if (init_sector5) {
                  if (await api.write(23, 'FFFFFFFFFFFF08778fffFFFFFFFFFFFF')) {
                    //console.log('init sector 5 sukses');
                    api.beep();
                  } else {
                    //console.log('gagal init sector 5 sukses');
                  }
                } else {
                  Swal.fire('Kartu tidak dapat dipakai lagi', 'ERROR CODE (5)', 'info')
                  return false;
                }

                //init sector 7
                var init_sector7 = await api.auth(7, 'B', 'ffffffffffff');
                if (init_sector7) {
                  if (await api.write(31, '2177A6F5342108778fffFFFFFFFFFFFF')) {
                    //console.log('init sector 7 sukses');
                    api.beep();
                  } else {
                    //console.log('gagal init sector 7 sukses');
                  }
                } else {
                  Swal.fire('Kartu tidak dapat dipakai lagi', 'ERROR CODE (7)', 'info')
                  return false;
                }

                var tulis_ktp = await api.write_sector(7, 'B', 'ffffffffffff', blok0, blok1, blok2);
                if (tulis_ktp) {
                  Swal.fire(
                    'Berhasil',
                    'Kartu Berhasil Ditulis',
                    'success'
                  );

                  api.beep();
                } else {
                  Swal.fire(
                    'Error',
                    'Kartu Gagal Ditulis',
                    'error'
                  );
                }
              }())
            }
          })
        }
      }
    } else {
      Swal.fire({
        title: 'UID Kartu Belum Terdata',
        customClass: {
          popup: 'swal-wides'
        },
        footer: "<a>proses ini akan mengupdate data pada data penerbitan kartu.</a>",
        html: "Menyinkronkan UID : <b>" + curr_uid + "</b> dengan <br> Nomor Registrasi : <b>" + no + "</b>",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: base_url + '/updateUID',
            method: "POST",
            dataType: 'JSON',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
              registrasi: no,
              uid: curr_uid
            },
            beforeSend: function() {},
            success: function(response) {
              //console.log(response); 
              $('#optionName').val(0).trigger('change');
              Swal.fire('Berhasil Mendata !', 'Silahkan Pilih Kembali', 'success');
            }
          });
        } else {
          Swal.fire('Perubahan dibatalkan', '', 'info')
        }
      })
    }
  });

  async function showKartuDinas() {
    var data = await api.read_sector(7, 'A', '2177A6F53421');
    if (data) {
      console.log(data);
      api.beep();
      api.beep();
      // $('#btnRead').prop('disabled', false);
      // //window.data_paspul=data;
      // document.getElementById('btnRead').dataktp = data;

    } else {
      //console.log('Bukan Kartu Dinas');
      api.beep();
      // $('#btnRead').prop('disabled', true);
    }
  }

  $("#btnService").on('click', function(){         
    var fileUrl = "{{ asset('assets/file/ClientService.exe') }}";
    // Now you can use this URL in JavaScript
    location.href = fileUrl;
  });
});

function tipeKartu(id) {
  var kartu = '';

  switch (parseInt(id)) {
    case 1:
      kartu = 'Operasional';
      break;
    case 2:
      kartu = 'Karyawan';
      break;
    case 3:
      kartu = 'Mitra';
      break;
    default:
      kartu = 'UNKNOWN';
      break;
  }

  return kartu;
}

$("#tombol-x-modal").click(function (){
  $("#kartuOperasionalModal").modal('hide');
})

$("#tombol-close-modal").click(function (){
  $("#kartuOperasionalModal").modal('hide');
})
</script>
@endsection