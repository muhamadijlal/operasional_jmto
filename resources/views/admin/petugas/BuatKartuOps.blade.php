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
    

    <hr class="my-5">

    <form>
      <div class="row ">
        <div class="col-lg-4">
          
          <div class="form-group mb-3">
            <label for="kode">Karu Operasional : </label>
            <select class="form-control" id="kode" required>
              <option value="1" selected>KSPT</option>
              <option value="2">PLT</option>
              <option value="3">Teknisi</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label for="shift">Shift : </label>
            <select class="form-control" id="shift" required>
              <option value="1" selected>1</option>
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

        <form id="form-tulis-kartu" name="form-tulis-kartu" method="POST">
          <div class="col-lg-4">
            <div class="form-group mb-3">           
              <label for="nama_kspt">Nama KSPT : </label>
              {{-- <select id="nama_kspt" onchange="getDataKSPTByChange()" class="select2 form-control"></select> --}}
              <select id="nama_kspt" class="select2 form-control"></select>
            </div>

            <div class="form-group mb-3">
              <label for="npp_kspt">NPP KSPT :</label>
              <input type="text" disabled maxlength="15" class="form-control " id="npp_kspt" placeholder="NPP Petugas KSPT Maksimal 6 Karakter">
            </div>

            <div class="form-group mb-3">
              <label for="nama_plt">Nama Personil :</label>
              {{-- <select id="nama_plt" class="select2 form-control" onchange="getDataPLTByChange()"></select> --}}
              <select id="nama_plt" class="select2 form-control"></select>
            </div>

            <div class="form-group">
              <label for="  ">NPP Personil :</label>
              <input type="text" disabled maxlength="15" class="form-control" id="npp_plt" placeholder="NPP Petugas PLT Maksimal 6 Karakter">
            </div>
          </div>
        </form>

        <div class="col-lg-4">
          <div class="form-group mb-3">
            <label for="penempatan_gardu_1">Penempatan Gardu 1 :</label>
            <input type="number" min="0" max="99" class="form-control" id="gardu1" placeholder="Maksimal 2 Karakter">
          </div>

          <div class="form-group mb-3">
            <label for="penempatan_gardu_2">Penempatan Gardu 2 :</label>
            <input type="number" min="0" max="99" class="form-control" id="gardu2" placeholder="Maksimal 2 Karakter">
          </div>

          <div class="form-group mb-3">
            <label for="penempatan_gardu_3">Penempatan Gardu 3 :</label>
            <input type="number" min="0" max="99" class="form-control" id="gardu3" placeholder="Maksimal 2 Karakter">
          </div>

          <div class="form-group">
            <label for="penempatan_gardu_4">Penempatan Gardu 4 :</label>
            <input type="number" min="0" max="99" class="form-control" id="gardu4" placeholder="Maksimal 2 Karakter">
          </div>
        </div>

        <div class="row mt-5 gap-2 justify-content-center">
          <button id="btnTulis" disabled type="button" class="col-4 btn btn-primary">Tulis Kartu</button>
          <button id="btnRead" disabled type="button" class="col-4 btn btn-danger">Baca Kartu</button>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="kartuOperasionalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" id="btn-close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
      <button type="button" class="btn btn-primary" id="btn-close" data-dismiss="modal">Tutup</button>
    </div>
    </div>
  </div>
</div>

