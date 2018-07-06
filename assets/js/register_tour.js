$(function() {
    $(".select-month").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-month").val(value);
    });

    $(".select-year").on("valueChanged", function() {
        var value = $(this).attr("data-value");
        $(".input-year").val(value);
    });

    $(".btn-search").on("click", function() {
        $(".form-search").submit();
    });
});