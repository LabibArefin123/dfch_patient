(function (window, $) {
    "use strict";

    window.patientPrintPreview = window.patientPrintPreview || {};

    const Preview = window.patientPrintPreview;

    Preview.setMode = function (mode) {
        const allowedModes = ["front", "back", "whole"];

        if (!allowedModes.includes(mode)) {
            console.error("Invalid print preview mode:", mode);
            return false;
        }

        Preview.mode = mode;

        if (window.patientCardPrint) {
            window.patientCardPrint.mode = mode;
        }

        return true;
    };

    Preview.getMode = function () {
        if (Preview.mode) {
            return Preview.mode;
        }

        if (window.patientCardPrint && window.patientCardPrint.mode) {
            return window.patientCardPrint.mode;
        }

        return null;
    };
})(window, jQuery);
