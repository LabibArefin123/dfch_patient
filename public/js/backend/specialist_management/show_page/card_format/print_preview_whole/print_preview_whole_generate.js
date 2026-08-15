$(function () {
    "use strict";

    const WholePrint = window.specialistWholePrint;

    if (!WholePrint) {
        console.error("specialistWholePrint is not initialized.");
        return;
    }

    WholePrint.generate = function () {
        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return false;
        }

        const source = WholePrint.getSource();

        if (!source.length) {
            return false;
        }

        return window.patientCardPrint.generate("whole");
    };
});
