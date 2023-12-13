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

    #loading-screen {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        z-index: 9999;
    }

    #loading-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    #loading-content img {
        width: 50px;
        /* Sesuaikan ukuran gambar loading */
    }

    #loading-content p {
        margin-top: 10px;
    }

</style>
@endsection
@section('content')

<div id="loading-screen">
    <div id="loading-content">
        <img src="{{ asset('') }}assets/img/loading.gif" alt="Loading..." />
        <p>Loading...</p>
    </div>
</div>

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

            {{-- <?php if(isset($BtnSuccess)){ ?><a href="{{ $BtnSuccess['url'] }}"
            class="btn btn-secondary add-new btn-success" tabindex="0" aria-controls="tbl_list" type="button"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"><?= $BtnSuccess['name'] ?></a><?php } ?>
            <?php if(isset($BtnInfo)){ ?><a href="{{ $BtnInfo['url'] }}"
                class="btn btn-secondary add-new btn-info"><?= $BtnInfo['name'] ?></a><?php } ?>
            <?php if(isset($BtnPrimary)){ ?><a href="{{ $BtnPrimary['url'] }}"
                class="btn btn-secondary add-new btn-primary"><?= $BtnPrimary['name'] ?></a><?php } ?>
            <?php if(isset($BtnWarning)){ ?><a href="{{ $BtnWarning['url'] }}"
                class="btn btn-secondary add-new btn-warning"><?= $BtnWarning['name'] ?></a><?php } ?>
            <?php if(isset($BtnDanger)){ ?><a href="{{ $BtnDanger['url'] }}"
                class="btn btn-secondary add-new btn-danger"><?= $BtnDanger['name'] ?></a><?php } ?> --}}


            <button class="btn btn-info add-new " id="btnAddDasarTarif"> <i class="fa fa-plus"></i> Tambah Dasar
                Tarif</button>
            <button class="btn btn-secondary  " id="btnRefeshDasarTarif"> <i class="fa fa-refresh"></i> Refresh</button>
            <br>
            <br>

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

{{-- add dasar tarif --}}
<div class="modal" tabindex="-1" id="DasarTarifModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dasar Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-tambah-edit-DasarTarif" id="form-tambah-edit-DasarTarif">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Gerbang :</label>
                        <select class="form-control" id="gerbangmodal" name="gerbangmodal" readonly="readonly">
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Versi :</label>
                        <input type="text" class="form-control" name="versi" id="versi" aria-describedby="versi"
                            placeholder="Versi Tarif" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Surat Keputusan :</label>
                        <textarea type="text" class="form-control" name="sk" id="sk" placeholder="Surat Keputusan"
                            rows="4" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Waktu Berlaku :</label>
                        <input type="date" class="form-control" name="waktu" id="waktu" aria-describedby="waktu"
                            placeholder="Waktu Berlaku" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- edit dasar tarif --}}
<div class="modal" tabindex="-1" id="DasarTarifModalEdit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Dasar Tarif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-edit-DasarTarif" id="form-edit-DasarTarif">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" id="idEdit" value="" />
                        <label for="exampleInputEmail1">Gerbang :</label>
                        <select class="form-control" id="gerbangmodalEdit" name="gerbangmodal" readonly="readonly">
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Versi :</label>
                        <input type="text" class="form-control" name="versi" id="versiEdit" aria-describedby="versi"
                            placeholder="Versi Tarif" required>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Surat Keputusan :</label>
                        <textarea type="text" class="form-control" name="sk" id="skEdit" placeholder="Surat Keputusan"
                            rows="4" required></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleInputEmail1">Waktu Berlaku :</label>
                        <input type="date" class="form-control" name="waktu" id="waktuEdit" aria-describedby="waktu"
                            placeholder="Waktu Berlaku" required>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="Submit" class="btn btn-primary">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_jquery.validate.min.js">
