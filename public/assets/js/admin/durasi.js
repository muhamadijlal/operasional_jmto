$(document).ready(function () {
    var dt_filter = $('#tbl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: UrlCurrent,
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
        var url = UrlCurrent + '/delete/' + $(this).data('asal') + '/' + $('#gerbang').val();

        Swal.fire({
            title: 'Peringatan ?',
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
        }).then(function (response) {
            if (response.isConfirmed) {
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
            } else {
                sweetAlert('Dibatalkan', 'Data masih tersimpan!', 'info')
            }
        });
    })

    $('.datatables-basic').on('click', '.btnEditDurasi', function () {
        var asal = $(this).data('asal');
        var url = UrlCurrent + '/edit/' + asal + '/' + $('#gerbang').val();
        $.ajax({
            url: url,
            method: "get",
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                $('#gerbangmodalEdit').find('option').remove().end();
                $("#form-edit-Durasi").trigger('reset');
                $("#asal_gerbangEdit").val(response.model.asal_gerbang);
                $("#nama_asal_gerbangEdit").val(response.model.nama_asal_gerbang);
                $("#gol1Edit").val(response.model.gol[0]);
                $("#gol2Edit").val(response.model.gol[1]);
                $("#gol3Edit").val(response.model.gol[2]);
                $("#gol4Edit").val(response.model.gol[3]);
                $("#gol5Edit").val(response.model.gol[4]);
                var optionValue = $("#gerbang option:selected").val();
                var optionText = $("#gerbang option:selected").text();
                $('#gerbangmodalEdit').append(
                    `<option value="${optionValue}"> ${optionText}</option>`);
                $("#DurasiModalEdit").modal('show');

            }

        });

    })

    $('#gerbang').select2({
        ajax: {
            url: '/admin/get-gerbang-data',
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

    });

    $('#btnAddDurasi').click(function () {

        if ($('#gerbang').val() == null) {
            sweetAlert('Gagal!', 'Gagal Tambah Data, Gerbang Belum Dipilih!', 'error')
        } else {
            $('#gerbangmodal').find('option').remove().end();
            $("#form-tambah-Durasi").trigger('reset');
            var optionValue = $("#gerbang option:selected").val();
            var optionText = $("#gerbang option:selected").text();
            $('#gerbangmodal').append(
                `<option value="${optionValue}"> ${optionText}</option>`);
            $("#DurasiModal").modal('show');
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

    $('#btnRefreshDurasi').click(function () {
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

    $("#form-tambah-Durasi").validate()
    $("#form-edit-Durasi").validate()

    $("#form-tambah-Durasi").submit(function (e) {
        e.preventDefault()
        var url = UrlCurrent + '/tambah';
        var formData = new FormData($("#form-tambah-Durasi")[0]);

        formData.append('_token', csrfToken);

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {

                $("#DurasiModal").modal('hide');
                $("#form-tambah-Durasi").trigger('reset');

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

    $("#form-edit-Durasi").submit(function (e) {
        e.preventDefault()
        var url = UrlCurrent + '/update';
        var formData = new FormData($("#form-edit-Durasi")[0]);

        formData.append('_token', csrfToken);

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $("#DurasiModalEdit").modal('hide');
                $("#form-edit-Durasi").trigger('reset');

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
