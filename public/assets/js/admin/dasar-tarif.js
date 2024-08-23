function cacheInput(e) {
    localStorage.setItem(e.attributes["name"].value, e.value)
}

$(document).ready(function () {
    var dt_filter = $('#tbl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: UrlCurrent, // Ganti dengan URL yang sesuai
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
        var url = UrlCurrent + '/delete/' + $(this).data('url') + '/' + $('#gerbang').val();

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
            if(response.isConfirmed){
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
            }else{
                sweetAlert('Dibatalkan', 'Data masih tersimpan!', 'info')
            }
        });
    })

    $('.datatables-basic').on('click', '.btnEditDasarTarif', function () {
        var url = UrlCurrent + '/edit/' + $(this).data('url') + '/' + $('#gerbang').val();
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
        var url = UrlCurrent + '/tambah';
        var formData = new FormData($("#form-tambah-edit-DasarTarif")[0]);

        // Tambahkan token CSRF ke dalam formData
        formData.append('_token', csrfToken);

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
        var url = UrlCurrent + '/update';
        var formData = new FormData($("#form-edit-DasarTarif")[0]);

        // Tambahkan token CSRF ke dalam formData
        formData.append('_token', csrfToken);

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
