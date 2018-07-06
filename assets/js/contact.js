$(function() {
    $(".btn-submit").on("click", function() {
        clearAllErrors();
        var valid = true;

        var name = $(".input-name").val().trim();
        var email = $(".input-email").val().trim();
        var phone = $(".input-phone").val().trim();
        var subject = $(".input-subject").val().trim();
        var message = $(".input-message").val().trim();

        if (name == "") {
            valid = false;
            $(".error-name").html("required");
            $(".input-name").addClass("has-error");
        }
        if (email == "") {
            valid = false;
            $(".error-email").html("required");
            $(".input-email").addClass("has-error");
        }
        if (phone == "") {
            valid = false;
            $(".error-phone").html("required");
            $(".input-phone").addClass("has-error");
        }

        if (valid) {
            $(".contact-form").submit();
        } else {
            showNotification("Silakan cek isian");
        }
    });
});

function clearAllErrors() {
    $(".error").html("");
    $(".has-error").removeClass("has-error");
}