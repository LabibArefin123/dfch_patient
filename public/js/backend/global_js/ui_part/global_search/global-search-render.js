/**
 * |--------------------------------------------------------------------------
 * | Global Search - Result Rendering
 * |--------------------------------------------------------------------------
 */

function escapeHtml(value) {
    if (value === null || value === undefined) {
        return "";
    }

    return String(value)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function renderSearchResults(data, query, resultBox) {
    console.log("[GLOBAL SEARCH][RENDER] Rendering results:", data);

    if (data.length === 0) {
        resultBox.innerHTML = `
            <div
                class="p-3 text-muted text-center"
                style="font-size: 13.5px;"
            >
                No patients found matching
                "<strong>${escapeHtml(query)}</strong>"
            </div>
        `;

        resultBox.style.display = "block";

        console.log("[GLOBAL SEARCH][RENDER] No results found");

        return;
    }

    resultBox.innerHTML = data
        .map((item) => {
            let statusBadges = "";

            // 🟠 Recommended Patient
            if (item.is_recommend) {
                statusBadges += `
                    <span
                        style="
                            font-size: 11px;
                            font-weight: 600;
                            color: #c2410c;
                            background: #ffedd5;
                            border: 1px solid #fdba74;
                            padding: 4px 8px;
                            border-radius: 5px;
                            margin-left: 6px;
                            white-space: nowrap;
                        "
                    >
                        Recommended Patient
                    </span>
                `;
            }

            // 🔵 Old Cancer History
            if (item.is_old_cancer) {
                statusBadges += `
                    <span
                        style="
                            font-size: 11px;
                            font-weight: 600;
                            color: #1d4ed8;
                            background: #dbeafe;
                            border: 1px solid #93c5fd;
                            padding: 4px 8px;
                            border-radius: 5px;
                            margin-left: 6px;
                            white-space: nowrap;
                        "
                    >
                        Old Cancer History
                    </span>
                `;
            }

            // 🔴 Emergency Patient
            if (item.is_emergency) {
                statusBadges += `
                    <span
                        style="
                            font-size: 11px;
                            font-weight: 700;
                            color: #dc2626;
                            background: #fee2e2;
                            border: 1px solid #fca5a5;
                            padding: 4px 8px;
                            border-radius: 5px;
                            margin-left: 6px;
                            white-space: nowrap;
                        "
                    >
                        Emergency Patient
                    </span>
                `;
            }

            return `
                <div
                    class="search-item"
                    style="
                        padding: 10px 15px;
                        cursor: pointer;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        gap: 12px;
                        border-bottom: 1px solid #f1f5f9;
                        transition: background 0.15s ease-in-out;
                        color: #1e293b;
                    "
                    onclick="
                        window.location.href='${escapeHtml(item.url)}'
                    "
                >

                    <span
                        style="
                            flex: 1;
                            min-width: 0;
                            font-size: 13px;
                            font-weight: 500;
                            line-height: 1.5;
                        "
                    >
                       ${item.label}
                    </span>

                    <span
                        style="
                            display: flex;
                            flex-wrap: wrap;
                            justify-content: flex-end;
                            align-items: center;
                            flex-shrink: 0;
                        "
                    >
                        ${statusBadges}
                    </span>

                </div>
            `;
        })
        .join("");

    resultBox.style.display = "block";

    console.log(
        "[GLOBAL SEARCH][RENDER SUCCESS] Results rendered successfully",
    );
}

function showSearchError(resultBox, message) {
    resultBox.innerHTML = `
        <div
            class="p-3 text-danger text-center"
            style="font-size: 13px;"
        >
            ${message}
        </div>
    `;

    resultBox.style.display = "block";
}
