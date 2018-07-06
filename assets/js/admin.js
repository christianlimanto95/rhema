$(function() {
    $(document).on("click", ".btn-follow-up", function() {
        if (!$(this).hasClass("disabled")) {
            var form = $(this).closest(".form-follow-up");
            var url = form.attr("action");
            var tp_kodePeserta = form.find("[name='tp_kodePeserta']").val();
            $(this).addClass("disabled");
            showLoader();
            (function(button) {
                ajaxCall(url, {tp_kodePeserta: tp_kodePeserta}, function(json) {
                    hideLoader();
                    var result = jQuery.parseJSON(json);
                    if (result.status == "success") {
                        button.remove();
                    } else {
                        button.removeClass("disabled");
                    }
                });
            }($(this)));
        }
    });
});