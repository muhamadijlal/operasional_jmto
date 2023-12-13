function cacheInput(e) {
    localStorage.setItem(e.attributes["name"].value, e.value)
}

$(document).ready(function () {
    // inisialisasi Table
    var dt_filter_open = null;

    // function custom alert
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

    // set datetimepicker for time
    $("#waktu").datetimepicker({
        format: 'Y-m-d H:i:s',
        theme: 'white'
    });


    var dt_filter_table = $('.datatables-basic');


    // set datatble with selected gerbang
    $('#gerbang').on('change', function (e) {
        e.preventDefault()

        // get Type gerbang
        var selectGerbang = $("#gerbang option:selected").text();
        selectGerbang = selectGerbang.split('-').pop().split(')')[0];

        if (selectGerbang == 0 || selectGerbang == 4) {
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

            if ($.fn.DataTable.isDataTable('#tbl_list_close')) {
                $('#tbl_list_close').DataTable().destroy();
                $('#tbl_list_close thead').empty();
            }

            dt_filter_open = $('#tbl_list_open').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: baseUrl, // Ganti dengan URL yang sesuai
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
                }]
            })

            $('.datatables-basic-open thead tr').clone(true).appendTo('.datatables-basic-open thead');
            $('.datatables-basic-open thead tr:eq(1) th').each(function (i) {
                var title = $(this).text();

                $(this).html('<input id="Search_' + title + '" name="Search_' + title +
                    '" type="text" oninput="cacheInput(this)" class="form-control" placeholder="Search" />'
                );
                $localdata = localStorage.getItem('Search_' + title);
                if ($localdata) {
                    document.getElementById('Search_' + title).value = $localdata;
                }
                $('input', this).on('keyup change', function () {
                    if (dt_filter_open.column(i).search() !== this.value) {
                        dt_filter_open.column(i).search(this.value).draw();
                    }
                });
            });



            document.getElementById('loading-screen').style.display = 'block';
            setTimeout(function () {
                document.getElementById('loading-screen').style.display = 'none';
            }, 1000);

        } else {



        }

    })

})
