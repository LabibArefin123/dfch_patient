(function (window, $) {
    "use strict";

    const Email = (window.specialistCardEmail =
        window.specialistCardEmail || {});

    /*
    |--------------------------------------------------------------------------
    | OPEN EMAIL MODAL
    |--------------------------------------------------------------------------
    */

    $(document).on(
        "click",
        ".print-preview-email-btn,#printPreviewEmailButton",
        function (e) {
            e.preventDefault();
            e.stopPropagation();

            Email.addModal();

            const currentTheme = Email.getSelectedTheme();

            $("#emailCardTheme").val(currentTheme);

            $("#emailCardRecipient").val("");

            $("#printPreviewEmailModal").modal({
                backdrop: false,
                keyboard: true,
                show: true,
            });
        },
    );

    /*
    |--------------------------------------------------------------------------
    | THEME CHANGE
    |--------------------------------------------------------------------------
    */

    $(document).on("change", "#emailCardTheme", function () {
        const theme = $(this).val();

        const cards = Email.getThemeCards(theme);

        if (!cards.front && !cards.back) {
            $(this).val(Email.getSelectedTheme());

            alert("The selected card theme is not available.");
        }
    });

    /*
    |--------------------------------------------------------------------------
    | SEND EMAIL
    |--------------------------------------------------------------------------
    */

    $(document).on("click", "#confirmPrintPreviewEmail", async function (e) {
        e.preventDefault();

        const email = $("#emailCardRecipient").val().trim();

        const theme = $("#emailCardTheme").val();

        /*
            |--------------------------------------------------------------------------
            | EMAIL REQUIRED
            |--------------------------------------------------------------------------
            */

        if (!email) {
            alert("Please enter the recipient email address.");

            $("#emailCardRecipient").focus();

            return;
        }

        /*
            |--------------------------------------------------------------------------
            | HTML EMAIL VALIDATION
            |--------------------------------------------------------------------------
            */

        const emailInput = document.getElementById("emailCardRecipient");

        if (!emailInput.checkValidity()) {
            emailInput.reportValidity();

            return;
        }

        /*
            |--------------------------------------------------------------------------
            | BUTTON LOADING
            |--------------------------------------------------------------------------
            */

        const $button = $(this);

        $button
            .prop("disabled", true)
            .html(
                '<i class="fas fa-spinner fa-spin mr-1"></i>' + "Generating...",
            );

        try {
            /*
                |--------------------------------------------------------------------------
                | GENERATE IMAGE
                |--------------------------------------------------------------------------
                */

            const canvas = await Email.generateImage(theme);

            if (!canvas) {
                $button
                    .prop("disabled", false)
                    .html(
                        '<i class="fas fa-paper-plane mr-1"></i>' + "Continue",
                    );

                return;
            }

            /*
                |--------------------------------------------------------------------------
                | DOWNLOAD IMAGE
                |--------------------------------------------------------------------------
                */

            Email.downloadCanvas(canvas, theme);

            /*
                |--------------------------------------------------------------------------
                | CLOSE MODAL
                |--------------------------------------------------------------------------
                */

            Email.cleanupModal();

            /*
                |--------------------------------------------------------------------------
                | OPEN EMAIL CLIENT
                |--------------------------------------------------------------------------
                */

            setTimeout(function () {
                Email.openEmailClient(email, theme);
            }, 500);
        } catch (error) {
            console.error("Email preparation failed:", error);

            alert("Unable to prepare the email.");
        } finally {
            $button
                .prop("disabled", false)
                .html('<i class="fas fa-paper-plane mr-1"></i>' + "Continue");
        }
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL SHOWN
    |--------------------------------------------------------------------------
    */

    $(document).on("shown.bs.modal", "#printPreviewEmailModal", function () {
        $("#emailCardRecipient").trigger("focus");
    });

    /*
    |--------------------------------------------------------------------------
    | MODAL HIDDEN
    |--------------------------------------------------------------------------
    */

    $(document).on("hidden.bs.modal", "#printPreviewEmailModal", function () {
        setTimeout(function () {
            Email.removeBackdrop();
        }, 50);
    });

    /*
    |--------------------------------------------------------------------------
    | INITIALIZE
    |--------------------------------------------------------------------------
    */

    $(function () {
        Email.addModal();
    });
})(window, jQuery);
