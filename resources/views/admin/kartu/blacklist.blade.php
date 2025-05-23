@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{-- {{ $judul }} --}}
Blacklist
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
    <div class="p-3 table-responsive">
      <div class="d-flex justify-content-between">
        <input type="text" class="form-control" id="search" style="width: 25%;" placeholder="Search">

        <button type="button" id="btnSync" class="btn btn-outline-info btn-sm" data-toggle="tooltip" title="Refresh tabel">
            <i class="menu-icon tf-icons ti ti-refresh"></i>
        </button>
      </div>
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
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js/admin/blacklist.js') }}"></script>
<script>
  baseUrl = '{{ url()->current() }}'

  var dataObject = eval('<?php echo json_encode($Columns); ?>')
  var table = ''

  $("#gerbang_connection").on('change', function(){
    table.draw();
  })

  $('#search').on('change', function(){
    console.log("searching..")
    table.draw()
  });

  table = $('#tbl_list').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl, // Ganti dengan URL yang sesuai
      type: 'GET',
      data: function(d){
        d.search = $('#search').val();
      }
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
    }
  });

  $("#btnRefresh").on('click', function() {
    table.draw();
  })

  $("#btnSync").on('click', function(){
    Swal.fire({
      title: 'Sync KTP',
      text: "KTP blacklist akan di sync seluruh gerbang.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sync',
      cancelButtonText: 'Batal',
      customClass: {
        confirmButton: 'btn btn-primary me-3',
        cancelButton: 'btn btn-label-secondary'
      },
      buttonsStyling: false
    }).then(function (result) {
      if(result.isConfirmed){
        $.ajax({
          url: baseUrl+'/sync',
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
            sweetAlert(response.status == 200 ? 'Berhasil!' : 'Gagal!', response.message, response.status == 200 ? 'success' : 'error')
          }
        });
      }
    });
  })
</script>
@endsection