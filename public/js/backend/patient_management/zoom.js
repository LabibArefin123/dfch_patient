document.addEventListener("DOMContentLoaded", function () {
    const imageZoomModal = document.getElementById("imageZoomModal");

    if (!imageZoomModal) return;

    const modalImage = imageZoomModal.querySelector("#modalZoomImage");

    /**
     * Bootstrap Modal Trigger
     * For elements with:
     * data-bs-toggle="modal"
     * data-bs-target="#imageZoomModal"
     * data-bs-img-src="..."
     */
    imageZoomModal.addEventListener("show.bs.modal", function (event) {
        const trigger = event.relatedTarget;

        if (!trigger) return;

        const imgSrc = trigger.getAttribute("data-bs-img-src");

        if (imgSrc) {
            modalImage.src = imgSrc;
        }
    });

    /**
     * Support normal images with class="zoomable"
     */
    document.querySelectorAll(".zoomable").forEach(function (img) {
        img.addEventListener("click", function () {
            modalImage.src = this.src;

            const modal = bootstrap.Modal.getOrCreateInstance(imageZoomModal);

            modal.show();
        });
    });

    /**
     * Clear image when modal closes
     */
    imageZoomModal.addEventListener("hidden.bs.modal", function () {
        modalImage.src = "";
    });
});
