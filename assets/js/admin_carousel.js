$(function() {
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

    $(".select-index").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-index").val(value);
    });

    $(".select-update-index").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-update-index").val(value);
    });

    $(".btn-add-carousel").on("click", function() {
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
            if (confirm("Add Carousel?")) {
                $(this).addClass("disabled");
                showLoader();
                $(".form-add-carousel").submit();
            }
        }
    });

    $(document).on("click", ".btn-edit-index", function() {
        var item = $(this).closest(".item");
        var id = item.attr("data-id");
        var index = item.attr("data-index");
        $(".label-from-index").html("From Index : " + index);
        $(".dialog-edit-index").find("input[name='carousel_id']").val(id);
        showDialog($(".dialog-edit-index"));
    });

    $(".btn-dialog-update-index").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            $(this).addClass("disabled");
            showLoader();
            $(".form-update-index").submit();
        }
    });

    $(document).on("click", ".btn-delete-carousel", function() {
        if (!$(this).hasClass("disabled")) {
            if (confirm("Delete Carousel?")) {
                $(this).addClass("disabled");
                showLoader();
                $(this).closest(".form-delete-carousel").submit();
            }
        }
    });
});

function clearAllErrors() {
    $(".error").html("");
}