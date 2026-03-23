document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("imageZoomModal");
    const modalImg = document.getElementById("zoomedImage");
    const closeBtn = document.querySelector(".zoom-close");

    // Click on image
    document.querySelectorAll(".zoomable").forEach((img) => {
        img.addEventListener("click", function () {
            modal.style.display = "block";
            modalImg.src = this.src;
        });
    });

    // Close modal
    closeBtn.onclick = function () {
        modal.style.display = "none";
    };

    // Click outside image to close
    modal.onclick = function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    };

    // ESC key close
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            modal.style.display = "none";
        }
    });
});
