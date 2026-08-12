/**
 * ==========================================================
 * LANYARD WHATSAPP
 * ==========================================================
 *
 * Features:
 *
 * - Uses selected Design 01 / 02 / 03
 * - Generates PNG in memory
 * - Does NOT download image
 * - Uses native Web Share when possible
 * - Image can be shared directly to WhatsApp on supported
 *   devices/browsers
 * - No dark modal backdrop
 * ==========================================================
 */

(function ($) {
    "use strict";

    let whatsappSource = null;

    /**
     * ======================================================
     * GET CURRENT THEME
     * ======================================================
     */

    function getWholeLanyard() {
        /*
         * Existing selected lanyard.
         */
        if (window.selectedLanyard && window.selectedLanyard.length) {
            return window.selectedLanyard.first()[0];
        }

        /*
         * Active lanyard.
         */
        const active = document.querySelector(".lanyard-card.active");

        if (active) {
            return active;
        }

        /*
         * Find currently visible design.
         */
        const visibleContainer = $(
            ".lanyard-preview-container:visible, " +
                ".lanyard-preview-container2:visible, " +
                ".lanyard-preview-container3:visible",
        ).first();

        if (visibleContainer.length) {
            const card = visibleContainer.find(".lanyard-card").first();

            if (card.length) {
                return card[0];
            }
        }

        /*
         * Final fallback.
         */
        return document.querySelector(".lanyard-card");
    }

    /**
     * ======================================================
     * GET LANYARD FROM INDIVIDUAL BUTTON
     * ======================================================
     */

    function getLanyardFromButton(button) {
        const row = $(button).closest(".lanyard-row");

        if (!row.length) {
            return null;
        }

        return (
            row
                .find(
                    ".lanyard-strip, " +
                        ".lanyard02-strip, " +
                        ".lanyard03-strip",
                )
                .first()[0] || null
        );
    }

    /**
     * ======================================================
     * CREATE MODAL
     * ======================================================
     */

    function createWhatsappModal() {
        if ($("#lanyardWhatsAppModal").length) {
            return;
        }

        const modal = `

            <div
                class="modal fade"
                id="lanyardWhatsAppModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >

                <div
                    class="modal-dialog modal-dialog-centered"
                    role="document"
                >

                    <div class="modal-content border-0 shadow-lg">

                        <div
                            class="modal-header bg-success text-white"
                        >

                            <h5 class="modal-title">

                                <i class="fab fa-whatsapp mr-2"></i>

                                WhatsApp Lanyard

                            </h5>


                            <button
                                type="button"
                                class="close text-white"
                                data-dismiss="modal"
                                aria-label="Close"
                            >

                                <span aria-hidden="true">
                                    &times;
                                </span>

                            </button>

                        </div>


                        <div class="modal-body p-4">

                            <div class="text-center mb-4">

                                <div class="lanyard-modal-icon">

                                    <i class="fab fa-whatsapp"></i>

                                </div>


                                <h5 class="mb-1">

                                    Send Lanyard

                                </h5>


                                <p class="text-muted mb-0">

                                    The selected lanyard will be
                                    generated as an image in memory.

                                </p>

                            </div>


                            <div class="form-group">

                                <label
                                    for="lanyardWhatsappNumber"
                                    class="font-weight-semibold"
                                >

                                    WhatsApp Number

                                </label>


                                <input
                                    type="tel"
                                    id="lanyardWhatsappNumber"
                                    class="form-control"
                                    placeholder="017XXXXXXXX"
                                    autocomplete="off"
                                >


                                <small class="form-text text-muted">

                                    Example: 01776197999

                                </small>

                            </div>


                            <div
                                id="lanyardWhatsappError"
                                class="text-danger small d-none"
                            ></div>


                            <div class="alert alert-light border mb-0">

                                <i class="fas fa-info-circle text-success mr-1"></i>

                                The image will not be downloaded.

                            </div>

                        </div>


                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >

                                <i class="fas fa-times mr-1"></i>

                                Cancel

                            </button>


                            <button
                                type="button"
                                class="btn btn-success"
                                id="confirmLanyardWhatsapp"
                            >

                                <i class="fab fa-whatsapp mr-1"></i>

                                Send Image

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
     * OPEN WHATSAPP MODAL
     * ======================================================
     */

    function openWhatsappModal(source) {
        if (!source) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        whatsappSource = source;

        createWhatsappModal();

        $("#lanyardWhatsappNumber").val("").trigger("focus");

        $("#lanyardWhatsappError").addClass("d-none").text("");

        /*
         * IMPORTANT:
         *
         * backdrop:false
         *
         * No dark screen.
         */
        $("#lanyardWhatsAppModal").modal({
            backdrop: false,

            keyboard: true,

            focus: true,

            show: true,
        });
    }

    /**
     * ======================================================
     * NORMALIZE BANGLADESH NUMBER
     * ======================================================
     */

    function normalizeBangladeshNumber(value) {
        let number = String(value || "").replace(/\D/g, "");

        /*
         * 8801776197999
         */
        if (number.startsWith("880")) {
            number = number.substring(3);
        }

        /*
         * 01776197999
         */
        if (number.startsWith("0")) {
            number = number.substring(1);
        }

        /*
         * Bangladesh mobile:
         *
         * 1XXXXXXXXX
         */
        if (number.length !== 10 || !number.startsWith("1")) {
            return null;
        }

        return "880" + number;
    }

    /**
     * ======================================================
     * GENERATE IMAGE FILE
     * ======================================================
     */

    async function generateImageFile(element) {
        if (!window.html2canvas) {
            throw new Error("html2canvas is required.");
        }

        const wrapper = document.createElement("div");

        wrapper.style.position = "fixed";

        wrapper.style.left = "-99999px";

        wrapper.style.top = "0";

        wrapper.style.padding = "20px";

        wrapper.style.background = "#ffffff";

        wrapper.style.display = "inline-block";

        wrapper.style.width = "max-content";

        wrapper.style.zIndex = "-1";

        const clone = element.cloneNode(true);

        /*
         * Remove every button.
         */
        $(clone)
            .find(
                ".lanyard-action-buttons, " +
                    ".lanyard-actions, " +
                    ".whole-lanyard-action-buttons, " +
                    ".whole-card-action-buttons, " +
                    ".print-button-container",
            )
            .remove();

        clone.classList.remove("active");

        wrapper.appendChild(clone);

        document.body.appendChild(wrapper);

        try {
            const canvas = await html2canvas(wrapper, {
                backgroundColor: "#ffffff",

                scale: 2,

                useCORS: true,

                allowTaint: false,

                logging: false,
            });

            const blob = await new Promise(function (resolve) {
                canvas.toBlob(resolve, "image/png");
            });

            if (!blob) {
                throw new Error("Unable to create image.");
            }

            return new File([blob], "lanyard.png", {
                type: "image/png",
            });
        } finally {
            if (document.body.contains(wrapper)) {
                document.body.removeChild(wrapper);
            }
        }
    }

    /**
     * ======================================================
     * WHOLE CARD WHATSAPP BUTTON
     * ======================================================
     */

    $(document).off("click.wholeCardWhatsapp", ".whole-card-whatsapp-btn");

    $(document).on(
        "click.wholeCardWhatsapp",
        ".whole-card-whatsapp-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            openWhatsappModal(getWholeLanyard());
        },
    );

    /**
     * ======================================================
     * OLD WHOLE LANYARD CLASS SUPPORT
     * ======================================================
     */

    $(document).off(
        "click.wholeLanyardWhatsapp",
        ".whole-lanyard-whatsapp-btn",
    );

    $(document).on(
        "click.wholeLanyardWhatsapp",
        ".whole-lanyard-whatsapp-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            openWhatsappModal(getWholeLanyard());
        },
    );

    /**
     * ======================================================
     * INDIVIDUAL LANYARD WHATSAPP
     * ======================================================
     */

    $(document).off("click.lanyardWhatsapp", ".lanyard-whatsapp-btn");

    $(document).on(
        "click.lanyardWhatsapp",
        ".lanyard-whatsapp-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            const source = getLanyardFromButton(this);

            openWhatsappModal(source);
        },
    );

    /**
     * ======================================================
     * CONFIRM WHATSAPP
     * ======================================================
     */

    $(document).off("click.confirmLanyardWhatsapp", "#confirmLanyardWhatsapp");

    $(document).on(
        "click.confirmLanyardWhatsapp",
        "#confirmLanyardWhatsapp",
        async function (e) {
            e.preventDefault();

            e.stopPropagation();

            if (!whatsappSource) {
                alert("Unable to find the selected lanyard.");

                return;
            }

            const number = normalizeBangladeshNumber(
                $("#lanyardWhatsappNumber").val(),
            );

            if (!number) {
                $("#lanyardWhatsappError")
                    .removeClass("d-none")
                    .text("Please enter a valid Bangladesh WhatsApp number.");

                return;
            }

            $("#lanyardWhatsappError").addClass("d-none").text("");

            const button = $(this);

            const originalHtml = button.html();

            button
                .prop("disabled", true)
                .html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i>' +
                        "Preparing...",
                );

            try {
                /*
                 * Generate image in memory.
                 */
                const file = await generateImageFile(whatsappSource);

                /*
                 * ==================================================
                 * NATIVE SHARE
                 * ==================================================
                 *
                 * On Android/iPhone this can show WhatsApp as a
                 * share target and pass lanyard.png directly.
                 */
                if (
                    navigator.share &&
                    navigator.canShare &&
                    navigator.canShare({
                        files: [file],
                    })
                ) {
                    try {
                        await navigator.share({
                            title: "Specialist Lanyard",

                            text: "Specialist Lanyard",

                            files: [file],
                        });

                        $("#lanyardWhatsAppModal").modal("hide");

                        return;
                    } catch (error) {
                        /*
                         * User cancelled Share.
                         */
                        if (error && error.name === "AbortError") {
                            return;
                        }

                        console.error("Native share failed:", error);
                    }
                }

                /*
                 * ==================================================
                 * FALLBACK
                 * ==================================================
                 *
                 * A normal browser cannot attach a generated File
                 * to WhatsApp Web automatically.
                 *
                 * Open WhatsApp conversation instead.
                 */

                const whatsappUrl =
                    "https://wa.me/" +
                    number +
                    "?text=" +
                    encodeURIComponent("Specialist Lanyard");

                window.open(whatsappUrl, "_blank");

                $("#lanyardWhatsAppModal").modal("hide");

                alert(
                    "WhatsApp was opened. " +
                        "This browser does not support direct file sharing. " +
                        "Use a device/browser that supports file sharing to send the image directly.",
                );
            } catch (error) {
                console.error("WhatsApp lanyard error:", error);

                alert("Unable to prepare the lanyard image.");
            } finally {
                button.prop("disabled", false).html(originalHtml);
            }
        },
    );

    /**
     * ======================================================
     * CLEANUP
     * ======================================================
     */

    $(document).on(
        "hidden.bs.modal.lanyardWhatsapp",
        "#lanyardWhatsAppModal",
        function () {
            whatsappSource = null;

            $("#lanyardWhatsappError").addClass("d-none").text("");

            cleanupModalBackdrop();
        },
    );

    function cleanupModalBackdrop() {
        setTimeout(function () {
            /*
             * Remove stale Bootstrap backdrop.
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

    window.LanyardWhatsApp = {
        open: openWhatsappModal,
    };
})(jQuery);
