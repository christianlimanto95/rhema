$(function() {
    var src = $(".tour-group-image-preview").attr("src");
    if (src != undefined) {
        toDataURL(src, function(dataUrl) {
            $(".tour-group-image-input").val(dataUrl);
        });
    }

    $(".input-date-start, .input-date-end").on("change", function() {
        checkDateValid(this);
    });

    $(".select-jenis-tour").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-jenis-tour").val(value);
    });

    $(".btn-add-harga").on("click", function() {
        var harga_count = parseInt($("input[name='harga_count']").val());
        harga_count++;
        var element = "<div class='harga-item'>";
        element += "<input type='text' name='harga_" + harga_count + "' class='form-input input-harga' data-type='number' data-thousand-separator='true' maxlength='15' value='0' />";
        element += " <div class='select select-kurs' data-type='kurs' data-value='usd'>";
        element += "<input type='hidden' class='kurs-value' name='kurs_" + harga_count + "' value='usd' />";
        element += "<div class='select-text'>USD</div>";
        element += "<div class='dropdown-container dropdown-container-kurs' data-type='kurs'>";
        element += "<div class='dropdown-item' data-value='usd'>USD</div>";
        element += "<div class='dropdown-item' data-value='idr'>IDR</div>";
        element += "</div>";
        element += "</div>";
        element += " <input type='text' name='harga_remarks_" + harga_count + "' class='form-input input-harga-remarks' maxlength='25' />";
        element += " <div class='btn btn-negative btn-delete-harga'>Delete</div>";
        element += "</div>";

        $(".harga-container").append(element);
        $("input[name='harga_count']").val(harga_count);
    });

    $(document).on("click", ".btn-delete-harga", function() {
        $(this).closest(".harga-item").remove();
        var harga_count = parseInt($("input[name='harga_count']").val());
        harga_count--;
        $("input[name='harga_count']").val(harga_count);

        for (var i = 1; i < harga_count; i++) {
            var item = $(".harga-item").eq(i);
            item.find(".input-harga").attr("name", "harga_" + (i + 1));
            item.find(".kurs-value").attr("name", "kurs_" + (i + 1));
            item.find(".input-harga-remarks").attr("name", "harga_remarks_" + (i + 1));
        }
    });

    $(".checkbox-container").on("checkboxEnabled", function() {
        var name = $(this).attr("data-name");
        var element = null;
        if (name == "highlight") {
            element = $("input[name='tour_highlight']");
        } else if (name == "bonus") {
            element = $("input[name='tour_bonus']");
        }
        var currentValue = element.val();
        if (currentValue != "") {
            currentValue += ";";
        }
        currentValue += $(this).attr("data-value");
        element.val(currentValue);
    });

    $(".checkbox-container").on("checkboxDisabled", function() {
        var name = $(this).attr("data-name");
        var value = $(this).attr("data-value");
        var element = null;
        if (name == "highlight") {
            element = $("input[name='tour_highlight']");
        } else if (name == "bonus") {
            element = $("input[name='tour_bonus']");
        }
        var currentValue = element.val();
        var currentValueItem = currentValue.split(";");
        currentValue = "";
        var iLength = currentValueItem.length;
        for (var i = 0; i < iLength; i++) {
            if (currentValueItem[i] != value) {
                if (currentValue != "") {
                    currentValue += ";";
                }
                currentValue += currentValueItem[i];
            }
        }

        element.val(currentValue);
    });

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

    $(".btn-add-tour-highlight").on("click", function() {
        showDialog($(".dialog-add-tour-highlight"));
    });

    $(".btn-dialog-add-tour-highlight").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var thi_nama = $(".input-add-tour-highlight").val().trim();
            if (thi_nama == "") {
                valid = false;
                showNotification("Name is Required");
            }

            if (valid) {
                $(this).addClass("disabled");
                showLoader();
                ajaxCall(add_tour_highlight_url, {thi_nama: thi_nama}, function(json) {
                    $(".btn-dialog-add-tour-highlight").removeClass("disabled");
                    hideLoader();
                    var result = jQuery.parseJSON(json);
                    if (result.status == "success") {
                        closeDialog($(".dialog-add-tour-highlight"));
                        var element = "";
                        element += "<div class='checkbox-container highlight-checkbox-container' data-name='highlight' data-value='" + result.thi_kode + "'>";
                        element += "<div class='checkbox'></div>";
                        element += "<div class='checkbox-text'>" + result.thi_nama + "</div>";
                        element += "</div>";

                        $(".form-item-tour-highlight .checkbox-outer-container").append(element);
                    }
                });
            }
        }
    });

    $(".btn-add-tour-bonus").on("click", function() {
        showDialog($(".dialog-add-tour-bonus"));
    });

    $(".btn-dialog-add-tour-bonus").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var tb_nama = $(".input-add-tour-bonus").val().trim();
            if (tb_nama == "") {
                valid = false;
                showNotification("Name is Required");
            }

            if (valid) {
                $(this).addClass("disabled");
                showLoader();
                ajaxCall(add_tour_bonus_url, {tb_nama: tb_nama}, function(json) {
                    $(".btn-dialog-add-tour-bonus").removeClass("disabled");
                    hideLoader();
                    var result = jQuery.parseJSON(json);
                    if (result.status == "success") {
                        closeDialog($(".dialog-add-tour-bonus"));
                        var element = "";
                        element += "<div class='checkbox-container bonus-checkbox-container' data-name='bonus' data-value='" + result.tb_kode + "'>";
                        element += "<div class='checkbox'></div>";
                        element += "<div class='checkbox-text'>" + result.tb_nama + "</div>";
                        element += "</div>";

                        $(".form-item-tour-bonus .checkbox-outer-container").append(element);
                    }
                });
            }
        }
    });

    $(".btn-update-tour-group").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var title = $(".input-judul").val().trim();
            var date_start = $(".input-date-start").val();
            var date_end = $(".input-date-end").val();
            var rute = $(".input-rute").val().trim();
            var harga = parseInt(removeThousandSeparator($(".input-harga[name='harga_1']").val()));
            var pembimbing = $(".input-pembimbing").val().trim();
            var include_pax = $(".input-include-pax").val();
            var exclude_pax = $(".input-exclude-pax").val();
            var responsibility = $(".input-responsibility").val();
            var cp_name_1 = $(".input-cp-name-1").val().trim();
            var cp_hp_1 = $(".input-cp-hp-1").val().trim();
            var cp_email_1 = $(".input-cp-email-1").val().trim();
            var cp_name_2 = $(".input-cp-name-1").val().trim();
            var cp_hp_2 = $(".input-cp-hp-1").val().trim();
            var cp_email_2 = $(".input-cp-email-1").val().trim();

            if (title == "") {
                valid = false;
                showNotification("Judul harus diisi");
            } else if (date_start == "") {
                valid = false;
                showNotification("Mulai Tanggal harus diisi");
            } else if (!checkDateValid($(".input-date-start")[0])) {
                valid = false;
                showNotification("Format Mulai Tanggal belum benar");
            } else if (date_end == "") {
                valid = false;
                showNotification("Berakhir Tanggal harus diisi");
            } else if (!checkDateValid($(".input-date-end")[0])) {
                valid = false;
                showNotification("Format Berakhir Tanggal belum benar");
            } else if (rute == "") {
                valid = false;
                showNotification("Rute harus diisi");
            } else if (harga == 0) {
                valid = false;
                showNotification("Harga harus lebih besar dari 0");
            } else if (cp_name_1 == "") {
                valid = false;
                showNotification("Nama CP 1 harus diisi");
            } else if (cp_hp_1 == "") {
                valid = false;
                showNotification("No. Handphone CP 1 harus diisi");
            } else if (cp_email_1 == "") {
                valid = false;
                showNotification("Email CP 1 harus diisi");
            }
            
            
            if (valid) {
                if (confirm('Simpan Perubahan?')) {
                    $(this).addClass("disabled");

                    $(".input-harga").each(function() {
                        var value = removeThousandSeparator($(this).val());
                        $(this).val(value);
                    });

                    $("input[type='file']").each(function() {
                        clearInputFile(this);
                    });
                    
                    $(".form-update").submit();
                    showLoader();
                }
            }
        }
    });

    $(".dialog-add-itinerary").on("dialogShown", function() {
        this.getElementsByClassName("dialog-text")[0].scrollTop = 0;
    });

    $(".dialog-add-itinerary").on("dialogClosed", function() {
        var data_type = $(this).attr("data-type");
        if (data_type == "edit") {
            $(".form-insert-itinerary").attr("action", insert_itinerary_url);
            $(this).attr("data-type", "add");
            $(this).find(".dialog-title").html("Add Itinerary");
            $(this).find(".btn-dialog-save-itinerary").html("Add");
            clearDialogItinerary();
        }
    });

    $(".btn-edit-itinerary").on("click", function() {
        var id = $(this).closest(".itinerary-item").attr("data-id");
        var iLength = itinerary_arr.length;
        for (var i = 0; i < iLength; i++) {
            var current_id = itinerary_arr[i].id;
            if (current_id == id) {
                $(".form-insert-itinerary").attr("action", update_itinerary_url);
                var dialogAddItinerary = $(".dialog-add-itinerary");
                dialogAddItinerary.attr("data-type", "edit");
                dialogAddItinerary.attr("data-source", "insert");
                dialogAddItinerary.find(".dialog-title").html("Edit Itinerary");
                dialogAddItinerary.find("input[name='tgi_kode']").val(id);
                dialogAddItinerary.find(".btn-dialog-save-itinerary").html("Save");

                $(".input-add-itinerary-date").val(itinerary_arr[i].date);
                $(".input-add-itinerary-place").val(itinerary_arr[i].place);
                $(".input-add-itinerary-remarks").val(itinerary_arr[i].remarks);
                setSelectValue($(".select-position"), itinerary_arr[i].image_position);

                var image_count = parseInt(itinerary_arr[i].image_count);
                $(".add-itinerary-image-count").val(image_count);
                for (var j = 1; j <= image_count; j++) {
                    dialogAddItinerary.find(".form-right").eq(j - 1).addClass("image-added");
                    var src = itinerary_image_src + "itinerary_image_" + id + "_" + j + "." + itinerary_arr[i]["image_" + j + "_extension"] + "?d=" + itinerary_arr[i].modified_date;
                    toDataURL(src, function(dataUrl, index) {
                        $(".image-preview-" + index).attr("src", dataUrl);
                        $("input[name='itinerary_image_" + index + "']").val(dataUrl);
                    }, j);
                }

                showDialog(dialogAddItinerary);
                break;
            }
        }
    });

    $(".btn-add-itinerary").on("click", function() {
        var dialogAddItinerary = $(".dialog-add-itinerary");
        $(".form-insert-itinerary").attr("action", insert_itinerary_url);
        dialogAddItinerary.attr("data-type", "add");
        dialogAddItinerary.attr("data-source", "insert");
        dialogAddItinerary.find(".dialog-title").html("Add Itinerary");
        dialogAddItinerary.find(".btn-dialog-save-itinerary").html("Add");
        showDialog(dialogAddItinerary);
    });

    $(".select-position").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-image-position").val(value);
    });

    $(".itinerary-input-upload").on("change", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var itineraryImageInput = formRight.find(".itinerary-image");
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                formRight.addClass("image-added");
                previewElement.attr("src", e.target.result);
                itineraryImageInput.val(e.target.result);
			};
            reader.readAsDataURL(this.files[0]);
            var count = parseInt($(".add-itinerary-image-count").val()) + 1;
            $(".add-itinerary-image-count").val(count);
		}
    });

    $(".btn-delete-itinerary-image").on("click", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var input = formRight.find(".input-upload");
        clearInputFile(input[0]);
        previewElement.removeAttr("src");
        formRight.removeClass("image-added");
        var count = parseInt($(".add-itinerary-image-count").val()) - 1;
        $(".add-itinerary-image-count").val(count);
    });

    $(".btn-dialog-save-itinerary").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var date = $(".input-add-itinerary-date").val();
            var place = $(".input-add-itinerary-place").val().trim();
            var remarks = $(".input-add-itinerary-remarks").val().trim();
            var imagePosition = $(".select-position").attr("data-value");

            if (date == "") {
                valid = false;
                showNotification("Date is Required");
            } else if (place == "") {
                valid = false;
                showNotification("Place is Required");
            } else if (remarks == "") {
                valid = false;
                showNotification("Remarks is Required");
            } else {
                var type = $(".dialog-add-itinerary").attr("data-type");
                if (type == "add") {
                    if (confirm("Add Itinerary?")) {
                        $(this).addClass("disabled");
                        $(".form-insert-itinerary").submit();
                        showLoader();
                    }
                } else {
                    if (confirm("Save Itinerary?")) {
                        $(this).addClass("disabled");
                        $(".form-insert-itinerary").submit();
                        showLoader();
                    }
                }
            }
        }
    });

    $(".btn-delete-itinerary").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            if (confirm("Delete Itinerary?")) {
                $(this).addClass("disabled");
                $(this).closest(".form-delete-itinerary").submit();
                showLoader();
            }
        }
    });
});

