(function (window, $) {
    "use strict";

    const BackPrint = window.specialistBackPrint;

    BackPrint.print = function () {
        const generated = BackPrint.generate();

        if (!generated) {
            return;
        }

        setTimeout(function () {
            window.print();
        }, 500);
    };

    /*
    |--------------------------------------------------------------------------
    | CLEANUP AFTER PRINT
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
})(window, jQuery);
