$('#ruas-ktp').select2({
  ajax: {
      url: '/admin/kartu/get-ruas-kartu', 
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
      url: '/admin/kartu/get-institusi', 
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
      url: '/admin/kartu/get-unit', 
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
      url: '/admin/kartu/get-ktp-opr', 
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

$('#jenis_ktp_edit').select2({
    ajax: {
        url: '/admin/kartu/get-ktp-opr', 
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
    dropdownParent: $("#ModalEditKartu")
  });

$('#ruas').select2({
    ajax: {
        url: '/admin/kartu/get-ruas', 
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.nama_ruas,
                        id: item.ruas_id,
                    };
                }),
            };
        },
        cache: true
    },
    placeholder: '-- Pilih Ruas --'
  });
  