function script1onload() {
    $(".input-add-itinerary-date").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $(".input-date-start").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $(".input-date-end").datepicker({
        dateFormat: "dd-mm-yy"
    });
}

function checkDateValid(element) {
    var value = $(element).val();
    var validity = false;
    if (value.indexOf("-") != -1) {
        var dateItem = value.split("-");
        if (dateItem.length == 3) {
            var date = parseInt(dateItem[0]);
            var month = parseInt(dateItem[1]);
            var year = parseInt(dateItem[2]);

            if (!isNaN(date) && date >= 1 && date <= 31 && !isNaN(month) && month >= 1 && month <= 12 && year >= 1000 && year <= 9999) {
                validity = true;
            }
        }
    }

    if (!validity) {
        $(element).addClass("has-error");
    } else {
        $(element).removeClass("has-error");
    }

    return validity;
}

function clearDialogItinerary() {
    var dialogAddItinerary = $(".dialog-add-itinerary");
    $(".input-add-itinerary-date").val("");
    $(".input-add-itinerary-place").val("");
    $(".input-add-itinerary-remarks").val("");
    setSelectValue($(".select-position"), "1");
    dialogAddItinerary.find(".image-preview").removeAttr("src");
    dialogAddItinerary.find(".form-right").removeClass("image-added");
    dialogAddItinerary.find(".input-upload").each(function() {
        clearInputFile(this);
    });
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