$(function () {
    "use strict";

    const WholePrint = window.specialistWholePrint;

    if (!WholePrint) {
        console.error("specialistWholePrint is not initialized.");
        return;
    }

    WholePrint.print = function () {
        if (
            !window.patientCardPrint ||
            typeof window.patientCardPrint.generate !== "function"
        ) {
            console.error("patientCardPrint.generate() is not available.");

            return;
        }

        const generated = window.patientCardPrint.generate("whole");

        if (generated === false) {
            return;
        }

        setTimeout(function () {
            window.print();
        }, 500);
    };

    /*
    |--------------------------------------------------------------------------
    | AFTER PRINT CLEANUP
    |--------------------------------------------------------------------------
    */

    $(window).on("afterprint", function () {
        setTimeout(function () {
            $(".modal-backdrop").remove();

            if (!$(".modal.show").length) {
                $("body").removeClass("modal-open").css({
                    paddingRight: "",
                    overflow: "",
                });
            }
        }, 50);
    });
});
