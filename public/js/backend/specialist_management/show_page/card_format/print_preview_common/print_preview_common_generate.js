$(function () {
    "use strict";

    const Print = window.patientCardPrint;

    if (!Print) {
        console.error("patientCardPrint is not initialized.");
        return;
    }

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
    | CREATE WHOLE CARD ITEM
    |--------------------------------------------------------------------------
    */

    Print.createItem = function (front, back, type, index) {
        const item = $("<div>", {
            class: "print-card-item",
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

        item.attr("data-card-index", index);

        item.attr("data-card-type", type);

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

        const front = Print.getFront();

        const back = Print.getBack();

        const type = Print.getCardType();

        const copies = Print.getCopies();

        const grid = $("#printCardGrid");

        if (!grid.length) {
            console.error("#printCardGrid not found.");

            return false;
        }

        Print.clearGrid();

        /*
        |--------------------------------------------------------------------------
        | FRONT ONLY
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
                });

                item.append(Print.clean(front).addClass("print-front-side"));

                grid.append(item);
            }
        } else if (mode === "back") {
            /*
        |--------------------------------------------------------------------------
        | BACK ONLY
        |--------------------------------------------------------------------------
        */
            if (!back.length) {
                console.error("Back card not found.");

                return false;
            }

            for (let i = 0; i < copies; i++) {
                const item = $("<div>", {
                    class: "print-card-item print-back-only",
                });

                item.append(Print.clean(back).addClass("print-back-side"));

                grid.append(item);
            }
        } else {
            /*
        |--------------------------------------------------------------------------
        | WHOLE CARD
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
        | GRID DATA
        |--------------------------------------------------------------------------
        */

        grid.attr("data-print-mode", mode);

        grid.attr("data-card-type", type);

        /*
        |--------------------------------------------------------------------------
        | APPLY LAYOUT
        |--------------------------------------------------------------------------
        */

        Print.applyLayout(type, mode);

        return true;
    };
});
