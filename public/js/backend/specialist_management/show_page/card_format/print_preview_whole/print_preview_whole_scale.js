$(function () {
    "use strict";

    const WholePrint = window.specialistWholePrint;

    if (!WholePrint) {
        console.error("specialistWholePrint is not initialized.");
        return;
    }

    WholePrint.scale = function () {
        /*
         * Scaling is handled by the common
         * print-preview CSS/layout system.
         *
         * This function is intentionally kept
         * for compatibility with older calls.
         */

        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.applyLayout === "function"
        ) {
            const type = window.patientCardPrint.getCardType();

            window.patientCardPrint.applyLayout(type, "whole");
        }
    };
});
