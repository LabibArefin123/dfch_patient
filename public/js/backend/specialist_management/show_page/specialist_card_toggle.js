document.addEventListener("DOMContentLoaded", function () {
    const lanyards = document.querySelectorAll(".lanyard-card");

    const cards = document.querySelectorAll(".specialist-card-preview");

    lanyards.forEach(function (lanyard) {
        lanyard.addEventListener("click", function () {
            const selectedCard = this.dataset.card;

            // remove active
            lanyards.forEach((item) => {
                item.classList.remove("active");
            });

            this.classList.add("active");

            // hide cards
            cards.forEach((card) => {
                card.style.display = "none";
            });

            const target = document.querySelector(
                `[data-card="${selectedCard}"]`,
            );

            if (target) {
                target.style.display = "block";
            }
        });
    });
});
