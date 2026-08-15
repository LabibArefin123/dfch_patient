/**
 * ==========================================================================
 * PATIENT PROGRESS - EMERGENCY
 * ==========================================================================
 *
 * File:
 * progress_7_emergency.js
 *
 * Works with:
 * ✔ Create page
 * ✔ Edit page
 * ✔ Existing emergency status
 * ✔ Existing emergency date
 * ✔ Existing emergency reason
 * ✔ CKEditor 5 support
 * ✔ Water fill animation
 *
 * Progress
 * --------------------------------------------------------------------------
 *
 * No Emergency
 *      = 100%
 *
 * Emergency = Yes
 *      Emergency Date = 50%
 *      Emergency Reason = 50%
 *      ----------------------
 *      Total           = 100%
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    // ----------------------------------------------------------------------
    // Find emergency progress item directly
    // ----------------------------------------------------------------------

    const emergencyItem = document.querySelector(
        '.patient-progress-card .progress-item[data-target="part_7_emergency"]',
    );

    if (!emergencyItem) {
        console.warn("Emergency progress item not found.");
        return;
    }

    const step = emergencyItem.querySelector(".step");

    if (!step) {
        console.warn("Emergency progress step not found.");
        return;
    }

    // ----------------------------------------------------------------------
    // Inject CSS
    // ----------------------------------------------------------------------

    injectEmergencyWaterCSS();

    // ----------------------------------------------------------------------
    // Fields
    // ----------------------------------------------------------------------

    const emergencyField = document.getElementById("is_emergency");

    const emergencyDate = document.getElementById("emergency_date");

    const emergencyReason =
        document.getElementById("edit_reason") ||
        document.querySelector("textarea[name='reason']");

    // ----------------------------------------------------------------------
    // Get textarea / CKEditor value
    // ----------------------------------------------------------------------

    function getEditorValue(textarea) {
        if (!textarea) {
            return "";
        }

        // --------------------------------------------------------------
        // CKEditor 5
        // --------------------------------------------------------------

        if (textarea.ckeditorInstance) {
            return textarea.ckeditorInstance
                .getData()
                .replace(/<[^>]*>/g, "")
                .replace(/&nbsp;/g, " ")
                .trim();
        }

        // --------------------------------------------------------------
        // Old CKEditor support
        // --------------------------------------------------------------

        if (window.CKEDITOR && textarea.name) {
            const instance = Object.values(CKEDITOR.instances).find(
                function (editor) {
                    return (
                        editor.element &&
                        editor.element.$ &&
                        editor.element.$.name === textarea.name
                    );
                },
            );

            if (instance) {
                return instance
                    .getData()
                    .replace(/<[^>]*>/g, "")
                    .replace(/&nbsp;/g, " ")
                    .trim();
            }
        }

        // --------------------------------------------------------------
        // Normal textarea
        // --------------------------------------------------------------

        return textarea.value
            .replace(/<[^>]*>/g, "")
            .replace(/&nbsp;/g, " ")
            .trim();
    }

    // ----------------------------------------------------------------------
    // Check emergency date
    // ----------------------------------------------------------------------

    function hasEmergencyDate() {
        return emergencyDate && emergencyDate.value.trim() !== "";
    }

    // ----------------------------------------------------------------------
    // Check emergency reason
    // ----------------------------------------------------------------------

    function hasEmergencyReason() {
        return getEditorValue(emergencyReason) !== "";
    }

    // ----------------------------------------------------------------------
    // Update emergency progress
    // ----------------------------------------------------------------------

    function updateEmergencyProgress() {
        // --------------------------------------------------------------
        // If field does not exist
        // --------------------------------------------------------------

        if (!emergencyField) {
            step.style.setProperty("--fill", "0%");

            emergencyItem.classList.remove("completed");

            return;
        }

        const emergencyValue = String(emergencyField.value).trim();

        // --------------------------------------------------------------
        // NO EMERGENCY
        //
        // Nothing else is required.
        // --------------------------------------------------------------

        if (emergencyValue === "0") {
            step.style.setProperty("--fill", "100%");

            emergencyItem.classList.add("completed");

            return;
        }

        // --------------------------------------------------------------
        // EMERGENCY = YES
        // --------------------------------------------------------------

        let percent = 0;

        // --------------------------------------------------------------
        // Emergency Date = 50%
        // --------------------------------------------------------------

        if (hasEmergencyDate()) {
            percent += 50;
        }

        // --------------------------------------------------------------
        // Emergency Reason = 50%
        // --------------------------------------------------------------

        if (hasEmergencyReason()) {
            percent += 50;
        }

        // --------------------------------------------------------------
        // Safety
        // --------------------------------------------------------------

        percent = Math.min(100, Math.max(0, percent));

        // --------------------------------------------------------------
        // Apply water fill
        // --------------------------------------------------------------

        step.style.setProperty("--fill", `${percent}%`);

        // --------------------------------------------------------------
        // Completed
        // --------------------------------------------------------------

        emergencyItem.classList.toggle("completed", percent === 100);
    }

    // ----------------------------------------------------------------------
    // Emergency status
    // ----------------------------------------------------------------------

    if (emergencyField) {
        emergencyField.addEventListener("change", updateEmergencyProgress);

        emergencyField.addEventListener("input", updateEmergencyProgress);
    }

    // ----------------------------------------------------------------------
    // Emergency date
    // ----------------------------------------------------------------------

    if (emergencyDate) {
        emergencyDate.addEventListener("change", updateEmergencyProgress);

        emergencyDate.addEventListener("input", updateEmergencyProgress);
    }

    // ----------------------------------------------------------------------
    // Emergency reason
    // ----------------------------------------------------------------------

    if (emergencyReason) {
        emergencyReason.addEventListener("input", updateEmergencyProgress);

        emergencyReason.addEventListener("change", updateEmergencyProgress);
    }

    // ----------------------------------------------------------------------
    // Wait for CKEditor
    // ----------------------------------------------------------------------

    let editorCheckCount = 0;

    const waitForEmergencyEditor = setInterval(() => {
        editorCheckCount++;

        // --------------------------------------------------------------
        // CKEditor 5
        // --------------------------------------------------------------

        if (emergencyReason && emergencyReason.ckeditorInstance) {
            clearInterval(waitForEmergencyEditor);

            if (!emergencyReason.dataset.emergencyProgressListener) {
                emergencyReason.ckeditorInstance.model.document.on(
                    "change:data",
                    updateEmergencyProgress,
                );

                emergencyReason.dataset.emergencyProgressListener = "true";
            }

            updateEmergencyProgress();

            return;
        }

        // --------------------------------------------------------------
        // Old CKEditor
        // --------------------------------------------------------------

        if (emergencyReason && window.CKEDITOR) {
            const instance = Object.values(CKEDITOR.instances).find(
                function (editor) {
                    return (
                        editor.element &&
                        editor.element.$ &&
                        editor.element.$.name === "reason"
                    );
                },
            );

            if (instance) {
                clearInterval(waitForEmergencyEditor);

                if (!emergencyReason.dataset.emergencyProgressListener) {
                    instance.on("change", updateEmergencyProgress);

                    emergencyReason.dataset.emergencyProgressListener = "true";
                }

                updateEmergencyProgress();

                return;
            }
        }

        // --------------------------------------------------------------
        // Do not wait forever
        // --------------------------------------------------------------

        if (editorCheckCount >= 50) {
            clearInterval(waitForEmergencyEditor);

            updateEmergencyProgress();
        }
    }, 200);

    // ----------------------------------------------------------------------
    // Initial calculation
    //
    // This is important on edit page because Blade already contains:
    //
    // $patient->is_emergency
    // $patient->latestEmergency->emergency_date
    // $patient->latestEmergency->reason
    // ----------------------------------------------------------------------

    updateEmergencyProgress();
});

/**
 * ==========================================================================
 * EMERGENCY WATER PROGRESS CSS
 * ==========================================================================
 */

