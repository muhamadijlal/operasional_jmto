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