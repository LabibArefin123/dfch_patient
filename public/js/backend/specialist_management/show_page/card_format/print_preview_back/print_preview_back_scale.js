(function (window, $) {
    "use strict";

    const BackPrint = window.specialistBackPrint;

    BackPrint.scale = function () {
        $(".print-clone-card").css({
            transform: "scale(0.38)",
            transformOrigin: "top center",
        });
    };
})(window, jQuery);
