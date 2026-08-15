(function (window, $) {
    "use strict";

    window.patientPrintPreview = window.patientPrintPreview || {};

    const Preview = window.patientPrintPreview;

    Preview.validate = function (mode) {
        if (!["front", "back", "whole"].includes(mode)) {
            console.error("Invalid print mode:", mode);
            return false;
        }

        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return false;
        }

        return true;
    };
})(window, jQuery);
