/**
 * ==========================================================
 * LANYARD PRINT ACTION
 * ==========================================================
 *
 * Each button belongs to one .lanyard-row.
 *
 * Structure:
 *
 * .lanyard-row
 *   ├── .lanyard-strip
 *   └── .lanyard-actions
 *
 * Therefore we find the parent row and then its strip.
 */

(function ($) {
    "use strict";

    /**
     * Find the lanyard belonging to the clicked button.
     */
    function getLanyardFromButton(button) {
        const row = $(button).closest(".lanyard-row");

        if (!row.length) {
            console.error("Lanyard row not found for clicked button.", button);

            return null;
        }

        const lanyard = row
            .children(
                ".lanyard-strip, " + ".lanyard02-strip, " + ".lanyard03-strip",
            )
            .first();

        if (!lanyard.length) {
            console.error("Lanyard strip not found inside row.", row[0]);

            return null;
        }

        return lanyard[0];
    }

    /**
     * Create clean printable clone.
     */
    function createCleanClone(element) {
        if (!element) {
            return null;
        }

        const clone = element.cloneNode(true);

        $(clone)
            .find(
                ".lanyard-action-buttons, " +
                    ".lanyard-actions, " +
                    ".whole-lanyard-action-buttons, " +
                    ".whole-card-action-buttons",
            )
            .remove();

        return clone;
    }

    /**
     * Print lanyard.
     */
    function printLanyard(element) {
        const clone = createCleanClone(element);

        if (!clone) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        const printArea = document.createElement("div");

        printArea.className = "print-lanyard-target";

        printArea.appendChild(clone);

        document.body.appendChild(printArea);

        /*
         * Give browser time to render print area.
         */
        setTimeout(function () {
            window.print();
        }, 50);

        /*
         * Remove after print.
         */
        setTimeout(function () {
            if (document.body.contains(printArea)) {
                document.body.removeChild(printArea);
            }
        }, 500);
    }

    /**
     * Remove previous handler.
     */
    $(document).off("click.lanyardPrint", ".lanyard-print-btn");

    /**
     * Print click.
     */
    $(document).on("click.lanyardPrint", ".lanyard-print-btn", function (e) {
        e.preventDefault();

        e.stopPropagation();

        const element = getLanyardFromButton(this);

        printLanyard(element);
    });

    /**
     * Public API.
     */
    window.LanyardPrint = {
        print: printLanyard,
    };
})(jQuery);
