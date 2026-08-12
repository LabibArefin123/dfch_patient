$(function () {
    async function emailWholeCard() {
        if (!window.html2canvas) {
            alert("html2canvas is required for email image generation.");
            return;
        }
        const front = document.querySelector(".doctor-card");
        const back = document.querySelector(".doctor-card-back");
        if (!front && !back) return;
        const wrapper = document.createElement("div");
        wrapper.style.position = "fixed";
        wrapper.style.left = "-99999px";
        wrapper.style.top = "0";
        wrapper.style.display = "flex";
        wrapper.style.gap = "20px";
        if (front) wrapper.appendChild(front.cloneNode(true));
        if (back) wrapper.appendChild(back.cloneNode(true));
        $(wrapper)
            .find(".whole-card-action-buttons,.lanyard-action-buttons")
            .remove();
        document.body.appendChild(wrapper);
        try {
            const canvas = await html2canvas(wrapper, {
                backgroundColor: "#ffffff",
                scale: 2,
                useCORS: true,
            });
            const link = document.createElement("a");
            link.download = "whole-card.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
            document.body.removeChild(wrapper);
            setTimeout(function () {
                window.location.href =
                    "mailto:?subject=" +
                    encodeURIComponent("Specialist Whole Card") +
                    "&body=" +
                    encodeURIComponent(
                        "Please attach the generated whole-card.png image to this email.",
                    );
            }, 500);
        } catch (error) {
            document.body.removeChild(wrapper);
            console.error(error);
            alert("Unable to generate card image.");
        }
    }
    $(document).on("click", ".whole-card-email-btn", emailWholeCard);
});
