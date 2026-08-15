/**
 * ==========================================================================
 * PATIENT PROGRESS - INVESTIGATION
 * ==========================================================================
 *
 * File:
 * progress_6_investigation.js
 *
 * Rules:
 * --------------------------------------------------------------------------
 * ✔ No investigation        = 100%
 * ✔ Investigation + image  = 100%
 * ✔ Investigation no image = 0%
 *
 * The investigation information field does NOT affect progress.
 * ==========================================================================
 */

document.addEventListener("DOMContentLoaded", () => {
    // ----------------------------------------------------------------------
    // Find Investigation progress item directly
    // ----------------------------------------------------------------------

    const investigationItem = document.querySelector(
        '.patient-progress-card .progress-item[data-target="part_6_investigation"]',
    );

    if (!investigationItem) {
        console.warn("Investigation progress item not found.");
        return;
    }

    const step = investigationItem.querySelector(".step");

    if (!step) {
        console.warn("Investigation progress step not found.");
        return;
    }

    // ----------------------------------------------------------------------
    // Inject CSS
    // ----------------------------------------------------------------------

    injectInvestigationWaterCSS();

    // ----------------------------------------------------------------------
    // Fields
    // ----------------------------------------------------------------------

    const statusField = document.getElementById("is_investigated");

    const imageField = document.querySelector(
        "input[name='investigation_images[]']",
    );

    // ----------------------------------------------------------------------
    // Check existing images on EDIT page
    // ----------------------------------------------------------------------
    //
    // Existing database images are already displayed in the page.
    //
    // The browser will NOT put these images inside the file input.
    //
    // So we check the preview/gallery inside part_6_investigation.
    // ----------------------------------------------------------------------

    function hasExistingInvestigationImages() {
        const investigationSection = document.getElementById(
            "part_6_investigation",
        );

        if (!investigationSection) {
            return false;
        }

        // --------------------------------------------------------------
        // Existing image cards
        // --------------------------------------------------------------

        const existingCards = investigationSection.querySelectorAll(
            ".investigation-image-card",
        );

        if (existingCards.length > 0) {
            return true;
        }

        // --------------------------------------------------------------
        // Existing gallery images
        // --------------------------------------------------------------

        const existingImages = investigationSection.querySelectorAll(
            ".investigation-gallery-image",
        );

        if (existingImages.length > 0) {
            return true;
        }

        return false;
    }

    // ----------------------------------------------------------------------
    // Check NEW image preview
    // ----------------------------------------------------------------------
    //
    // This handles images selected from the file input.
    //
    // Even if another JS creates a preview, we also inspect the preview
    // container directly.
    // ----------------------------------------------------------------------

    function hasInvestigationPreview() {
        const investigationSection = document.getElementById(
            "part_6_investigation",
        );

        if (!investigationSection) {
            return false;
        }

        // --------------------------------------------------------------
        // Common preview containers
        // --------------------------------------------------------------

        const previewSelectors = [
            "#investigationPreviewContainer img",
            ".investigation-preview-container img",
            ".investigation-preview img",
            ".investigation-image-preview img",
            ".investigation-preview-item img",
            ".investigation-preview-card img",
        ];

        for (let i = 0; i < previewSelectors.length; i++) {
            if (investigationSection.querySelector(previewSelectors[i])) {
                return true;
            }
        }

        return false;
    }

    // ----------------------------------------------------------------------
    // Check newly selected files
    // ----------------------------------------------------------------------

    function hasNewInvestigationImages() {
        return imageField && imageField.files && imageField.files.length > 0;
    }

    // ----------------------------------------------------------------------
    // Main image check
    // ----------------------------------------------------------------------

    function hasInvestigationImage() {
        // Existing database image
        if (hasExistingInvestigationImages()) {
            return true;
        }

        // New file selected
        if (hasNewInvestigationImages()) {
            return true;
        }

        // New preview generated by preview JS
        if (hasInvestigationPreview()) {
            return true;
        }

        return false;
    }

    // ----------------------------------------------------------------------
    // Update Investigation Progress
    // ----------------------------------------------------------------------

    function updateInvestigationProgress() {
        if (!statusField) {
            step.style.setProperty("--fill", "0%");

            investigationItem.classList.remove("completed");

            return;
        }

        const status = String(statusField.value).trim();

        // ------------------------------------------------------------------
        // NOT INVESTIGATED
        // ------------------------------------------------------------------
        //
        // No investigation is required.
        // Therefore section is complete.
        // ------------------------------------------------------------------

        if (status === "0") {
            step.style.setProperty("--fill", "100%");

            investigationItem.classList.add("completed");

            return;
        }

        // ------------------------------------------------------------------
        // INVESTIGATED
        // ------------------------------------------------------------------
        //
        // Only image matters.
        //
        // Image exists / preview exists = 100%
        // No image = 0%
        // ------------------------------------------------------------------

        if (hasInvestigationImage()) {
            step.style.setProperty("--fill", "100%");

            investigationItem.classList.add("completed");

            return;
        }

        step.style.setProperty("--fill", "0%");

        investigationItem.classList.remove("completed");
    }

    // ----------------------------------------------------------------------
    // Status events
    // ----------------------------------------------------------------------

    if (statusField) {
        statusField.addEventListener("change", updateInvestigationProgress);

        statusField.addEventListener("input", updateInvestigationProgress);
    }

    // ----------------------------------------------------------------------
    // File input events
    // ----------------------------------------------------------------------

    if (imageField) {
        imageField.addEventListener("change", updateInvestigationProgress);

        imageField.addEventListener("input", updateInvestigationProgress);
    }

    // ----------------------------------------------------------------------
    // Watch preview changes
    // ----------------------------------------------------------------------
    //
    // Your image-preview JS may create/remove preview elements dynamically.
    //
    // MutationObserver makes the progress icon react immediately.
    // ----------------------------------------------------------------------

    const investigationSection = document.getElementById(
        "part_6_investigation",
    );

    if (investigationSection) {
        const previewObserver = new MutationObserver(() => {
            updateInvestigationProgress();
        });

        previewObserver.observe(investigationSection, {
            childList: true,
            subtree: true,
        });
    }

    // ----------------------------------------------------------------------
    // Initial calculation
    //
    // Important for EDIT page.
    // Existing investigation images are detected immediately.
    // ----------------------------------------------------------------------

    updateInvestigationProgress();
});

