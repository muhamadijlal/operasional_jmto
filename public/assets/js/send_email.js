$(document).ready(function() {
    // Mengatur counter email
    var emailCounter = 1;

    // Menambahkan field email baru
    $(".add-email").click(function() {
        emailCounter++;
        var newEmailField = `
            <div class="form-group mb-3 mt-3">
                <label for="email">Email ${emailCounter}</label>
                <input type="email" class="form-control" name="email[]" required placeholder="Masukkan email">
                <button type="button" class="btn btn-danger mt-1 btn-sm delete-email">Delete</button>
            </div>
        `;
        $(".email-fields").append(newEmailField);
    });

    // Menghapus field email yang bersangkutan
    $(".email-fields").on("click", ".delete-email", function() {
        $(this).closest(".form-group").remove();
        emailCounter--;
        // Mengubah label email sesuai dengan nomor urut
        $(".email-fields .form-group").each(function(index) {
            $(this).find("label").text(`Email ${index + 1}`);
        });
    });
});

$("#send-email").validate({
    rules: {

        email: {
            required: true,
            email:true,
        },


    },
    messages: {
        email: {
            required: "Email wajib diisi.",
        },
    }
});