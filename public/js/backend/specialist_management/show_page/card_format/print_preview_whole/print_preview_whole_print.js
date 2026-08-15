(function (window, $) {
    "use strict";

    window.specialistWholePrint = window.specialistWholePrint || {};

    const WholePrint = window.specialistWholePrint;

    WholePrint.print = function () {
        if (
            !window.patientPrintPreview ||
            typeof window.patientPrintPreview.print !== "function"
        ) {
            console.error("patientPrintPreview.print() is not available.");

            return false;
        }

        WholePrint.isPrinting = true;

        return window.patientPrintPreview.print("whole");
    };
})(window, jQuery);
