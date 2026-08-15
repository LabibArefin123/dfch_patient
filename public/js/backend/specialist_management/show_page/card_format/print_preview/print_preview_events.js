(function (window, $) {
    "use strict";

    window.patientPrintPreview = window.patientPrintPreview || {};

    const Preview = window.patientPrintPreview;

    Preview.cleanup = function () {
        /*
        |--------------------------------------------------------------------------
        | REMOVE BACKDROPS
        |--------------------------------------------------------------------------
        */

        $(".modal-backdrop").remove();

        /*
        |--------------------------------------------------------------------------
        | RESET BODY
        |--------------------------------------------------------------------------
        */

        if (!$(".modal.show").length) {
            $("body").removeClass("modal-open").css({
                paddingRight: "",
                overflow: "",
            });
        }

        /*
        |--------------------------------------------------------------------------
        | RESET PRINT STATE
        |--------------------------------------------------------------------------
        */

        Preview.mode = null;
        Preview.isPrinting = false;

        if (window.patientCardPrint) {
            window.patientCardPrint.mode = null;
        }

        /*
        |--------------------------------------------------------------------------
        | RESET SPECIALIZED PRINT MODULES
        |--------------------------------------------------------------------------
        */

        if (window.specialistFrontPrint) {
            window.specialistFrontPrint.isPrinting = false;
        }

        if (window.specialistBackPrint) {
            window.specialistBackPrint.isPrinting = false;
        }

        if (window.specialistWholePrint) {
            window.specialistWholePrint.isPrinting = false;
        }
    };

    /*
    |--------------------------------------------------------------------------
    | AFTER PRINT
    |--------------------------------------------------------------------------
    */

    $(window)
        .off("afterprint.patientPrintCleanup")
        .on("afterprint.patientPrintCleanup", function () {
            setTimeout(function () {
                Preview.cleanup();
            }, 100);
        });
})(window, jQuery);
