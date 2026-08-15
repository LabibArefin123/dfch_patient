$(function () {
    "use strict";

    const Preview = window.patientPrintPreview;

    if (!Preview) {
        console.error("patientPrintPreview is not initialized.");
        return;
    }

    Preview.validate = function (mode) {
        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return false;
        }

        if (!["front", "back", "whole"].includes(mode)) {
            console.error("Invalid print mode:", mode);

            return false;
        }

        return true;
    };
});
