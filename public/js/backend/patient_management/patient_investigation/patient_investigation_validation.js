/**
 * ==========================================================================
 * Patient Treatment Validation
 * ==========================================================================
 * File:
 * patient_investigation_validation.js
 *
 * Responsibilities
 * ----------------
 * ✔ Validate image type
 * ✔ Validate max file size (10 MB)
 * ✔ Format file size
 * ✔ Return validation status
 * ==========================================================================
 */

const INVESTIGATION_MAX_FILE_SIZE = 10 * 1024 * 1024; // 10 MB

const INVESTIGATION_ALLOWED_TYPES = [
    "image/jpeg",
    "image/jpg",
    "image/png",
    "image/webp",
    "image/gif",
    "image/bmp",
    "image/svg+xml",
];

/**
 * Validate Treatment Image
 *
 * @param {File} file
 * @returns {Object}
 */
function validateTreatmentImage(file) {
    if (!file) {
        return {
            valid: false,
            message: "No file selected.",
        };
    }

    /**
     * Check MIME Type
     */
    if (!INVESTIGATION_ALLOWED_TYPES.includes(file.type)) {
        return {
            valid: false,
            message:
                "Invalid image format. Allowed: JPG, JPEG, PNG, WEBP, GIF, BMP, SVG.",
        };
    }

    /**
     * Check File Size
     */
    if (file.size > INVESTIGATION_MAX_FILE_SIZE) {
        return {
            valid: false,
            message: `File exceeds 10 MB (${formatTreatmentFileSize(file.size)}).`,
        };
    }

    return {
        valid: true,
        message: "",
    };
}

/**
 * Format File Size
 *
 * Example:
 * 1200 -> 1.17 KB
 * 2500000 -> 2.38 MB
 */
function formatTreatmentFileSize(bytes) {
    if (bytes === 0) return "0 Bytes";

    const units = ["Bytes", "KB", "MB", "GB"];

    const index = Math.floor(Math.log(bytes) / Math.log(1024));

    return (bytes / Math.pow(1024, index)).toFixed(2) + " " + units[index];
}

/**
 * Check Image Type Only
 *
 * @param {File} file
 * @returns {Boolean}
 */
function isTreatmentImage(file) {
    return !!file && INVESTIGATION_ALLOWED_TYPES.includes(file.type);
}

/**
 * Check File Size Only
 *
 * @param {File} file
 * @returns {Boolean}
 */
function isTreatmentFileSizeValid(file) {
    return !!file && file.size <= INVESTIGATION_MAX_FILE_SIZE;
}

/**
 * Get Image Extension
 *
 * @param {File} file
 * @returns {String}
 */
function getTreatmentExtension(file) {
    if (!file || !file.name) return "";

    const parts = file.name.split(".");

    return parts.length > 1 ? parts.pop().toUpperCase() : "";
}

/**
 * Get Image Info
 *
 * @param {File} file
 * @returns {Object}
 */
function getTreatmentImageInfo(file) {
    return {
        name: file.name,
        size: formatTreatmentFileSize(file.size),
        bytes: file.size,
        extension: getTreatmentExtension(file),
        type: file.type,
    };
}
