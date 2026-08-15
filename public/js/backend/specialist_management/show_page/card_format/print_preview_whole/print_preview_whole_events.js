$(function () {
    "use strict";

    const WholePrint = window.specialistWholePrint;

    if (!WholePrint) {
        console.error("specialistWholePrint is not initialized.");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | OPEN WHOLE PRINT PREVIEW
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#openWholePrintPreview", function (e) {
        e.preventDefault();
        e.stopPropagation();

        /*
         * Make sure the Whole card exists.
         */

        const source = WholePrint.getSource();

        if (!source.length) {
            return false;
        }

        /*
         * Use the central print controller.
         */

        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.open === "function"
        ) {
            window.patientCardPrint.open("whole");
        } else {
            console.error("patientCardPrint.open() is not available.");
        }

        return false;
    });

    /*
    |--------------------------------------------------------------------------
    | COPY CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#cardPrintCopies", function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.generate === "function"
        ) {
            if (window.patientCardPrint.mode === "whole") {
                window.patientCardPrint.generate("whole");
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | THEME CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#card_theme", function () {
        if (
            window.patientCardPrint &&
            window.patientCardPrint.mode === "whole"
        ) {
            window.patientCardPrint.generate("whole");
        }
    });

    /*
    |--------------------------------------------------------------------------
    | PRINT BUTTON
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#printCardButton", function (e) {
        e.preventDefault();
        e.stopPropagation();

        WholePrint.print();

        return false;
    });
});
