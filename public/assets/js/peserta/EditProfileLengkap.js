$(document).ready(function () {
    $('#tingkat_pendidikan').select2();
    $('#provinsi').select2({
        minimumInputLength: 3,
        placeholder: 'Pilih Provinsi...',
        ajax: {
            url: '/api/list/provinsi-select',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id_wil,
                            text: item.nm_wil
                        };
                    })
                };
            },
            cache: true
        }
    });

    $('#provinsi').on('change', function () {
        var provinceId = $(this).val();

        $('#kabupaten').val(null).trigger('change');
        $('#kecamatan').val(null).trigger('change');

        if (provinceId) {
            $('#kabupaten').prop('disabled', false);
            // $('#kabupaten').select2('enable');
            // $('#kabupaten').select2('open');

            $('#kabupaten').select2({
                minimumInputLength: 3,
                placeholder: 'Pilih Kabupaten / Kota...',
                ajax: {
                    url: '/api/list/kota-select',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            provinsi: provinceId,
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id_wil,
                                    text: item.nm_wil
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        } else {
            // $('#kabupaten').prop('disabled', true);
            // $('#kabupaten').select2('disable');
            // $('#kabupaten').val(null).trigger('change');
        }
    });

    $('#kabupaten').on('change', function () {
        var cityId = $(this).val();

        $('#kecamatan').val(null).trigger('change');

        if (cityId) {
            $('#kecamatan').prop('disabled', false);
            // $('#kecamatan').select2('enable');
            // $('#kecamatan').select2('open');

            $('#kecamatan').select2({
                minimumInputLength: 3,
                placeholder: 'Pilih kecamatan...',
                ajax: {
                    url: '/api/list/kecamatan-select',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            kabupaten: cityId,
                            term: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id_wil,
                                    text: item.nm_wil
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        } else {
            // $('#kecamatan').prop('disabled', true);
            // $('#kecamatan').select2('disable');
            // $('#kecamatan').val(null).trigger('change');
        }
    });

    $('#tingkat_pendidikan').on('change', function () {
        $('#nama_instansi').prop('disabled', false);
        var selectedOption = $(this).val();

        if (selectedOption === 'sd') {
            $('#nama_instansi').html('');
            // $('#nama_instansi').select2('destroy');
            $('#nama_instansi').select2({
                minimumInputLength: 3,
                placeholder: 'Pilih SD...',
                ajax: {
                    url: '/api/list/sd-select',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.nama_instansi
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        } else if (selectedOption === 'smp') {
            $('#nama_instansi').html('');
            // $('#nama_instansi').select2('destroy');
            $('#nama_instansi').select2({
                minimumInputLength: 3,
                placeholder: 'PILIH SMP...',
                ajax: {
                    url: '/api/list/smp-select',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.nama_instansi
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        } else if (selectedOption === 'sma') {
            $('#nama_instansi').html('');
            // $('#nama_instansi').select2('destroy');
            $('#nama_instansi').select2({
                minimumInputLength: 3,
                placeholder: 'Pilih SMA...',
                ajax: {
                    url: '/api/list/sma-select',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.nama_instansi
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        } else if (selectedOption === 'pt') {
            $('#nama_instansi').html('');
            // $('#nama_instansi').select2('destroy');
            $('#nama_instansi').select2({
                minimumInputLength: 3,
                placeholder: 'Select pt...',
                ajax: {
                    url: '/api/list/pt-select',
                    dataType: 'json',
                    delay: 250,
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.nama_instansi
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }

    });
});

$.validator.addMethod("lettersonly", function(value, element) {
    return /^[a-zA-Z\s]+$/.test(value);
}, "Desa Hanya Bisa Mengandung Huruf dan Spasi");

$.validator.addMethod("nospecialchars", function(value, element) {
    return /^[a-zA-Z0-9\s]*$/.test(value);
}, "Field should not contain special characters.");

$("#isiProfileLengkap").validate({
    rules: {

        tempat_lahir: {
            required: true,
            lettersonly: true,
            nospecialchars: true,
        },
        tanggal_lahir: {
            required: true,
        },
        desa: {
            required: true,
            lettersonly: true,
        },
        rt: {
            required: true,
            digits: true,
        },
        rw: {
            required: true,
            digits: true,
        },
        no_rek_bjb:{
            digits: true,
        },
        provinsi: {
            required: true,
        },
        kabupaten: {
            required: true,
        },
        kecamatan: {
            required: true,
        },
        tingkat_pendidikan: {
            required: true,
        },
        nama_instansi: {
            required: true,
        },
        nama_ibu: {
            required: true,
            lettersonly: true,
        },
        no_hp_ibu: {
            required: true,
            digits: true,
        },
        nik_ibu: {
            required: true,
            minlength: 16,
            maxlength: 16,
            digits: true,
        },
        pas_photo: {
            extension: "jpg|jpeg|png|pdf"
        },
        kk: {
            extension: "jpg|jpeg|png|pdf"
        },
        ktp_ortu: {
            extension: "jpg|jpeg|png|pdf"
        },
        ktp_peserta: {
            extension: "jpg|jpeg|png|pdf"
        },

    },
    messages: {
        tempat_lahir: {
            required: "Tempat Lahir Wajib Diisi",
        },
        tanggal_lahir: {
            required: "Tanggal Lahir Wajib Diisi",
        },
        desa: {
            required: "Desa Wajib Diisi",
        },
        rt: {
            required: "Rt Wajib Diisi",
            digits: "Wajib Angka",
        },
        rw: {
            required: "Rw Wajib Diisi",
                        digits: "Wajib Angka",
        },
        provinsi: {
            required: "Provinsi Wajib Diisi",
        },
        kabupaten: {
            required: "Kabupaten Wajib Diisi",
        },
        kecamatan: {
            required: "Kecamatan Wajib Diisi",
        },
        tingkat_pendidikan: {
            required: "Tingkat Pendidikan Wajib Diisi",
        },
        nama_instansi: {
            required: "Instansi Wajib Diisi",
        },
        nama_ibu: {
            required: "Nama Ibu Wajib Diisi",
        },
        no_hp_ibu: {
            required: "No HP Ibu Wajib Diisi",
        },
        nik_ibu: {
            required: "NIK Ibu Wajib Diisi",
            number:"Format Harus Angka",
            minlength:"NIK Ibu Wajib 16 Digit",
            maxlength:"NIK Ibu Wajib 16 Digit"
        },
        pas_photo: {
            extension: "Pas Photo Wajib jpg/jpeg/png/pdf",
        },
        kk: {
            extension: "Kartu Keluarga Wajib jpg/jpeg/png/pdf",
        },
        ktp_ortu: {
            extension: "KTP Orang Tua Wajib jpg/jpeg/png/pdf",
        },
        ktp_peserta: {
            extension: "KTP Peserta/Kartu Siswa Wajib jpg/jpeg/png/pdf",
        },
        // nik: {
        //     required: "Nomor NIK Wajib Diisi",
        //     number:"Format Harus Angka"
        // },
    }
});

$("#isiProfileLengkap").submit(function() {
    $("#kabupaten").prop("disabled", false);
    $("#kecamatan").prop("disabled", false);
    $("#nama_instansi").prop("disabled", false); 
});
