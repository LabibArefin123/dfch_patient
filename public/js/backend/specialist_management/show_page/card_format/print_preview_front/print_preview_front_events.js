$(function () {
    "use strict";

    const FrontPrint = window.specialistFrontPrint;

    /*
    |--------------------------------------------------------------------------
    | OPEN FRONT PREVIEW
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#openFrontPrintPreview", function (e) {
        e.preventDefault();
        e.stopPropagation();

        const source = FrontPrint.getSource();

        if (!source.length) {
            return false;
        }

        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.open === "function"
        ) {
            window.patientCardPrint.open("front");
        } else {
            console.error("patientCardPrint.open() is not available.");
        }

        return false;
    });

    /*
    |--------------------------------------------------------------------------
    | PRINT FRONT
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#printCardButton", function (e) {
        e.preventDefault();
        e.stopPropagation();

        FrontPrint.print();

        return false;
    });
});
