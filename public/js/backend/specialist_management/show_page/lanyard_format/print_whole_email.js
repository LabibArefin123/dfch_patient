(function ($) {
    "use strict";
    let emailLanyardSource = null;
    function getSelectedLanyard() {
        if (window.selectedLanyard && window.selectedLanyard.length)
            return window.selectedLanyard.first()[0];
        const active = document.querySelector(".lanyard-card.active");
        if (active) return active;
        const visible = $(
            ".lanyard-preview-container:visible,.lanyard-preview-container2:visible,.lanyard-preview-container3:visible",
        ).first();
        if (visible.length) {
            const card = visible.find(".lanyard-card").first();
            if (card.length) return card[0];
        }
        return document.querySelector(".lanyard-card");
    }
    function createEmailModal() {
        if ($("#lanyardEmailModal").length) return;
        $("body").append(`
<div class="modal fade" id="lanyardEmailModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content border-0 shadow-lg">
<div class="modal-header bg-danger text-white">
<h5 class="modal-title"><i class="fas fa-envelope mr-2"></i>Send Lanyard by Email</h5>
<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
</div>
<div class="modal-body p-4">
<div class="text-center mb-4">
<div class="mb-2"><i class="fas fa-envelope-open-text fa-3x text-danger"></i></div>
<h5 class="mb-1">Send Lanyard</h5>
<p class="text-muted mb-0">Choose an email service and enter the recipient.</p>
</div>
<div class="form-group">
<label for="lanyardEmailProvider"><i class="fas fa-globe mr-1"></i>Email Service</label>
<select id="lanyardEmailProvider" class="form-control">
<option value="gmail">Gmail</option>
<option value="yahoo">Yahoo Mail</option>
<option value="outlook">Outlook</option>
<option value="share">Device Share</option>
</select>
</div>
<div class="form-group">
<label for="lanyardEmailAddress"><i class="fas fa-at mr-1"></i>Recipient Email</label>
<input type="email" id="lanyardEmailAddress" class="form-control" placeholder="doctor@example.com" autocomplete="off">
<div id="lanyardEmailError" class="text-danger small mt-2 d-none"></div>
</div>
<div class="alert alert-light border mb-0">
<i class="fas fa-info-circle text-danger mr-1"></i>
The lanyard image will be generated first. Gmail, Yahoo and Outlook Web do not allow a browser to automatically attach a generated file through their compose URL.
</div>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times mr-1"></i>Cancel</button>
<button type="button" class="btn btn-danger" id="confirmLanyardEmail"><i class="fas fa-paper-plane mr-1"></i>Continue</button>
</div>
</div>
</div>
</div>`);
    }
    function openEmailModal(source) {
        if (!source) {
            alert("Unable to find the selected lanyard.");
            return;
        }
        emailLanyardSource = source;
        createEmailModal();
        $("#lanyardEmailAddress").val("");
        $("#lanyardEmailError").addClass("d-none").text("");
        $("#lanyardEmailModal").modal({
            backdrop: true,
            keyboard: true,
            focus: true,
            show: true,
        });
    }
    async function generateLanyardFile(source) {
        if (!window.html2canvas) throw new Error("html2canvas is required.");
        const wrapper = document.createElement("div");
        wrapper.style.position = "fixed";
        wrapper.style.left = "-99999px";
        wrapper.style.top = "0";
        wrapper.style.padding = "20px";
        wrapper.style.background = "#fff";
        wrapper.style.display = "inline-block";
        wrapper.style.width = "max-content";
        wrapper.style.zIndex = "-1";
        const clone = source.cloneNode(true);
        $(clone)
            .find(
                ".lanyard-action-buttons,.lanyard-actions,.whole-lanyard-action-buttons,.whole-card-action-buttons,.print-button-container",
            )
            .remove();
        clone.classList.remove("active");
        wrapper.appendChild(clone);
        document.body.appendChild(wrapper);
        try {
            const canvas = await html2canvas(wrapper, {
                backgroundColor: "#fff",
                scale: 2,
                useCORS: true,
                allowTaint: false,
                logging: false,
            });
            const blob = await new Promise((resolve) =>
                canvas.toBlob(resolve, "image/png"),
            );
            if (!blob) throw new Error("Unable to create PNG.");
            return new File([blob], "lanyard.png", { type: "image/png" });
        } finally {
            if (document.body.contains(wrapper))
                document.body.removeChild(wrapper);
        }
    }
    async function sendEmail() {
        const source = emailLanyardSource || getSelectedLanyard();
        if (!source) {
            alert("Unable to find the selected lanyard.");
            return;
        }
        const email = $.trim($("#lanyardEmailAddress").val());
        const pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!pattern.test(email)) {
            $("#lanyardEmailError")
                .removeClass("d-none")
                .text("Please enter a valid email address.");
            return;
        }
        $("#lanyardEmailError").addClass("d-none").text("");
        const button = $("#confirmLanyardEmail");
        const original = button.html();
        button
            .prop("disabled", true)
            .html(
                '<span class="spinner-border spinner-border-sm mr-1"></span>Preparing...',
            );
        try {
            const file = await generateLanyardFile(source);
            const provider = $("#lanyardEmailProvider").val();
            if (
                provider === "share" &&
                navigator.share &&
                navigator.canShare &&
                navigator.canShare({ files: [file] })
            ) {
                await navigator.share({
                    title: "Specialist Lanyard",
                    text: "Specialist Lanyard",
                    files: [file],
                });
                $("#lanyardEmailModal").modal("hide");
                return;
            }
            const subject = encodeURIComponent("Specialist Lanyard");
            const body = encodeURIComponent(
                "Dear Sir/Madam,\n\nPlease find the Specialist Lanyard image attached.\n\nRegards",
            );
            let url = "";
            if (provider === "gmail") {
                url =
                    "https://mail.google.com/mail/?view=cm&fs=1&to=" +
                    encodeURIComponent(email) +
                    "&su=" +
                    subject +
                    "&body=" +
                    body;
            } else if (provider === "yahoo") {
                url =
                    "https://compose.mail.yahoo.com/?to=" +
                    encodeURIComponent(email) +
                    "&subject=" +
                    subject +
                    "&body=" +
                    body;
            } else if (provider === "outlook") {
                url =
                    "https://outlook.live.com/mail/0/deeplink/compose?to=" +
                    encodeURIComponent(email) +
                    "&subject=" +
                    subject +
                    "&body=" +
                    body;
            }
            const link = document.createElement("a");
            link.href = URL.createObjectURL(file);
            link.download = "lanyard.png";
            link.style.display = "none";
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            window.open(url, "_blank", "noopener,noreferrer");
            $("#lanyardEmailModal").modal("hide");
            setTimeout(function () {
                alert(
                    "The lanyard image has been prepared as lanyard.png and the email composer has been opened. Please attach the image before sending.",
                );
            }, 400);
        } catch (error) {
            if (error && error.name === "AbortError") return;
            console.error("Lanyard email error:", error);
            alert("Unable to prepare the lanyard image.");
        } finally {
            button.prop("disabled", false).html(original);
        }
    }
    $(document)
        .off("click.lanyardEmail", ".lanyard-email-btn")
        .on("click.lanyardEmail", ".lanyard-email-btn", function (e) {
            e.preventDefault();
            e.stopPropagation();
            const card = $(this).closest(".lanyard-card");
            if (card.length) {
                openEmailModal(card[0]);
                return;
            }
            const container = $(this).closest(
                ".lanyard-preview-container,.lanyard-preview-container2,.lanyard-preview-container3",
            );
            const source =
                container.find(".lanyard-card").first()[0] ||
                getSelectedLanyard();
            openEmailModal(source);
        });
    $(document)
        .off("click.wholeLanyardEmail", ".whole-lanyard-email-btn")
        .on(
            "click.wholeLanyardEmail",
            ".whole-lanyard-email-btn",
            function (e) {
                e.preventDefault();
                e.stopPropagation();
                openEmailModal(getSelectedLanyard());
            },
        );
    $(document)
        .off("click.wholeCardEmail", ".whole-card-email-btn")
        .on("click.wholeCardEmail", ".whole-card-email-btn", function (e) {
            e.preventDefault();
            e.stopPropagation();
            openEmailModal(getSelectedLanyard());
        });
    $(document)
        .off("click.confirmLanyardEmail", "#confirmLanyardEmail")
        .on("click.confirmLanyardEmail", "#confirmLanyardEmail", function (e) {
            e.preventDefault();
            sendEmail();
        });
    $(document).on(
        "hidden.bs.modal.lanyardEmail",
        "#lanyardEmailModal",
        function () {
            emailLanyardSource = null;
            $("#lanyardEmailError").addClass("d-none").text("");
        },
    );
})(jQuery);
