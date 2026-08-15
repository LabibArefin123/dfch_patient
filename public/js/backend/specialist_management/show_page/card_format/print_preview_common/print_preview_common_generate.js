(function (window, $) {
    "use strict";

    window.patientCardPrint = window.patientCardPrint || {};

    const Print = window.patientCardPrint;

    /*
    |--------------------------------------------------------------------------
    | CLEAR GRID
    |--------------------------------------------------------------------------
    */

    Print.clearGrid = function () {
        $("#printCardGrid").empty();
    };

    /*
    |--------------------------------------------------------------------------
    | CREATE WHOLE CARD
    |--------------------------------------------------------------------------
    */

    Print.createItem = function (front, back, type, index) {
        const item = $("<div>", {
            class: "print-card-item",
            "data-card-index": index,
            "data-card-type": type,
        });

        const sides = $("<div>", {
            class: "print-card-sides",
        });

        if (front && front.length) {
            sides.append(Print.clean(front).addClass("print-front-side"));
        }

        if (back && back.length) {
            sides.append(Print.clean(back).addClass("print-back-side"));
        }

        item.append(sides);

        return item;
    };

    /*
    |--------------------------------------------------------------------------
    | GENERATE
    |--------------------------------------------------------------------------
    */

    Print.generate = function (mode) {
        mode = mode || Print.mode || "front";

        if (!["front", "back", "whole"].includes(mode)) {
            console.error("Invalid print mode:", mode);
            return false;
        }

        const grid = $("#printCardGrid");

        if (!grid.length) {
            console.error("#printCardGrid not found.");
            return false;
        }

        const front = Print.getFront();
        const back = Print.getBack();

        const type = Print.getCardType();
        const copies = Print.getCopies();

        Print.clearGrid();

        /*
        |--------------------------------------------------------------------------
        | FRONT
        |--------------------------------------------------------------------------
        */

        if (mode === "front") {
            if (!front.length) {
                console.error("Front card not found.");
                return false;
            }

            for (let i = 0; i < copies; i++) {
                const item = $("<div>", {
                    class: "print-card-item print-front-only",
                    "data-card-index": i,
                });

                item.append(Print.clean(front).addClass("print-front-side"));

                grid.append(item);
            }
        } else if (mode === "back") {
            /*
        |--------------------------------------------------------------------------
        | BACK
        |--------------------------------------------------------------------------
        */
            if (!back.length) {
                console.error("Back card not found.");
                return false;
            }

            for (let i = 0; i < copies; i++) {
                const item = $("<div>", {
                    class: "print-card-item print-back-only",
                    "data-card-index": i,
                });

                item.append(Print.clean(back).addClass("print-back-side"));

                grid.append(item);
            }
        } else {
            /*
        |--------------------------------------------------------------------------
        | WHOLE
        |--------------------------------------------------------------------------
        */
            if (!front.length && !back.length) {
                console.error("Neither front nor back card was found.");

                return false;
            }

            for (let i = 0; i < copies; i++) {
                grid.append(Print.createItem(front, back, type, i));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE STATE
        |--------------------------------------------------------------------------
        */

        Print.mode = mode;

        grid.attr("data-print-mode", mode);
        grid.attr("data-card-type", type);

        /*
        |--------------------------------------------------------------------------
        | APPLY LAYOUT
        |--------------------------------------------------------------------------
        */

        if (typeof Print.applyLayout === "function") {
            Print.applyLayout(type, mode);
        }

        return true;
    };
})(window, jQuery);
