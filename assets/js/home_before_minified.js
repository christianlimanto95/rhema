var section_1_items = [];
var section_1_item_index = 1;
var isAnimating = false;
var section2;
var last_scroll_position = 0;
var header_shown = false;
var svgTriangle1, svgTriangle2, svgTriangle3, svgTriangle4, svgTriangle5, svgTriangle6, svgTriangle7, svgTriangle8;

$(function() {
    $(".section-1").addClass("show");
    initialize();

    $(".section-1-item").each(function() {
        section_1_items.push(this);
    });

    if (section_1_items.length > 1) {
        $(".carousel-circle[data-index='" + section_1_item_index + "']").addClass("active");
        carouselEventListener();
        $(".carousel-circle").on("click", function() {
            var index = parseInt($(this).attr("data-index"));
            setCarouselActive(index);
        });
        
        $(".section-1-item-left-image").on("click", function() {
            if (section_1_item_index - 1 >= 1) {
                setCarouselActive(section_1_item_index - 1);
            } else {
                setCarouselActive(section_1_items.length);
            }
        });

        $(".section-1-item-right-image").on("click", function() {
            if (section_1_item_index + 1 <= section_1_items.length) {
                setCarouselActive(section_1_item_index + 1);
            } else {
                setCarouselActive(1);
            }
        });
    }

    $(".section-1-scroll-down").on("click", function() {
        $('html, body').animate({
            scrollTop: $(".section-2").offset().top
        }, 500);
    });
    
    $(window).on("resize", function() {
        initialize();
    });
});

function initialize() {
    var triangle1 = $(".svg-triangle-border-1");
    svgTriangle1 = {
        element: triangle1,
        top_desktop: parseInt(triangle1.attr("data-desktop-top")) * vw / 100,
    };

    var triangle2 = $(".svg-triangle-border-2");
    svgTriangle2 = {
        element: triangle2,
        top_desktop: parseInt(triangle2.attr("data-desktop-top")) * vw / 100,
    };

    var triangle3 = $(".svg-triangle-border-3");
    svgTriangle3 = {
        element: triangle3,
        top_desktop: parseInt(triangle3.attr("data-desktop-top")) * vw / 100,
    };

    var triangle4 = $(".svg-triangle-border-4");
    svgTriangle4 = {
        element: triangle4,
        top_desktop: parseInt(triangle4.attr("data-desktop-top")) * vw / 100,
    };

    var triangle5 = $(".svg-triangle-1");
    svgTriangle5 = {
        element: triangle5,
        top_desktop: parseInt(triangle5.attr("data-desktop-top")) * vw / 100,
    };

    var triangle6 = $(".svg-triangle-2");
    svgTriangle6 = {
        element: triangle6,
        top_desktop: parseInt(triangle6.attr("data-desktop-top")) * vw / 100,
    };

    var triangle7 = $(".section-2-triangle-right-2");
    svgTriangle7 = {
        element: triangle7,
        top_desktop: parseInt(triangle7.attr("data-desktop-top")) * vw / 100,
    };

    var triangle8 = $(".section-2-triangle-left-2");
    svgTriangle8 = {
        element: triangle8,
        top_desktop: parseInt(triangle8.attr("data-desktop-top")) * vw / 100,
    };

    var svgRatio = vw / 1366;
    $(".svg-triangle").each(function() {
        var width = parseInt($(this).attr("data-real-width"));
        var height = parseInt($(this).attr("data-real-height"));
        $(this).attr({
            width: width * svgRatio,
            height: height * svgRatio
        });
    });

    section2 = $(".section-2");
    
    last_scroll_position = container.scrollTop();
    $(".header-fixed").removeClass("show");
    header_shown = false;
    $(window).on("scroll", checkHeaderScroll);

    container.scroll();
}

function carouselEventListener() {
    $(".carousel-circle.active").one("webkitTransitionEnd oTransitionEnd msTransitionEnd transitionend", function(e) {
        var index = parseInt($(this).attr("data-index"));
        if (index + 1 <= section_1_items.length) {
            index++;
        } else {
            index = 1;
        }
        setCarouselActive(index);
    });
}

function setCarouselActive(index) {
    var currentActive = $(".carousel-circle.active");
    var currentIndex = parseInt(currentActive.attr("data-index"));
    if (index != currentIndex && !isAnimating) {
        isAnimating = true;
        currentActive.removeClass("active").off("webkitTransitionEnd oTransitionEnd msTransitionEnd transitionend");
        $(".carousel-circle[data-index='" + index + "']").addClass("active");

        if (index > currentIndex) {
            var currentSectionActive = $(".section-1-item.active").eq(0);
            $(section_1_items[index - 1]).insertAfter($(currentSectionActive)).addClass("active");
            $(currentSectionActive).eq(0).animate({
                marginLeft: "-100vw"
            }, 500, function() {
                $(this).removeAttr("style").removeClass("active");
                section_1_item_index = index;
                isAnimating = false;
            });
        } else {
            var currentSectionActive = $(".section-1-item.active").eq(0);
            $(section_1_items[index - 1]).insertBefore(currentSectionActive).addClass("active").css({
                marginLeft: "-100vw"
            });
            $(".section-1-item.active").eq(0).animate({
                marginLeft: "0vw"
            }, 500, function() {
                currentSectionActive.removeAttr("style").removeClass("active");
                section_1_item_index = index;
                isAnimating = false;
            });
        }
        carouselEventListener();
    }
}

function checkHeaderScroll() {
    var scrollTop = container.scrollTop();
    if (scrollTop < last_scroll_position) {
        if (scrollTop >= section2.offset().top) {
            if (!header_shown) {
                $(".header-fixed").addClass("show");
                header_shown = true;
            }
        } else {
            if (header_shown) {
                $(".header-fixed").removeClass("show");
                header_shown = false;
            }
        }
    } else {
        if (header_shown) {
            $(".header-fixed").removeClass("show");
            header_shown = false;
        }
    }
    last_scroll_position = scrollTop;

    if (!isMobile) {
        var selisih = scrollTop - section2.offset().top;
        svgTriangle1.element.css({
            top: svgTriangle1.top_desktop + selisih * 0.4 + "px"
        });

        svgTriangle2.element.css({
            top: svgTriangle2.top_desktop + selisih * 0.5 + "px"
        });

        svgTriangle3.element.css({
            top: svgTriangle3.top_desktop + selisih * 0.6 + "px"
        });

        svgTriangle4.element.css({
            top: svgTriangle4.top_desktop + selisih * 0.7 + "px"
        });

        svgTriangle5.element.css({
            top: svgTriangle5.top_desktop + selisih * 0.3 + "px"
        });

        svgTriangle6.element.css({
            top: svgTriangle6.top_desktop - selisih * 0.8 + "px"
        });

        svgTriangle7.element.css({
            top: svgTriangle7.top_desktop - selisih * 0.1 + "px"
        });

        svgTriangle8.element.css({
            top: svgTriangle8.top_desktop - selisih * 0.2 + "px"
        });
    } else {
        svgTriangle1.element.removeAttr("style");
        svgTriangle2.element.removeAttr("style");
        svgTriangle3.element.removeAttr("style");
        svgTriangle4.element.removeAttr("style");
        svgTriangle5.element.removeAttr("style");
        svgTriangle6.element.removeAttr("style");
        svgTriangle7.element.removeAttr("style");
        svgTriangle8.element.removeAttr("style");
    }
}