var weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
var ctr_itinerary = 0;
var itinerary_count = 0;

$(function() {
    $(document).on("change", ".input-date-start, .input-date-end", function() {
        checkDateValid(this);
    });

    $(".select-jenis-tour").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-jenis-tour").val(value);
    });

    $(".btn-add-tanggal").on("click", function() {
        var tanggal_count = parseInt($("input[name='tanggal_count']").val());
        tanggal_count++;
        var element = "<div class='tanggal-inner-container'>";
        element += "<div class='form-item-inline'>";
        element += "<div class='form-label-inline'>Mulai Tanggal</div>";
        element += "<input type='text' name='date_start_" + tanggal_count + "' class='form-input input-date-start' maxlength='10' data-type='date' />";
        element += "</div>";
        element += "<div class='form-item-inline'>";
        element += "<div class='form-label-inline'>Sampai Tanggal</div>";
        element += "<input type='text' name='date_end_" + tanggal_count + "' class='form-input input-date-end' maxlength='10' data-type='date' />";
        element += "</div>";
        element += "<div class='btn btn-negative btn-delete-tanggal'>Delete</div>";
        element += "</div>";

        $(".tanggal-container").append(element);
        $("input[name='tanggal_count']").val(tanggal_count);

        $(".input-date-start[name='date_start_" + tanggal_count + "']").datepicker({
            dateFormat: "dd-mm-yy"
        });
    
        $(".input-date-end[name='date_end_" + tanggal_count + "']").datepicker({
            dateFormat: "dd-mm-yy"
        });
    });

    $(document).on("click", ".btn-delete-tanggal", function() {
        $(this).closest(".tanggal-inner-container").remove();
        var tanggal_count = parseInt($("input[name='tanggal_count']").val());
        tanggal_count--;
        $("input[name='tanggal_count']").val(tanggal_count);

        for (var i = 1; i < tanggal_count; i++) {
            var item = $(".tanggal-inner-container").eq(i);
            item.find(".input-date-start").attr("name", "date_start_" + (i + 1));
            item.find(".input-date-end").attr("name", "date_end_" + (i + 1));
        }
    });

    $(document).on("valueChanged", ".select-kurs", function() {
        var value = $(this).attr("data-value");
        $(this).find(".kurs-value").val(value);
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

    $(".dialog-add-itinerary").on("dialogClosed", function() {
        var dataType = $(this).attr("data-type");
        if (dataType == "edit") {
            clearDialogItinerary();
        }
    });

    $(".btn-add-itinerary").on("click", function() {
        var dialogAddItinerary = $(".dialog-add-itinerary");
        dialogAddItinerary.attr("data-type", "add");
        dialogAddItinerary.attr("data-source", "insert");
        dialogAddItinerary.find(".dialog-title").html("Add Itinerary");
        dialogAddItinerary.find(".btn-dialog-save-itinerary").html("Add");
        showDialog(dialogAddItinerary);
    });

    $(".dialog-add-itinerary").on("dialogShown", function() {
        $(this).find(".dialog-text").scrollTop(0);
    });

    $(".itinerary-input-upload").on("change", function() {
        var formRight = $(this).closest(".form-right");
		var previewElement = formRight.find(".image-preview");
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                formRight.addClass("image-added");
				previewElement.attr("src", e.target.result);
			};
            reader.readAsDataURL(this.files[0]);
            var count = parseInt($(".add-itinerary-image-count").val()) + 1;
            $(".add-itinerary-image-count").val(count);
		}
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

    $(".btn-delete-tour-group-image").on("click", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var input = formRight.find(".input-upload");
        clearInputFile(input[0]);
        $(".tour-group-image-input").val("");
        previewElement.removeAttr("src");
        formRight.removeClass("image-added");
    });

    $(".btn-dialog-save-itinerary").on("click", function() {
        var valid = true;
        var date = $(".input-add-itinerary-day").val();
        var place = $(".input-add-itinerary-place").val().trim();
        var remarks = $(".input-add-itinerary-remarks").val().trim();
        var imagePosition = $(".select-position").attr("data-value");

        if (date == "") {
            valid = false;
            showNotification("Hari Ke harus diisi");
        } else if (place == "") {
            valid = false;
            showNotification("Tempat harus diisi");
        } else if (remarks == "") {
            valid = false;
            showNotification("Remarks harus diisi");
        } else {
            ctr_itinerary++;

            var currentDay = parseInt(date);

            var itinerary_image_count = 0;
            var selectPosition = $(".select-position").attr("data-value");
            var element = "";
            element += "<div class='itinerary-hidden-item' data-ctr='" + ctr_itinerary + "'>";
            element += "<div class='itinerary-hidden-item-date'>Hari ke " + date + "</div>";
            element += "<div class='btn btn-edit-itinerary'>View / Edit</div>";
            element += "<div class='btn btn-negative btn-remove-itinerary'>Remove</div>";
            element += "<input type='hidden' name='itinerary_date' value='" + date + "' />";
            element += "<input type='hidden' name='itinerary_place' value='" + place + "' />";
            element += "<input type='hidden' name='itinerary_remarks' value='" + remarks + "' />";
            element += "<input type='hidden' name='itinerary_image_position' value='" + selectPosition + "' />";
            $(".dialog-add-itinerary .image-preview").each(function() {
                var src = $(this).attr("src");
                if (src != undefined) {
                    element += "<input type='hidden' class='itinerary-image' value='" + src + "' />";
                    itinerary_image_count++;
                }
            });
            element += "<input type='hidden' name='itinerary_image_count' value='" + itinerary_image_count + "' />";
            element += "</div>";

            var done = true;
            var dialogAddItinerary = $(".dialog-add-itinerary");
            var dataType = dialogAddItinerary.attr("data-type");
            if (dataType == "edit") {
                if (confirm('Simpan Perubahan Itinerary?')) {
                    var dataCtr = dialogAddItinerary.attr("data-ctr");
                    $(".itinerary-hidden-item[data-ctr='" + dataCtr + "']").remove();
                } else {
                    done = false;
                }
            } else {
                itinerary_count++;
                $(".itinerary-count").val(itinerary_count);
            }

            if (done) {
                var afterElement = null;
                $(".itinerary-hidden-item").each(function() {
                    var day = parseInt($(this).find("input[name='itinerary_date']").val());

                    if (currentDay > day) {
                        afterElement = $(this);
                    } else {
                        return false;
                    }
                });
                
                if (afterElement == null) {
                    $(".itinerary-container").prepend(element);
                } else {
                    afterElement.after(element);
                }

                closeDialog($(".dialog-add-itinerary"));
                clearDialogItinerary();
            }
        }
    });

    $(document).on("click", ".btn-edit-itinerary", function() {
        var itineraryHiddenItem = $(this).closest(".itinerary-hidden-item");
        var ctr = itineraryHiddenItem.attr("data-ctr");
        var dialogAddItinerary = $(".dialog-add-itinerary");
        dialogAddItinerary.attr("data-type", "edit");
        dialogAddItinerary.attr("data-source", "insert");
        dialogAddItinerary.attr("data-ctr", ctr);
        dialogAddItinerary.find(".dialog-title").html("Edit Itinerary");

        var date = itineraryHiddenItem.find("input[name='itinerary_date']").val();
        var remarks = itineraryHiddenItem.find("input[name='itinerary_remarks']").val();
        var imagePosition = itineraryHiddenItem.find("input[name='itinerary_image_position']").val();
        dialogAddItinerary.find(".input-add-itinerary-date").val(date);
        dialogAddItinerary.find(".input-add-itinerary-remarks").val(remarks);
        setSelectValue($(".select-position"), imagePosition);

        var itineraryImageCtr = 0;
        itineraryHiddenItem.find(".itinerary-image").each(function() {
            var formRight = dialogAddItinerary.find(".form-right").eq(itineraryImageCtr);
            formRight.addClass("image-added");
            formRight.find(".image-preview").attr("src", this.value);
            itineraryImageCtr++;
        });

        dialogAddItinerary.find(".btn-dialog-save-itinerary").html("Save");

        showDialog(dialogAddItinerary);
    });

    $(document).on("click", ".btn-remove-itinerary", function() {
        var itineraryHiddenItem = $(this).closest(".itinerary-hidden-item");
        if (confirm('Remove Itinerary?')) {
            itineraryHiddenItem.remove();
            itinerary_count--;
            $(".itinerary-count").val(itinerary_count);
        }
    });

    $(".btn-insert-tour-group").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var title = $(".input-judul").val().trim();
            var description = $(".input-description").val().trim();
            var rute = $(".input-rute").val().trim();
            var durasi = $(".input-durasi").val().trim();
            var harga_count = parseInt($("input[name='harga_count']").val());
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
            } else if (description == "") {
                valid = false;
                showNotification("Deskripsi harus diisi");
            } else if (rute == "") {
                valid = false;
                showNotification("Rute harus diisi");
            } else if (durasi == "") {
                valid = false;
                showNotification("Durasi harus diisi");
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
                if (confirm('Insert Tour Package?')) {
                    $(this).addClass("disabled");
                    
                    $(".input-harga").each(function() {
                        var value = removeThousandSeparator($(this).val());
                        $(this).val(value);
                    });

                    for (var i = 0; i < itinerary_count; i++) {
                        var itinerary_hidden_item = $(".itinerary-hidden-item").eq(i);
                        itinerary_hidden_item.find("input[name='itinerary_date']").attr("name", "itinerary_date_" + (i + 1));
                        itinerary_hidden_item.find("input[name='itinerary_place']").attr("name", "itinerary_place_" + (i + 1));
                        itinerary_hidden_item.find("input[name='itinerary_remarks']").attr("name", "itinerary_remarks_" + (i + 1));
                        itinerary_hidden_item.find("input[name='itinerary_image_position']").attr("name", "itinerary_image_position_" + (i + 1));
                        itinerary_hidden_item.find("input[name='itinerary_image_count']").attr("name", "itinerary_image_count_" + (i + 1));
                        
                        var image_count = 0;
                        itinerary_hidden_item.find(".itinerary-image").each(function() {
                            image_count++;
                            $(this).attr("name", "itinerary_image_" + (i + 1) + "_" + image_count);
                        });
                    }

                    $("input[type='file']").each(function() {
                        clearInputFile(this);
                    });
                    
                    $(".form-insert").submit();
                    showLoader();
                }
            }
        }
    });

    $(document).on("click", ".btn-delete-tour-package", function() {
        var nama = $(this).closest(".tour-group-item").find(".tour-group-item-nama").html();
        if (confirm("Yakin mau delete tour package " + nama + "?")) {
            $(this).closest(".form-delete-tour-package").submit();
        }
    });
});

function script1onload() {
    $(".input-date-start").datepicker({
        dateFormat: "dd-mm-yy"
    });

    $(".input-date-end").datepicker({
        dateFormat: "dd-mm-yy"
    });
}

function checkDateValid(element) {
    var value = $(element).val().trim();
    if (value != "") {
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
    } else {
        $(element).removeClass("has-error");
    }
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