$(function () {
    let emailLanyardSource = null;

    function getWholeLanyard() {
        const selected = window.selectedLanyard;

        if (selected && selected.length) {
            return selected.first()[0];
        }

        const active = document.querySelector(".lanyard-card.active");

        if (active) {
            return active;
        }

        return document.querySelector(".lanyard-card");
    }

    function createEmailModal() {
        if ($("#lanyardEmailModal").length) return;

        $("body").append(`
<div class="modal fade" id="lanyardEmailModal" tabindex="-1" aria-labelledby="lanyardEmailModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow-lg">

<div class="modal-header bg-primary text-white">
<h5 class="modal-title" id="lanyardEmailModalLabel">
<i class="fas fa-envelope me-2"></i>
Send Lanyard by Email
</h5>

<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body p-4">

<div class="text-center mb-4">
<div class="lanyard-modal-icon lanyard-email-icon">
<i class="fas fa-envelope"></i>
</div>

<h5 class="mb-1">
Choose Email Service
</h5>

<p class="text-muted mb-0">
The lanyard will be generated as a PNG image.
</p>
</div>

<div class="mb-3">
<label class="form-label fw-semibold">
<i class="fas fa-at me-1"></i>
Email Service
</label>

<select id="lanyardEmailProvider" class="form-control">
<option value="gmail">Gmail</option>
<option value="yahoo">Yahoo Mail</option>
<option value="outlook">Outlook</option>
<option value="mailto">Default Email App</option>
</select>
</div>

<div class="mb-3">
<label for="lanyardEmailAddress" class="form-label fw-semibold">
Recipient Email
</label>

<input
type="email"
id="lanyardEmailAddress"
class="form-control"
placeholder="doctor@example.com"
autocomplete="off"
>

<div id="lanyardEmailError" class="text-danger small mt-1 d-none"></div>
</div>

<div class="alert alert-light border mb-0">
<i class="fas fa-info-circle text-primary me-1"></i>
After generating the image, attach <strong>lanyard.png</strong> to the email.
</div>

</div>

<div class="modal-footer">

<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
<i class="fas fa-times me-1"></i>
Cancel
</button>

<button type="button" class="btn btn-primary" id="confirmLanyardEmail">
<i class="fas fa-envelope me-1"></i>
Continue to Email
</button>

</div>

</div>
</div>
</div>
`);
    }

    function openEmailModal(source) {
        if (!source) {
            alert("Please select a lanyard first.");
            return;
        }

        emailLanyardSource = source;

        createEmailModal();

        $("#lanyardEmailAddress").val("");
        $("#lanyardEmailError").addClass("d-none").text("");

        $("#lanyardEmailModal").modal("show");
    }

    async function generateEmailImage(source) {
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

        const clone = source.cloneNode(true);

        $(clone)
            .find(
                ".lanyard-action-buttons,.whole-lanyard-action-buttons,.whole-card-action-buttons",
            )
            .remove();

        wrapper.appendChild(clone);
        document.body.appendChild(wrapper);

        try {
            const canvas = await html2canvas(wrapper, {
                backgroundColor: "#ffffff",
                scale: 2,
                useCORS: true,
                logging: false,
            });

            const link = document.createElement("a");

            link.download = "lanyard.png";
            link.href = canvas.toDataURL("image/png");
            link.click();

            return true;
        } finally {
            if (document.body.contains(wrapper)) {
                document.body.removeChild(wrapper);
            }
        }
    }

    async function sendEmail() {
        const source = emailLanyardSource || getWholeLanyard();

        if (!source) {
            alert("Please select a lanyard first.");
            return;
        }

        const email = $.trim($("#lanyardEmailAddress").val());

        if (!email || !email.includes("@")) {
            $("#lanyardEmailError")
                .removeClass("d-none")
                .text("Please enter a valid email address.");

            return;
        }

        $("#lanyardEmailError").addClass("d-none").text("");

        const provider = $("#lanyardEmailProvider").val();

        const button = $("#confirmLanyardEmail");
        const originalHtml = button.html();

        button
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm me-1"></span> Preparing...',
            );

        try {
            await generateEmailImage(source);

            const subject = encodeURIComponent("Specialist Lanyard");
            const body = encodeURIComponent(
                "Dear Sir/Madam,\n\nPlease find the Specialist Lanyard image attached.\n\nRegards",
            );

            $("#lanyardEmailModal").modal("hide");

            setTimeout(function () {
                if (provider === "gmail") {
                    window.open(
                        "https://mail.google.com/mail/?view=cm&fs=1&to=" +
                            encodeURIComponent(email) +
                            "&su=" +
                            subject +
                            "&body=" +
                            body,
                        "_blank",
                    );
                } else if (provider === "yahoo") {
                    window.open(
                        "https://compose.mail.yahoo.com/?to=" +
                            encodeURIComponent(email) +
                            "&subject=" +
                            subject +
                            "&body=" +
                            body,
                        "_blank",
                    );
                } else if (provider === "outlook") {
                    window.open(
                        "https://outlook.live.com/mail/0/deeplink/compose?to=" +
                            encodeURIComponent(email) +
                            "&subject=" +
                            subject +
                            "&body=" +
                            body,
                        "_blank",
                    );
                } else {
                    window.location.href =
                        "mailto:" +
                        encodeURIComponent(email) +
                        "?subject=" +
                        subject +
                        "&body=" +
                        body;
                }

                alert(
                    "lanyard.png has been downloaded. Please attach it to the email before sending.",
                );
            }, 500);
        } catch (error) {
            console.error(error);
            alert("Unable to generate the lanyard image.");
        } finally {
            button.prop("disabled", false).html(originalHtml);
        }
    }

    $(document).on(
        "click",
        ".whole-lanyard-email-btn,.whole-card-email-btn",
        function (e) {
            e.preventDefault();
            openEmailModal(getWholeLanyard());
        },
    );

    $(document).on("click", ".lanyard-email-btn", function (e) {
        e.preventDefault();

        const source = $(this).closest(
            ".lanyard-strip,.lanyard02-strip,.lanyard03-strip",
        )[0];

        openEmailModal(source);
    });

    $(document).on("click", "#confirmLanyardEmail", function (e) {
        e.preventDefault();
        sendEmail();
    });
});
