(function (window, $) {
    "use strict";

    window.specialistWholePrint = window.specialistWholePrint || {};

    const WholePrint = window.specialistWholePrint;

    WholePrint.scale = function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.applyLayout === "function"
        ) {
            const type = window.patientCardPrint.getCardType();

            window.patientCardPrint.applyLayout(type, "whole");
        }
    };
})(window, jQuery);
