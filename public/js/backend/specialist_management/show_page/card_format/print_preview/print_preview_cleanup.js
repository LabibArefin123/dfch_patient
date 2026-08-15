$(function () {
    "use strict";

    const Preview = window.patientPrintPreview;

    if (!Preview) {
        console.error("patientPrintPreview is not initialized.");
        return;
    }

    Preview.cleanup = function () {
        $(".modal-backdrop").remove();

        if (!$(".modal.show").length) {
            $("body").removeClass("modal-open").css({
                paddingRight: "",
                overflow: "",
            });
        }

        const modal = $("#printPreviewModal");

        if (modal.length) {
            modal
                .removeClass("show")
                .attr("aria-hidden", "true")
                .css("display", "none");
        }

        Preview.isPrinting = false;
    };

    /*
    |--------------------------------------------------------------------------
    | AFTER PRINT
    |--------------------------------------------------------------------------
    */

    $(window).on("afterprint", function () {
        setTimeout(function () {
            Preview.cleanup();
        }, 50);
    });
});
