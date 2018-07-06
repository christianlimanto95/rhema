$(function() {
    $(".btn-insert").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var name = $(".input-insert-name").val().trim();
            if (name == "") {
                valid = false;
                $(".error-insert-name").html("is Required");
                showNotification("Name is Required");
            }

            if (valid) {
                $(this).addClass("disabled");
                $(".form-insert").submit();
                showLoader();
            } else {
                e.preventDefault();
            }
        }
    });

    $(document).on("click", ".btn-update", function() {
        var dialogUpdate = $(".dialog-update");
        var item = $(this).closest(".item");
        var id = item.attr("data-id");
        var nama = item.attr("data-nama");
        $(".dialog-update-id").val(id);
        $(".input-name-update").val(nama);
        showDialog(dialogUpdate);
    });
    
    $(".btn-dialog-save").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            var valid = true;
            var name = $(".input-name-update").val().trim();
            if (name == "") {
                valid = false;
                showNotification("Name is Required");
            }

            if (valid) {
                $(this).addClass("disabled");
                $(".form-update").submit();
                showLoader();
            }
        }
    });

    $(document).on("click", ".btn-delete", function() {
        var dialogDelete = $(".dialog-delete");
        var item = $(this).closest(".item");
        var id = item.attr("data-id");
        var nama = item.attr("data-nama");
        $(".dialog-delete-id").val(id);
        dialogDelete.find(".dialog-text").html("Yakin mau hapus " + nama + "?");
        showDialog(dialogDelete);
    });

    $(".btn-dialog-delete").on("click", function() {
        if (!$(this).hasClass("disabled")) {
            $(this).addClass("disabled");
            $(".form-delete").submit();
            showLoader();
        }
    });
});