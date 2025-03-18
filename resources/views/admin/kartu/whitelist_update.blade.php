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

    <form id="form-tulis-kartu">
      <div class="row col-12">
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
            <select class="form-control" id="tipe_ktp" readonly disabled>
              <option selected value="0">Pilih Jenis KTP</option>
              <option value="Operasional">KTP OPERASIONAL</option>
              <option value="Karyawan">KTP KARYAWAN</option>
              <option value="Mitra">KTP MITRA</option>
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

<!-- Modal-->
<div class="modal fade" id="kartuOperasionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
              <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>

          </div>
      </div>

  </div>
</div>
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/kartu.js') }}"></script>
<script src="{{ asset('assets/js/admin/clientapi.js') }}"></script>
<script>
baseUrl = '{{ url()->current() }}'


$(document).ready(function() {
  var api = IOTClientService;
  var status = false;
  var write_status = false;

  function write_aktif(s) {
    // $('#updateKartu').prop('disabled', !s);
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
          document.getElementById('updateKartu').uid = curr_uuid;

          $('#updateKartu').prop('disabled', false);

          showKartuDinas();
          write_aktif(true);
        } else {
          write_aktif(false);
          $("#uid").html(' -');
          document.getElementById('updateKartu').uid = '';
          $('#bacaKartu').prop('disabled',true);
          $("#masa_berlaku").prop('disabled', true);
          $("#form-tulis-kartu")[0].reset();
          $('#updateKartu').prop('disabled', true);
        }
      }
    }
  }

  api.open();

  $("#bacaKartu").click(function() {
    window.history.forward(1);

    var data = document.getElementById('bacaKartu').dataktp;

    var blok0 = data[0];
    var blok1 = data[1];
    var blok2 = data[2];

    $.ajax({
      url: baseUrl + '/getDetailKTP',
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      dataType: 'json',
      data: {
        blok0: blok0,
        blok1: blok1,
        blok2: blok2
      },
      beforeSend: function() {
        document.getElementById('loading-screen').style.display = 'block';
      },
      success: function(response) {
        var ruas = (response.data.ruas).toUpperCase();
        var expired = (response.data.expire).substring(0, 4) + '-' + (response.data.expire).substring(4, 6) + '-' + (response.data.expire).substring(6, 8);
        var tipe = response.data.tipe;
        var nokartu = response.data.nokartu;
        var uid = (response.data.uid).toUpperCase();
        var namaa = (response.ktpNama[0].nama).toUpperCase();
        var nama;       

        Swal.fire({
          title: 'Data Kartu Tol Perusahaan',
          customClass: {
            popup: 'swal-wide',
            closeButton: 'clse',
          },
          showCloseButton: true,
          background: '#add5e3',
          showConfirmButton: false,
          footer: '<a href="https://www.jmto.co.id/">Butuh bantuan untuk memahami aplikasi ?</a>',
          html: `<table width="100%"  border="0" class="tble">
            <style>
            .uid_img{
              width: 250px;
            }
            .odd{
              background-color:#7bb3c1;
            }
            .swal2-popup {
              width: 35% !important;
            }
            .clse{
              color:black;
            }
            .even{
              background-color:#7bb3c1;
            }
            .tble{
              background-color:#add5e3;
              color:black; font-weight:bold;  
            }
            </style>
            <thead>
            <tr style="padding:10px;">
              <td width="25%" rowspan="6"><img class="uid_img" src="/assets/img/card.png"></img></td>
              <td class="" width="20%" style="text-align:left;">UID</td>
              <td width="2%" style="text-align:left;">:</td>
              <td width="" style="text-align:left;">` + uid + `</td>
            </tr>
        
            <tr>
              <td style="text-align:left;">Registrasi</td>
              <td style="text-align:left;">:</th>
              <td style="text-align:left;">` + nokartu + `</td>
            </tr>
        
            <tr>
              <td style="text-align:left;">Nama</td>
              <td style="text-align:left;">:</th>
              <td style="text-align:left;">` + namaa + `</td>
            </tr>
            <tr>
              <td style="text-align:left;">Ruas</td>
              <td style="text-align:left;">:</th>
              <td style="text-align:left;">` + tipeRuas(ruas) + `</td>
            </tr>
            <tr>
              <td style="text-align:left;">Jenis</td>
              <td style="text-align:left;">:</th>
              <td style="text-align:left;">Kartu ` + tipeKartu(tipe) + `</td>
            </tr>
            <tr>
              <td style="text-align:left;">Expired</td>
              <td style="text-align:left;">:</th>
              <td style="text-align:left;">` + expired + `</td>
            </tr>
            </thead>
          </table>`
        });

          $('#uid_ktp').val(uid);
          // $('#nama').val(nama);
          $('#kode_ruas').val(ruas);
          $('#no_ktp').val(nokartu);
          // $('#tipe_ktp').val(tipe);
          $('#tipe_ktp').val(tipeKartu(tipe));
          // console.log($('#tipe_ktp_show').val(parseInt(tipe)));
          // $('#tipe_ktp').prop('disabled', true);
          // $('#nama_ruas_show').val(tipeRuas(ruas));
          $('#masa_berlaku').prop('disabled', false);
          $('#masa_berlaku').val(expired);

          document.getElementById('loading-screen').style.display = 'none';
      },
      error: function(jqXHR, exception) {
        document.getElementById('loading-screen').style.display = 'none';
        if (jqXHR.status === 0) {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Not connect.\n Verify Network.'
          })
        } else if (jqXHR.status == 404) {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Requested page not found. [404]'
          })
        } else if (jqXHR.status == 500) {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Internal Server Error [500].'
          })
        } else if (exception === 'parsererror') {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Requested JSON parse failed.'
          })
        } else if (exception === 'timeout') {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Time out error.'
          })
        } else if (exception === 'abort') {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Ajax request aborted.'
          })
        } else {
          Swal.fire({
            type: 'error',
            title: 'DATA TIDAK TER RELOAD DENGAN BAIK',
            text: 'Uncaught Error.\n' + jqXHR.responseText
          })
        }
      }
    });
  })

  $("#updateKartu").click(function(e) {
  e.preventDefault();

  var uid = $('#uid_ktp').val();
  var no = $('#no_ktp').val();

  var curr_uid = document.getElementById('updateKartu').uid;
  
  if (uid) {
    if (document.getElementById('updateKartu').uid != '') {
          // if (uid != curr_uid) {
          //   Swal.fire('Terdapat Kesalahan !', 'Kartu tidak sesuai', 'error');

          //   return false;
          // } else {
            var formData = new FormData();

            formData.append('uid_ktp', $('#uid_ktp').val());
            formData.append('no_ktp',  $('#no_ktp').val());
            formData.append('kode_ruas', $('#kode_ruas').val());
            formData.append('tipe_ktp', generateTipeKTP($('#tipe_ktp').val()));
            formData.append('masa_berlaku', $('#masa_berlaku').val());

            // Display the key/value pairs
            for (var pair of formData.entries()) {
              console.log('datanya : '+pair[0]+ ', ' + pair[1]); 
            }
            
            $.ajax({
              url: baseUrl + '/generateDataKartu',
              method: "POST",
              data: formData,
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              contentType: false,
              cache: false,
              processData: false,
              beforeSend: function() {
                document.getElementById('loading-screen').style.display = 'block';

              },
              success: function(response) {
                data = response.data
                document.getElementById('loading-screen').style.display = 'none';
                var blok0 = data[0];
                var blok1 = data[1];
                var blok2 = data[2];

                (async function() {
                  //init sector 5
                  var init_sector5 = await api.auth(5, 'B', 'ffffffffffff');
                  if (init_sector5) {
                    if (await api.write(23, 'FFFFFFFFFFFF08778fffFFFFFFFFFFFF')) {
                      api.beep();
                    } else {
                    }
                  } else {
                    Swal.fire('Kartu tidak dapat dipakai lagi', 'ERROR CODE (5)', 'info')
                    return false;
                  }

                  //init sector 7
                  var init_sector7 = await api.auth(7, 'B', 'ffffffffffff');
                  if (init_sector7) {
                    if (await api.write(31, '2177A6F5342108778fffFFFFFFFFFFFF')) {
                      api.beep();
                    } else {
                    }
                  } else {
                    Swal.fire('Kartu tidak dapat dipakai lagi', 'ERROR CODE (7)', 'info')
                    return false;
                  }


                  var tulis_ktp = await api.write_sector(7, 'B', 'ffffffffffff', blok0, blok1, blok2);
                  if (tulis_ktp) {
                    Swal.fire(
                        'Berhasil',
                        'Kartu Berhasil Diupdate',
                        'success'
                    );

                    api.beep();

                    $("#form-tulis-kartu")[0].reset();
                    $("#tgl").prop('disabled', true);
                    //edit status draft to aktif

                    //showPaspul();
                  } else {
                    Swal.fire(
                      'Error',
                      'Kartu Gagal Diupdate',
                      'error'
                    );
                  }
                })();
              }
            });
          // }
      }
  } else {
      Swal.fire(
          'Mohon Maaf',
          'Mohon Baca Kartu Terlebih Dahulu',
          'warning'
      );
  }

});

  $("#btnService").on('click', function(){         
    var fileUrl = "{{ asset('assets/file/ClientService.exe') }}";
    // Now you can use this URL in JavaScript
    location.href = fileUrl;
  });

  function generateTipeKTP(tipe) {
    const tipeKTP = tipe.toLowerCase();
    console.log("TIPE KTPNYA :" + tipeKTP);
    
    switch (tipeKTP) {
      case 'operasional':
        return 1;
      case 'karyawan':
        return 2;
      case 'mitra':
        return 3;
      default:
        return 0;
    }
  }

  function tipeKartu(id) {
    switch (id) {
      case '01':
        kartu = 'Operasional';
        break;
      case '02':
        kartu = 'Karyawan';
        break;
      case '03':
        kartu = 'Mitra';
        break;
      default:
        kartu = 'UNKNOWN';
        break;
    }

    return kartu;
  }

  function tipeRuas(id) {
    var kartu = '';
    switch (id.toUpperCase()) {
      // case 'A045':
      //   kartu = 'MTN';
      //   break;
      // case 'A047':
      //   kartu = 'MTN + JANGER';
      //   break;
      // case 'A04D':
      //   kartu = 'MTN + BSD';
      //   break;
      // case 'A04F':
      //   kartu = 'MTN + JANGER + BSD';
      //   break;
      // case 'A050':
      //   kartu = 'JKC';
      //   break;
      // case 'A052':
      //   kartu = 'JKC + JANGER';
      //   break;
      // case 'A024':
      //   kartu = 'CSJ';
      //   break;
      // case 'A02C':
      //   kartu = 'CSJ+BSD';
      //   break;
      // case 'A07F':
      //   kartu = 'JORR 2 + BSD + JANGER';
      //   break;
      // case 'A075':
      //   kartu = 'MTN + CSJ + JKC';
      //   break;
      // case 'A047':
      //   kartu = 'MTN + JANGER';
      //   break;
      // case 'A077':
      //   kartu = 'JORR 2 + JANGER';
      //   break;
      case 'B001':
        kartu = 'JMJ';
        break;
      default:
        kartu = 'Unknown1';
        break;
    }

    return kartu;
  }

  async function showKartuDinas() {
    var data = await api.read_sector(7, 'A', '2177A6F53421');
    if (data) {
      //console.log(data);
      api.beep();
      api.beep();
      $('#bacaKartu').prop('disabled', false);
      //window.data_paspul=data;
      document.getElementById('bacaKartu').dataktp = data;

    } else {
      //console.log('Bukan Kartu Dinas');
      api.beep();
      $('#bacaKartu').prop('disabled', true);
    }
  }
})
</script>
@endsection