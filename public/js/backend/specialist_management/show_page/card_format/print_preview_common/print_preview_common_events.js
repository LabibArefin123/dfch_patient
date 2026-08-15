$(function () {
    "use strict";

    const Print = window.patientCardPrint;

    if (!Print) {
        console.error("patientCardPrint is not initialized.");
        return;
    }

    /*
    |--------------------------------------------------------------------------
    | OPEN PREVIEW
    |--------------------------------------------------------------------------
    */

    Print.open = function (mode) {
        mode = mode === "back" ? "back" : mode === "whole" ? "whole" : "front";

        Print.mode = mode;

        const modal = $("#printPreviewModal");

        if (!modal.length) {
            console.error("#printPreviewModal not found.");

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        | Disable Bootstrap's dark backdrop.
        */

        modal.modal({
            backdrop: false,
            keyboard: true,
            show: true,
        });

        /*
        |--------------------------------------------------------------------------
        | Generate immediately
        |--------------------------------------------------------------------------
        */

        Print.generate(mode);
    };

    /*
    |--------------------------------------------------------------------------
    | COPY CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#cardPrintCopies", function () {
        if (Print.mode) {
            Print.generate(Print.mode);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | THEME CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#card_theme", function () {
        if (Print.mode) {
            Print.generate(Print.mode);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL SHOWN
    |--------------------------------------------------------------------------
    */

    $(document).on("shown.bs.modal", "#printPreviewModal", function () {
        if (Print.mode) {
            Print.generate(Print.mode);
        }
    });

    /*
    |--------------------------------------------------------------------------
    | REMOVE BACKDROP
    |--------------------------------------------------------------------------
    */

    function removePrintModalBackdrop() {
        $(".modal-backdrop").remove();

        if (!$(".modal.show").length) {
            $("body").removeClass("modal-open").css({
                paddingRight: "",
                overflow: "",
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure modal doesn't retain Bootstrap backdrop state
        |--------------------------------------------------------------------------
        */

        $("#printPreviewModal")
            .removeClass("show")
            .attr("aria-hidden", "true")
            .css("display", "none");
    }

    /*
    |--------------------------------------------------------------------------
    | MODAL HIDDEN
    |--------------------------------------------------------------------------
    */

    $(document).on(
        "hidden.bs.modal.cardPrintCleanup",
        "#printPreviewModal",
        function () {
            $("#printCardGrid").empty();

            setTimeout(function () {
                if (!$(".modal.show").length) {
                    removePrintModalBackdrop();
                }
            }, 50);
        },
    );

    /*
    |--------------------------------------------------------------------------
    | AFTER PRINT
    |--------------------------------------------------------------------------
    */

    $(window).on("afterprint", function () {
        setTimeout(function () {
            removePrintModalBackdrop();
        }, 50);
    });
});
