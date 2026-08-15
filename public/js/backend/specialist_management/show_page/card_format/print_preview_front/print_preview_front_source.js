(function (window, $) {
    "use strict";

    window.specialistFrontPrint = window.specialistFrontPrint || {};

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.getSource = function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.getFront === "function"
        ) {
            const source = window.patientCardPrint.getFront();

            if (source.length) {
                return source;
            }
        }

        console.error("Front card not found.");

        return $();
    };
})(window, jQuery);
