@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{-- {{ $judul }} --}}
Whitelist
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
      <div class="form-group flex-grow-1">
        <input type="text" class="form-control" id="search" style="width: 25%;" placeholder="Search">
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
<script src="{{ asset('assets/js/admin/whitelist.js') }}"></script>
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
</script>
@endsection