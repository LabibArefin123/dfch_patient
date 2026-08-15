(function (window, $) {
    "use strict";

    window.specialistFrontPrint = window.specialistFrontPrint || {};

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.print = function () {
        if (
            !window.patientPrintPreview ||
            typeof window.patientPrintPreview.print !== "function"
        ) {
            console.error("patientPrintPreview.print() is not available.");

            return false;
        }

        FrontPrint.isPrinting = true;

        return window.patientPrintPreview.print("front");
    };
})(window, jQuery);
