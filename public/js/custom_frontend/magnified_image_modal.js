document.addEventListener("DOMContentLoaded", function () {
    // create modal container
    const modal = document.createElement("div");
    modal.classList.add("image-modal");

    // create modal box inside modal
    modal.innerHTML = `
        <div class="modal-box">
            <span class="close-btn">&times;</span>
            <img src="" alt="Magnified Image">
        </div>
    `;
    document.body.appendChild(modal);

    const modalImg = modal.querySelector("img");
    const closeBtn = modal.querySelector(".close-btn");

    // open modal on click
    document.querySelectorAll(".magnify-img").forEach((img) => {
        img.addEventListener("click", () => {
            modal.style.display = "flex";
            modalImg.src = img.src;
        });
    });

    // close modal on close button click
    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    // close modal when clicking outside the modal-box
    modal.addEventListener("click", (e) => {
        if (!e.target.closest(".modal-box")) {
            modal.style.display = "none";
        }
    });
});
