/**
 * ==========================================================
 * WHOLE CARD / LANYARD PRINT
 * ==========================================================
 *
 * Handles:
 *
 * .whole-card-print-btn
 *
 * Prints the currently selected lanyard design.
 *
 * No modal.
 * No dark screen.
 * No new browser window.
 * ==========================================================
 */

(function ($) {
    "use strict";

    /**
     * ======================================================
     * GET CURRENTLY SELECTED LANYARD
     * ======================================================
     *
     * Your show page contains:
     *
     * .lanyard-preview-container
     * .lanyard-preview-container2
     * .lanyard-preview-container3
     *
     * initializeSpecialistLanyard() controls which one
     * is visible.
     *
     * Therefore we first use the visible lanyard.
     */

    function getSelectedLanyard() {
        /*
         * Existing manually selected lanyard.
         */
        if (window.selectedLanyard && window.selectedLanyard.length) {
            return window.selectedLanyard.first();
        }

        /*
         * Active card, if your other JS uses it.
         */
        const active = $(".lanyard-card.active").first();

        if (active.length) {
            return active;
        }

        /*
         * Use the currently visible container.
         */
        const visibleContainers = $(
            ".lanyard-preview-container:visible, " +
                ".lanyard-preview-container2:visible, " +
                ".lanyard-preview-container3:visible",
        );

        if (visibleContainers.length) {
            const visibleCard = visibleContainers.find(".lanyard-card").first();

            if (visibleCard.length) {
                return visibleCard;
            }
        }

        /*
         * Final fallback.
         */
        const first = $(".lanyard-card").first();

        if (first.length) {
            return first;
        }

        return null;
    }

    /**
     * ======================================================
     * CREATE CLEAN PRINT CLONE
     * ======================================================
     */

    function createPrintClone(source) {
        if (!source || !source.length) {
            return null;
        }

        const clone = source.clone();

        /*
         * Remove every action/control element.
         */
        clone
            .find(
                ".lanyard-action-buttons, " +
                    ".lanyard-actions, " +
                    ".whole-lanyard-action-buttons, " +
                    ".whole-card-action-buttons, " +
                    ".print-button-container",
            )
            .remove();

        /*
         * Remove possible active/selection states.
         */
        clone.removeClass("active");

        return clone;
    }

    /**
     * ======================================================
     * PRINT WHOLE CARD
     * ======================================================
     */

    function printWholeCard() {
        const source = getSelectedLanyard();

        if (!source || !source.length) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        const clone = createPrintClone(source);

        if (!clone) {
            alert("Unable to prepare the lanyard for printing.");

            return;
        }

        /*
         * Create temporary print container.
         */
        const target = $("<div>", {
            class: "print-lanyard-target",
        });

        target.append(clone);

        $("body").append(target);

        /*
         * Allow browser to render the print content first.
         */
        setTimeout(function () {
            window.print();
        }, 100);

        /*
         * Clean up after print dialog.
         */
        setTimeout(function () {
            target.remove();
        }, 1000);
    }

    /**
     * ======================================================
     * CLICK HANDLER
     * ======================================================
     *
     * IMPORTANT:
     *
     * Blade:
     *
     * .whole-card-print-btn
     *
     * Therefore JS must listen to the same class.
     */

    $(document).off("click.wholeCardPrint", ".whole-card-print-btn");

    $(document).on(
        "click.wholeCardPrint",
        ".whole-card-print-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            printWholeCard();
        },
    );

    /**
     * ======================================================
     * PUBLIC API
     * ======================================================
     */

    window.WholeCardPrint = {
        print: printWholeCard,
    };
})(jQuery);
