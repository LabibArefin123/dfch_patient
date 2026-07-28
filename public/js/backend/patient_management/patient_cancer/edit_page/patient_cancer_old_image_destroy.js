document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll(".delete-image-checkbox")
        .forEach(function (checkbox) {
            checkbox.addEventListener("change", function () {
                const card = this.closest(".existing-image-card");

                if (!card) return;

                if (this.checked) {
                    card.classList.add("marked-delete");
                } else {
                    card.classList.remove("marked-delete");
                }
            });
        });
});
