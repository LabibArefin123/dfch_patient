(function (window, $) {
    "use strict";

    window.specialistBackPrint = window.specialistBackPrint || {};

    const BackPrint = window.specialistBackPrint;

    BackPrint.getSource = function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.getBack === "function"
        ) {
            const source = window.patientCardPrint.getBack();

            if (source.length) {
                return source;
            }
        }

        console.error("Back card not found.");

        return $();
    };
})(window, jQuery);
