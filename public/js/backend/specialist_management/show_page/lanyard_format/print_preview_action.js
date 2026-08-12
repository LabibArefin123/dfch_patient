/**
 * LANYARD EMAIL
 */

(function ($) {
    "use strict";

    let emailSource = null;

    function getLanyardFromButton(button) {
        const row = $(button).closest(".lanyard-row");

        if (!row.length) {
            return null;
        }

        return (
            row
                .children(".lanyard-strip, .lanyard02-strip, .lanyard03-strip")
                .first()[0] || null
        );
    }

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

                    <div class="modal-content">

                        <div class="modal-header">

                            <h5 class="modal-title">
                                <i class="fas fa-envelope mr-2"></i>
                                Email Lanyard
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

                            <div class="form-group">

                                <label for="lanyardEmailAddress">
                                    Recipient Email
                                </label>

                                <input
                                    type="email"
                                    id="lanyardEmailAddress"
                                    class="form-control"
                                    placeholder="example@gmail.com"
                                    autocomplete="email"
                                >

                                <small class="form-text text-muted">
                                    The lanyard image will be generated first.
                                </small>

                            </div>

                            <div
                                id="lanyardEmailError"
                                class="text-danger small d-none"
                            ></div>

                        </div>


                        <div class="modal-footer">

                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="btn btn-primary"
                                id="confirmLanyardEmail"
                            >
                                <i class="fas fa-paper-plane mr-1"></i>
                                Generate Email
                            </button>

                        </div>

                    </div>

                </div>

            </div>
        `;

        $("body").append(modal);
    }

    async function generateLanyardImage(element) {
        if (!window.html2canvas) {
            alert("html2canvas is required for lanyard image generation.");

            return null;
        }

        const clone = element.cloneNode(true);

        $(clone)
            .find(
                ".lanyard-action-buttons, " +
                    ".whole-lanyard-action-buttons, " +
                    ".whole-card-action-buttons",
            )
            .remove();

        clone.classList.add("lanyard-export-clone");

        document.body.appendChild(clone);

        try {
            const canvas = await html2canvas(clone, {
                backgroundColor: "#ffffff",

                scale: 2,

                useCORS: true,

                allowTaint: false,

                logging: false,
            });

            document.body.removeChild(clone);

            return canvas;
        } catch (error) {
            if (document.body.contains(clone)) {
                document.body.removeChild(clone);
            }

            console.error(error);

            alert("Unable to generate lanyard image.");

            return null;
        }
    }

    $(document).off("click.lanyardEmail", ".lanyard-email-btn");

    $(document).on("click.lanyardEmail", ".lanyard-email-btn", function (e) {
        e.preventDefault();
        e.stopPropagation();

        emailSource = getLanyardFromButton(this);

        if (!emailSource) {
            alert("Unable to find the selected lanyard.");

            return;
        }

        createEmailModal();

        $("#lanyardEmailAddress").val("");

        $("#lanyardEmailError").addClass("d-none").text("");

        $("#lanyardEmailModal").modal("show");
    });

    $(document).off("click.lanyardEmailConfirm", "#confirmLanyardEmail");

    $(document).on(
        "click.lanyardEmailConfirm",
        "#confirmLanyardEmail",
        async function () {
            if (!emailSource) {
                return;
            }

            const email = $.trim($("#lanyardEmailAddress").val());

            if (!email) {
                $("#lanyardEmailError")
                    .removeClass("d-none")
                    .text("Please enter an email address.");

                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(email)) {
                $("#lanyardEmailError")
                    .removeClass("d-none")
                    .text("Please enter a valid email address.");

                return;
            }

            const button = $(this);

            button
                .prop("disabled", true)
                .html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i> Generating...',
                );

            try {
                const canvas = await generateLanyardImage(emailSource);

                if (!canvas) {
                    return;
                }

                const link = document.createElement("a");

                link.download = "lanyard.png";

                link.href = canvas.toDataURL("image/png");

                link.click();

                /*
                |--------------------------------------------------------------------------
                | Open mail client
                |--------------------------------------------------------------------------
                */

                setTimeout(function () {
                    window.location.href =
                        "mailto:" +
                        encodeURIComponent(email) +
                        "?subject=" +
                        encodeURIComponent("Lanyard Design") +
                        "&body=" +
                        encodeURIComponent(
                            "Please attach the generated lanyard.png image.",
                        );
                }, 300);

                $("#lanyardEmailModal").modal("hide");
            } finally {
                button
                    .prop("disabled", false)
                    .html(
                        '<i class="fas fa-paper-plane mr-1"></i> Generate Email',
                    );
            }
        },
    );

    $(document).on(
        "hidden.bs.modal.lanyardEmail",
        "#lanyardEmailModal",
        function () {
            emailSource = null;

            cleanupModalBackdrop();
        },
    );

    function cleanupModalBackdrop() {
        setTimeout(function () {
            if (!$(".modal.show").length) {
                $(".modal-backdrop").remove();

                $("body").removeClass("modal-open").css({
                    paddingRight: "",
                    overflow: "",
                });
            }
        }, 100);
    }
})(jQuery);
