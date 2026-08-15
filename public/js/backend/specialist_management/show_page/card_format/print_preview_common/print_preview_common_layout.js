$(function () {
    "use strict";

    const Print = window.patientCardPrint;

    if (!Print) {
        console.error("patientCardPrint is not initialized.");
        return;
    }

    Print.applyLayout = function (type, mode) {
        const grid = $("#printCardGrid");

        if (!grid.length) {
            return;
        }

        grid.removeClass(
            "print-layout-vertical " +
                "print-layout-wide " +
                "print-mode-front " +
                "print-mode-back " +
                "print-mode-whole",
        );

        grid.addClass(
            type === "wide" ? "print-layout-wide" : "print-layout-vertical",
        );

        grid.addClass("print-mode-" + mode);
    };
});
