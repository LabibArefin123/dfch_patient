(function (window, $) {
    "use strict";

    window.patientPrintPreview = window.patientPrintPreview || {};

    const Preview = window.patientPrintPreview;

    Preview.print = function (mode) {
        mode = mode || Preview.getMode();

        if (!Preview.validate(mode)) {
            return false;
        }

        Preview.setMode(mode);

        if (!window.patientCardPrint) {
            console.error("patientCardPrint is not available.");
            return false;
        }

        window.patientCardPrint.mode = mode;

        const generated = window.patientCardPrint.generate(mode);

        if (generated === false) {
            console.error("Unable to generate print content for mode:", mode);

            return false;
        }

        Preview.isPrinting = true;

        /*
         * Give the browser time to render the generated cards
         * before opening the native print dialog.
         */
        setTimeout(function () {
            window.print();
        }, 350);

        return true;
    };
})(window, jQuery);
