$('#optionNama').select2({
    ajax: {
        url: '/admin/kartu/get-option-nama',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return {
                q: params.term
            };
        },
        processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        id: item.id,
                        text: item.nama
                    };
                })
            };
        }
    },
    placeholder: 'Pilih Nama'
});

$('#gerbang_connection').select2({
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