$(function() {
    $(".btn-login").on("click", function() {
        do_login();
    });

    $(".input-username, .input-password").on("keyup", function(e) {
        if (e.which == 13) {
            do_login();
        }
    });
});

function do_login() {
    if (!$(".btn-login").hasClass("disabled")) {
        removeAllErrors();
        var username = $(".input-username").val().trim();
        var password = $(".input-password").val().trim();
        var valid = true;
        if (username == "") {
            valid = false;
            $(".error-username").html("required");
        }
        if (password == "") {
            valid = false;
            $(".error-password").html("required");
        }

        if (valid) {
            $(".btn-login").addClass("disabled");
            showLoader();
            ajaxCall(do_login_url, {username: username, password: password}, function(json) {
                var result = jQuery.parseJSON(json);
                if (result.status == "success") {
                    window.location = admin_url;
                } else {
                    hideLoader();
                    $(".btn-login").removeClass("disabled");
                    showNotification("Username / Password Salah");
                }
            });
        }
    }
}

function removeAllErrors() {
    $(".error").html("");
}

function showLoader() {
    $(".loader").addClass("show");
}

function hideLoader() {
    $(".loader").removeClass("show");
}

function showNotification(text) {
    var notification = $(".notification");
    notification.html(text);
    notification.off("webkitAnimationEnd oanimationend msAnimationEnd animationend");
    notification.one("webkitAnimationEnd oanimationend msAnimationEnd animationend", function(e) {
        notification.removeClass("showing");
    });

    notification.removeClass("showing");
    setTimeout(function() {
        notification.addClass("showing");
    }, 1);
}

function ajaxCall(url, data, callback) {
	return $.ajax({
		url: url,
		data: data,
		type: 'POST',
		error: function(jqXHR, exception) {
			if (exception != "abort") {
				console.log(jqXHR + " : " + jqXHR.responseText);
			}
		},
		success: function(result) {
			callback(result);
		}
	});
}