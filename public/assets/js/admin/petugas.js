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

$('#nama_kspt').select2({
    ajax: {
        url: '/admin/get-nama-kspt', 
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: `${item.nama_pegawai} [${item.npp_no}]`,
                        id: item.npp_no,
                    };
                }),
            };
        },
        cache: true
    },
    placeholder: '-- Silahkan Pilih Petugas --'
});

$('#nama_personil').select2({
    ajax: {
        url: '/admin/get-nama-personil', 
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: `${item.nama_pegawai} [${item.npp_no}]`,
                        id: item.npp_no,
                    };
                }),
            };
        },
        cache: true
    },
    placeholder: '-- Silahkan Pilih Petugas --'
});

$('#nama_kspt').on('change', function(){
    var npp_no =  $('#nama_kspt').val();
    $('#npp_kspt').val(npp_no)
});

$('#nama_personil').on('change', function(){
    var npp_no =  $('#nama_personil').val();
    $('#npp_personil').val(npp_no)
});