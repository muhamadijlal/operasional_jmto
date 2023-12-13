
$.validator.addMethod("lettersonly", function(value, element) {
    return /^[a-zA-Z\s]+$/.test(value);
}, "Desa Hanya Bisa Mengandung Huruf dan Spasi");

$.validator.addMethod("nospecialchars", function(value, element) {
    return /^[a-zA-Z0-9\s]*$/.test(value);
}, "Field should not contain special characters.");


$("#editMyProfile").validate({
    rules: {

        name: {
            required: true,
            lettersonly: true,
            nospecialchars: true,
        },
        nohp: {
            required: true,
        },
        company: {
            required: true,
            lettersonly: true,
            nospecialchars: true,
        },
        divisi: {
            required: true,
            lettersonly: true,
            nospecialchars: true,
        },
        email: {
            required: true,
            email: true,
        },

        foto_profil: {
            extension: "jpg|jpeg|png"
        },
       

    },
    messages: {
        name: {
            required: "Nama Lengkap wajib diisi.",
        },
        nohp: {
            required: "No HP wajib diisi.",
        },
        company: {
            required: "Company wajib diisi.",
        },
        divisi: {
            required: "Divisi wajib diisi.",
        },
        email: {
            required: "Email wajib diisi.",
            email: "Format email tidak sesuai.",
        },
        foto_profil: {
            extension: "Hanya file dengan ekstensi JPG, JPEG, atau PNG yang diperbolehkan."
        },
    }
});