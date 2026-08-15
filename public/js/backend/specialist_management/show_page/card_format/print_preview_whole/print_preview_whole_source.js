$(function () {
    "use strict";

    const WholePrint = window.specialistWholePrint;

    if (!WholePrint) {
        console.error("specialistWholePrint is not initialized.");
        return;
    }

    WholePrint.getSource = function () {
        const source = $(".card-preview-middle").first();

        if (!source.length) {
            console.error(
                "Whole card source (.card-preview-middle) not found.",
            );

            return $();
        }

        return source;
    };
});
