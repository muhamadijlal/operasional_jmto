@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{ $judul }}
@endsection

@section('content')
<div class="card">
  <div class="mb-2 d-flex gap-2 p-2">
    <div class="form-group">
      <select name="kategori" id="kategori" style="width: 300px;" class="form-control">
        <option value="" disabled selected>-- Pilih Kategori --</option>
        <option value="*">All Kategori</option>
        <option value="1">Petugas</option>
        <option value="2">Tarif</option>
        <option value="3">kartu Dinas</option>
        <option value="4">kartu PassPull</option>
        <option value="5">Blacklist</option>
      </select>
    </div>

    <button type="button" id="submit-btn" class="btn btn-primary">Pilih</button>
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
@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  baseUrl = '{{ url()->current() }}';
  var dataObject = eval('<?php echo json_encode($Columns); ?>')
  var table = ''

  $(document).ready(function () {
    dataTable()

    $('#submit-btn').on('click', function () {
      table.ajax.reload();
    });
  });

  function dataTable(){
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
  }
</script>
@endsection