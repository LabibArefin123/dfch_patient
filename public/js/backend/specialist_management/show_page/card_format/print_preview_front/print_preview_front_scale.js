$(function () {
    "use strict";

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.scale = function () {
        /*
         * Front card scaling is now handled
         * by the common print-preview CSS.
         */

        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.applyLayout === "function"
        ) {
            const type = window.patientCardPrint.getCardType();

            window.patientCardPrint.applyLayout(type, "front");
        }
    };
});
