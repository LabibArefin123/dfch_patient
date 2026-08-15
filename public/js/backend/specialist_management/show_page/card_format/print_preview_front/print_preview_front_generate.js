(function (window, $) {
    "use strict";

    window.specialistFrontPrint = window.specialistFrontPrint || {};

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.generate = function () {
        const source = FrontPrint.getSource();

        if (!source.length) {
            console.error("Front card source not found.");

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
})(window, jQuery);
