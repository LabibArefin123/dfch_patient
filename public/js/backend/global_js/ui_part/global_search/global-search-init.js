/**
 * |--------------------------------------------------------------------------
 * | Global Search - Initialization
 * |--------------------------------------------------------------------------
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("[GLOBAL SEARCH][STEP 1] DOMContentLoaded fired");

    const config = window.Laravel || {};

    console.log("[GLOBAL SEARCH][STEP 1] Laravel config:", config);

    if (!config.searchUrl) {
        console.warn("[GLOBAL SEARCH][STEP 1 FAILED] Search URL not found");

        return;
    }

    console.log(
        "[GLOBAL SEARCH][STEP 1 SUCCESS] Search URL:",
        config.searchUrl,
    );

    /*
    |--------------------------------------------------------------------------
    | Find Only Search Inputs
    |--------------------------------------------------------------------------
    */

    const searchInputs = document.querySelectorAll(
        'input[name="term"], input[type="search"]',
    );

    console.log(
        "[GLOBAL SEARCH][STEP 2] Search inputs found:",
        searchInputs.length,
    );

    if (searchInputs.length === 0) {
        console.warn("[GLOBAL SEARCH][STEP 2 FAILED] No search input found");

        return;
    }

    searchInputs.forEach(function (input, index) {
        console.log(
            `[GLOBAL SEARCH][STEP 2] Processing search input #${index + 1}`,
            input,
        );

        const form = input.closest("form");

        if (!form) {
            console.warn(
                "[GLOBAL SEARCH][STEP 2 FAILED] Search input has no parent form",
                input,
            );

            return;
        }

        console.log(
            "[GLOBAL SEARCH][STEP 2 SUCCESS] Search input found:",
            input,
        );

        /*
        |--------------------------------------------------------------------------
        | Correct Function Name
        |--------------------------------------------------------------------------
        */

        initGlobalSearch(form, config);
    });
});
