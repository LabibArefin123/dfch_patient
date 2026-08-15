$(document).ready(function () {
    const progressCard = document.querySelector(".patient-progress-card");

    if (!progressCard) {
        return;
    }

    const progressItems = progressCard.querySelectorAll(
        ".progress-item[data-target]",
    );

    if (!progressItems.length) {
        return;
    }

    progressItems.forEach(function (item) {
        item.addEventListener("click", function () {
            const targetId = this.dataset.target;

            if (!targetId) {
                return;
            }

            const targetSection = document.getElementById(targetId);

            if (!targetSection) {
                console.warn("Patient section not found:", targetId);

                return;
            }

            const progressHeight = progressCard.offsetHeight;
            const extraSpace = 25;

            const targetPosition =
                targetSection.getBoundingClientRect().top +
                window.pageYOffset -
                progressHeight -
                extraSpace;

            window.scrollTo({
                top: targetPosition,
                behavior: "smooth",
            });
        });
    });
});
