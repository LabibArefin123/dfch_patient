(function (window, $) {
    "use strict";

    const BackPrint = window.specialistBackPrint;

    BackPrint.getSource = function () {
        const source = $(".doctor-card-holder").first();

        if (!source.length) {
            console.error("Back card source (.doctor-card-holder) not found.");

            return null;
        }

        return source;
    };
})(window, jQuery);
