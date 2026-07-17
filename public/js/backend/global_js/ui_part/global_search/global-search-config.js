/**
 * |--------------------------------------------------------------------------
 * | Global Search - Config & Form Initialization
 * |--------------------------------------------------------------------------
 */

function initGlobalSearch(form, config) {
    console.log("[GLOBAL SEARCH][CONFIG] Initializing search form:", form);

    const input =
        form.querySelector('input[name="term"]') ||
        form.querySelector('input[type="search"]') ||
        form.querySelector('input[type="text"]');

    if (!input) {
        console.error(
            "[GLOBAL SEARCH][STEP 2 FAILED] Search input not found in form:",
            form,
        );

        return;
    }

    console.log("[GLOBAL SEARCH][STEP 2 SUCCESS] Search input found:", input);

    const resultBox = createSearchResultBox();

    const parentGroup = input.closest(".input-group") || input.parentElement;

    if (!parentGroup) {
        console.error(
            "[GLOBAL SEARCH][STEP 2 FAILED] Input parent container not found",
        );

        return;
    }

    parentGroup.style.position = "relative";

    parentGroup.style.overflow = "visible";

    parentGroup.appendChild(resultBox);

    console.log(
        "[GLOBAL SEARCH][STEP 2 SUCCESS] Result box attached:",
        resultBox,
    );

    let searchTimer = null;

    /*
    |--------------------------------------------------------------------------
    | Prevent Full Page Submit
    |--------------------------------------------------------------------------
    */

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        console.log("[GLOBAL SEARCH] Form submit prevented");
    });

    /*
    |--------------------------------------------------------------------------
    | Search Input
    |--------------------------------------------------------------------------
    */

    input.addEventListener("input", function () {
        const query = this.value.trim();

        console.log("[GLOBAL SEARCH][STEP 3] User typed:", query);

        clearTimeout(searchTimer);

        if (query.length < 2) {
            console.log("[GLOBAL SEARCH][STEP 3] Query too short");

            resultBox.style.display = "none";

            resultBox.innerHTML = "";

            return;
        }

        console.log(
            "[GLOBAL SEARCH][STEP 3 SUCCESS] Valid search query:",
            query,
        );

        searchTimer = setTimeout(function () {
            searchPatients(query, config.searchUrl, resultBox);
        }, 300);
    });

    /*
    |--------------------------------------------------------------------------
    | Hide Results When Clicking Outside
    |--------------------------------------------------------------------------
    */

    document.addEventListener("click", function (e) {
        if (!resultBox.contains(e.target) && e.target !== input) {
            resultBox.style.display = "none";
        }
    });
}
