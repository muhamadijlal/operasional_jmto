@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{-- {{ $judul }} --}}
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <button id="addPetugas" class="btn btn-info"> <i class="fa fa-plus"></i> Tambah Petugas</button>
        <button id="SyncronPetugas" class="btn btn-secondary"> <i class="fa fa-sync"></i> Syncron Data</button>
    </div>
    <div class="p-3 table-responsive">
        <table id="tbl_list" class="datatables-basic table table-striped table-bordered">
            <thead>
                <tr style="text-align: center !important">
                    <?php foreach($Cloums as $row){ ?>


                    <th style="text-align: center !important">{{$row['name']}}</td>

                        <?php } ?>
                </tr>
            </thead>
        </table>

    </div>
</div>




<div class="modal" id="ModalTambahPetugas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="gerbang_penempatan">
                        <span style="float:left !important">
                            Gerbang Penempatan
                        </span>

                        <div style="float: right !important" class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="pilihSemua">
                            <label class="form-check-label" for="pilihSemua">
                                Pilih Semua
                            </label>
                        </div>

                    </label>
                    <br>
                    <select id="gerbang_penempatan" multiple style="width: 100%" class="form-control select2">
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="nama_petugas">Nama Petugas (Max 15 Karakter):</label>
                    <input type="text" maxlength="15" class="form-control " id="nama_petugas" placeholder="Nama Petugas">
                </div>
                <div class="form-group mt-3">
                    <label for="npp">NPP</label>
                    <input type="text" class="form-control " id="npp" placeholder="NPP">
                </div>
                <div class="form-group mt-3">
                    <label for="jabatan">Jabatan</label>
                    <select class="form-control" id="jabatan">
                        <option value="">Pilih Jabatan</option>
                        <option value="4">Teknisi</option>
                        <option value="0">MA</option>
                        <option value="1">KBT</option>
                        <option value="2">KSPT</option>
                        <option value="3">PLT</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="inisial_petugas">Inisial Petugas (Max 3 Karakter)</label>
                    <input type="text" class="form-control" maxlength="3" id="inisial_petugas"
                        placeholder="Inisial Petugas">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnSumbitAddPetugas" class="btn btn-primary">Tambah</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="ModalEditPetugas">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Petugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="id_edit">
                    <label for="gerbang_penempatan">
                        <span style="float:left !important">
                            Gerbang Penempatan
                        </span>

                        <div style="float: right !important" class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="pilihSemuaEdit">
                            <label class="form-check-label" for="pilihSemuaEdit">
                                Pilih Semua
                            </label>
                        </div>

                    </label>
                    <br>
                    <select id="gerbang_penempatan_edit" multiple style="width: 100%" class="form-control select2">
                    </select>
                </div>
                <div class="form-group mt-3">
                    <label for="nama_petugas_edit">Nama Petugas (Max 15 Karakter):</label>
                    <input type="text" maxlength="15" class="form-control " id="nama_petugas_edit"
                        placeholder="Nama Petugas">
                </div>
                <div class="form-group mt-3">
                    <label for="npp_edit">NPP</label>
                    <input type="text" class="form-control " id="npp_edit" placeholder="NPP">
                </div>
                <div class="form-group mt-3">
                    <label for="jabatan_edit">Jabatan</label>
                    <select class="form-control" id="jabatan_edit">
                        <option value="">Pilih Jabatan</option>
                        <option value="4">Teknisi</option>
                        <option value="0">MA</option>
                        <option value="1">KBT</option>
                        <option value="2">KSPT</option>
                        <option value="3">PLT</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="inisial_petugas_edit">Inisial Petugas (Max 3 Karakter)</label>
                    <input type="text" class="form-control" maxlength="3" id="inisial_petugas_edit"
                        placeholder="Inisial Petugas">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="btnSumbitEditPetugas" class="btn btn-primary">Edit</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    baseUrl = '{{ url()->current() }}';
    var dataObject = eval('<?php echo json_encode($Cloums); ?>')

    $(document).ready(function () {
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


        $('#gerbang_penempatan_edit').select2({
            dropdownParent: $("#ModalEditPetugas")
        })

        $('#gerbang_penempatan').select2({
            dropdownParent: $("#ModalTambahPetugas")
        })

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

        $('.datatables-basic').on('click', '.delete', function () {
            var url = baseUrl + '/delete/' + $(this).data('url');

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

        $('.datatables-basic').on('click', '.btnEditPetugas', function () {
            var url = baseUrl + '/edit/' + $(this).data('url');
            var id = $(this).data('url')
            $.ajax({
                url: url,
                method: "get",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    data = response.model

                    $('#id_edit').val(data.id)
                    $('#nama_petugas_edit').val(data.nama_pegawai)
                    $('#npp_edit').val(data.npp_no)
                    $('#inisial_petugas_edit').val(data.kode_tugas)

                    // penempatan gerbang
                    $('#gerbang_penempatan_edit').find('option').remove().end()
                    var optionGerbangPenempatan = '';

                    var penempatanArray = data.penempatan_gerbang.split(',');

                    $.ajax({
                        url: '/admin/get-gerbang-ajax/2',
                        async: false,
                        method: "GET",
                        dataType: "JSON",
                        success: function (response) {
                            var optionGerbangPenempatan = '';

                            $.each(response, function (i, item) {
                                var gerbangId = response[i].gerbang_id;
                                var gerbangNama = response[i]
                                    .gerbang_nama;

                                // Check if gerbangId is in the penempatanArray
                                var isSelected = penempatanArray
                                    .includes(gerbangId.toString()) ?
                                    'selected' : '';

                                optionGerbangPenempatan +=
                                    '<option value="' + gerbangId +
                                    '" ' + isSelected + '>' +
                                    gerbangNama + '</option>';
                            });

                            // Append the generated options to your select element
                            $('#gerbang_penempatan_edit').html(
                                optionGerbangPenempatan);

                            // Iterate through each option in the select element
                            $('#jabatan_edit option').each(function () {
                                var optionValue = $(this).val();

                                // Check if the optionValue matches the jabatanValues
                                if (optionValue == data.jabatan_id) {
                                    console.log('benar')
                                    $(this).prop('selected', true);
                                }
                            });

                            $('#ModalEditPetugas').modal('show')
                        }
                    });


                    // $('#gerbangmodal').find('option').remove().end();
                    // $("#form-tambah-edit-DasarTarif").trigger('reset');
                    // $("#gerbangmodal").val($("#gerbang").val());
                    // $("#idEdit").val(id);
                    // $("#versiEdit").val(response.model.versi_tarif);
                    // $("#skEdit").val(response.model.dasar_tarif);
                    // $("#waktuEdit").val(response.model.mulai_berlaku);
                    // var optionValue = $("#gerbang option:selected").val();
                    // var optionText = $("#gerbang option:selected").text();
                    // $('#gerbangmodalEdit').append(
                    //     `<option value="${optionValue}"> ${optionText}</option>`);
                    // $("#DasarTarifModalEdit").modal('show');

                }

            });

        })

        $('#pilihSemua').on('change', function () {
            if ($(this).is(':checked')) {
                // Jika dicentang, pilih semua opsi di select
                $('#gerbang_penempatan option').prop('selected', true);

                $('#gerbang_penempatan').trigger('change.select2');
            } else {
                // Jika tidak dicentang, hilangkan semua pilihan di select
                $('#gerbang_penempatan option').prop('selected', false);

                $('#gerbang_penempatan').trigger('change.select2');
            }
        });

        $('#pilihSemuaEdit').on('change', function () {
            if ($(this).is(':checked')) {
                // Jika dicentang, pilih semua opsi di select
                $('#gerbang_penempatan_edit option').prop('selected', true);

                $('#gerbang_penempatan_edit').trigger('change.select2');
            } else {
                // Jika tidak dicentang, hilangkan semua pilihan di select
                $('#gerbang_penempatan_edit option').prop('selected', false);

                $('#gerbang_penempatan_edit').trigger('change.select2');
            }
        });


        $('#addPetugas').click(function () {

            $('#nama_petugas').val('')
            $('#npp').val('')
            $('#jabatan').val('')
            $('#inisial_petugas').val('')

            // penempatan gerbang
            $('#gerbang_penempatan').find('option').remove().end()
            var optionGerbangPenempatan = '';

            $.ajax({
                url: '/admin/get-gerbang-ajax/2',
                async: false,
                method: "GET",

                dataType: "JSON",
                success: function (response) {

                    $.each(response, function (i, item) {
                        optionGerbangPenempatan += '<option value="' + response[i]
                            .gerbang_id + '"  >' + response[i]
                            .gerbang_nama + '</option>'
                    });
                }
            });
            $('#gerbang_penempatan').append(optionGerbangPenempatan);



            $('#ModalTambahPetugas').modal('show')
        })

        $('#btnSumbitAddPetugas').click(function () {
            var gerbang_penempatan = $('#gerbang_penempatan').val()
            var nama_petugas = $('#nama_petugas').val()
            var npp = $('#npp').val()
            var jabatan = $('#jabatan').val()
            var inisial_petugas = $('#inisial_petugas').val()

            if (gerbang_penempatan.length == 0) {
                sweetAlert('Gagal!', 'Gerbang Penempatan Harus Diisi', 'error');
            } else if (
                validateField(nama_petugas, 'Nama Petugas Wajib Diisi') &&
                validateField(npp, 'NPP Wajib Diisi') &&
                validateField(jabatan, 'Jabatan Wajib Diisi') &&
                validateField(inisial_petugas, 'Inisial Petugas Wajib Diisi')
            ) {
                var formData = new FormData();
                formData.append('gerbang_penempatan', gerbang_penempatan);
                formData.append('nama_petugas', nama_petugas);
                formData.append('npp', npp);
                formData.append('jabatan', jabatan);
                formData.append('inisial_petugas', inisial_petugas);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: baseUrl + '/tambah',
                    async: false,
                    beforeSend: function () {
                        document.getElementById('loading-screen').style.display =
                            'block';
                    },
                    success: function (response) {
                        // console.log(response)

                        if (response.code == 200) {
                            $("#ModalTambahPetugas").modal('hide')
                            // dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                response.message, 'success')
                        } else {
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            displayAlerts(response);
                            // console.log(response)
                        }

                        // if (response.code == 200) {

                        //     $("#ModalTambahPetugas").modal('hide')
                        //     // dt_filter.ajax.reload();
                        //     document.getElementById('loading-screen').style
                        //         .display = 'none';
                        //     sweetAlert('Berhasil!',
                        //         response.message, 'success')

                        // } else {
                        //     $("#ModalTambahPetugas").modal('hide')
                        //     // dt_filter.ajax.reload();
                        //     document.getElementById('loading-screen').style
                        //         .display = 'none';
                        //     sweetAlert('Gagal!',
                        //         response.message, 'error')
                        // }
                    },

                })

            }
        })
        $('#btnSumbitEditPetugas').click(function () {
            var gerbang_penempatan = $('#gerbang_penempatan_edit').val()
            var nama_petugas = $('#nama_petugas_edit').val()
            var npp = $('#npp_edit').val()
            var jabatan = $('#jabatan_edit').val()
            var inisial_petugas = $('#inisial_petugas_edit').val()
            var id = $('#id_edit').val()

            if (gerbang_penempatan.length == 0) {
                sweetAlert('Gagal!', 'Gerbang Penempatan Harus Diisi', 'error');
            } else if (
                validateField(nama_petugas, 'Nama Petugas Wajib Diisi') &&
                validateField(npp, 'NPP Wajib Diisi') &&
                validateField(jabatan, 'Jabatan Wajib Diisi') &&
                validateField(inisial_petugas, 'Inisial Petugas Wajib Diisi')
            ) {
                var formData = new FormData();
                formData.append('gerbang_penempatan', gerbang_penempatan);
                formData.append('nama_petugas', nama_petugas);
                formData.append('npp', npp);
                formData.append('jabatan', jabatan);
                formData.append('inisial_petugas', inisial_petugas);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    type: "POST",
                    contentType: false,
                    processData: false,
                    data: formData,
                    url: baseUrl + '/update/' + id,
                    async: false,
                    beforeSend: function () {
                        document.getElementById('loading-screen').style.display =
                            'block';
                    },
                    success: function (response) {
                        // console.log(response)

                        if (response.code == 200) {
                            $("#ModalEditPetugas").modal('hide')
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                response.message, 'success')
                        } else {
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            displayAlerts(response);
                            // console.log(response)
                        }

                        // if (response.code == 200) {

                        //     $("#ModalTambahPetugas").modal('hide')
                        //     // dt_filter.ajax.reload();
                        //     document.getElementById('loading-screen').style
                        //         .display = 'none';
                        //     sweetAlert('Berhasil!',
                        //         response.message, 'success')

                        // } else {
                        //     $("#ModalTambahPetugas").modal('hide')
                        //     // dt_filter.ajax.reload();
                        //     document.getElementById('loading-screen').style
                        //         .display = 'none';
                        //     sweetAlert('Gagal!',
                        //         response.message, 'error')
                        // }
                    },

                })

            }
        })

        $('#SyncronPetugas').click(function () {
            Swal.fire({
                title: 'Peringatan?',
                text: "Apakah Anda Yakin Sycron Data ??",
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
                $.ajax({
                    url: baseUrl + '/sycron',
                    method: "get",
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function () {
                        document.getElementById('loading-screen').style.display =
                            'block';
                    },
                    success: function (response) {

                        document.getElementById('loading-screen').style.display =
                            'none';
                        sweetAlert('Berhasil!',
                            'Data Berhasil Dihapus!', 'success')
                        // setTimeout(function () {
                        //     dt_filter.ajax.reload();
                        //     document.getElementById('loading-screen').style
                        //         .display = 'none';
                        //     sweetAlert('Berhasil!',
                        //         'Data Berhasil Dihapus!', 'success')
                        // }, 1000);
                    }

                });


            });
        })

        function validateField(fieldValue, errorMessage) {
            if (fieldValue === '') {
                sweetAlert('Gagal!', errorMessage, 'error');
                return false;
            }
            return true;
        }

        function displayAlerts(errors) {

            // Clear existing alerts
            $('.alert').remove();

            // Check if there are any errors
            if (errors) {
                // Iterate through the errors and display them as alerts
                $.each(errors, function (fieldName, messages) {
                    $.each(messages, function (index, message) {
                        var alertMessage =
                            '<div class="alert alert-danger alert-dismissible " role="alert">' +
                            message +
                            ' <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                            '</div>';

                        // Append the alert to the desired location in your HTML (e.g., a form)
                        $('#' + fieldName).after(alertMessage);
                    });
                });
            }
        }
    })

</script>
@endsection
