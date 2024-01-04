@extends('admin.master')

{{-- judul dari dashboard--}}
@section('title')
{{-- {{ $judul }} --}}
@endsection

@section('content')

<div class="card">
    <div class="card-body">
        <button id="addPetugas" class="btn btn-info"> <i class="fa fa-plus"></i> Tambah Petugas</button>
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
                    <input type="text" maxlength="15" class="form-control " id="nama_petugas"
                        placeholder="Nama Petugas">
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


@endsection

@section('js')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    baseUrl = '{{ url()->current() }}';

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


        $('.select2').select2({
            dropdownParent: $("#ModalTambahPetugas")
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


        $('#addPetugas').click(function () {

            $('#nama_petugas').val('')
            $('#npp').val('')
            $('#jabatan').val('')
            $('#inisial_petugas').val('')

            // penempatan gerbang
            $('#gerbang_penempatan').find('option').remove().end()
            var optionGerbangPenempatan =
                '';

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
                        if (response.code == 200) {

                            $("#ModalTambahPetugas").modal('hide')
                            // dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Berhasil!',
                                response.message, 'success')

                        } else {
                            $("#ModalTambahPetugas").modal('hide')
                            // dt_filter.ajax.reload();
                            document.getElementById('loading-screen').style
                                .display = 'none';
                            sweetAlert('Gagal!',
                                response.message, 'error')
                        }
                    }
                })

            }
        })

        function validateField(fieldValue, errorMessage) {
            if (fieldValue === '') {
                sweetAlert('Gagal!', errorMessage, 'error');
                return false;
            }
            return true;
        }
    })

</script>
@endsection
