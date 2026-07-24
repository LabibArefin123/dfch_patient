/**
 * ==========================================================================
 * Patient Refer Validation
 * ==========================================================================
 * File:
 * patient_refer_validation.js
 *
 * Responsibilities
 * ----------------
 * ✔ Validate image type
 * ✔ Validate max file size (10 MB)
 * ✔ Format file size
 * ✔ Return validation status
 * ==========================================================================
 */

const REFER_MAX_FILE_SIZE = 10 * 1024 * 1024; // 10 MB

const REFER_ALLOWED_TYPES = [
    "image/jpeg",
    "image/jpg",
    "image/png",
    "image/webp",
    "image/gif",
    "image/bmp",
    "image/svg+xml",
    "application/pdf",
];
/**
 * Validate Refer Image
 *
 * @param {File} file
 * @returns {Object}
 */
function validateReferImage(file) {
    if (!file) {
        return {
            valid: false,
            message: "No file selected.",
        };
    }

    /**
     * Check MIME Type
     */
    if (!REFER_ALLOWED_TYPES.includes(file.type)) {
        return {
            valid: false,
            message:
                "Allowed files: JPG, JPEG, PNG, WEBP, GIF, BMP, SVG and PDF.",
        };
    }

    /**
     * Check File Size
     */
    if (file.size > REFER_MAX_FILE_SIZE) {
        return {
            valid: false,
            message: `File exceeds 10 MB (${formatReferFileSize(file.size)}).`,
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
function formatReferFileSize(bytes) {
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
function isReferImage(file) {
    return !!file && REFER_ALLOWED_TYPES.includes(file.type);
}

/**
 * Check File Size Only
 *
 * @param {File} file
 * @returns {Boolean}
 */
function isReferFileSizeValid(file) {
    return !!file && file.size <= REFER_MAX_FILE_SIZE;
}

/**
 * Get Image Extension
 *
 * @param {File} file
 * @returns {String}
 */
function getReferExtension(file) {
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
function getReferFileInfo(file) {
    return {
        name: file.name,
        size: formatReferFileSize(file.size),
        extension: getReferExtension(file),
        type: file.type,
        isPdf: file.type === "application/pdf",
        isImage: file.type.startsWith("image/"),
    };
}
