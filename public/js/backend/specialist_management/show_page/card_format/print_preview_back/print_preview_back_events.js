(function (window, $) {
    "use strict";

    const BackPrint = window.specialistBackPrint;

    /*
    |--------------------------------------------------------------------------
    | OPEN BACK PRINT PREVIEW
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#openBackPrintPreview", function (e) {
        e.preventDefault();
        e.stopPropagation();

        /*
         * Use the central patientCardPrint controller
         * if it exists.
         */

        if (
            window.patientCardPrint &&
            typeof window.patientCardPrint.open === "function"
        ) {
            window.patientCardPrint.open("back");

            return false;
        }

        /*
         * Fallback
         */

        const $modal = $("#printPreviewModal");

        if (!$modal.length) {
            console.error("#printPreviewModal not found.");

            return false;
        }

        /*
         * IMPORTANT:
         * No Bootstrap backdrop.
         */

        $modal.modal({
            backdrop: false,
            keyboard: true,
            show: true,
        });

        setTimeout(function () {
            BackPrint.generate();
        }, 50);

        return false;
    });

    /*
    |--------------------------------------------------------------------------
    | COPY CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#cardPrintCopies", function () {
        BackPrint.generate();
    });

    /*
    |--------------------------------------------------------------------------
    | PRINT BUTTON
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#printCardButton", function (e) {
        e.preventDefault();
        e.stopPropagation();

        BackPrint.print();

        return false;
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL OPENED
    |--------------------------------------------------------------------------
    */

    $(document).on("shown.bs.modal", "#printPreviewModal", function () {
        BackPrint.generate();
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL CLOSED
    |--------------------------------------------------------------------------
    */

    $(document).on("hidden.bs.modal", "#printPreviewModal", function () {
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
})(window, jQuery);
