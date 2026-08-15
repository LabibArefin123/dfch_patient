(function (window, $) {
    "use strict";

    window.specialistWholePrint = window.specialistWholePrint || {};

    const WholePrint = window.specialistWholePrint;

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
})(window, jQuery);
