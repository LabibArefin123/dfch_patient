(function (window, $) {
    "use strict";

    window.specialistFrontPrint = window.specialistFrontPrint || {};

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.scale = function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.applyLayout === "function"
        ) {
            const type = window.patientCardPrint.getCardType();

            window.patientCardPrint.applyLayout(type, "front");
        }
    };
})(window, jQuery);
