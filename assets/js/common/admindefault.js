$(function() {
    $(document).on("keydown", "input[data-type='number']", function(e) {
        isNumber(e);
    });

    $(document).on("keydown", "input[data-type='date']", function(e) {
        isNumberWithDash(e);
    });

    $(document).on("input", "input[data-thousand-separator='true']", function() {
        var value = parseInt(removeThousandSeparator($(this).val()));
        if (isNaN(value)) {
            value = 0;
        }
        $(this).val(addCommas(value + ""));
    });

    $(document).on("click", ".radio-container", function() {
        var value = $(this).attr("data-value");
        var name = $(this).attr("data-name");
        $(".radio-container[data-name='" + name + "']").removeClass("active");
        $(".radio-container[data-name='" + name + "'] .radio-text-additional-input").prop("readonly", true);
        $(".radio-input[data-name='" + name + "']").val(value);
        $(this).addClass("active");
        $(this).find(".radio-text-additional-input").prop("readonly", false).focus();
        $(this).trigger("radioEnabled");
    });

    $(document).on("click", ".checkbox-container", function() {
        if (!$(this).hasClass("active")) {
            $(this).addClass("active");
            $(this).find(".checkbox-text-additional-input").prop("readonly", false).focus();
            $(this).trigger("checkboxEnabled");
        } else {
            $(this).removeClass("active");
            $(this).find(".checkbox-text-additional-input").prop("readonly", true);
            $(this).trigger("checkboxDisabled");
        }
    });
    
    $(document).on("click", ".select", function(e) {
        var type = $(this).data("type");
        var selectedDropdown = $(this).find(".dropdown-container");
        
        if (selectedDropdown.hasClass("show")) {
            selectedDropdown.removeClass("show");
        } else {
            selectedDropdown.addClass("show");
        }
        
        e.stopPropagation();
    });

    $(document).on("click", ".admin-menu-icon", function(e) {
        if ($(".admin-menu-container").hasClass("show")) {
            $(".admin-menu-container").removeClass("show");
        } else {
            $(".admin-menu-container").addClass("show");
        }
        e.stopPropagation();
    });

    $(document).on("click", ".dropdown-item", function(e) {
        var select = $(this).closest(".select");
        var data = [].filter.call(this.attributes, function(at) { return /^data-/.test(at.name); });
        var iLength = data.length;
        for (var i = 0; i < iLength; i++) {
            select.attr(data[i].name, data[i].value);
        }
        var text = $(this).html();
        select.find(".select-text").html(text);
        select.trigger("valueChanged");

        var dropdownContainer = $(this).parent();
        dropdownContainer.removeClass("show");
        e.stopPropagation();
    });

    $(document).on("click", function(e) {
        var target = $(e.target);
        if (target.closest(".dropdown-container").length == 0) {
            $(".dropdown-container").removeClass("show");
        }
        if (target.closest(".admin-menu-container").length == 0) {
            $(".admin-menu-container").removeClass("show");
        }
    });

    $(document).on("click", ".dialog-close-icon, .btn-dialog-cancel", function() {
        var dialogElement = $(this).closest(".dialog");
        closeDialog(dialogElement);
    });

    $(window).on("keydown", function(e) {
        switch (e.which) {
            case 27: // ESC
                closeDialog();
                break;
        }
    });
});

function isNumber(e) {
	if (e.key.length == 1) {
		if ("0123456789".indexOf(e.key) < 0) {
			e.preventDefault();
		}
	}
}

function isNumberWithDash(e) {
	if (e.key.length == 1) {
		if ("0123456789-".indexOf(e.key) < 0) {
			e.preventDefault();
		}
	}
}

function addCommas(nStr) {
    nStr = nStr.replace(/,/g, "");
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2');
    }
    return x1 + x2;
}

function removeThousandSeparator(str) {
    return str.replace(/\./g,'');
}

function clearInputFile(input) {
    input.value = ''

    if (!/safari/i.test(navigator.userAgent)) {
        input.type = ''
        input.type = 'file'
    }
}

function setSelectValue(select, value) {
    var dropdownItem = select.find(".dropdown-item[data-value='" + value + "']")[0];
    var data = [].filter.call(dropdownItem.attributes, function(at) { return /^data-/.test(at.name); });
    var iLength = data.length;
    for (var i = 0; i < iLength; i++) {
        select.attr(data[i].name, data[i].value);
    }
    var text = $(dropdownItem).html();
    select.find(".select-text").html(text);
    select.trigger("valueChanged");
}

function showDialog(dialogElement) {
    dialogElement.addClass("show");
    dialogElement.trigger("dialogShown");
}

function closeDialog(element) {
    if (element == null) {
        element = $(".dialog");
    }
    element.removeClass("show");
    element.trigger("dialogClosed");
}

function removeAllErrors() {
    $(".error").html("");
}

function showLoader() {
    $(".loader").addClass("show");
}

function hideLoader() {
    $(".loader").removeClass("show");
}

function showNotification(text) {
    var notification = $(".notification");
    notification.html(text);
    notification.off("webkitAnimationEnd oanimationend msAnimationEnd animationend");
    notification.one("webkitAnimationEnd oanimationend msAnimationEnd animationend", function(e) {
        notification.removeClass("showing");
    });

    notification.removeClass("showing");
    setTimeout(function() {
        notification.addClass("showing");
    }, 1);
}

function ajaxCall(url, data, callback) {
	return $.ajax({
		url: url,
		data: data,
		type: 'POST',
		error: function(jqXHR, exception) {
			if (exception != "abort") {
				console.log(jqXHR + " : " + jqXHR.responseText);
			}
		},
		success: function(result) {
			callback(result);
		}
	});
}