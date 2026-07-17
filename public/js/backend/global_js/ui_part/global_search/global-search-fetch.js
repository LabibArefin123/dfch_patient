/**
 * |--------------------------------------------------------------------------
 * | Global Search - Fetch
 * |--------------------------------------------------------------------------
 */

function searchPatients(query, searchUrl, resultBox) {
    const url = `${searchUrl}?term=${encodeURIComponent(query)}`;

    console.log("[GLOBAL SEARCH][STEP 3] Fetching URL:", url);

    fetch(url, {
        method: "GET",
        headers: {
            Accept: "application/json",
            "X-Requested-With": "XMLHttpRequest",
        },
    })
        .then((response) => {
            console.log("[GLOBAL SEARCH][STEP 4] Server response:", response);

            console.log(
                "[GLOBAL SEARCH][STEP 4] HTTP status:",
                response.status,
            );

            if (!response.ok) {
                throw new Error(`Search server error: ${response.status}`);
            }

            return response.json();
        })
        .then((data) => {
            console.log("[GLOBAL SEARCH][STEP 4 SUCCESS] JSON response:", data);

            if (!Array.isArray(data)) {
                console.error(
                    "[GLOBAL SEARCH][STEP 4 FAILED] Response is not an array:",
                    data,
                );

                showSearchError(
                    resultBox,
                    "Invalid search response from server.",
                );

                return;
            }

            console.log("[GLOBAL SEARCH][STEP 4] Results count:", data.length);

            renderSearchResults(data, query, resultBox);
        })
        .catch((error) => {
            console.error("[GLOBAL SEARCH][FETCH ERROR]", error);

            showSearchError(resultBox, "Error loading search results.");
        });
}
