$(function () {
    "use strict";

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.print = function () {
        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return;
        }

        const generated = window.patientCardPrint.generate("front");

        if (generated === false) {
            return;
        }

        setTimeout(function () {
            window.print();
        }, 500);
    };
});
