$(function () {
    "use strict";

    const FrontPrint = window.specialistFrontPrint;

    FrontPrint.getSource = function () {
        const source = $(".doctor-card").first();

        if (!source.length) {
            console.error("Front card (.doctor-card) not found.");

            return $();
        }

        return source;
    };
});
