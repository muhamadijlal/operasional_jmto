$('#optionNama').select2({
  ajax: {
      url: '/admin/get-option-nama', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: `${item.nama} - ${item.no_registrasi}`,
                      id: item.id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Nama --'
});