$(function () {
    let whatsappLanyardSource = null;

    function getWholeLanyard() {
        const selected = window.selectedLanyard;
        if (selected && selected.length) return selected.first()[0];
        const active = document.querySelector(".lanyard-card.active");
        if (active) return active;
        return document.querySelector(".lanyard-card");
    }

    function createWhatsappModal() {
        if ($("#lanyardWhatsAppModal").length) return;

        $("body").append(`
<div class="modal fade" id="lanyardWhatsAppModal" tabindex="-1" aria-labelledby="lanyardWhatsAppModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow-lg">
<div class="modal-header bg-success text-white">
<h5 class="modal-title" id="lanyardWhatsAppModalLabel">
<i class="fab fa-whatsapp me-2"></i>
Send Lanyard via WhatsApp
</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body p-4">
<div class="text-center mb-4">
<div class="lanyard-modal-icon lanyard-whatsapp-icon">
<i class="fab fa-whatsapp"></i>
</div>
<h5 class="mb-1">WhatsApp Recipient</h5>
<p class="text-muted mb-0">
Choose the WhatsApp number for this lanyard.
</p>
</div>

<div class="mb-3">
<label for="lanyardWhatsappNumber" class="form-label fw-semibold">
<i class="fas fa-phone-alt me-1"></i>
WhatsApp Number
</label>

<div class="input-group">
<span class="input-group-text">+880</span>
<input type="tel" id="lanyardWhatsappNumber" class="form-control lanyard-modal-input" value="1776197999" maxlength="10" placeholder="1776197999" autocomplete="off">
</div>

<div class="lanyard-modal-help text-muted mt-1">
Example: 01776197999
</div>

<div id="lanyardWhatsappNumberError" class="text-danger small mt-1 d-none"></div>
</div>

<div class="alert alert-light border mb-0">
<i class="fas fa-info-circle text-success me-1"></i>
The complete selected lanyard will be generated as a PNG image.
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
<i class="fas fa-times me-1"></i>
Cancel
</button>

<button type="button" class="btn btn-success" id="confirmLanyardWhatsapp">
<i class="fab fa-whatsapp me-1"></i>
Send to WhatsApp
</button>
</div>

</div>
</div>
</div>
`);
    }

    function normalizeNumber() {
        let number = $.trim($("#lanyardWhatsappNumber").val()).replace(
            /\D/g,
            "",
        );

        if (number.startsWith("880")) {
            number = number.substring(3);
        }

        if (number.startsWith("0")) {
            number = number.substring(1);
        }

        if (number.length !== 10) return null;
        if (!number.startsWith("1")) return null;

        return "880" + number;
    }

    function openWhatsappModal(source) {
        if (!source) {
            alert("Please select a lanyard first.");
            return;
        }

        whatsappLanyardSource = source;

        createWhatsappModal();

        $("#lanyardWhatsappNumber").val("1776197999");
        $("#lanyardWhatsappNumberError").addClass("d-none").text("");

        $("#lanyardWhatsAppModal").modal("show");
    }

    async function generateLanyardImage(source) {
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

            return await new Promise(function (resolve, reject) {
                canvas.toBlob(function (blob) {
                    if (blob) {
                        resolve({
                            blob: blob,
                            canvas: canvas,
                        });
                    } else {
                        reject(new Error("Unable to create PNG."));
                    }
                }, "image/png");
            });
        } finally {
            if (document.body.contains(wrapper)) {
                document.body.removeChild(wrapper);
            }
        }
    }

    async function sendWhatsapp() {
        const source = whatsappLanyardSource || getWholeLanyard();

        if (!source) {
            alert("Please select a lanyard first.");
            return;
        }

        const number = normalizeNumber();

        if (!number) {
            $("#lanyardWhatsappNumberError")
                .removeClass("d-none")
                .text("Please enter a valid Bangladesh mobile number.");
            return;
        }

        const button = $("#confirmLanyardWhatsapp");
        const originalHtml = button.html();

        button
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm me-1"></span> Creating image...',
            );

        try {
            const result = await generateLanyardImage(source);

            const link = document.createElement("a");
            link.download = "lanyard.png";
            link.href = result.canvas.toDataURL("image/png");
            link.click();

            const message = encodeURIComponent("Specialist Lanyard");

            $("#lanyardWhatsAppModal").modal("hide");

            setTimeout(function () {
                window.open(
                    "https://wa.me/" + number + "?text=" + message,
                    "_blank",
                );

                alert(
                    "The lanyard image has been downloaded as lanyard.png. WhatsApp has been opened for the selected number. Please attach the downloaded image to the chat.",
                );
            }, 500);
        } catch (error) {
            console.error(error);
            alert("Unable to create the lanyard image.");
        } finally {
            button.prop("disabled", false).html(originalHtml);
        }
    }

    $(document).on(
        "click",
        ".whole-lanyard-whatsapp-btn,.whole-card-whatsapp-btn",
        function (e) {
            e.preventDefault();
            openWhatsappModal(getWholeLanyard());
        },
    );

    $(document).on("click", ".lanyard-whatsapp-btn", function (e) {
        e.preventDefault();

        const source = $(this).closest(
            ".lanyard-strip,.lanyard02-strip,.lanyard03-strip",
        )[0];

        openWhatsappModal(source);
    });

    $(document).on("click", "#confirmLanyardWhatsapp", function (e) {
        e.preventDefault();
        sendWhatsapp();
    });

    $(document).on("input", "#lanyardWhatsappNumber", function () {
        let value = $(this).val().replace(/\D/g, "");

        if (value.startsWith("880")) {
            value = value.substring(3);
        }

        if (value.length > 10) {
            value = value.substring(0, 10);
        }

        $(this).val(value);

        $("#lanyardWhatsappNumberError").addClass("d-none").text("");
    });
});
