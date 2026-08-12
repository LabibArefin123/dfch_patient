$(function () {
    function getSelectedTheme() {
        return $("#card_theme").val() || "1";
    }

    function getThemeContainer(theme) {
        const containers = {
            1: ".card-preview-container",
            2: ".card-preview-container2",
            3: ".card-preview-container3",
        };
        let container = $(containers[theme]).first();
        if (!container.length)
            container = $(
                ".card-preview-container,.card-preview-container2,.card-preview-container3",
            )
                .filter(":visible")
                .first();
        return container;
    }

    function getThemeCards(theme) {
        const container = getThemeContainer(theme);
        if (!container.length) return { front: null, back: null };

        let front = null;
        let back = null;

        if (theme === "1") {
            front = container.find(".doctor-card").first();
            back = container.find(".doctor-card-back").first();
        }

        if (theme === "2") {
            front = container.find(".wide-card").first();
            back = container.find(".wide-card-back").first();
        }

        if (theme === "3") {
            front = container.find(".doctor-card-3").first();
            back = container.find(".doctor-card-back-3").first();
        }

        if (!front.length) {
            front = container
                .find(".doctor-card,.wide-card,.doctor-card-3")
                .first();
        }

        if (!back.length) {
            back = container
                .find(".doctor-card-back,.wide-card-back,.doctor-card-back-3")
                .first();
        }

        return {
            front: front.length ? front : null,
            back: back.length ? back : null,
        };
    }

    function addEmailModal() {
        if ($("#printPreviewEmailModal").length) return;

        const modal = `
<div class="modal fade" id="printPreviewEmailModal" tabindex="-1" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-danger text-white">
<h5 class="modal-title">
<i class="fas fa-envelope mr-2"></i>Pass Card via Email
</h5>
<button type="button" class="close text-white" data-bs-dismiss="modal" aria-label="Close">
<span>&times;</span>
</button>
</div>

<div class="modal-body">
<div class="form-group">
<label for="emailCardTheme">
<i class="fas fa-id-card mr-1"></i> Card Theme
</label>
<select id="emailCardTheme" class="form-control">
<option value="1">Theme 1</option>
<option value="2">Theme 2</option>
<option value="3">Theme 3</option>
</select>
</div>

<div class="form-group">
<label for="emailCardRecipient">
<i class="fas fa-envelope mr-1"></i> Recipient Email
</label>
<input type="email" id="emailCardRecipient" class="form-control" placeholder="example@gmail.com" autocomplete="email">
<small class="form-text text-muted">
Gmail, Yahoo, Outlook and other email addresses are supported.
</small>
</div>

<div class="alert alert-info mb-0">
<i class="fas fa-info-circle mr-1"></i>
The card image will be generated and downloaded first. Then your email application will open so you can attach the generated image.
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
<i class="fas fa-times mr-1"></i>Cancel
</button>

<button type="button" class="btn btn-danger" id="confirmPrintPreviewEmail">
<i class="fas fa-paper-plane mr-1"></i>Continue
</button>
</div>
</div>
</div>
</div>
`;

        $("body").append(modal);
    }

    function cleanClone(element) {
        const clone = element.clone(false);

        $(clone)
            .find(
                ".print-button-container,.print-card-actions,.whole-card-action-buttons,.lanyard-action-buttons,.whole-lanyard-action-buttons",
            )
            .remove();

        return clone;
    }

    async function generateEmailImage(theme) {
        if (!window.html2canvas) {
            alert("html2canvas is required for email image generation.");
            return null;
        }

        const cards = getThemeCards(theme);

        if (!cards.front && !cards.back) {
            alert("Unable to find the selected card theme.");
            return null;
        }

        const wrapper = document.createElement("div");

        wrapper.style.position = "fixed";
        wrapper.style.left = "-99999px";
        wrapper.style.top = "0";
        wrapper.style.display = "flex";
        wrapper.style.flexDirection = "row";
        wrapper.style.alignItems = "flex-start";
        wrapper.style.justifyContent = "center";
        wrapper.style.gap = "30px";
        wrapper.style.padding = "20px";
        wrapper.style.background = "#ffffff";
        wrapper.style.width = "max-content";
        wrapper.style.zIndex = "-9999";

        if (cards.front) {
            wrapper.appendChild(cleanClone(cards.front[0]));
        }

        if (cards.back) {
            wrapper.appendChild(cleanClone(cards.back[0]));
        }

        document.body.appendChild(wrapper);

        try {
            const canvas = await html2canvas(wrapper, {
                backgroundColor: "#ffffff",
                scale: 2,
                useCORS: true,
                allowTaint: false,
                logging: false,
            });

            document.body.removeChild(wrapper);

            return canvas;
        } catch (error) {
            if (document.body.contains(wrapper)) {
                document.body.removeChild(wrapper);
            }

            console.error(error);
            alert("Unable to generate the card image.");
            return null;
        }
    }

    function downloadCanvas(canvas, theme) {
        const link = document.createElement("a");

        link.download = "specialist-card-theme-" + theme + ".png";
        link.href = canvas.toDataURL("image/png");

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    function openEmailClient(email, theme) {
        const subject = "Specialist ID Card - Theme " + theme;

        const body =
            "Hello,%0D%0A%0D%0A" +
            "Please find the Specialist ID Card attached.%0D%0A" +
            "Card Theme: " +
            theme +
            "%0D%0A%0D%0A" +
            "Please attach the downloaded specialist-card-theme-" +
            theme +
            ".png image to this email.%0D%0A%0D%0A" +
            "Thank you.";

        const mailto =
            "mailto:" +
            encodeURIComponent(email) +
            "?subject=" +
            encodeURIComponent(subject) +
            "&body=" +
            body;

        window.location.href = mailto;
    }

    $(document).on(
        "click",
        ".print-preview-email-btn,#printPreviewEmailButton",
        function (e) {
            e.preventDefault();

            addEmailModal();

            const currentTheme = getSelectedTheme();

            $("#emailCardTheme").val(currentTheme);
            $("#emailCardRecipient").val("");

            $("#printPreviewEmailModal").modal("show");
        },
    );

    $(document).on("change", "#emailCardTheme", function () {
        const theme = $(this).val();

        const cards = getThemeCards(theme);

        if (!cards.front && !cards.back) {
            $(this).val(getSelectedTheme());
            alert("The selected card theme is not available.");
        }
    });

    $(document).on("click", "#confirmPrintPreviewEmail", async function (e) {
        e.preventDefault();

        const email = $("#emailCardRecipient").val().trim();
        const theme = $("#emailCardTheme").val();

        if (!email) {
            alert("Please enter the recipient email address.");
            $("#emailCardRecipient").focus();
            return;
        }

        const emailInput = document.getElementById("emailCardRecipient");

        if (!emailInput.checkValidity()) {
            emailInput.reportValidity();
            return;
        }

        const button = $(this);

        button.prop("disabled", true);
        button.html('<i class="fas fa-spinner fa-spin mr-1"></i>Generating...');

        try {
            const canvas = await generateEmailImage(theme);

            if (!canvas) {
                button.prop("disabled", false);
                button.html('<i class="fas fa-paper-plane mr-1"></i>Continue');
                return;
            }

            downloadCanvas(canvas, theme);

            $("#printPreviewEmailModal").modal("hide");

            setTimeout(function () {
                openEmailClient(email, theme);
            }, 700);
        } catch (error) {
            console.error(error);
            alert("Unable to prepare the email.");
        } finally {
            button.prop("disabled", false);
            button.html('<i class="fas fa-paper-plane mr-1"></i>Continue');
        }
    });

    $(document).on("shown.bs.modal", "#printPreviewEmailModal", function () {
        $("#emailCardRecipient").trigger("focus");
    });

    addEmailModal();
});
