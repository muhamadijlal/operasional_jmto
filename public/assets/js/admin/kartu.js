$('#ruas-ktp').select2({
  ajax: {
      url: '/admin/get-ruas-kartu', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: item.ruas,
                      id: item.id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Ruas --',
  dropdownParent: $("#ModalTambahKartu")
});

$('#institusi').select2({
  ajax: {
      url: '/admin/get-institusi', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: `${item.institusi} (${item.keterangan})`,
                      id: item.id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Institusi --',
  dropdownParent: $("#ModalTambahKartu")
});

$('#unit').select2({
  ajax: {
      url: '/admin/get-unit', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: item.unit,
                      id: item.id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Unit --',
  dropdownParent: $("#ModalTambahKartu")
});

$('#jenis_ktp').select2({
  ajax: {
      url: '/admin/get-ktp-opr', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: `KTP ${item.keterangan}`,
                      id: item.jenis_ktp_id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Jenis KTP --',
  dropdownParent: $("#ModalTambahKartu")
});

$('#ruas').select2({
    ajax: {
        url: '/admin/get-ruas', 
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.ruas_nama,
                        id: item.ruas_id,
                    };
                }),
            };
        },
        cache: true
    },
    placeholder: '-- Pilih Ruas --'
  });
  