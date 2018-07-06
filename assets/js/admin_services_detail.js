$(function() {
    var src = $(".tour-group-image-preview").attr("src");
    if (src != undefined) {
        toDataURL(src, function(dataUrl) {
            $(".tour-group-image-input").val(dataUrl);
        });
    }
    
    $(".tour-group-image-input-upload").on("change", function() {
        var formRight = $(this).closest(".form-right");
		var previewElement = formRight.find(".image-preview");
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                formRight.addClass("image-added");
                previewElement.attr("src", e.target.result);
                $(".tour-group-image-input").val(e.target.result);
			};
            reader.readAsDataURL(this.files[0]);
            var count = parseInt($(".add-itinerary-image-count").val()) + 1;
            $(".add-itinerary-image-count").val(count);
		}
    });

    $(".btn-delete-tour-group-image").on("click", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var input = formRight.find(".input-upload");
        clearInputFile(input[0]);
        $(".tour-group-image-input").val("");
        previewElement.removeAttr("src");
        formRight.removeClass("image-added");
    });

    $(".btn-update").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var nama = $(".input-nama").val().trim();
            var deskripsi = $(".input-deskripsi").val().trim();

            if (nama == "") {
                valid = false;
                showNotification("Nama Service harus diisi");
            } else if (deskripsi == "") {
                valid = false;
                showNotification("Deskripsi harus diisi");
            }

            if (valid) {
                if (confirm('Simpan Perubahan?')) {
                    $(this).addClass("disabled");

                    $("input[type='file']").each(function() {
                        clearInputFile(this);
                    });
                    
                    $(".form-update").submit();
                    showLoader();
                }
            }
        }
    });
});

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