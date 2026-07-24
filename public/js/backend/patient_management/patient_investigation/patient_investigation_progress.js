/**
 * ==========================================================================
 * Patient Investigate Progress
 * ==========================================================================
 * File:
 * patient_investigation_progress.js
 *
 * Responsibilities
 * ----------------
 * ✔ Animate fake upload progress (0 → 100%)
 * ✔ Update SVG circular progress
 * ✔ Change status to Ready
 * ✔ Smooth animation
 * ==========================================================================
 */

/**
 * Animate Progress
 *
 * @param {HTMLElement} card
 */
function animateInvestigateProgress(card) {
    if (!card) return;

    let progress = 0;

    setInvestigateCardStatus(card, "Preparing...", "badge-secondary");

    const timer = setInterval(() => {
        /**
         * Random speed
         */
        progress += Math.floor(Math.random() * 8) + 3;

        if (progress >= 100) {
            progress = 100;
        }

        updateInvestigateCardProgress(card, progress);

        /**
         * Update Status
         */
        if (progress < 25) {
            setInvestigateCardStatus(card, "Reading...", "badge-secondary");
        } else if (progress < 50) {
            setInvestigateCardStatus(card, "Validating...", "badge-info");
        } else if (progress < 75) {
            setInvestigateCardStatus(
                card,
                "Generating Preview...",
                "badge-warning",
            );
        } else if (progress < 100) {
            setInvestigateCardStatus(card, "Almost Ready...", "badge-primary");
        }

        /**
         * Completed
         */
        if (progress === 100) {
            clearInterval(timer);

            updateInvestigateCardProgress(card, 100);

            card.classList.add("investigation-ready");

            /**
             * Small Success Animation
             */
            card.animate(
                [
                    {
                        transform: "scale(.96)",
                    },
                    {
                        transform: "scale(1.03)",
                    },
                    {
                        transform: "scale(1)",
                    },
                ],
                {
                    duration: 250,
                    easing: "ease-out",
                },
            );
        }
    }, 35);
}

/**
 * Instantly Complete
 *
 * Optional helper
 */
function completeInvestigateProgress(card) {
    updateInvestigateCardProgress(card, 100);

    card.classList.add("investigation-ready");
}

/**
 * Reset Progress
 *
 * Optional helper
 */
function resetInvestigateProgress(card) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");

    if (!circle || !text) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    text.textContent = "0%";

    setInvestigateCardStatus(card, "Waiting...", "badge-secondary");

    card.classList.remove("investigation-ready");
}

/**
 * Error Progress
 *
 * Optional helper
 */
function failInvestigateProgress(card, message = "Upload Failed") {
    markInvestigateCardError(card, message);

    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");

    if (circle) {
        const radius = 28;
        const circumference = 2 * Math.PI * radius;

        circle.style.strokeDasharray = circumference;
        circle.style.strokeDashoffset = circumference;

        circle.classList.add("progress-error");
    }

    if (text) {
        text.textContent = "!";
    }
}
