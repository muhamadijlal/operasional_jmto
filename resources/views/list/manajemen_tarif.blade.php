@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{ $judul }}
@endsection

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/jquery.datetimepicker.min.css">
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


            <button class="btn btn-info add-new " id="btnAddTarif"> <i class="fa fa-plus"></i> Tambah Tarif</button>
            <button class="btn btn-secondary  " id="btnRefeshDasarTarif"> <i class="fa fa-refresh"></i> Refresh</button>
            <br>
            <br>

            <table id="tbl_list_open" class="datatables-basic-open table">
            </table>

            <table id="tbl_list_close" class="datatables-basic table">
            </table>


        </div>
    </div>
</div>
@endsection

@extends('admin.modal.manajemen_tarif')


@push('scripts')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-datetime-picker@2.5.11/build/jquery.datetimepicker.full.min.js"
    integrity="sha256-ptCFteBa9gzHPnbHLsFaC6n2j+u9F60jtR6AwEKEaeM=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_jquery.validate.min.js">
</script>
<script src="{{ asset('assets/js') }}/cdn.jsdelivr.net_npm_jquery-validation@1.19.5_dist_additional-methods.min.js">
</script>
<script>
    baseUrl = '{{ url()->current() }}';
</script>

<script src="{{ asset('admin/js/manajemen_tarif.js') }}"></script>



