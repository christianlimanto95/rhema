$(function() {
    $(".select-date").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $("input[name='tpd_kode']").val(value);
    });

    $(".btn-tambah-no-hp").on("click", function() {
        var element = "<input type='text' class='form-input-inline input-hp' maxlength='20' data-type='number' />";
        $(".input-hp-container").append(element);
        $(".input-hp:nth-last-child(1)").focus();
    });

    $(".input-date").on("input", function() {
        var value = parseInt($(this).val());
        if (value > 31) {
            $(this).addClass("input-error");
        } else {
            $(this).removeClass("input-error");
        }
    });

    $(".input-month").on("input", function() {
        var value = parseInt($(this).val());
        if (value > 12) {
            $(this).addClass("input-error");
        } else {
            $(this).removeClass("input-error");
        }
    });

    $(".input-year").on("input", function() {
        var value = $(this).val();
        if (value.length == 4) {
            $(this).removeClass("input-error");
        }
    });

    $(".input-year").on("blur", function() {
        var value = $(this).val();
        if (value.length > 0 && value.length < 4) {
            $(this).addClass("input-error");
        } else {
            $(this).removeClass("input-error");
        }
    });

    $(".radio-container").on("selected", function() {
        var name = $(this).attr("data-name");
        var value = $(this).attr("data-value");
        $(".input-" + name).val(value);

        $(this).siblings(".error").html("");
    });

    $(".input-upload-foto-passport").on("change", function() {
        var formRight = $(this).closest(".form-right");
		var previewElement = formRight.find(".image-preview");
		if (this.files.length > 0) {
			var reader = new FileReader();
			reader.onload = function(e) {
                formRight.addClass("image-added");
                previewElement.attr("src", e.target.result);
                $(".input-foto-passport").val(e.target.result);
			};
            reader.readAsDataURL(this.files[0]);
		}
    });

    $(".btn-delete-image").on("click", function() {
        var formRight = $(this).closest(".form-right");
        var previewElement = formRight.find(".image-preview");
        var input = formRight.find(".input-upload");
        clearInputFile(input[0]);
        $(".input-foto-passport").val("");
        previewElement.removeAttr("src");
        formRight.removeClass("image-added");
    });

    $(".btn-register").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            clearAllErrors();
            var valid = true;

            var email = $(".input-email").val().trim();
            var namaDepan = $(".input-nama-depan").val().trim();
            //var namaBelakang = $(".input-nama-belakang").val().trim();
            var jk = $(".input-jk").val();
            /*var gd = $(".input-gd").val();
            var namaAyah = $(".input-nama-ayah").val().trim();
            var namaIbu = $(".input-nama-ibu").val().trim();
            var namaKakek = $(".input-nama-kakek").val().trim();
            var passport = $(".input-passport").val().trim();*/
            //var tempatLahir = $(".input-tempat-lahir").val().trim();
            var hp = $(".input-hp").val().trim();
            //var alamatRumah = $(".input-address").val().trim();
            /*var teleponRumah = $(".input-phone").val().trim();
            var statusPerkawinan = $(".input-status").val();
            var istriSuami = $(".input-istri-suami").val().trim();*/

            if (email == "") {
                valid = false;
                $(".input-email").addClass("input-error");
                $(".error-email").html("Email harus diisi");
            }

            if (namaDepan == "") {
                valid = false;
                $(".input-nama-depan").addClass("input-error");
                $(".error-nama-depan").html("Nama harus diisi");
            }

            if (jk == "") {
                valid = false;
                $(".error-jk").html("Pilih Jenis Kelamin");
            }

            /*if (gd == "") {
                valid = false;
                $(".error-gd").html("Pilih Golongan Darah");
            }

            if (namaAyah == "") {
                valid = false;
                $(".input-nama-ayah").addClass("input-error");
                $(".error-nama-ayah").html("Nama Ayah harus diisi");
            }

            if (namaIbu == "") {
                valid = false;
                $(".input-nama-ibu").addClass("input-error");
                $(".error-nama-ibu").html("Nama Ibu harus diisi");
            }

            if (namaKakek == "") {
                valid = false;
                $(".input-nama-kakek").addClass("input-error");
                $(".error-nama-kakek").html("Nama Kakek harus diisi");
            }

            if (passport == "") {
                valid = false;
                $(".input-passport").addClass("input-error");
                $(".error-passport").html("No. Paspor harus diisi");
            }

            if (tempatLahir == "") {
                valid = false;
                $(".input-tempat-lahir").addClass("input-error");
                $(".error-tempat-lahir").html("Tempat Lahir harus diisi");
            }*/

            if (hp == "") {
                valid = false;
                $(".input-hp").addClass("input-error");
                $(".error-hp").html("No. HP harus diisi");
            }

            /*if (alamatRumah == "") {
                valid = false;
                $(".input-address").addClass("input-error");
                $(".error-address").html("Alamat Rumah harus diisi");
            }

            if (teleponRumah == "") {
                valid = false;
                $(".input-phone").addClass("input-error");
                $(".error-phone").html("Telepon Rumah harus diisi");
            }

            if (status == "") {
                valid = false;
                $(".error-status").html("Pilih Status Perkawinan");
            }

            if (istriSuami == "") {
                valid = false;
                $(".input-istri-suami").addClass("input-error");
                $(".error-istri-suami").html("Nama Istri / Suami harus diisi");
            }*/

            if (valid) {
                $(".form-value-email").html(email);
                $(".form-value-nama-depan").html(namaDepan);

                var jenisKelamin = "Laki - laki";
                if (jk == "p") {
                    jenisKelamin = "Perempuan";
                }
                $(".form-value-jenis-kelamin").html(jenisKelamin);
                $(".form-value-no-hp").html(hp);

                $(".dialog-detail").addClass("show");
            } else {
                showNotification("Silakan cek isian");
            }
        }
    });

    $(".dialog-box").on("click", function(e) {
        e.stopPropagation();
    });

    $(".dialog-close-icon, .dialog-background").on("click", function() {
        $(this).closest(".dialog").removeClass("show");
    });

    $(document).on("keydown", function(e) {
        if (e.which == 27) {
            $(".dialog").removeClass("show");
        }
    });

    $(".btn-confirm-submit").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            $(".form-daftar").submit();
        }
    });
});

function clearAllErrors() {
    $(".input-error").removeClass("input-error");
    $(".error").html("");
}