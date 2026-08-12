/**
 * ==========================================================
 * WHOLE CARD / LANYARD PREVIEW
 * ==========================================================
 *
 * Handles:
 *
 * .whole-card-preview-btn
 *
 * Preview opens inside Bootstrap modal.
 *
 * IMPORTANT:
 * backdrop is disabled because you do NOT want the
 * dark screen over the page.
 * ==========================================================
 */

(function ($) {
    "use strict";

    /**
     * ======================================================
     * GET CURRENTLY SELECTED LANYARD
     * ======================================================
     */

    function getSelectedLanyard() {
        /*
         * Existing selected lanyard.
         */
        if (window.selectedLanyard && window.selectedLanyard.length) {
            return window.selectedLanyard.first();
        }

        /*
         * Active lanyard.
         */
        const active = $(".lanyard-card.active").first();

        if (active.length) {
            return active;
        }

        /*
         * Get the currently visible design.
         *
         * Your theme selector hides the other containers.
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
     * CREATE MODAL
     * ======================================================
     */

    function createModal() {
        if ($("#wholeLanyardPreviewModal").length) {
            return;
        }

        const html = `

            <div
                class="modal fade"
                id="wholeLanyardPreviewModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >

                <div
                    class="modal-dialog modal-dialog-centered modal-xl"
                    role="document"
                >

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-eye mr-2"></i>

                                Whole Card Preview

                            </h5>


                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        <div class="modal-body">

                            <div
                                id="wholeLanyardPreviewContent"
                                class="whole-lanyard-preview-content"
                            ></div>

                        </div>


                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >

                                <i class="fas fa-times mr-1"></i>

                                Close

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        `;

        $("body").append(html);
    }

    /**
     * ======================================================
     * CREATE CLEAN CLONE
     * ======================================================
     */

    function createPreviewClone(source) {
        if (!source || !source.length) {
            return null;
        }

        const clone = source.clone();

        /*
         * Remove all buttons and controls.
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
         * Remove active state.
         */
        clone.removeClass("active");

        return clone;
    }

    /**
     * ======================================================
     * OPEN WHOLE CARD PREVIEW
     * ======================================================
     */

    function openPreview() {
        const lanyard = getSelectedLanyard();

        if (!lanyard || !lanyard.length) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        createModal();

        const clone = createPreviewClone(lanyard);

        if (!clone) {
            alert("Unable to create the preview.");

            return;
        }

        /*
         * Clear previous preview.
         */
        $("#wholeLanyardPreviewContent").empty().append(clone);

        /*
         * ==================================================
         * IMPORTANT
         * ==================================================
         *
         * backdrop: false
         *
         * This prevents Bootstrap from creating the dark
         * screen behind the modal.
         */

        $("#wholeLanyardPreviewModal").modal({
            backdrop: false,

            keyboard: true,

            focus: true,

            show: true,
        });
    }

    /**
     * ======================================================
     * CLICK HANDLER
     * ======================================================
     *
     * Blade uses:
     *
     * .whole-card-preview-btn
     */

    $(document).off("click.wholeCardPreview", ".whole-card-preview-btn");

    $(document).on(
        "click.wholeCardPreview",
        ".whole-card-preview-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            openPreview();
        },
    );

    /**
     * ======================================================
     * MODAL CLEANUP
     * ======================================================
     */

    $(document).off(
        "hidden.bs.modal.wholeCardPreview",
        "#wholeLanyardPreviewModal",
    );

    $(document).on(
        "hidden.bs.modal.wholeCardPreview",
        "#wholeLanyardPreviewModal",
        function () {
            $("#wholeLanyardPreviewContent").empty();

            cleanupModal();
        },
    );

    /**
     * ======================================================
     * CLEANUP
     * ======================================================
     */

    function cleanupModal() {
        setTimeout(function () {
            /*
             * Remove any stale Bootstrap backdrop.
             */
            $(".modal-backdrop").remove();

            /*
             * Restore body.
             */
            $("body").removeClass("modal-open").css({
                paddingRight: "",
                overflow: "",
            });
        }, 100);
    }

    /**
     * ======================================================
     * PUBLIC API
     * ======================================================
     */

    window.WholeCardPreview = {
        open: openPreview,
    };
})(jQuery);
