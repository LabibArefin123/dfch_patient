$(function () {
    function addEmailButtons() {
        $(".lanyard-strip,.lanyard02-strip,.lanyard03-strip").each(function () {
            const buttons = $(this).find(".lanyard-action-buttons");
            if (!buttons.length || buttons.find(".lanyard-email-btn").length)
                return;
            buttons.append(
                $("<button>", {
                    type: "button",
                    class: "btn btn-sm btn-secondary lanyard-email-btn",
                }).html('<i class="fas fa-envelope"></i> Email'),
            );
        });
    }
    async function emailLanyard(element) {
        if (!window.html2canvas) {
            alert("html2canvas is required for email image generation.");
            return;
        }
        const clone = element.cloneNode(true);
        $(clone).find(".lanyard-action-buttons").remove();
        clone.style.position = "fixed";
        clone.style.left = "-99999px";
        document.body.appendChild(clone);
        try {
            const canvas = await html2canvas(clone, {
                backgroundColor: null,
                scale: 2,
                useCORS: true,
            });
            const link = document.createElement("a");
            link.download = "lanyard.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
            document.body.removeChild(clone);
            setTimeout(function () {
                window.location.href =
                    "mailto:?subject=" +
                    encodeURIComponent("Lanyard Design") +
                    "&body=" +
                    encodeURIComponent(
                        "Please attach the generated lanyard.png image to this email.",
                    );
            }, 500);
        } catch (error) {
            document.body.removeChild(clone);
            console.error(error);
            alert("Unable to generate lanyard image.");
        }
    }
    $(document).on("click", ".lanyard-email-btn", function () {
        emailLanyard(
            $(this).closest(
                ".lanyard-strip,.lanyard02-strip,.lanyard03-strip",
            )[0],
        );
    });
    addEmailButtons();
});
