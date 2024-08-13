@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{ $judul }}
@endsection

@section('content')

<div class="card">
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
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  baseUrl = '{{ url()->current() }}';
  var dataObject = eval('<?php echo json_encode($Columns); ?>')

  $(document).ready(function () {
    var dt_filter = $('#tbl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: baseUrl, // Ganti dengan URL yang sesuai
            type: 'GET',
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
            emptyTable: "Tidak ada data yang tersedia"
            // Atur pesan lain sesuai kebutuhan Anda
        }
    });
  });
</script>
@endsection