@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/petugas.js') }}"></script>
<script src="{{ asset('assets/js/admin/clientapi.js') }}"></script>
<script>
  // Use the IOTClientService API
  $( document ).ready(function() {
    var api = IOTClientService;
    var status = false;
    var write_status = false;

    function write_aktif(s) {
      $('#btnTulis').prop('disabled', !s);
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
        // write_status = false;
      } else {
        $("#service i").removeClass("text-danger").addClass("text-success");
        // write_aktif(true);           
        // write_status = true;
      }
    };

    var cst = false;
    var have_card = false;
    var com = '';
    var tipe_cst = '';
    var curr_uuid = '';
    
    api.onmessage = function(msg) {
      console.log("Message received:", msg);

      if ('active' in msg) {
        if (msg.active != cst) {
          cst = msg.active;
          if (cst){
            $("#cst i").removeClass("text-danger").addClass("text-success");
            $("#cst_type").html(': '+ msg.type);
            //write_aktif(true);
            //write_status=true;
          } else {
            $("#cst i").removeClass("text-success").addClass("text-danger");
            $("#cst_type" ).html('');
            $("#uid" ).html('?');
            write_aktif(false);
            //write_status=false;
          }
        }
        if (!msg.active) {
          msg.havecard=false;
        }
      }

      if ('com' in msg) {
        if(msg.com != com) {
          console.log('BuatKartuops:277');
          
          $("#com i").removeClass("text-danger").addClass("text-success");
          $("#com i + span").text(msg.com)
          //write_aktif(true);
          //write_status=true;
        } else {
          console.log('BuatKartuops:234');
          $("#com i").removeClass("text-success").addClass("text-danger");
          $("#uid" ).html('?');
          write_aktif(false);
          //write_status=false;
        }
      }

      if ('havecard' in msg) {
        if(msg.uid != curr_uuid) {
          curr_uuid = msg.uid;
          if(curr_uuid) {
            $("#uid").html('UID : ' + curr_uuid);
            showPaspul();
            write_aktif(true);
          } else {
            write_aktif(false);
            $("#uid").html(' -');
            $('#btnRead').prop('disabled',true);
          }
        }
      }
    }

    api.open();

    $("#btnRead").click(function() {
      $("#petugas-modal-tittle").html('Info Kartu');   
      var data = document.getElementById('btnRead').datapaspul;
      //console.log(data[0]);
      var blok0 = data[0];
      var blok1 = data[1];
      var blok2 = data[2];

      var hasil = "========== DATA KARTU ==========" + "\n\n";
      hasil += "Kode Operasional : " + jabatanName(parseInt(blok0.substring(0,2))) + "\n"; 
      hasil += "NPP KSPT : " + parseInt(blok1.substring(0,6)) + "\n";      
      hasil += "Nama KSPT : " + hex2str(blok1.substring(6,32)) + "\n"; 
      hasil += "NPP Personil : " + parseInt(blok2.substring(0,6)) + "\n";    
      hasil += "Nama Personil : " + hex2str(blok2.substring(6,32)) + "\n"; 
      hasil += "Shift : " + parseInt(blok0.substring(2,4)) + "\n";
      hasil += "Tanggal Laporan : " + blok0.substring(4,6) + '-' + blok0.substring(6,8) + '-'+parseInt(blok0.substring(8,12)) + "\n";   
      hasil += "Tanggal Kadaluarsa : " + blok0.substring(12,14) +'-'+blok0.substring(14,16) + '-'+blok0.substring(16,20) + "\n";  
      hasil += "Gerbang : " + blok0.substring(22,24) + "\n";        
      hasil += "Gardu 1 : " + blok0.substring(22,24) + blok0.substring(24,26) + "\n";
      hasil += "Gardu 2 : " + blok0.substring(22,24) + blok0.substring(26,28) + "\n";
      hasil += "Gardu 3 : " + blok0.substring(22,24) + blok0.substring(28,30) + "\n";
      hasil += "Gardu 4 : " + blok0.substring(22,24) + blok0.substring(30,32) + "\n\n";  
      hasil += "=================================";

      $('#response').attr('rows', 17);
      $("#response").val(hasil);  

      $('#gerbang').val(blok0.substring(22,24));
      $('#kode').val(parseInt(blok0.substring(0,2)));
      $('#shift').val(parseInt(blok0.substring(2,4)));
      $('#tgl_laporan').val(blok0.substring(8,12) + '-' + blok0.substring(6,8) + '-' + blok0.substring(4,6));
      $('#tgl_kadaluarsa').val(blok0.substring(16,20) + '-' + blok0.substring(14,16) + '-' + blok0.substring(12,14));
      $('#nama_kspt').val(parseInt(blok1.substring(0,6))).trigger('change');
      $('#nama_plt').val(parseInt(blok2.substring(0,6))).trigger('change');
      $('#gardu1').val(parseInt(blok0.substring(24,26)));
      $('#gardu2').val(parseInt(blok0.substring(26,28)));
      $('#gardu3').val(parseInt(blok0.substring(28,30)));
      $('#gardu4').val(parseInt(blok0.substring(30,32)));

      $("#kartuOperasionalModal").modal('show');
    });

    async function showPaspul() {
      var data= await api.read_sector(1,'A','0A1B2C3D4E5F');
      if(data) {
        //console.log(data);
        api.beep();
        api.beep();
        $('#btnRead').prop('disabled',false);
        //window.data_paspul=data;
        document.getElementById('btnRead').datapaspul = data;
      } else {
        console.log('Bukan Kartu PassPull');
        api.beep();
        $('#btnRead').prop('disabled',true);
      }
    }

    $("#btnTulis").click(function() {
      var blok0='';
      var blok1='';
      var blok2='';
        
      var formData = new FormData($("#form-tulis-kartu")[0]);	
      var kspt = $("#nama_kspt").select2('data');
      var plt = $("#nama_plt").select2('data');  
      var nama_kspt   = strReplace((kspt[0].text)).toUpperCase();  
      var npp_kspt    = $("#npp_kspt").val();
      var nama_plt    = strReplace((plt[0].text)).toUpperCase();

      //return false;
      var npp_plt     = $("#npp_plt").val();
      var no_gerbang  = ($("#gerbang").val()=='default'?'00':$("#gerbang").val());
      var no_shift    = $("#shift").val();
      var tgl_laporan     = ($("#tanggal_laporan").val()==''?'00000000':$("#tanggal_laporan").val());
      var tgl_kadaluarsa  = ($("#tanggal_kadaluarsa").val()==''?'00000000':$("#tanggal_kadaluarsa").val());
      var kode_kartu  = $("#kode").val();
      var gardu1      = $("#gardu1").val();
      var gardu2      = $("#gardu2").val();
      var gardu3      = $("#gardu3").val();
      var gardu4      = $("#gardu4").val();
      var gardu4      = $("#gardu4").val();
          
      //BLOK O
      //kode
      blok0 += dataToHex(kode_kartu.toString(),2);

      //shift
      blok0 += dataToHex(no_shift.toString(),2);

      //tgl laporan
      var tgl = new Date(tgl_laporan);
      var hari = tgl.getDate().toString();
      var bulan = (tgl.getMonth() + 1).toString();
      var tahun=tgl.getFullYear().toString();

      //fill
      blok0+=dataToHex(hari,2);
      blok0+=dataToHex(bulan,2);
      blok0+=dataToHex(tahun.substring(0,2),2);
      blok0+=dataToHex(tahun.substring(2,4),2);

      //tgl kadaluaras
      var tgl_kd = new Date(tgl_kadaluarsa);
      var hari = tgl_kd.getDate().toString();
      var bulan = (tgl_kd.getMonth() + 1).toString();
      var tahun = tgl_kd.getFullYear().toString();

      //fill
      blok0 += dataToHex(hari,2);
      blok0 += dataToHex(bulan,2);
      blok0 += dataToHex(tahun.substring(0,2),2);
      blok0 += dataToHex(tahun.substring(2,4),2);

      //byte kosong
      blok0 += '00';

      //No Gerbang
      blok0 += dataToHex(no_gerbang,2);

      //No Gardu
      gardu1 = (gardu1==''?'00':gardu1);
      gardu2 = (gardu2==''?'00':gardu2);
      gardu3 = (gardu1==''?'00':gardu3);
      gardu4 = (gardu1==''?'00':gardu4);
      blok0 += dataToHex(gardu1,2);
      blok0 += dataToHex(gardu2,2);
      blok0 += dataToHex(gardu3,2);
      blok0 += dataToHex(gardu4,2);

      //BLOK1
      //NPP KSPT
      blok1 += dataToHex(npp_kspt,6);
      //Nama KSPT
      blok1 += dataToHex(str2hex(nama_kspt),26);
          
      //BLOK2
      //NPP KSPT
      blok2 += dataToHex(npp_plt,6);
      //Nama KSPT
      blok2 += dataToHex(str2hex(nama_plt),26);
    

      (async function() {
        var non_paspul = await api.auth(1,'A','0A1B2C3D4E5F');
        if (!non_paspul) {
          var kunci2 = await api.auth(1,'A','FFFFFFFFFFFF');

          if(!kunci2) {
            kunci2 = await api.auth(1,'A','000000000000');
          }

          if (kunci2) {
            if(!(await api.write(7,'0A1B2C3D4E5F'+'FF078069'+'0A1B2C3D4E5F'))) {
              Swal.fire(
                'Terdapat Kesalahan!',
                'Gagal Write Key',
                'error'
              );
              
              api.beep();
              return;
            }
          } else {
            Swal.fire(
              'Terdapat Kesalahan!',
              'Kartu Tidak Dapat Digunakan Lagi',
              'error'
            );

            api.beep();
            return;
          }
        }

        if(await api.write_sector(1,'A','0A1B2C3D4E5F',blok0,blok1,blok2)) {
          Swal.fire(
            'Berhasil',
            'Kartu Berhasil Ditulis',
            'success'
          );

          api.beep();
          showPaspul();
        } else {
          Swal.fire(
            'Terdapat Kesalahan!',
            'Kartu Gagal Ditulis',
            'error'
          );

          api.beep();
        }
      })();
    });

    $("#btnService").on('click', function(){         
      var fileUrl = "{{ asset('assets/file/ClientService.exe') }}";
      // Now you can use this URL in JavaScript
      location.href = fileUrl;
    });
  });

  function strReplace(data) {
    l = data.length;
    c = data.indexOf("[");
    s = data.substring(0, c);

    return s;
  }

  function dataToHex(data,panjang) {
    var hasil='';

    if(data.length == panjang) {
      hasil = data;
    } 

    else if(data.length<panjang) {
      var snol='';

      for (var i = 1; i <= panjang - data.length; i++) {
        snol += '0';
      }

      hasil = snol + data;
    }else if(data.length>panjang) {
      hasil=data.substring(0, panjang);
    }
    
    return hasil;
  }

  function dexhex2(d, padding) {
    var hex = Number(d).toString(16);

    while (hex.length < padding) {
      hex = "0" + hex;
    }

    return hex;
  }

  function str2hex(str) {
    var out = "";

    for (var i=0; i<str.length; i++) {
      out += dexhex2(str.charCodeAt(i),2);
    }

    return out;
  }
  
  function hex2str(hex) {
    var out = "";
    for (var i=0; i<hex.length; i+=2) {
      out += String.fromCharCode(parseInt(hex.substring(i,i+2), 16));
    }

    return out;
  }

  function jabatanName(id) {
    switch(id)
    {
      case 1:
        return 'KSPT';
      break;
      case 2:
        return 'PLT';
      break;
      case 3:
        return 'TEKNISI';
      break;
      default :
        return 'UNKNOWN';
      break;
    }
  }

  $("#btn-close").click(function(){
    $("#kartuOperasionalModal").modal('close');
  })
</script>
@endsection
