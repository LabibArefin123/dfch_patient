$(function () {
    "use strict";

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.generate = function () {
        const source = FrontPrint.getSource();

        if (!source.length) {
            return false;
        }

        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return false;
        }

        return window.patientCardPrint.generate("front");
    };
});
