/**
 * ==========================================================================
 * Patient Cancer Progress
 * ==========================================================================
 * File:
 * patient_cancer_progress.js
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
function animateCancerProgress(card) {
    if (!card) return;

    let progress = 0;

    setCancerCardStatus(card, "Preparing...", "badge-secondary");

    const timer = setInterval(() => {
        /**
         * Random speed
         */
        progress += Math.floor(Math.random() * 8) + 3;

        if (progress >= 100) {
            progress = 100;
        }

        updateCancerCardProgress(card, progress);

        /**
         * Update Status
         */
        if (progress < 25) {
            setCancerCardStatus(card, "Reading...", "badge-secondary");
        } else if (progress < 50) {
            setCancerCardStatus(card, "Validating...", "badge-info");
        } else if (progress < 75) {
            setCancerCardStatus(
                card,
                "Generating Preview...",
                "badge-warning",
            );
        } else if (progress < 100) {
            setCancerCardStatus(card, "Almost Ready...", "badge-primary");
        }

        /**
         * Completed
         */
        if (progress === 100) {
            clearInterval(timer);

            updateCancerCardProgress(card, 100);

            card.classList.add("cancer-ready");

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
function completeCancerProgress(card) {
    updateCancerCardProgress(card, 100);

    card.classList.add("cancer-ready");
}

/**
 * Reset Progress
 *
 * Optional helper
 */
function resetCancerProgress(card) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");

    if (!circle || !text) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    text.textContent = "0%";

    setCancerCardStatus(card, "Waiting...", "badge-secondary");

    card.classList.remove("cancer-ready");
}

/**
 * Error Progress
 *
 * Optional helper
 */
function failCancerProgress(card, message = "Upload Failed") {
    markCancerCardError(card, message);

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
