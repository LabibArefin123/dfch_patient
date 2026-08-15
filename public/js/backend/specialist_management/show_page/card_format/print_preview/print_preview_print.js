$(function () {
    "use strict";

    const Preview = window.patientPrintPreview;

    if (!Preview) {
        console.error("patientPrintPreview is not initialized.");
        return;
    }

    Preview.print = function (mode) {
        mode = mode || Preview.getMode();

        if (!Preview.validate(mode)) {
            return false;
        }

        Preview.setMode(mode);

        const generated = window.patientCardPrint.generate(mode);

        if (generated === false) {
            return false;
        }

        Preview.isPrinting = true;

        setTimeout(function () {
            window.print();
        }, 500);

        return true;
    };
});
