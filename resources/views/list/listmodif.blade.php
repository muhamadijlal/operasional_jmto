@extends('menu.master')

{{-- judul dari dashboard--}}
@section('title')
{{ $judul }}
@endsection

@section('content')


<h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light"><b>{{ $judul }}</b>
</h4>

@yield('contents')
<div class="card">
     <div class="card-datatable table-responsive pt-0">
            <div class="card-body">

                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif
                @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                @endif

                    <?php if(isset($BtnSuccess)){ ?><a href="{{ $BtnSuccess['url'] }}"  class="btn btn-secondary add-new btn-success" tabindex="0" aria-controls="tbl_list" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><?= $BtnSuccess['name'] ?></a><?php } ?>
                    <?php if(isset($BtnInfo)){ ?><a href="{{ $BtnInfo['url'] }}" class="btn btn-secondary add-new btn-info"><?= $BtnInfo['name'] ?></a><?php } ?>
                    <?php if(isset($BtnPrimary)){ ?><a href="{{ $BtnPrimary['url'] }}" class="btn btn-secondary add-new btn-primary"><?= $BtnPrimary['name'] ?></a><?php } ?>
                    <?php if(isset($BtnWarning)){ ?><a href="{{ $BtnWarning['url'] }}" class="btn btn-secondary add-new btn-warning"><?= $BtnWarning['name'] ?></a><?php } ?>
                    <?php if(isset($BtnDanger)){ ?><a href="{{ $BtnDanger['url'] }}" class="btn btn-secondary add-new btn-danger"><?= $BtnDanger['name'] ?></a><?php } ?>

                    <table id="tbl_list" class="datatables-basic table" >
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
@endsection
@push('scripts')
<script type="text/javascript">
    function cacheInput(e) {
        localStorage.setItem(e.attributes["name"].value, e.value)
    }

    $(document).ready(function () {

        var dt_filter_table = $('.datatables-basic');
        var dataObject = eval('<?php echo json_encode($Cloums); ?>');
        $('.datatables-basic thead tr').clone(true).appendTo('.datatables-basic thead');
        $('.datatables-basic thead tr:eq(1) th').each(function (i) {
            var title = $(this).text();

            $(this).html('<input id="Search_' + title + '" name="Search_' + title +
                '" type="text" oninput="cacheInput(this)" class="form-control" placeholder="Search ' +
                title + '" />');
            $localdata = localStorage.getItem('Search_' + title);
            if ($localdata) {
                document.getElementById('Search_' + title).value = $localdata;
            }
            $('input', this).on('keyup change', function () {
                if (dt_filter.column(i).search() !== this.value) {
                    dt_filter.column(i).search(this.value).draw();
                }
            });
        });
        var dt_filter = $('#tbl_list').DataTable({
            processing: false,
            serverSide: true,
            ajax: '{{ url()->current() }}',
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
            dom: '<"row mx-2"' +
                '<"col-md-2"<"me-3"l>>' +
                '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',

            buttons: [{
                extend: 'collection',
                className: 'btn btn-label-primary dropdown-toggle mx-3',
                text: '<i class="ti ti-logout rotate-n90 me-2"></i>Export',
                buttons: [{
                        extend: 'print',
                        text: '<i class="ti ti-printer me-2" ></i>Print',
                        className: 'dropdown-item',
                        customize: function (win) {
                            //customize print view for dark
                            $(win.document.body)
                                .css('color', config.colors.headingColor)
                                .css('border-color', config.colors.borderColor)
                                .css('background-color', config.colors.body);
                            $(win.document.body)
                                .find('table')
                                .addClass('compact')
                                .css('color', 'inherit')
                                .css('border-color', 'inherit')
                                .css('background-color', 'inherit');
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="ti ti-file-text me-2" ></i>Csv',
                        className: 'dropdown-item',
                    },
                    {
                        extend: 'excel',
                        text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                        className: 'dropdown-item',

                    },
                    {
                        extend: 'pdf',
                        text: '<i class="ti ti-file-text me-2"></i>Pdf',
                        className: 'dropdown-item',

                    },
                    {
                        extend: 'copy',
                        text: '<i class="ti ti-copy me-1" ></i>Copy',
                        className: 'dropdown-item',

                    }
                ]
            }],




        });

    });

</script>

<script>
    $(document).ready(function () {
        $('.datatables-basic').on('click', '.delete', function () {
            var url = $(this).data('url');
            Swal.fire({
                title: 'Peringatan?',
                text: "Apakah Anda Yakin Menghapus Data Ini??",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Berhasil Dihapus!',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                    window.location.href = url;
                }


            });
        })
        $('.datatables-basic').on('click', '.confirm', function () {
            var url = $(this).data('url');
            Swal.fire({
                title: 'Peringatan?',
                text: "Apakah Anda Yakin Mengubah Data Ini??",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Data Berhasil Diupdate!',
                        icon: 'success',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false
                    });
                    window.location.href = url;
                }


            });
        })

    });

</script>
@endpush
