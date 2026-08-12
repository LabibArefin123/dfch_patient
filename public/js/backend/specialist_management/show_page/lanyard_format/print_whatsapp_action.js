$(function () {
    function addWhatsappButtons() {
        $(".lanyard-strip,.lanyard02-strip,.lanyard03-strip").each(function () {
            const buttons = $(this).find(".lanyard-action-buttons");
            if (!buttons.length || buttons.find(".lanyard-whatsapp-btn").length)
                return;
            buttons.append(
                $("<button>", {
                    type: "button",
                    class: "btn btn-sm btn-success lanyard-whatsapp-btn",
                }).html('<i class="fab fa-whatsapp"></i> WhatsApp'),
            );
        });
    }
    async function shareWhatsapp(element) {
        if (!window.html2canvas) {
            alert("html2canvas is required for WhatsApp image sharing.");
            return;
        }
        const clone = element.cloneNode(true);
        $(clone).find(".lanyard-action-buttons").remove();
        clone.style.position = "fixed";
        clone.style.left = "-99999px";
        clone.style.top = "0";
        document.body.appendChild(clone);
        try {
            const canvas = await html2canvas(clone, {
                backgroundColor: null,
                scale: 2,
                useCORS: true,
            });
            canvas.toBlob(async function (blob) {
                if (!blob) return;
                const file = new File([blob], "lanyard.png", {
                    type: "image/png",
                });
                if (
                    navigator.share &&
                    navigator.canShare &&
                    navigator.canShare({ files: [file] })
                ) {
                    await navigator.share({
                        title: "Lanyard",
                        text: "Lanyard Design",
                        files: [file],
                    });
                } else {
                    const url =
                        "https://wa.me/?text=" +
                        encodeURIComponent("Lanyard Design");
                    window.open(url, "_blank");
                    alert(
                        "Your browser does not support direct image sharing. Please attach the generated lanyard image manually.",
                    );
                }
                document.body.removeChild(clone);
            }, "image/png");
        } catch (error) {
            document.body.removeChild(clone);
            console.error(error);
            alert("Unable to create lanyard image.");
        }
    }
    $(document).on("click", ".lanyard-whatsapp-btn", function () {
        shareWhatsapp(
            $(this).closest(
                ".lanyard-strip,.lanyard02-strip,.lanyard03-strip",
            )[0],
        );
    });
    addWhatsappButtons();
});
