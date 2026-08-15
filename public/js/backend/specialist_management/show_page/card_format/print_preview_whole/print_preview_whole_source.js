(function (window, $) {
    "use strict";

    window.specialistWholePrint = window.specialistWholePrint || {};

    const WholePrint = window.specialistWholePrint;

    WholePrint.getSource = function () {
        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.getFront === "function"
        ) {
            const front = window.patientCardPrint.getFront();

            if (front.length) {
                return front;
            }
        }

        const source = $(".card-preview-middle").filter(":visible").first();

        if (source.length) {
            return source;
        }

        console.error("Whole card source not found.");

        return $();
    };
})(window, jQuery);
