/**
 * |--------------------------------------------------------------------------
 * | Global Search - UI
 * |--------------------------------------------------------------------------
 */

function createSearchResultBox() {
    console.log("[GLOBAL SEARCH][UI] Creating result box");

    const resultBox = document.createElement("div");

    Object.assign(resultBox.style, {
        position: "absolute",
        top: "100%",
        left: "0",
        width: "100%",
        maxHeight: "320px",
        overflowY: "auto",
        background: "#ffffff",
        border: "1px solid rgba(0, 0, 0, 0.15)",
        borderRadius: "8px",
        boxShadow: "0 10px 25px rgba(0, 0, 0, 0.15)",
        zIndex: "99999",
        display: "none",
        color: "#1e293b",
        marginTop: "5px",
    });

    return resultBox;
}
