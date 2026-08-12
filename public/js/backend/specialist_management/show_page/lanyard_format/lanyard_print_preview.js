/**
 * ==========================================================
 * LANYARD PREVIEW
 * ==========================================================
 *
 * Preview always opens inside Bootstrap modal.
 *
 * No new browser window.
 * No navigation.
 * No action buttons inside preview.
 */

(function ($) {
    "use strict";

    /**
     * ======================================================
     * FIND SELECTED LANYARD
     * ======================================================
     */

    function getLanyardFromButton(button) {
        const row = $(button).closest(".lanyard-row");

        if (!row.length) {
            console.error("Lanyard row not found.", button);

            return null;
        }

        const lanyard = row
            .children(
                ".lanyard-strip, " + ".lanyard02-strip, " + ".lanyard03-strip",
            )
            .first();

        if (!lanyard.length) {
            console.error("Lanyard strip not found.", row[0]);

            return null;
        }

        return lanyard[0];
    }

    /**
     * ======================================================
     * CREATE MODAL
     * ======================================================
     */

    function createPreviewModal() {
        if ($("#lanyardPreviewModal").length) {
            return;
        }

        const modal = `

            <div
                class="modal fade"
                id="lanyardPreviewModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >

                <div
                    class="modal-dialog modal-dialog-centered modal-lg"
                    role="document"
                >

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">

                                <i class="fas fa-eye mr-2"></i>

                                Lanyard Preview

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
                                id="lanyardPreviewContent"
                                class="lanyard-preview-modal-body"
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

        $("body").append(modal);
    }

    /**
     * ======================================================
     * CLEAN CLONE
     * ======================================================
     */

    function createPreviewClone(element) {
        if (!element) {
            return null;
        }

        const clone = element.cloneNode(true);

        /*
         * Remove anything interactive.
         */
        $(clone)
            .find(
                ".lanyard-action-buttons, " +
                    ".lanyard-actions, " +
                    ".whole-lanyard-action-buttons, " +
                    ".whole-card-action-buttons",
            )
            .remove();

        /*
         * Remove IDs if copied.
         */
        $(clone).removeAttr("id");

        return clone;
    }

    /**
     * ======================================================
     * OPEN PREVIEW
     * ======================================================
     */

    function previewLanyard(element) {
        if (!element) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        createPreviewModal();

        const clone = createPreviewClone(element);

        if (!clone) {
            alert("Unable to create lanyard preview.");

            return;
        }

        const content = $("#lanyardPreviewContent");

        content.empty();

        const wrapper = $("<div>", {
            class: "lanyard-preview-single",
        });

        wrapper.append(clone);

        content.append(wrapper);

        /*
         * Bootstrap 4 modal.
         */
        $("#lanyardPreviewModal").modal({
            backdrop: false,
            keyboard: true,
            focus: true,
            show: true,
        });
    }

    /**
     * ======================================================
     * PREVIEW CLICK
     * ======================================================
     */

    $(document).off("click.lanyardPreview", ".lanyard-preview-btn");

    $(document).on(
        "click.lanyardPreview",
        ".lanyard-preview-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            const element = getLanyardFromButton(this);

            previewLanyard(element);
        },
    );

    /**
     * ======================================================
     * MODAL CLEANUP
     * ======================================================
     */

    $(document).off("hidden.bs.modal.lanyardPreview", "#lanyardPreviewModal");

    $(document).on(
        "hidden.bs.modal.lanyardPreview",
        "#lanyardPreviewModal",
        function () {
            $("#lanyardPreviewContent").empty();

            cleanupModalBackdrop();
        },
    );

    /**
     * ======================================================
     * BACKDROP CLEANUP
     * ======================================================
     */

    function cleanupModalBackdrop() {
        setTimeout(function () {
            if (!$(".modal.show").length) {
                $(".modal-backdrop").remove();

                $("body").removeClass("modal-open").css({
                    paddingRight: "",
                    overflow: "",
                });
            }
        }, 150);
    }

    /**
     * ======================================================
     * PUBLIC API
     * ======================================================
     */

    window.LanyardPreview = {
        open: previewLanyard,
    };
})(jQuery);
