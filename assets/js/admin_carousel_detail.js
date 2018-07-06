$(function() {
    var src = $(".form-image").find(".tour-group-image-preview").attr("src");
    if (src != undefined) {
        toDataURL(src, function(dataUrl) {
            $(".tour-group-image-input").val(dataUrl);
        });
    }

    src = $(".form-image-mobile").find(".tour-group-image-preview").attr("src");
    if (src != undefined) {
        toDataURL(src, function(dataUrl) {
            $(".tour-group-image-input-mobile").val(dataUrl);
        });
    }
    
    $(".input-upload").on("change", function() {
        var formRight = $(this).closest(".form-right");
		var previewElement = formRight.find(".image-preview");
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                formRight.addClass("image-added");
                previewElement.attr("src", e.target.result);
                formRight.find(".image-input").val(e.target.result);
			};
            reader.readAsDataURL(this.files[0]);
		}
    });

    $(".btn-delete-tour-group-image").on("click", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var input = formRight.find(".input-upload");
        clearInputFile(input[0]);
        formRight.find(".image-input").val("");
        previewElement.removeAttr("src");
        formRight.removeClass("image-added");
    });

    $(".select-text-position").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-text-position").val(value);
    });

    $(".select-title-color").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-title-color").val(value);
    });

    $(".select-description-color").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-description-color").val(value);
    });

    $(".btn-update-carousel").on("click", function() {
        clearAllErrors();
        var valid = true;
        var image = $(".tour-group-image-input").val();
        var title = $(".input-title").val().trim();

        if (image == "") {
            valid = false;
            $(".error-image").html("is required");
            showNotification("Pilih Gambar");
        }

        if (valid) {
            if (confirm("Simpan Perubahan?")) {
                $(this).addClass("disabled");
                showLoader();
                $(".form-update-carousel").submit();
            }
        }
    });
});

function clearAllErrors() {
    $(".error").html("");
}

function toDataURL(url, callback, temp) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
        var reader = new FileReader();
        reader.onloadend = function() {
            callback(reader.result, temp);
        }
        reader.readAsDataURL(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
}