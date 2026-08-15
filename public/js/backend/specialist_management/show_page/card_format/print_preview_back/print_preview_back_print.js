(function (window, $) {
    "use strict";

    window.specialistBackPrint = window.specialistBackPrint || {};

    const BackPrint = window.specialistBackPrint;

    BackPrint.print = function () {
        if (
            !window.patientPrintPreview ||
            typeof window.patientPrintPreview.print !== "function"
        ) {
            console.error("patientPrintPreview.print() is not available.");

            return false;
        }

        BackPrint.isPrinting = true;

        return window.patientPrintPreview.print("back");
    };
})(window, jQuery);
