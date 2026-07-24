/**
 * ==========================================================================
 * Patient Refer Progress
 * ==========================================================================
 * File:
 * patient_refer_progress.js
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
function animateReferProgress(card) {
    if (!card) return;

    let progress = 0;

    setReferCardStatus(card, "Preparing...", "badge-secondary");

    const timer = setInterval(() => {
        /* Random speed*/
        progress += Math.floor(Math.random() * 8) + 3;
        if (progress >= 100) {
            progress = 100;
        }

        updateReferCardProgress(card, progress);

        /** Update Status */
        if (progress < 25) {
            setReferCardStatus(card, "Reading...", "badge-secondary");
        } else if (progress < 50) {
            setReferCardStatus(card, "Validating...", "badge-info");
        } else if (progress < 75) {
            setReferCardStatus(
                card,
                "Generating Preview...",
                "badge-warning",
            );
        } else if (progress < 100) {
            setReferCardStatus(card, "Almost Ready...", "badge-primary");
        }

        /** Completed*/
        if (progress === 100) {
            clearInterval(timer);
            updateReferCardProgress(card, 100);
            card.classList.add("refer-ready");

            /**Small Success Animation */
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

/** Instantly Complete*/
function completeReferProgress(card) {
    updateReferCardProgress(card, 100);
    card.classList.add("refer-ready");
}

/** Reset Progress*/
function resetReferProgress(card) {
    const circle = card.querySelector(".progress-bar");
    const text = card.querySelector(".progress-text");

    if (!circle || !text) return;

    const radius = 28;
    const circumference = 2 * Math.PI * radius;

    circle.style.strokeDasharray = circumference;
    circle.style.strokeDashoffset = circumference;

    text.textContent = "0%";

    setReferCardStatus(card, "Waiting...", "badge-secondary");

    card.classList.remove("refer-ready");
}

/* Error Progress*/
function failReferProgress(card, message = "Upload Failed") {
    markReferCardError(card, message);

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
