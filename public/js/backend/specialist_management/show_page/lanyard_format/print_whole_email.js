/**
 * ==========================================================
 * LANYARD EMAIL
 * ==========================================================
 *
 * Features:
 *
 * - Uses currently selected lanyard theme
 * - Design 01 / 02 / 03 supported
 * - Generates PNG in memory
 * - DOES NOT download the PNG
 * - Uses Web Share API when supported
 * - Can share the generated PNG to Gmail / Mail / other
 *   installed sharing applications
 * - No dark Bootstrap backdrop
 *
 * IMPORTANT:
 *
 * A browser cannot force Gmail/Yahoo/Outlook Web to receive
 * a generated file as an attachment through mailto or URL.
 *
 * Native Web Share is therefore used when available.
 * ==========================================================
 */

(function ($) {
    "use strict";

    let emailLanyardSource = null;

    /**
     * ======================================================
     * GET SELECTED LANYARD
     * ======================================================
     *
     * Your theme selector hides:
     *
     * .lanyard-preview-container
     * .lanyard-preview-container2
     * .lanyard-preview-container3
     *
     * So the visible card is the selected design.
     */

    function getWholeLanyard() {
        /*
         * Existing global selection, if available.
         */
        if (window.selectedLanyard && window.selectedLanyard.length) {
            return window.selectedLanyard.first()[0];
        }

        /*
         * Active card.
         */
        const active = document.querySelector(".lanyard-card.active");

        if (active) {
            return active;
        }

        /*
         * Current visible theme.
         */
        const visibleContainers = document.querySelectorAll(
            ".lanyard-preview-container:visible, " +
                ".lanyard-preview-container2:visible, " +
                ".lanyard-preview-container3:visible",
        );

        /*
         * :visible is a jQuery selector and does not work
         * with querySelectorAll.
         *
         * Therefore use jQuery here.
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
     * CREATE EMAIL MODAL
     * ======================================================
     */

    function createEmailModal() {
        if ($("#lanyardEmailModal").length) {
            return;
        }

        const modal = `

            <div
                class="modal fade"
                id="lanyardEmailModal"
                tabindex="-1"
                role="dialog"
                aria-hidden="true"
            >

                <div
                    class="modal-dialog modal-dialog-centered"
                    role="document"
                >

                    <div class="modal-content border-0 shadow-lg">

                        <div class="modal-header bg-primary text-white">

                            <h5 class="modal-title">

                                <i class="fas fa-envelope mr-2"></i>

                                Send Lanyard by Email

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

                                <div class="lanyard-modal-icon lanyard-email-icon">

                                    <i class="fas fa-envelope"></i>

                                </div>


                                <h5 class="mb-1">

                                    Send Lanyard

                                </h5>


                                <p class="text-muted mb-0">

                                    The selected lanyard image will be
                                    prepared without downloading it.

                                </p>

                            </div>


                            <div class="mb-3">

                                <label
                                    for="lanyardEmailProvider"
                                    class="form-label font-weight-semibold"
                                >

                                    <i class="fas fa-at mr-1"></i>

                                    Email Service

                                </label>


                                <select
                                    id="lanyardEmailProvider"
                                    class="form-control"
                                >

                                    <option value="share">
                                        Native Share / Mail App
                                    </option>

                                    <option value="gmail">
                                        Gmail
                                    </option>

                                    <option value="outlook">
                                        Outlook
                                    </option>

                                    <option value="yahoo">
                                        Yahoo Mail
                                    </option>

                                </select>

                            </div>


                            <div class="mb-3">

                                <label
                                    for="lanyardEmailAddress"
                                    class="form-label font-weight-semibold"
                                >

                                    Recipient Email

                                </label>


                                <input
                                    type="email"
                                    id="lanyardEmailAddress"
                                    class="form-control"
                                    placeholder="doctor@example.com"
                                    autocomplete="off"
                                >


                                <div
                                    id="lanyardEmailError"
                                    class="text-danger small mt-1 d-none"
                                ></div>

                            </div>


                            <div class="alert alert-light border mb-0">

                                <i class="fas fa-info-circle text-primary mr-1"></i>

                                The lanyard image will be generated in memory.
                                It will not be downloaded automatically.

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
                                class="btn btn-primary"
                                id="confirmLanyardEmail"
                            >

                                <i class="fas fa-envelope mr-1"></i>

                                Send Lanyard

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
     * OPEN EMAIL MODAL
     * ======================================================
     */

    function openEmailModal(source) {
        if (!source) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        emailLanyardSource = source;

        createEmailModal();

        $("#lanyardEmailAddress").val("").trigger("focus");

        $("#lanyardEmailError").addClass("d-none").text("");

        /*
         * Bootstrap 4
         *
         * backdrop:false prevents dark screen.
         */
        $("#lanyardEmailModal").modal({
            backdrop: false,

            keyboard: true,

            focus: true,

            show: true,
        });
    }

    /**
     * ======================================================
     * CREATE PNG BLOB
     * ======================================================
     *
     * IMPORTANT:
     *
     * No download happens here.
     *
     * We only create:
     *
     * Blob -> File
     *
     * in memory.
     */

    async function generateEmailFile(source) {
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

        const clone = source.cloneNode(true);

        /*
         * Remove all buttons.
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
                throw new Error("Unable to create PNG.");
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
     * SEND EMAIL
     * ======================================================
     */

    async function sendEmail() {
        const source = emailLanyardSource || getWholeLanyard();

        if (!source) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        const email = $.trim($("#lanyardEmailAddress").val());

        /*
         * Validate email.
         */
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !emailPattern.test(email)) {
            $("#lanyardEmailError")
                .removeClass("d-none")
                .text("Please enter a valid email address.");

            return;
        }

        $("#lanyardEmailError").addClass("d-none").text("");

        const button = $("#confirmLanyardEmail");

        const originalHtml = button.html();

        button
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm mr-1"></span>' +
                    "Preparing...",
            );

        try {
            /*
             * Generate image entirely in memory.
             */
            const file = await generateEmailFile(source);

            /*
             * ==================================================
             * NATIVE FILE SHARE
             * ==================================================
             *
             * This is the only browser-supported way to pass
             * the generated image as an actual file attachment
             * to compatible apps.
             */

            if (
                navigator.share &&
                navigator.canShare &&
                navigator.canShare({
                    files: [file],
                })
            ) {
                await navigator.share({
                    title: "Specialist Lanyard",

                    text: "Please find the Specialist Lanyard image.",

                    files: [file],
                });

                $("#lanyardEmailModal").modal("hide");

                return;
            }

            /*
             * ==================================================
             * DESKTOP FALLBACK
             * ==================================================
             *
             * Gmail / Outlook / Yahoo URLs cannot accept a
             * generated browser File as an attachment.
             *
             * So open the selected provider with the email
             * information prefilled.
             */

            const subject = encodeURIComponent("Specialist Lanyard");

            const body = encodeURIComponent(
                "Dear Sir/Madam,\n\n" +
                    "Please find the Specialist Lanyard image attached.\n\n" +
                    "Regards",
            );

            const provider = $("#lanyardEmailProvider").val();

            let url = "";

            if (provider === "gmail") {
                url =
                    "https://mail.google.com/mail/?view=cm&fs=1" +
                    "&to=" +
                    encodeURIComponent(email) +
                    "&su=" +
                    subject +
                    "&body=" +
                    body;
            } else if (provider === "outlook") {
                url =
                    "https://outlook.live.com/mail/0/deeplink/compose" +
                    "?to=" +
                    encodeURIComponent(email) +
                    "&subject=" +
                    subject +
                    "&body=" +
                    body;
            } else if (provider === "yahoo") {
                url =
                    "https://compose.mail.yahoo.com/" +
                    "?to=" +
                    encodeURIComponent(email) +
                    "&subject=" +
                    subject +
                    "&body=" +
                    body;
            } else {
                url =
                    "mailto:" +
                    encodeURIComponent(email) +
                    "?subject=" +
                    subject +
                    "&body=" +
                    body;
            }

            window.open(url, "_blank");

            $("#lanyardEmailModal").modal("hide");

            alert(
                "Your email composer has been opened. " +
                    "This browser cannot automatically attach the generated image here. " +
                    "On a supported device, use the native Share option to send the image directly.",
            );
        } catch (error) {
            /*
             * User cancelled native sharing.
             */
            if (error && error.name === "AbortError") {
                return;
            }

            console.error("Lanyard email error:", error);

            alert("Unable to prepare the lanyard image.");
        } finally {
            button.prop("disabled", false).html(originalHtml);
        }
    }

    /**
     * ======================================================
     * WHOLE CARD EMAIL BUTTON
     * ======================================================
     */

    $(document).off("click.wholeCardEmail", ".whole-card-email-btn");

    $(document).on(
        "click.wholeCardEmail",
        ".whole-card-email-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            openEmailModal(getWholeLanyard());
        },
    );

    /**
     * ======================================================
     * OLD CLASS SUPPORT
     * ======================================================
     */

    $(document).off("click.wholeLanyardEmail", ".whole-lanyard-email-btn");

    $(document).on(
        "click.wholeLanyardEmail",
        ".whole-lanyard-email-btn",
        function (e) {
            e.preventDefault();

            e.stopPropagation();

            openEmailModal(getWholeLanyard());
        },
    );

    /**
     * ======================================================
     * INDIVIDUAL LANYARD EMAIL
     * ======================================================
     */

    $(document).off("click.lanyardEmail", ".lanyard-email-btn");

    $(document).on("click.lanyardEmail", ".lanyard-email-btn", function (e) {
        e.preventDefault();

        e.stopPropagation();

        const source = $(this)
            .closest(".lanyard-row")
            .find(
                ".lanyard-strip, " + ".lanyard02-strip, " + ".lanyard03-strip",
            )
            .first()[0];

        openEmailModal(source);
    });

    /**
     * ======================================================
     * CONFIRM
     * ======================================================
     */

    $(document).off("click.confirmLanyardEmail", "#confirmLanyardEmail");

    $(document).on(
        "click.confirmLanyardEmail",
        "#confirmLanyardEmail",
        function (e) {
            e.preventDefault();

            sendEmail();
        },
    );

    /**
     * ======================================================
     * MODAL CLEANUP
     * ======================================================
     */

    $(document).on(
        "hidden.bs.modal.lanyardEmail",
        "#lanyardEmailModal",
        function () {
            emailLanyardSource = null;

            $("#lanyardEmailError").addClass("d-none").text("");

            cleanupModalBackdrop();
        },
    );

    function cleanupModalBackdrop() {
        setTimeout(function () {
            $(".modal-backdrop").remove();

            $("body").removeClass("modal-open").css({
                paddingRight: "",

                overflow: "",
            });
        }, 100);
    }
})(jQuery);
