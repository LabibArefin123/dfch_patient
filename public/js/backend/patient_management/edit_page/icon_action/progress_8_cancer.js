/**
 * ==========================================================================
 * PATIENT PROGRESS - CANCER
 * ==========================================================================
 *
 * File:
 * progress_8_cancer.js
 *
 * Works with:
 * ✔ Create page
 * ✔ Edit page
 * ✔ Existing cancer values
 * ✔ Existing cancer images
 * ✔ Newly selected cancer images
 * ✔ X-Ray / CT description
 * ✔ Cancer remarks
 * ✔ CKEditor 5
 *
 * Progress
 * --------------------------------------------------------------------------
 *
 * Cancer Status        = required
 * Total Cancer         = 25%
 * Cancer Images        = 35%
 * X-Ray Description    = 20%
 * Cancer Remarks       = 20%
 *
 * If Cancer Status = No:
 *      Cancer section is considered complete = 100%
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    // ----------------------------------------------------------------------
    // Find cancer progress item directly
    // ----------------------------------------------------------------------

    const cancerItem = document.querySelector(
        '.patient-progress-card .progress-item[data-target="part_8_cancer"]',
    );

    if (!cancerItem) {
        console.warn("Cancer progress item not found.");
        return;
    }

    const step = cancerItem.querySelector(".step");

    if (!step) {
        console.warn("Cancer progress step not found.");
        return;
    }

    // ----------------------------------------------------------------------
    // Inject CSS
    // ----------------------------------------------------------------------

    injectCancerWaterCSS();

    // ----------------------------------------------------------------------
    // Fields
    // ----------------------------------------------------------------------

    const statusField = document.getElementById("is_old_cancer");

    const totalField =
        document.getElementById("edit_total_cancer") ||
        document.getElementById("total_cancer");

    const imageField = document.querySelector("input[name='xray_photo[]']");

    const descriptionField = document.querySelector(
        "textarea[name='xray_description']",
    );

    const remarksField = document.querySelector(
        "textarea[name='cancer_remarks']",
    );

    // ----------------------------------------------------------------------
    // Get editor value
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
        // Old CKEditor support, if present
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
    // Existing cancer images
    // ----------------------------------------------------------------------
    //
    // IMPORTANT:
    //
    // On edit page the browser will NOT put existing images inside
    // input[type=file].
    //
    // Therefore:
    //
    // input.files.length === 0
    //
    // even when the patient already has cancer images.
    //
    // We detect the existing gallery cards instead.
    // ----------------------------------------------------------------------

    function hasExistingCancerImages() {
        const existingImages = document.querySelectorAll(
            "#part_8_cancer .investigation-image-card",
        );

        return existingImages.length > 0;
    }

    // ----------------------------------------------------------------------
    // Newly selected images
    // ----------------------------------------------------------------------

    function hasNewCancerImages() {
        return imageField && imageField.files && imageField.files.length > 0;
    }

    // ----------------------------------------------------------------------
    // Check X-Ray description
    // ----------------------------------------------------------------------

    function hasDescription() {
        return getEditorValue(descriptionField) !== "";
    }

    // ----------------------------------------------------------------------
    // Check cancer remarks
    // ----------------------------------------------------------------------

    function hasRemarks() {
        return getEditorValue(remarksField) !== "";
    }

    // ----------------------------------------------------------------------
    // Update cancer progress
    // ----------------------------------------------------------------------

    function updateCancerProgress() {
        // --------------------------------------------------------------
        // No cancer status field
        // --------------------------------------------------------------

        if (!statusField) {
            step.style.setProperty("--fill", "0%");
            cancerItem.classList.remove("completed");

            return;
        }

        const cancerStatus = String(statusField.value).trim();

        // --------------------------------------------------------------
        // NO PREVIOUS CANCER
        //
        // Nothing else is required.
        // --------------------------------------------------------------

        if (cancerStatus === "0") {
            step.style.setProperty("--fill", "100%");

            cancerItem.classList.add("completed");

            return;
        }

        // --------------------------------------------------------------
        // YES - Previous / Existing Cancer
        // --------------------------------------------------------------

        let percent = 0;

        // --------------------------------------------------------------
        // Cancer Status
        //
        // Selecting Yes means the cancer section is active.
        // --------------------------------------------------------------

        // We do not give percentage for status itself because the
        // remaining fields represent the actual cancer information.
        //
        // Total = 25 + 35 + 20 + 20 = 100
        // --------------------------------------------------------------

        // --------------------------------------------------------------
        // Total Cancer = 25%
        // --------------------------------------------------------------

        if (totalField && parseInt(totalField.value, 10) > 0) {
            percent += 25;
        }

        // --------------------------------------------------------------
        // Cancer Images = 35%
        //
        // Either:
        // - Existing images
        // - Newly selected images
        // --------------------------------------------------------------

        if (hasExistingCancerImages() || hasNewCancerImages()) {
            percent += 35;
        }

        // --------------------------------------------------------------
        // X-Ray / CT Description = 20%
        // --------------------------------------------------------------

        if (hasDescription()) {
            percent += 20;
        }

        // --------------------------------------------------------------
        // Cancer Remarks = 20%
        // --------------------------------------------------------------

        if (hasRemarks()) {
            percent += 20;
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

        cancerItem.classList.toggle("completed", percent === 100);
    }

    // ----------------------------------------------------------------------
    // Cancer status
    // ----------------------------------------------------------------------

    if (statusField) {
        statusField.addEventListener("change", updateCancerProgress);

        statusField.addEventListener("input", updateCancerProgress);
    }

    // ----------------------------------------------------------------------
    // Total cancer
    // ----------------------------------------------------------------------

    if (totalField) {
        totalField.addEventListener("change", updateCancerProgress);

        totalField.addEventListener("input", updateCancerProgress);
    }

    // ----------------------------------------------------------------------
    // Cancer image upload
    // ----------------------------------------------------------------------

    if (imageField) {
        imageField.addEventListener("change", updateCancerProgress);
    }

    // ----------------------------------------------------------------------
    // Normal textarea events
    // ----------------------------------------------------------------------

    if (descriptionField) {
        descriptionField.addEventListener("input", updateCancerProgress);

        descriptionField.addEventListener("change", updateCancerProgress);
    }

    if (remarksField) {
        remarksField.addEventListener("input", updateCancerProgress);

        remarksField.addEventListener("change", updateCancerProgress);
    }

    // ----------------------------------------------------------------------
    // CKEditor watcher
    // ----------------------------------------------------------------------
    //
    // Your edit page may initialize CKEditor after this script.
    //
    // Wait for both fields independently.
    // ----------------------------------------------------------------------

    let editorCheckCount = 0;

    const waitForEditors = setInterval(() => {
        editorCheckCount++;

        let descriptionReady =
            !descriptionField || !!descriptionField.ckeditorInstance;

        let remarksReady = !remarksField || !!remarksField.ckeditorInstance;

        // --------------------------------------------------------------
        // CKEditor 5
        // --------------------------------------------------------------

        if (descriptionField && descriptionField.ckeditorInstance) {
            if (!descriptionField.dataset.cancerProgressListener) {
                descriptionField.ckeditorInstance.model.document.on(
                    "change:data",
                    updateCancerProgress,
                );

                descriptionField.dataset.cancerProgressListener = "true";
            }
        }

        if (remarksField && remarksField.ckeditorInstance) {
            if (!remarksField.dataset.cancerProgressListener) {
                remarksField.ckeditorInstance.model.document.on(
                    "change:data",
                    updateCancerProgress,
                );

                remarksField.dataset.cancerProgressListener = "true";
            }
        }

        // --------------------------------------------------------------
        // Both ready
        // --------------------------------------------------------------

        if (descriptionReady && remarksReady) {
            clearInterval(waitForEditors);

            updateCancerProgress();

            return;
        }

        // --------------------------------------------------------------
        // Do not wait forever
        // --------------------------------------------------------------

        if (editorCheckCount >= 50) {
            clearInterval(waitForEditors);

            updateCancerProgress();
        }
    }, 200);

    // ----------------------------------------------------------------------
    // Initial calculation
    //
    // This is especially important for EDIT page.
    //
    // Blade already contains the patient's existing values.
    // ----------------------------------------------------------------------

    updateCancerProgress();
});

/**
 * ==========================================================================
 * CANCER WATER PROGRESS CSS
 * ==========================================================================
 */

function injectCancerWaterCSS() {
    if (document.getElementById("cancer-progress-style")) {
        return;
    }

    const style = document.createElement("style");

    style.id = "cancer-progress-style";

    style.innerHTML = `
        /*
         * Cancer progress icon
         */
        .patient-progress-card
        .progress-item[data-target="part_8_cancer"]
        .step {
            position: relative;
            overflow: hidden;
        }

        /*
         * Cancer water fill
         */
        .patient-progress-card
        .progress-item[data-target="part_8_cancer"]
        .step::before {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: var(--fill, 0%);

            background: linear-gradient(
                180deg,
                #ef4444,
                #b91c1c
            );

            transition: height 0.4s ease;

            z-index: 0;
        }

        /*
         * Moving water wave
         */
        .patient-progress-card
        .progress-item[data-target="part_8_cancer"]
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
                cancerWave
                2.5s linear infinite;

            z-index: 1;
        }

        /*
         * Keep cancer ribbon icon above water
         */
        .patient-progress-card
        .progress-item[data-target="part_8_cancer"]
        .step i {
            position: relative;
            z-index: 2;
        }

        /*
         * Cancer water animation
         */
        @keyframes cancerWave {
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
