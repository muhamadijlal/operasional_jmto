@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{ $judul }}
@endsection

@section('css')
<style>
    .select2-container .select2-selection--single {
        display: block !important;
        width: 100% !important;
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

<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light"><b>{{ $judul }}</b>
</h4>

<div class="row mb-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="gerbang">Gerbang</label>
                    <select name="gerbang" id="gerbang" class="select2 form-control"></select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-datatable table-responsive pt-0">

        <div class="card-body">
           
            <button class="btn btn-info add-new  mb-5  " id="btnAddDasarTarif"> <i class="fa fa-plus"></i> Tambah Dasar
                Tarif</button>
            <button class="btn btn-secondary mb-5  " id="btnRefeshDasarTarif"> <i class="fa fa-refresh"></i> Refresh</button>


            <table id="tbl_list" class="datatables-basic table">
                <thead>
                    <tr>
                        <?php foreach($Cloums as $row){ ?>


                        <th>{{$row['name']}}</td>

                            <?php } ?>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('admin.dasar-tarif.modal')


@endsection


@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_jquery.validate.min.js"></script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_additional-methods.min.js"></script>

<script>
    var dataObject = eval('<?php echo json_encode($Cloums); ?>')
    var UrlCurrent = "{{ url()->current() }}"
    var csrfToken = '{{ csrf_token() }}'
</script>

<script src="{{ asset('assets/js/admin/dasar-tarif.js') }}"></script>


@endpush
