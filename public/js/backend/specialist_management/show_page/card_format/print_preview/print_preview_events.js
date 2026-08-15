$(function () {
    "use strict";

    const Preview = window.patientPrintPreview;

    if (!Preview) {
        console.error("patientPrintPreview is not initialized.");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | PRINT BUTTON
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#printCardButton", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const mode =
            window.patientCardPrint && window.patientCardPrint.mode
                ? window.patientCardPrint.mode
                : Preview.getMode();

        if (!mode) {
            console.error("No print preview mode selected.");

            return false;
        }

        Preview.print(mode);

        return false;
    });

    /*
    |--------------------------------------------------------------------------
    | COPY CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#cardPrintCopies", function () {
        const mode =
            window.patientCardPrint && window.patientCardPrint.mode
                ? window.patientCardPrint.mode
                : Preview.getMode();

        if (
            mode &&
            window.patientCardPrint &&
            typeof window.patientCardPrint.generate === "function"
        ) {
            window.patientCardPrint.generate(mode);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | THEME CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#card_theme", function () {
        const mode =
            window.patientCardPrint && window.patientCardPrint.mode
                ? window.patientCardPrint.mode
                : Preview.getMode();

        if (
            mode &&
            window.patientCardPrint &&
            typeof window.patientCardPrint.generate === "function"
        ) {
            window.patientCardPrint.generate(mode);
        }
    });
});
