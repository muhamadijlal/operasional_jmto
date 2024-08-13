$('#gerbang').select2({
  ajax: {
      url: '/admin/get-gerbang-data', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: `${item.gerbang_nama} - ${item.gerbang_id}`,
                      id: item.gerbang_id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Gerbang --',
});

$('#jabatan').select2({
  ajax: {
      url: '/admin/get-jabatan-data', 
      dataType: 'json',
      delay: 250,
      processResults: function (data) {
          return {
              results: $.map(data, function (item) {
                  return {
                      text: item.nama_jabatan,
                      id: item.jabatan_id,
                  };
              }),
          };
      },
      cache: true
  },
  placeholder: '-- Pilih Jabatan --',
});