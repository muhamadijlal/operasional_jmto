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
    <div class="d-flex flex-row-reverse m-2 gap-2">
      <button type="button" id="btnRefresh" class="btn btn-outline-info btn-sm" data-toggle="tooltip" title="Refresh tabel">
        <i class="menu-icon tf-icons ti ti-refresh"></i>
      </button>
    </div>
    <div class="form-group mx-3">
      <label for="gerbang">Pilih Gerbang : </label>
      <select name="gerbang" id="gerbang_connection" style="width: 300px;" class="select2 form-control"></select>
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

  table = $('#tbl_list').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: baseUrl, // Ganti dengan URL yang sesuai
      type: 'GET',
      data: function (d) {
        d.gerbang_id = $('#gerbang_connection').val();
      },
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
    }
  });

  $("#btnRefresh").on('click', function() {
    table.draw();
  })
</script>
@endsection