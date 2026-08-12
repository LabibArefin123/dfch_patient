/**
 * LANYARD WHATSAPP
 */

(function ($) {
    "use strict";

    let whatsappSource = null;

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

                    <div class="modal-content">

                        <div class="modal-header bg-success text-white">

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


                        <div class="modal-body">

                            <div class="form-group">

                                <label for="lanyardWhatsappNumber">
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
                                class="btn btn-success"
                                id="confirmLanyardWhatsapp"
                            >
                                <i class="fab fa-whatsapp mr-1"></i>
                                Continue
                            </button>

                        </div>

                    </div>

                </div>

            </div>
        `;

        $("body").append(modal);
    }

    async function generateImage(element) {
        if (!window.html2canvas) {
            alert("html2canvas is required for WhatsApp image generation.");

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

    function normalizeBangladeshNumber(value) {
        let number = String(value || "").replace(/\D/g, "");

        if (number.startsWith("880")) {
            number = number.substring(3);
        }

        if (number.startsWith("0")) {
            number = number.substring(1);
        }

        if (number.length !== 10 || !number.startsWith("1")) {
            return null;
        }

        return "880" + number;
    }

    $(document).off("click.lanyardWhatsapp", ".lanyard-whatsapp-btn");

    $(document).on(
        "click.lanyardWhatsapp",
        ".lanyard-whatsapp-btn",
        function (e) {
            e.preventDefault();
            e.stopPropagation();

            whatsappSource = getLanyardFromButton(this);

            if (!whatsappSource) {
                alert("Unable to find the selected lanyard.");

                return;
            }

            createWhatsappModal();

            $("#lanyardWhatsappNumber").val("");

            $("#lanyardWhatsappError").addClass("d-none").text("");

            $("#lanyardWhatsAppModal").modal("show");
        },
    );

    $(document).off("click.lanyardWhatsappConfirm", "#confirmLanyardWhatsapp");

    $(document).on(
        "click.lanyardWhatsappConfirm",
        "#confirmLanyardWhatsapp",
        async function () {
            if (!whatsappSource) {
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

            const button = $(this);

            button
                .prop("disabled", true)
                .html(
                    '<i class="fas fa-spinner fa-spin mr-1"></i> Preparing...',
                );

            try {
                const canvas = await generateImage(whatsappSource);

                if (!canvas) {
                    return;
                }

                canvas.toBlob(async function (blob) {
                    if (!blob) {
                        return;
                    }

                    const file = new File([blob], "lanyard.png", {
                        type: "image/png",
                    });

                    /*
                        |--------------------------------------------------------------------------
                        | Native share if supported
                        |--------------------------------------------------------------------------
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
                                title: "Lanyard",

                                text: "Lanyard Design",

                                files: [file],
                            });
                        } catch (error) {
                            if (error.name !== "AbortError") {
                                console.error(error);
                            }
                        }
                    } else {
                        /*
                            |--------------------------------------------------------------------------
                            | WhatsApp fallback
                            |--------------------------------------------------------------------------
                            */

                        window.open(
                            "https://wa.me/" +
                                number +
                                "?text=" +
                                encodeURIComponent("Lanyard Design"),
                            "_blank",
                        );
                    }

                    $("#lanyardWhatsAppModal").modal("hide");
                }, "image/png");
            } finally {
                button
                    .prop("disabled", false)
                    .html('<i class="fab fa-whatsapp mr-1"></i> Continue');
            }
        },
    );

    $(document).on(
        "hidden.bs.modal.lanyardWhatsapp",
        "#lanyardWhatsAppModal",
        function () {
            whatsappSource = null;

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
