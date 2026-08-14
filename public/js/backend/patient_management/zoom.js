document.addEventListener("DOMContentLoaded", function () {
    const imageZoomModal = document.getElementById("imageZoomModal");

    if (!imageZoomModal) {
        return;
    }

    const modalImage = imageZoomModal.querySelector("#modalZoomImage");

    if (!modalImage) {
        console.warn("Zoom modal image #modalZoomImage not found.");
        return;
    }

    /* ==========================================================
       OPEN IMAGE
    ========================================================== */

    imageZoomModal.addEventListener("show.bs.modal", function (event) {
        const trigger = event.relatedTarget;

        if (!trigger) {
            return;
        }

        /*
         * Get image URL from the element that opened the modal.
         */
        let imageUrl = trigger.getAttribute("data-bs-img-src");

        /*
         * Fallback:
         * If the trigger is an image itself, use its src.
         */
        if (!imageUrl && trigger.tagName === "IMG") {
            imageUrl = trigger.getAttribute("src");
        }

        /*
         * Fallback:
         * If the trigger contains an image, use that image's src.
         */
        if (!imageUrl) {
            const childImage = trigger.querySelector("img");

            if (childImage) {
                imageUrl = childImage.getAttribute("src");
            }
        }

        if (!imageUrl) {
            console.warn(
                "Image URL not found for image zoom trigger.",
                trigger,
            );

            return;
        }

        /*
         * Clear first so Bootstrap/browser does not keep
         * an old image while loading the new one.
         */
        modalImage.removeAttribute("src");

        modalImage.style.display = "none";

        /*
         * Wait until the image is loaded.
         */
        modalImage.onload = function () {
            modalImage.style.display = "block";
        };

        modalImage.onerror = function () {
            console.error("Unable to load zoom image:", imageUrl);

            modalImage.style.display = "none";
        };

        /*
         * Finally load the image.
         */
        modalImage.src = imageUrl;
    });

    /* ==========================================================
       CLEAR IMAGE WHEN MODAL CLOSES
    ========================================================== */

    imageZoomModal.addEventListener("hidden.bs.modal", function () {
        modalImage.onload = null;
        modalImage.onerror = null;

        modalImage.removeAttribute("src");

        modalImage.style.display = "none";
    });

    /* ==========================================================
       NORMAL .zoomable IMAGES
    ========================================================== */

    document.querySelectorAll(".zoomable").forEach(function (image) {
        image.addEventListener("click", function (event) {
            event.preventDefault();

            const imageUrl = this.getAttribute("src");

            if (!imageUrl) {
                return;
            }

            modalImage.src = imageUrl;

            const modal = bootstrap.Modal.getOrCreateInstance(imageZoomModal);

            modal.show();
        });
    });
});
