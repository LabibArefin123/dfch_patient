/**
 * |--------------------------------------------------------------------------
 * | Global Search - Initialization
 * |--------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log(
        "%c[GLOBAL SEARCH][STEP 1] DOMContentLoaded fired",
        "color: #0d6efd; font-weight: bold;",
    );

    const config = window.Laravel || {};

    console.log("[GLOBAL SEARCH][STEP 1] Laravel config:", config);

    if (!config.searchUrl) {
        console.error(
            "[GLOBAL SEARCH][STEP 1 FAILED] searchUrl is missing from window.Laravel",
        );

        return;
    }

    console.log(
        "[GLOBAL SEARCH][STEP 1 SUCCESS] Search URL:",
        config.searchUrl,
    );

    // Get all search forms
    const navbarForms = document.querySelectorAll(
        ".navbar-search-block form, form.navbar-search, .navbar-nav form, .form-inline",
    );

    console.log("[GLOBAL SEARCH][STEP 2] Forms found:", navbarForms.length);

    if (navbarForms.length === 0) {
        console.error("[GLOBAL SEARCH][STEP 2 FAILED] No search forms found");

        return;
    }

    navbarForms.forEach((form, index) => {
        console.log(
            `[GLOBAL SEARCH][STEP 2] Processing form #${index + 1}`,
            form,
        );

        initGlobalSearch(form, config);
    });
});
