$(function() {
    $(".btn-submit").on("click", function() {
        update();
    });

    $(".form-input").on("keydown", function(e) {
        if (e.which == 13) {
            update();
        }
    });
});

function update() {
    if (!$(".btn-submit").hasClass("disabled")) {
        var valid = true;
        var old_password = $(".old-password").val().trim();
        var new_password = $(".new-password").val().trim();
        var confirm_new_password = $(".confirm-new-password").val().trim();

        if (old_password == "") {
            valid = false;
            showNotification("Password Lama harus diisi");
        } else if (new_password == "") {
            valid = false;
            showNotification("Password Baru harus diisi");
        } else if (confirm_new_password == "") {
            valid = false;
            showNotification("Confirm Password Baru harus diisi");
        } else if (confirm_new_password != new_password) {
            valid = false;
            showNotification("Confirm Password Baru harus sama dengan Password Baru");
        }

        if (valid) {
            $(".form-change-password").submit();
            showLoader();
        }
    }
}