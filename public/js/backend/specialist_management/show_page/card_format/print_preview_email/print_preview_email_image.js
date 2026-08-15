(function (window, $) {
    "use strict";

    const Email = (window.specialistCardEmail =
        window.specialistCardEmail || {});

    Email.cleanClone = function (element) {
        const clone = element.clone(false);

        $(clone)
            .find(
                ".print-button-container," +
                    ".print-card-actions," +
                    ".whole-card-action-buttons," +
                    ".lanyard-action-buttons," +
                    ".whole-lanyard-action-buttons",
            )
            .remove();

        return clone;
    };

    Email.generateImage = async function (theme) {
        if (!window.html2canvas) {
            alert("html2canvas is required for email image generation.");

            return null;
        }

        const cards = Email.getThemeCards(theme);

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

        /*
         * Keep the wrapper outside the visible screen.
         * Do NOT use z-index:-9999 because html2canvas can
         * sometimes fail to capture elements with negative stacking.
         */
        wrapper.style.visibility = "visible";

        if (cards.front) {
            wrapper.appendChild(Email.cleanClone(cards.front[0]));
        }

        if (cards.back) {
            wrapper.appendChild(Email.cleanClone(cards.back[0]));
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

            wrapper.remove();

            return canvas;
        } catch (error) {
            if (document.body.contains(wrapper)) {
                wrapper.remove();
            }

            console.error("Email card image generation failed:", error);

            alert("Unable to generate the card image.");

            return null;
        }
    };
})(window, jQuery);
