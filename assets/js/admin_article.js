$(function() {
    $(document).on("keydown", ".insert-content-text", function(e) {
        if (e.which == 9) {
            e.preventDefault();
            this.insertAtCaret("          ");
        }
    });

    $(document).on("change", ".input-upload-main", function() {
		var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var thisElement = this;
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                formRight.addClass("image-added");
                previewElement.attr("src", e.target.result);
                $(".main-image-input").val(e.target.result);
                clearInputFile(thisElement);
			};
            reader.readAsDataURL(this.files[0]);
		}
    });

    $(".btn-delete-image").on("click", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var input = formRight.find(".input-upload-main");
        clearInputFile(input[0]);
        $(".tour-group-image-input").val("");
        previewElement.removeAttr("src");
        formRight.removeClass("image-added");
    });

    $(document).on("click", ".btn-insert-text", function() {
        var element = "<div class='content-group content-group-text'><textarea class='insert-content-text'></textarea><div><div class='btn btn-negative btn-delete-text'>Delete Text</div><div class='upload-container btn btn-insert-image'><div class='upload-button'><div class='upload-text'>Insert Image</div></div><input type='file' class='input-upload' name='input-image' accept='image/*' /></div><div class='btn btn-insert-text'>Insert Text</div></div></div>";
        $(this).closest(".content-group").after(element);
    });

    $(document).on("change", ".input-upload", function() {
        var contentGroup = $(this).closest(".content-group");
        var previewElement = $(".upload-image-preview");
        var thisElement = this;
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                var element = "<div class='content-group content-group-image'><input type='hidden' name='article-image' class='article-image' value='" + e.target.result + "' /><div class='image-container'><img class='image' src='" + e.target.result + "' /></div><input type='text' class='form-input input-image-description' name='article_image_description' /><div><div class='btn btn-negative btn-delete-article-image'>Delete Image</div><div class='upload-container btn btn-insert-image'><div class='upload-button'><div class='upload-text'>Insert Image</div></div><input type='file' class='input-upload' name='input-image' accept='image/*' /></div><div class='btn btn-insert-text'>Insert Text</div></div></div>";
                contentGroup.after(element);
                clearInputFile(thisElement);
			};
			reader.readAsDataURL(this.files[0]);
		} else {
			previewElement.removeAttr("src");
		}
    });

    $(document).on("click", ".btn-delete-text", function() {
        if (confirm("Delete Text?")) {
            $(this).closest(".content-group").remove();
        }
    });

    $(document).on("click", ".btn-delete-article-image", function() {
        if (confirm("Delete Image?")) {
            $(this).closest(".content-group").remove();
        }
    });

    $(".btn-submit").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            $(".error").html("");
            var valid = true;
            var judul = $(".input-judul").val().trim();
            if (judul == "") {
                valid = false;
                $(".error-judul").html("harus diisi");
                showNotification("Judul harus diisi");
            }

            if (valid) {
                if (confirm("Submit Article?")) {
                    $(this).addClass("disabled");
                    var contentType = "";
                    var contentCtr = 0;
                    $(".content-group").each(function() {
                        if (contentType != "") {
                            contentType += ";";
                        }

                        if ($(this).hasClass("content-group-text")) {
                            contentType += "text";
                            $(this).find(".insert-content-text").attr("name", "content_" + contentCtr);
                        } else {
                            contentType += "image";
                            $(this).find(".article-image").attr("name", "content_" + contentCtr);
                        }
                        contentCtr++;
                    });
                    $(".content-type").val(contentType);
                    $(".form-insert").submit();
                    showLoader();
                }
            }
        }
    });

    $(".btn-delete-article").on("click", function() {
        if (confirm("Delete Article?")) {
            $(this).addClass("disabled");
            $(this).closest(".form-delete").submit();
            showLoader();
        }
    });
});

HTMLTextAreaElement.prototype.insertAtCaret = function (text) {
    text = text || '';
    if (document.selection) {
        // IE
        this.focus();
        var sel = document.selection.createRange();
        sel.text = text;
    } else if (this.selectionStart || this.selectionStart === 0) {
        // Others
        var startPos = this.selectionStart;
        var endPos = this.selectionEnd;
        this.value = this.value.substring(0, startPos) +
        text +
        this.value.substring(endPos, this.value.length);
        this.selectionStart = startPos + text.length;
        this.selectionEnd = startPos + text.length;
    } else {
        this.value += text;
    }
};