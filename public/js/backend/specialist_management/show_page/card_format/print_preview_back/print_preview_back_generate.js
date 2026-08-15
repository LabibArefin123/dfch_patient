(function (window, $) {
    "use strict";

    window.specialistBackPrint = window.specialistBackPrint || {};

    const BackPrint = window.specialistBackPrint;

    BackPrint.generate = function () {
        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return false;
        }

        return window.patientCardPrint.generate("back");
    };
})(window, jQuery);