<script type="text/javascript">
    // function cacheInput(e) {
    //     localStorage.setItem(e.attributes["name"].value, e.value)
    // }

    $(document).ready(function () {

        // var dt_filter = null;

        // function sweetAlert(title, text, icon) {
        //     Swal.fire({
        //         title: title,
        //         text: text,
        //         icon: icon,
        //         customClass: {
        //             confirmButton: 'btn btn-primary'
        //         },
        //         buttonsStyling: false
        //     });
        // }

        $("#waktu").datetimepicker({
            format: 'Y-m-d H:i:s',
            theme: 'white'
        });

        var dt_filter_table = $('.datatables-basic');

        $('#gerbang').on('change', function () {

            var selectedVal = $("#gerbang option:selected").text();
            selectedVal = selectedVal.split('-').pop().split(')')[0]; // returns 'two'
            console.log(selectedVal)
            if (selectedVal == 0 || selectedVal == 4) {
                dataObject = [{

                        title: 'Nama Gerbang',
                        data: 'gerbang_nama',
                        name: 'tbl_gerbang.gerbang_nama',
                    },
                    {

                        title: 'Dasar Tarif',
                        data: 'dasar_tarif',
                        name: 'tbl_dasar_tarif.dasar_tarif',
                    },
                    {

                        title: 'Golongan 1',
                        data: 'gol1',
                        name: 'tbl_tarif_open.gol1',
                    },
                    {

                        title: 'Golongan 2',
                        data: 'gol2',
                        name: 'tbl_tarif_open.gol2',
                    },
                    {

                        title: 'Golongan 3',
                        data: 'gol3',
                        name: 'tbl_tarif_open.gol3',
                    },
                    {

                        title: 'Golongan 4',
                        data: 'gol4',
                        name: 'tbl_tarif_open.gol4',
                    },
                    {

                        title: 'Golongan 5',
                        data: 'gol5',
                        name: 'tbl_tarif_open.gol5',
                    },
                    {

                        title: 'Waktu Berlaku',
                        data: 'tgl_berlaku',
                        name: 'tbl_tarif_open.tgl_berlaku',
                    },

                    {
                        data: 'action',
                        name: 'action',
                    },
                ]
            } else {
                dataObject = [{

                        title: 'Nama Gerbang',
                        data: 'gerbang1',
                        name: 'gerbang.gerbang_nama',
                    },
                    {

                        title: 'Asal Gerbang',
                        data: 'gerbang_nama',
                        name: 'gerbang_asal.gerbang_nama',
                    },
                    {

                        title: 'Jenis',
                        data: 'jenis',
                        name: 'tbl_tarif_exit.jenis',
                    },
                    {

                        title: 'Dasar Tarif',
                        data: 'dasar_tarif',
                        name: 'tbl_dasar_tarif.dasar_tarif',
                    },
                    {

                        title: 'Golongan 1',
                        data: 'gol1',
                        name: 'tbl_tarif_exit.gol1',
                    },
                    {

                        title: 'Golongan 2',
                        data: 'gol2',
                        name: 'tbl_tarif_exit.gol2',
                    },
                    {

                        title: 'Golongan 3',
                        data: 'gol3',
                        name: 'tbl_tarif_exit.gol3',
                    },
                    {

                        title: 'Golongan 4',
                        data: 'gol4',
                        name: 'tbl_tarif_exit.gol4',
                    },
                    {

                        title: 'Golongan 5',
                        data: 'gol5',
                        name: 'tbl_tarif_exit.gol5',
                    },
                    {

                        title: 'Waktu Berlaku',
                        data: 'tgl_berlaku',
                        name: 'tbl_tarif_exit.tgl_berlaku',
                    },

                    {
                        data: 'action',
                        name: 'action',
                    }
                ];
            }

            if ($.fn.DataTable.isDataTable('#tbl_list')) {
                console.log(dataObject)
                $('#tbl_list').DataTable().destroy();
                $('#tbl_list thead').empty();
            }


            dt_filter = $('#tbl_list').DataTable({
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
                                    .css('border-color', config.colors
                                        .borderColor)
                                    .css('background-color', config.colors
                                        .body);
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



            document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function () {
                document.getElementById('loading-screen').style.display = 'none';
            }, 1000);
        });

        $("#form-tambah-edit-DaftarTarif").submit(function (e) {
            e.preventDefault()
            var selectedVal = $("#gerbang option:selected").text();
            selectedVal = selectedVal.split('-').pop().split(')')[0]; // returns 'two'

            // $('#asik2').show();
            if (selectedVal == 0 || selectedVal == 4) {

                var url = '{{ url()->current() }}' + '/tambah';
                var formData = new FormData($("#form-tambah-edit-DaftarTarif")[0]);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {

                        $("#DaftarTarifModal").modal('hide');
                        $("#form-tambah-edit-DaftarTarif").trigger('reset');
                        document.getElementById('loading-screen').style.display =
                            'block';
                        setTimeout(function () {
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                'Data Berhasil Ditambahkan!', 'success')
                        }, 1000);

                    }
                });
            } else {
                var url = '{{ url()->current() }}' + '/tambah';
                var formData = new FormData($("#form-tambah-edit-DaftarTarif")[0]);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        $("#DaftarTarifModal").modal('hide');
                        $("#form-tambah-edit-DaftarTarif").trigger('reset');
                        document.getElementById('loading-screen').style.display =
                            'block';
                        setTimeout(function () {
                            dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                'Data Berhasil Ditambahkan!', 'success')
                        }, 1000);
                    }
                });
            }

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

        $('.datatables-basic').on('click', '#btnDetailInvestor', function () {
            $("#modalDetailInvestor tbody tr").remove();
            var gerbang = $("#gerbang").val();
            // console.log($(this).data('url'))
            var id = $(this).data('url')
            $.ajax({
                url: "{{ url()->current() }}/get-investor-by-id/" + id + '/' + gerbang,
                method: "GET",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    console.log(response.model.tarif_inv)
                    inventor = JSON.parse(response.model.tarif_inv)
                    totalInven1 = JSON.parse(response.model.gol1_d)
                    totalInven2 = JSON.parse(response.model.gol2_d)
                    totalInven3 = JSON.parse(response.model.gol3_d)
                    totalInven4 = JSON.parse(response.model.gol4_d)
                    totalInven5 = JSON.parse(response.model.gol5_d)

                    var table = $("#tableDetailInvestor tbody");
                    $.each(inventor, function (i, item) {
                        var newRow = $("<tr>");
                        newRow.append($("<td>").text(inventor[i]));
                        newRow.append($("<td>").text(formatRupiah(totalInven1[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven2[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven3[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven4[i])));
                        newRow.append($("<td>").text(formatRupiah(totalInven5[i])));
                        table.append(newRow);
                    })

                    $("#modalDetailInvestor").modal('show')

                }

            })

        })

        $('.datatables-basic').on('click', '.btnEditTarif', function () {

            var url = '{{ url()->current() }}/edit/' + $(this).data('url') + '/' + $('#gerbang').val();
            var id = $(this).data('url')

            var selectedVal = $("#gerbang option:selected").text();
            selectedVal = selectedVal.split('-').pop().split(')')[0]; // returns 'two'
            $(".dataInventor").remove();

            if (selectedVal == 0 || selectedVal == 4) {
                $.ajax({
                    url: url,
                    method: "get",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {

                        $('#dasartarifmodal').find('option').remove().end();
                        $('#gerbangmodal').find('option').remove().end();
                        $("#id").val(response.model.id);
                        $('#jenis').find('option').remove().end();

                        var option = '';
                        var gerbang = $("#gerbang").val();

                        $.ajax({
                            url: '/admin/get-dasar-tarif',
                            async: false,
                            method: "POST",
                            data: {
                                gerbang: gerbang,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "JSON",
                            success: function (data) {
                                //console.log(data);
                                //console.log(data[0].id_daftar_tarif);

                                $.each(data, function (i, item) {

                                    var selected = '';
                                    console.log(response.model
                                        .id_dasar_tarif)
                                    console.log(data[i].id_dasar_tarif)
                                    if (response.model.id_dasar_tarif ==
                                        data[i].id_dasar_tarif) {
                                        selected = "selected";
                                    }

                                    option += '<option value="' + data[
                                            i].id_dasar_tarif + '" ' +
                                        selected + '>' + data[i]
                                        .dasar_tarif + '</option>'
                                    //console.log(option);
                                    //console.log(response[i].dasar_tarif);
                                });
                            }


                        });

                        $('#dasartarifmodal').append(option);

                        var optionValue = $("#gerbang option:selected").val();
                        var optionText = $("#gerbang option:selected").text();
                        $('#gerbangmodal').append(
                            `<option value="${optionValue}"> ${optionText}</option>`);

                        $("#waktu").val(response.model.tgl_berlaku);
                        $("#jagorawigol1").val(response.model.gol1);
                        $("#totalgol1").val(response.model.gol1)

                        $("#jagorawigol2").val(response.model.gol2);
                        $("#totalgol2").val(response.model.gol2)

                        $("#jagorawigol3").val(response.model.gol3);
                        $("#totalgol3").val(response.model.gol3)

                        $("#jagorawigol4").val(response.model.gol4);
                        $("#totalgol4").val(response.model.gol4)

                        $("#jagorawigol5").val(response.model.gol5);
                        $("#totalgol5").val(response.model.gol5)
                        $("#judulModalTarif").html('Edit Daftar Tarif');
                        $("#DaftarTarifModal").modal('show');
                        $("#asal_gerbang").hide();
                        $("#asal_gerbang_update").hide();

                        $("#jenis").hide();
                        $("#asd1").hide();
                        $("#asd2").hide();
                        $("#asq").hide();


                        inventor = JSON.parse(response.model.bagi_hasil)
                        totalInven1 = JSON.parse(response.model.gol1_d)
                        totalInven2 = JSON.parse(response.model.gol2_d)
                        totalInven3 = JSON.parse(response.model.gol3_d)
                        totalInven4 = JSON.parse(response.model.gol4_d)
                        totalInven5 = JSON.parse(response.model.gol5_d)

                        $("#investor1").val(inventor[0]);
                        $("#investor2").val(inventor[0]);
                        $("#investor3").val(inventor[0]);
                        $("#investor4").val(inventor[0]);
                        $("#investor5").val(inventor[0]);
                        $("#total_investor1").val(totalInven1[0]);
                        $("#total_investor2").val(totalInven2[0]);
                        $("#total_investor3").val(totalInven3[0]);
                        $("#total_investor4").val(totalInven4[0]);
                        $("#total_investor5").val(totalInven5[0]);


                        $.each(inventor, function (i, item) {

                            if (i > 0) {
                                tambahInvestor(1, inventor[i], totalInven1[i])
                                tambahInvestor(2, inventor[i], totalInven2[i])
                                tambahInvestor(3, inventor[i], totalInven3[i])
                                tambahInvestor(4, inventor[i], totalInven4[i])
                                tambahInvestor(5, inventor[i], totalInven5[i])
                            }

                        })

                    }

                });


            } else {
                $.ajax({
                    url: url,
                    method: "get",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {



                        $('#dasartarifmodal').find('option').remove().end();
                        $('#gerbangmodal').find('option').remove().end();
                        $("#id").val(response.model.id);
                        $('#jenis').find('option').remove().end();

                        var option = '';
                        var gerbang = $("#gerbang").val();

                        $.ajax({
                            url: '/admin/get-dasar-tarif',
                            async: false,
                            method: "POST",
                            data: {
                                gerbang: gerbang,
                                _token: '{{ csrf_token() }}'
                            },
                            dataType: "JSON",
                            success: function (data) {
                                //console.log(data);
                                //console.log(data[0].id_daftar_tarif);

                                $.each(data, function (i, item) {

                                    var selected = '';
                                    console.log(response.model
                                        .id_dasar_tarif)
                                    console.log(data[i].id_dasar_tarif)
                                    if (response.model.id_dasar_tarif ==
                                        data[i].id_dasar_tarif) {
                                        selected = "selected";
                                    }

                                    option += '<option value="' + data[
                                            i].id_dasar_tarif + '" ' +
                                        selected + '>' + data[i]
                                        .dasar_tarif + '</option>'
                                    //console.log(option);
                                    //console.log(response[i].dasar_tarif);
                                });
                            }


                        });

                        $('#dasartarifmodal').append(option);

                        var optionJenisVal = response.model.jenis;
                        var optionJenisVal = optionJenisVal.toUpperCase();

                        $('#jenis').find('option').remove().end();


                        if (optionJenisVal == 'KHL') {
                            $("#jenis").append(
                                `<option value="1"> ${optionJenisVal}</option>`);
                            $("#jenis").append(`<option value="2">AGS</option>`);
                            $("#jenis").append(`<option value="3">NORMAL</option>`);


                        } else if (optionJenisVal == 'AGS') {
                            $("#jenis").append(
                                `<option value="2"> ${optionJenisVal}</option>`);
                            $("#jenis").append(`<option value="1">KHL</option>`);
                            $("#jenis").append(`<option value="3">NORMAL</option>`);
                        } else {
                            $("#jenis").append(
                                `<option value="3"> ${optionJenisVal}</option>`);
                            $("#jenis").append(`<option value="1">KHL</option>`);
                            $("#jenis").append(`<option value="2">AGS</option>`);
                        }

                        var optionValue = $("#gerbang option:selected").val();
                        var optionText = $("#gerbang option:selected").text();
                        $('#gerbangmodal').append(
                            `<option value="${optionValue}"> ${optionText}</option>`);

                        $("#waktu").val(response.model.tgl_berlaku);
                        $("#jagorawigol1").val(response.model.gol1);
                        $("#totalgol1").val(response.model.gol1)

                        $("#jagorawigol2").val(response.model.gol2);
                        $("#totalgol2").val(response.model.gol2)

                        $("#jagorawigol3").val(response.model.gol3);
                        $("#totalgol3").val(response.model.gol3)

                        $("#jagorawigol4").val(response.model.gol4);
                        $("#totalgol4").val(response.model.gol4)

                        $("#jagorawigol5").val(response.model.gol5);
                        $("#totalgol5").val(response.model.gol5)
                        $("#judulModalTarif").html('Edit Daftar Tarif');
                        $("#DaftarTarifModal").modal('show');
                        $("#asal_gerbang").hide();
                        $("#asal_gerbang_update").hide();

                        // $("#jenis").hide();
                        // $("#asd1").hide();
                        // $("#asd2").hide();
                        // $("#asq").hide();
                        $("#asd1").hide();
                        $("#asq").show();
                        select2 = $('#asal_gerbang_update').select2({
                            dropdownParent: $("#DaftarTarifModal"),
                            ajax: {
                                url: '/admin/get-gerbang-data', // Ganti dengan URL yang sesuai untuk mengambil data Gerbang dari server
                                dataType: 'json',
                                delay: 250,
                                processResults: function (data) {
                                    return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item
                                                    .gerbang_nama +
                                                    '-' + item
                                                    .jenis_gerbang,
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

                        $('#asal_gerbang_update').val(response.asal_gerbang);
                        $('#asal_gerbang_update').select2().trigger('change');

                        // select2.on('select2:select', function (e) {
                        //     // Trigger the 'select2:select' event to set the selected value
                        //     var data = e.params.data;
                        //     if (data.id === response.model
                        //     .asal_gerbang) {
                        //         select2.val(data.id);
                        //     }
                        // });
                        // $("#asal_gerbang_update").show();


                        inventor = JSON.parse(response.model.tarif_inv)
                        totalInven1 = JSON.parse(response.model.gol1_d)
                        totalInven2 = JSON.parse(response.model.gol2_d)
                        totalInven3 = JSON.parse(response.model.gol3_d)
                        totalInven4 = JSON.parse(response.model.gol4_d)
                        totalInven5 = JSON.parse(response.model.gol5_d)

                        $("#investor1").val(inventor[0]);
                        $("#investor2").val(inventor[0]);
                        $("#investor3").val(inventor[0]);
                        $("#investor4").val(inventor[0]);
                        $("#investor5").val(inventor[0]);
                        $("#total_investor1").val(totalInven1[0]);
                        $("#total_investor2").val(totalInven2[0]);
                        $("#total_investor3").val(totalInven3[0]);
                        $("#total_investor4").val(totalInven4[0]);
                        $("#total_investor5").val(totalInven5[0]);


                        $.each(inventor, function (i, item) {

                            if (i > 0) {
                                tambahInvestor(1, inventor[i], totalInven1[i])
                                tambahInvestor(2, inventor[i], totalInven2[i])
                                tambahInvestor(3, inventor[i], totalInven3[i])
                                tambahInvestor(4, inventor[i], totalInven4[i])
                                tambahInvestor(5, inventor[i], totalInven5[i])
                            }

                        })

                    }

                });

            }



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
                                text: item.gerbang_nama + '-' + item.jenis_gerbang,
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

        $('#btnAddTarif').click(function () {

            if ($('#gerbang').val() == null) {
                sweetAlert('Gagal!', 'Gagal Tambah Data, Gerbang Belum Dipilih!', 'error')
            } else {
                $('#gerbangmodal').find('option').remove().end();
                $("#form-tambah-Tarif").trigger('reset');
                $("#gerbangmodal").val($("#gerbang").val());

                $(".dataInventor").remove();


                // $("#id").val(0);

                var selectedVal = $("#gerbang option:selected").text();
                selectedVal = selectedVal.split('-').pop().split(')')[0]; // returns 'two'
                var gerbang = $("#gerbang").val();

                if (selectedVal == 0 || selectedVal == 4) {
                    $("#asal_gerbang_update").hide();
                    $("#asq").hide();
                    var option = '';
                    $('#gerbangmodal').find('option').remove().end();
                    $('#dasartarifmodal').find('option').remove().end();
                    $("#form-tambah-edit-DaftarTarif").trigger('reset');
                    $.ajax({
                        url: '/admin/get-dasar-tarif',
                        async: false,
                        method: "POST",
                        data: {
                            gerbang: gerbang,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (response) {

                            $.each(response, function (i, item) {

                                option += '<option value="' + response[i]
                                    .id_dasar_tarif + '"  >' + response[i]
                                    .dasar_tarif + '</option>'
                                //console.log(option);
                                //console.log(response[i].dasar_tarif);
                            });
                        }

                    });


                    $("#gerbangmodal").val($("#gerbang").val());
                    $("#id").val(0);
                    var optionValue = $("#gerbang option:selected").val();
                    var optionText = $("#gerbang option:selected").text();
                    $('#gerbangmodal').append(`<option value="${optionValue}"> ${optionText}</option>`);
                    $('#dasartarifmodal').append(option);
                    $("#DaftarTarif-modal-tittle").html('Tambah Tarif');
                    $("#DaftarTarifModal").modal('show');
                    $("#asal_gerbang").hide();
                    $("#jenis").hide();
                    $("#asd1").hide();
                    $("#asd2").hide();
                } else if (selectedVal == 1 || selectedVal == 3) {
                    $("#asal_gerbang_update").hide();
                    $("#asq").hide();
                    $('#gerbangmodal').find('option').remove().end();
                    $('#dasartarifmodal').find('option').remove().end();
                    $("#form-tambah-edit-DaftarTarif").trigger('reset');
                    var option = '';
                    $.ajax({
                        url: '/admin/get-dasar-tarif',
                        async: false,
                        method: "POST",
                        data: {
                            gerbang: gerbang,
                            _token: '{{ csrf_token() }}'
                        },
                        dataType: "JSON",
                        success: function (response) {

                            $.each(response, function (i, item) {

                                option += '<option value="' + response[i]
                                    .id_dasar_tarif + '"  >' + response[i]
                                    .dasar_tarif + '</option>'
                                //console.log(option);
                                //console.log(response[i].dasar_tarif);
                            });
                        }

                    });

                    $('#asal_gerbang').select2({
                        dropdownParent: $("#DaftarTarifModal"),
                        ajax: {
                            url: '/admin/get-gerbang-data', // Ganti dengan URL yang sesuai untuk mengambil data Gerbang dari server
                            dataType: 'json',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.gerbang_nama + '-' + item
                                                .jenis_gerbang,
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

                    $('#jenis').find('option').remove().end();
                    $("#jenis").append(`<option value="3">NORMAL</option>`);
                    $("#jenis").append(`<option value="1">KHL</option>`);
                    $("#jenis").append(`<option value="2">AGS</option>`);

                    $("#gerbangmodal").val($("#gerbang").val());
                    $("#id").val(0);
                    var optionValue = $("#gerbang option:selected").val();
                    var optionText = $("#gerbang option:selected").text();
                    $('#gerbangmodal').append(`<option value="${optionValue}"> ${optionText}</option>`);
                    $('#dasartarifmodal').append(option);
                    $("#DaftarTarif-modal-tittle").html('Tambah Tarif');
                    $("#DaftarTarifModal").modal('show');
                    $("#asal_gerbang").show();
                    $("#jenis").show();
                    $("#asd1").show();
                    $("#asd2").show();
                }

            }



        });


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





        // $("#form-tambah-edit-DasarTarif").validate()
        // $("#form-edit-DasarTarif").validate()

        // $("#form-tambah-edit-DasarTarif").submit(function (e) {
        //     e.preventDefault()
        //     var url = '{{ url()->current() }}/tambah';
        //     var formData = new FormData($("#form-tambah-edit-DasarTarif")[0]);

        //     // Tambahkan token CSRF ke dalam formData
        //     formData.append('_token', '{{ csrf_token() }}');

        //     $.ajax({
        //         url: url,
        //         method: "POST",
        //         data: formData,
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function (response) {

        //             $("#DasarTarifModal").modal('hide');
        //             $("#form-tambah-edit-DasarTarif").trigger('reset');

        //             document.getElementById('loading-screen').style.display = 'block';
        //             setTimeout(function () {
        //                 dt_filter.ajax.reload();
        //                 document.getElementById('loading-screen').style.display =
        //                     'none';
        //                 sweetAlert('Berhasil!', 'Data Berhasil Ditambahkan!',
        //                     'success')
        //             }, 1000);
        //         }

        //     });

        // });

        // $("#form-edit-DasarTarif").submit(function (e) {
        //     e.preventDefault()
        //     var url = '{{ url()->current() }}/update';
        //     var formData = new FormData($("#form-edit-DasarTarif")[0]);

        //     // Tambahkan token CSRF ke dalam formData
        //     formData.append('_token', '{{ csrf_token() }}');

        //     $.ajax({
        //         url: url,
        //         method: "POST",
        //         data: formData,
        //         contentType: false,
        //         cache: false,
        //         processData: false,
        //         success: function (response) {
        //             //console.log(response);
        //             $("#DasarTarifModalEdit").modal('hide');
        //             $("#form-edit-DasarTarif").trigger('reset');

        //             document.getElementById('loading-screen').style.display = 'block';
        //             setTimeout(function () {
        //                 dt_filter.ajax.reload();
        //                 document.getElementById('loading-screen').style.display =
        //                     'none';
        //                 sweetAlert('Berhasil!', 'Data Berhasil Diedit!', 'success')
        //             }, 1000);

        //         }

        //     });

        // });



    });

    function sum_gol(id) {
        switch (id) {
            case 1:
                var jgrw = $('#jagorawigol1').val() == '' ? 0 : $('#jagorawigol1').val();


                var result = parseFloat(jgrw);
                if (!isNaN(result)) {
                    $('#totalgol1').val(result);
                }
                break;
            case 2:
                var jgrw = $('#jagorawigol2').val() == '' ? 0 : $('#jagorawigol2').val();


                var result = parseFloat(jgrw);
                if (!isNaN(result)) {
                    $('#totalgol2').val(result);
                }
                break;
            case 3:
                var jgrw = $('#jagorawigol3').val() == '' ? 0 : $('#jagorawigol3').val();


                var result = parseFloat(jgrw);
                if (!isNaN(result)) {
                    $('#totalgol3').val(result);
                }
                break;
            case 4:
                var jgrw = $('#jagorawigol4').val() == '' ? 0 : $('#jagorawigol4').val();
                var result = parseFloat(jgrw);
                if (!isNaN(result)) {
                    $('#totalgol4').val(result);
                }
                break;
            case 5:
                var jgrw = $('#jagorawigol5').val() == '' ? 0 : $('#jagorawigol5').val();

                var result = parseFloat(jgrw);
                if (!isNaN(result)) {
                    $('#totalgol5').val(result);
                }
                break;
        }

    }

    function tambahInvestor(tabIndex, value = null, totalinven = null) {
        // Temukan elemen tab-pane yang sesuai berdasarkan tabIndex
        var tabPane = document.getElementById('gol' + tabIndex + '-tab-pane');

        // Buat elemen form group untuk input investor
        var formGroup = document.createElement('div');
        formGroup.className = 'form-group dataInventor';

        // Label untuk input investor
        var label = document.createElement('label');
        label.textContent = 'Investor';
        label.setAttribute('for', 'investor');

        // Input untuk investor
        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control';
        input.name = 'investor' + tabIndex + '[]';
        input.id = 'investor' + tabIndex;
        if (value != null) {
            input.value = value
        }

        // Tombol "Delete" untuk menghapus investor
        var deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.className = 'btn btn-danger btn-sm mt-2 mb-2';
        deleteButton.type = 'button';

        var hr = document.createElement('hr');

        // Tambahkan event listener untuk tombol "Delete"
        deleteButton.addEventListener('click', function () {
            // Hapus elemen form group saat tombol "Delete" diklik
            formGroup.remove();
        });

        // Total Investor
        var totalLabel = document.createElement('label');
        totalLabel.textContent = 'Total Investor';
        totalLabel.setAttribute('for', 'total_investor');

        var totalInput = document.createElement('input');
        totalInput.type = 'number';
        totalInput.className = 'form-control';
        totalInput.name = 'totalinvestor' + tabIndex + '[]';
        totalInput.id = 'total_investor' + tabIndex;
        totalInput.value = totalinven

        // Tambahkan elemen-elemen ini ke dalam tab-pane

        formGroup.appendChild(hr);
        formGroup.appendChild(label);
        formGroup.appendChild(input);
        formGroup.appendChild(totalLabel);
        formGroup.appendChild(totalInput);
        tabPane.appendChild(formGroup);
        formGroup.appendChild(deleteButton);

        formGroup.appendChild(hr); // Tambahkan tombol "Delete"
    }

    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp.' + ribuan + '.00';
    }

</script>

@endpush
