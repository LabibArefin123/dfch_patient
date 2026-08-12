$(function () {
    async function shareWholeLanyard() {
        if (!window.html2canvas) {
            alert("html2canvas is required for WhatsApp image sharing.");
            return;
        }
        const selected = window.selectedLanyard;
        let source = null;
        if (selected && selected.length) {
            source = selected.first()[0];
        } else {
            const active = document.querySelector(".lanyard-card.active");
            if (active) {
                source = active;
            } else {
                source = document.querySelector(".lanyard-card");
            }
        }
        if (!source) {
            alert("Please select a lanyard first.");
            return;
        }
        const wrapper = document.createElement("div");
        wrapper.style.position = "fixed";
        wrapper.style.left = "-99999px";
        wrapper.style.top = "0";
        wrapper.style.padding = "20px";
        wrapper.style.background = "#ffffff";
        wrapper.style.display = "inline-block";
        const clone = source.cloneNode(true);
        $(clone)
            .find(
                ".whole-lanyard-action-buttons,.whole-card-action-buttons,.lanyard-action-buttons",
            )
            .remove();
        wrapper.appendChild(clone);
        document.body.appendChild(wrapper);
        try {
            const canvas = await html2canvas(wrapper, {
                backgroundColor: "#ffffff",
                scale: 2,
                useCORS: true,
            });
            canvas.toBlob(async function (blob) {
                if (!blob) {
                    document.body.removeChild(wrapper);
                    return;
                }
                const file = new File([blob], "lanyard.png", {
                    type: "image/png",
                });
                if (
                    navigator.share &&
                    navigator.canShare &&
                    navigator.canShare({ files: [file] })
                ) {
                    try {
                        await navigator.share({
                            title: "Lanyard",
                            text: "Specialist Lanyard",
                            files: [file],
                        });
                    } catch (error) {
                        console.log("Share cancelled.", error);
                    }
                } else {
                    const link = document.createElement("a");
                    link.download = "lanyard.png";
                    link.href = canvas.toDataURL("image/png");
                    link.click();
                    setTimeout(function () {
                        window.open(
                            "https://wa.me/?text=" +
                                encodeURIComponent("Specialist Lanyard"),
                            "_blank",
                        );
                        alert(
                            "Your browser does not support direct image sharing. The lanyard image has been downloaded. Please attach lanyard.png in WhatsApp.",
                        );
                    }, 300);
                }
                document.body.removeChild(wrapper);
            }, "image/png");
        } catch (error) {
            if (document.body.contains(wrapper)) {
                document.body.removeChild(wrapper);
            }
            console.error(error);
            alert("Unable to create lanyard image.");
        }
    }
    $(document).on(
        "click",
        ".whole-lanyard-whatsapp-btn,.whole-card-whatsapp-btn",
        function (e) {
            e.preventDefault();
            shareWholeLanyard();
        },
    );
});
