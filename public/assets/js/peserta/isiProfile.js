$("#isi_profile").validate({
    rules: {
      no_kk: {
        required: true,
        number: true,
        minlength:16,
        maxlength:16
      },
      nik: {
        required: true,
        number: true,
        minlength:16,
        maxlength:16
      }
    },
    messages: {
        no_kk: {
            required: "Nomor Kartu Keluarga Wajib Diisi",
            number:"Format Harus Angka",
            minlength:"Nomor Kartu Keluarga Wajib 16 Digit",
            maxlength:"Nomor Kartu Keluarga Wajib 16 Digit"
        },
        nik: {
            required: "Nomor NIK Wajib Diisi",
            number:"Format Harus Angka",
            minlength:"Nomor NIK Wajib 16 Digit",
            maxlength:"Nomor NIK Wajib 16 Digit"
        },
    }
  });