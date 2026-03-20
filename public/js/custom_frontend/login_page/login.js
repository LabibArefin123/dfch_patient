document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("problemModal");
    const openBtn = document.getElementById("openProblemBtn");
    const closeBtn = document.getElementById("closeModalBtn");

    if (!modal || !openBtn || !closeBtn) return;

    // Always start closed
    modal.classList.remove("show");

    // Open modal
    openBtn.addEventListener("click", function (e) {
        e.preventDefault();
        modal.classList.add("show");
    });

    // Close modal
    closeBtn.addEventListener("click", function () {
        modal.classList.remove("show");
    });

    // Click outside closes modal
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.classList.remove("show");
        }
    });
});

// About toggle
function toggleAbout(show) {
    document.getElementById("aboutShort").style.display = show
        ? "none"
        : "block";
    document.getElementById("aboutFull").style.display = show
        ? "block"
        : "none";
}
