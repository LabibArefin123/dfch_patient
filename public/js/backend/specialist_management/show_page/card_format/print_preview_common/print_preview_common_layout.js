(function (window, $) {
    "use strict";

    window.patientCardPrint = window.patientCardPrint || {};

    const Print = window.patientCardPrint;

    Print.applyLayout = function (type, mode) {
        const grid = $("#printCardGrid");

        if (!grid.length) {
            return;
        }

        grid.removeClass(
            [
                "print-layout-vertical",
                "print-layout-wide",
                "print-mode-front",
                "print-mode-back",
                "print-mode-whole",
            ].join(" "),
        );

        grid.addClass(
            type === "wide" ? "print-layout-wide" : "print-layout-vertical",
        );

        grid.addClass("print-mode-" + mode);
    };
})(window, jQuery);