/**
 * ==========================================================================
 * INVESTIGATION WATER PROGRESS CSS
 * ==========================================================================
 */

function injectInvestigationWaterCSS() {
    if (document.getElementById("investigation-progress-style")) {
        return;
    }

    const style = document.createElement("style");

    style.id = "investigation-progress-style";

    style.innerHTML = `
        /*
         * Investigation progress icon
         */
        .patient-progress-card
        .progress-item[data-target="part_6_investigation"]
        .step {
            position: relative;
            overflow: hidden;
        }

        /*
         * Investigation water fill
         */
        .patient-progress-card
        .progress-item[data-target="part_6_investigation"]
        .step::before {
            content: "";

            position: absolute;

            left: 0;
            right: 0;
            bottom: 0;

            height: var(--fill, 0%);

            background: linear-gradient(
                180deg,
                #f59e0b,
                #d97706
            );

            transition: height 0.4s ease;

            z-index: 0;
        }

        /*
         * Moving water wave
         */
        .patient-progress-card
        .progress-item[data-target="part_6_investigation"]
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
                investigationWave
                2.5s linear infinite;

            z-index: 1;
        }

        /*
         * Keep microscope icon above water
         */
        .patient-progress-card
        .progress-item[data-target="part_6_investigation"]
        .step i {
            position: relative;
            z-index: 2;
        }

        /*
         * Water animation
         */
        @keyframes investigationWave {
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