</script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_additional-methods.min.js">
</script>



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
                '" type="text" oninput="cacheInput(this)" class="form-control" placeholder="Search" />'
            );
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
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ url()->current() }}', // Ganti dengan URL yang sesuai
                type: 'GET',
                data: function (d) {
                    d.gerbang = $('#gerbang').val();
                },
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
            dom: '<"row mx-2"' +
                '<"col-md-2"<"me-3"l>>' +
                '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                '>t' +
                '<"row mx-2"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                emptyTable: "Tidak ada data yang tersedia"
                // Atur pesan lain sesuai kebutuhan Anda
            },
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

        $('#gerbang').on('change', function () {
            document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function () {
                dt_filter.ajax.reload();
                document.getElementById('loading-screen').style.display = 'none';
            }, 1000);
        });

        $('.datatables-basic').on('click', '.delete', function () {
            var url = '{{ url()->current() }}/delete/' + $(this).data('url') + '/' + $('#gerbang')
                .val();
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
                $.ajax({
                    url: url,
                    method: "get",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {

                        document.getElementById('loading-screen').style.display =
                            'block';
                        setTimeout(function () {
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                'Data Berhasil Dihapus!', 'success')
                        }, 1000);
                    }

                });


            });
        })

        $('.datatables-basic').on('click', '.btnEditDasarTarif', function () {
            var url = '{{ url()->current() }}/edit/' + $(this).data('url') + '/' + $('#gerbang').val();
            var id = $(this).data('url')
            $.ajax({
                url: url,
                method: "get",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {

                    $('#gerbangmodal').find('option').remove().end();
                    $("#form-tambah-edit-DasarTarif").trigger('reset');
                    $("#gerbangmodal").val($("#gerbang").val());
                    $("#idEdit").val(id);
                    $("#versiEdit").val(response.model.versi_tarif);
                    $("#skEdit").val(response.model.dasar_tarif);
                    $("#waktuEdit").val(response.model.mulai_berlaku);
                    var optionValue = $("#gerbang option:selected").val();
                    var optionText = $("#gerbang option:selected").text();
                    $('#gerbangmodalEdit').append(
                        `<option value="${optionValue}"> ${optionText}</option>`);
                    $("#DasarTarifModalEdit").modal('show');

                }

            });

        })


        // $('.datatables-basic').on('click', '.confirm', function () {
        //     var url = $(this).data('url');
        //     Swal.fire({
        //         title: 'Peringatan?',
        //         text: "Apakah Anda Yakin Mengubah Data Ini??",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'Ya!',
        //         cancelButtonText: 'Batal',
        //         customClass: {
        //             confirmButton: 'btn btn-primary me-3',
        //             cancelButton: 'btn btn-label-secondary'
        //         },
        //         buttonsStyling: false
        //     }).then(function (result) {
        //         if (result.value) {
        //             Swal.fire({
        //                 title: 'Berhasil!',
        //                 text: 'Data Berhasil Diupdate!',
        //                 icon: 'success',
        //                 customClass: {
        //                     confirmButton: 'btn btn-primary'
        //                 },
        //                 buttonsStyling: false
        //             });
        //             window.location.href = url;
        //         }


        //     });
        // })

        $('#gerbang').select2({
            ajax: {
                url: '/admin/get-gerbang-data', // Ganti dengan URL yang sesuai untuk mengambil data Gerbang dari server
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.gerbang_nama,
                                id: item.gerbang_id,
                            };
                        }),
                    };
                },
                cache: true
            },
            placeholder: 'Pilih Gerbang',
            minimumInputLength: 1 // Jumlah karakter minimum yang harus dimasukkan sebelum AJAX diaktifkan
        });

        $('#btnAddDasarTarif').click(function () {

            if ($('#gerbang').val() == null) {
                sweetAlert('Gagal!', 'Gagal Tambah Data, Gerbang Belum Dipilih!', 'error')
            } else {
                $('#gerbangmodal').find('option').remove().end();
                $("#form-tambah-edit-DasarTarif").trigger('reset');
                $("#gerbangmodal").val($("#gerbang").val());
                $("#id").val(0);
                var optionValue = $("#gerbang option:selected").val();
                var optionText = $("#gerbang option:selected").text();
                $('#gerbangmodal').append(
                    `<option value="${optionValue}"> ${optionText}</option>`);
                $("#DasarTarif-modal-tittle").html('Tambah DasarTarif');
                $("#DasarTarifModal").modal('show');
            }



        });


        function sweetAlert(title, text, icon) {
            Swal.fire({
                title: title,
                text: text,
                icon: icon,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }

        $('#btnRefeshDasarTarif').click(function () {
            if ($('#gerbang').val() == null) {
                sweetAlert('Gagal!', 'Gagal Refresh Data, Gerbang Belum Dipilih!', 'error')
            } else {
                document.getElementById('loading-screen').style.display = 'block';
                setTimeout(function () {
                    dt_filter.ajax.reload();
                    document.getElementById('loading-screen').style.display = 'none';
                }, 1000);
            }
        });



        $("#form-tambah-edit-DasarTarif").validate()
        $("#form-edit-DasarTarif").validate()

        $("#form-tambah-edit-DasarTarif").submit(function (e) {
            e.preventDefault()
            var url = '{{ url()->current() }}/tambah';
            var formData = new FormData($("#form-tambah-edit-DasarTarif")[0]);

            // Tambahkan token CSRF ke dalam formData
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {

                    $("#DasarTarifModal").modal('hide');
                    $("#form-tambah-edit-DasarTarif").trigger('reset');

                    document.getElementById('loading-screen').style.display = 'block';
                    setTimeout(function () {
                        dt_filter.ajax.reload();
                        document.getElementById('loading-screen').style.display =
                            'none';
                        sweetAlert('Berhasil!', 'Data Berhasil Ditambahkan!',
                            'success')
                    }, 1000);
                }

            });

        });

        $("#form-edit-DasarTarif").submit(function (e) {
            e.preventDefault()
            var url = '{{ url()->current() }}/update';
            var formData = new FormData($("#form-edit-DasarTarif")[0]);

            // Tambahkan token CSRF ke dalam formData
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: url,
                method: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    //console.log(response);
                    $("#DasarTarifModalEdit").modal('hide');
                    $("#form-edit-DasarTarif").trigger('reset');

                    document.getElementById('loading-screen').style.display = 'block';
                    setTimeout(function () {
                        dt_filter.ajax.reload();
                        document.getElementById('loading-screen').style.display =
                            'none';
                        sweetAlert('Berhasil!', 'Data Berhasil Diedit!', 'success')
                    }, 1000);

                }

            });

        });


    });

</script>

@endpush
