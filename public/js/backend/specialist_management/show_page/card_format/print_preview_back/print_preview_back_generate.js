(function (window, $) {
    "use strict";

    const BackPrint = window.specialistBackPrint;

    BackPrint.generate = function () {
        const copies = parseInt($("#cardPrintCopies").val(), 10) || 1;

        const $grid = $("#printCardGrid");

        if (!$grid.length) {
            console.error("#printCardGrid not found.");

            return false;
        }

        $grid.empty();

        const $source = BackPrint.getSource();

        if (!$source) {
            return false;
        }

        for (let i = 0; i < copies; i++) {
            const $clone = $source.clone(false);

            $clone.removeAttr("id").addClass("print-clone-card");

            const $wrapper = $("<div>", {
                class: "print-card-item",
            });

            $wrapper.append($clone);

            $grid.append($wrapper);
        }

        BackPrint.scale();

        return true;
    };
})(window, jQuery);
