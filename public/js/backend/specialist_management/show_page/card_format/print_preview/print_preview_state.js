$(function () {
    "use strict";

    const Preview = window.patientPrintPreview;

    if (!Preview) {
        console.error("patientPrintPreview is not initialized.");
        return;
    }

    Preview.setMode = function (mode) {
        const allowedModes = ["front", "back", "whole"];

        if (!allowedModes.includes(mode)) {
            console.error("Invalid print preview mode:", mode);

            return false;
        }

        Preview.mode = mode;

        return true;
    };

    Preview.getMode = function () {
        return Preview.mode;
    };
});
