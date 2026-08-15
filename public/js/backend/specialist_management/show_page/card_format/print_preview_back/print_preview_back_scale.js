(function (window, $) {
    "use strict";

    window.specialistBackPrint = window.specialistBackPrint || {};

    const BackPrint = window.specialistBackPrint;

    BackPrint.scale = function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.applyLayout === "function"
        ) {
            const type = window.patientCardPrint.getCardType();

            window.patientCardPrint.applyLayout(type, "back");
        }
    };
})(window, jQuery);
