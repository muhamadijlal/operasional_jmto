CKEDITOR.replace( 'text' );
$.validator.addMethod("lettersonly", function(value, element) {
    return /^[a-zA-Z\s]+$/.test(value);
}, "Desa Hanya Bisa Mengandung Huruf dan Spasi");

$.validator.addMethod("nospecialchars", function(value, element) {
    return /^[a-zA-Z0-9\s]*$/.test(value);
}, "Field should not contain special characters.");

$("#addDocent").validate({
    rules: {

        title: {
            required: true,

        },
        content: {
            required: true,
        },
        tanggal_signing: {
            required: true,
        },
        jabatan_signing: {
            required: true,
        },
        nama_signing: {
            required: true,
        },
        signing: {
            required: true,
            extension: "jpg|jpeg|png|pdf"
        },
       

    },
    messages: {
       
        title: {
            required: "title document wajib diisi.",
        },
        content: {
            required: "content document wajib diisi.",
        },
        tanggal_signing: {
            required: "Tanggal document wajib diisi.",
        },
        jabatan_signing: {
            required: "Jabatan Penangung Jawab document wajib diisi.",
        },
        nama_signing: {
            required: "Nama Penanung Jawab document wajib diisi.",
        },
        signing: {
            required: "signing document wajib diisi.",
            extension: "Hanya file dengan ekstensi JPG, JPEG,PNG atau PDF yang diperbolehkan."
        },
    }
});
$("#editDocument").validate({
    rules: {

        title: {
            required: true,
        },
        content: {
            required: true,
        },
        signing: {
            extension: "jpg|jpeg|png|pdf"
        },
       

    },
    messages: {
       
        title: {
            required: "title document wajib diisi.",
        },
        content: {
            required: "content document wajib diisi.",
        },
        signing: {
            extension: "Hanya file dengan ekstensi JPG, JPEG,PNG atau PDF yang diperbolehkan."
        },
    }
});