function injectEmergencyWaterCSS() {
    if (document.getElementById("emergency-progress-style")) {
        return;
    }

    const style = document.createElement("style");

    style.id = "emergency-progress-style";

    style.innerHTML = `
        /*
         * Emergency progress icon
         */
        .patient-progress-card
        .progress-item[data-target="part_7_emergency"]
        .step {
            position: relative;
            overflow: hidden;
        }

        /*
         * Emergency water fill
         */
        .patient-progress-card
        .progress-item[data-target="part_7_emergency"]
        .step::before {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: var(--fill, 0%);

            background: linear-gradient(
                180deg,
                #dc2626,
                #991b1b
            );

            transition: height 0.4s ease;

            z-index: 0;
        }

        /*
         * Moving water wave
         */
        .patient-progress-card
        .progress-item[data-target="part_7_emergency"]
        .step::after {
            content: "";

            position: absolute;

            left: -50%;

            width: 200%;
            height: 14px;

            bottom: calc(
                var(--fill, 0%) - 7px
            );

            background: rgba(
                255,
                255,
                255,
                0.35
            );

            border-radius: 50%;

            animation:
                emergencyWave
                2.5s linear infinite;

            z-index: 1;
        }

        /*
         * Keep ambulance icon above water
         */
        .patient-progress-card
        .progress-item[data-target="part_7_emergency"]
        .step i {
            position: relative;
            z-index: 2;
        }

        /*
         * Emergency water animation
         */
        @keyframes emergencyWave {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(50%);
            }
        }
    `;

    document.head.appendChild(style);
}
