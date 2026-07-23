/**
 * ==========================================================================
 * Patient Treatment Progress
 * ==========================================================================
 * File:
 * patient_treatment_progress.js
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
function animateTreatmentProgress(card) {
    if (!card) return;

    let progress = 0;

    setTreatmentCardStatus(card, "Preparing...", "badge-secondary");

    const timer = setInterval(() => {
        /**
         * Random speed
         */
        progress += Math.floor(Math.random() * 8) + 3;

        if (progress >= 100) {
            progress = 100;
        }

        updateTreatmentCardProgress(card, progress);

        /**
         * Update Status
         */
        if (progress < 25) {
            setTreatmentCardStatus(card, "Reading...", "badge-secondary");
        } else if (progress < 50) {
            setTreatmentCardStatus(card, "Validating...", "badge-info");
        } else if (progress < 75) {
            setTreatmentCardStatus(
                card,
                "Generating Preview...",
                "badge-warning",
            );
        } else if (progress < 100) {
            setTreatmentCardStatus(card, "Almost Ready...", "badge-primary");
        }

        /**
         * Completed
         */
        if (progress === 100) {
            clearInterval(timer);

            updateTreatmentCardProgress(card, 100);

            card.classList.add("treatment-ready");

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
function completeTreatmentProgress(card) {
    updateTreatmentCardProgress(card, 100);

    card.classList.add("treatment-ready");
}

/**
 * Reset Progress
 *
 * Optional helper
 */
function resetTreatmentProgress(card) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");

    if (!circle || !text) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    text.textContent = "0%";

    setTreatmentCardStatus(card, "Waiting...", "badge-secondary");

    card.classList.remove("treatment-ready");
}

/**
 * Error Progress
 *
 * Optional helper
 */
function failTreatmentProgress(card, message = "Upload Failed") {
    markTreatmentCardError(card, message);

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
