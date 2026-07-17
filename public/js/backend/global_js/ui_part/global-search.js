javascript;
document.addEventListener("DOMContentLoaded", function () {
    const config = window.Laravel || {};

    if (!config.searchUrl) return;

    // 🔍 Locate AdminLTE search forms
    const navbarForms = document.querySelectorAll(
        ".navbar-search-block form, form.navbar-search, .navbar-nav form, .form-inline",
    );

    navbarForms.forEach((form) => {
        const input =
            form.querySelector('input[name="term"]') ||
            form.querySelector('input[type="search"]') ||
            form.querySelector('input[type="text"]');

        if (!input) return;

        // 🎨 Search result dropdown
        const resultBox = document.createElement("div");
        Object.assign(resultBox.style, {
            position: "absolute",
            top: "100%", // Positions it right below the search input
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

       
        // 📌 Attach dropdown to input parent
        const parentGroup =
            input.closest(".input-group") || input.parentElement;

        if (parentGroup) {
            parentGroup.style.position = "relative";
            parentGroup.style.overflow = "visible";
            parentGroup.appendChild(resultBox);
        }

        let searchTimer = null;

        // Prevent form submit
        form.addEventListener("submit", function (e) {
            e.preventDefault();
        });

        // 🛡️ Escape HTML to prevent unsafe HTML injection
        function escapeHtml(value) {
            if (value === null || value === undefined) return "";

            return String(value)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        // 🔍 Search input
        input.addEventListener("input", function () {
            const query = this.value.trim();

            clearTimeout(searchTimer);

            if (query.length < 2) {
                resultBox.style.display = "none";
                resultBox.innerHTML = "";
                return;
            }

            searchTimer = setTimeout(() => {
                fetch(`${config.searchUrl}?term=${encodeURIComponent(query)}`, {
                    headers: {
                        Accept: "application/json",
                    },
                })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error("Search server error");
                        }

                        return response.json();
                    })
                    .then((data) => {
                        if (!Array.isArray(data) || data.length === 0) {
                            resultBox.innerHTML = `
                                <div class="p-3 text-muted text-center"
                                     style="font-size: 13.5px;">
                                    No patients found matching
                                    "<strong>${escapeHtml(query)}</strong>"
                                </div>
                            `;

                            resultBox.style.display = "block";
                            return;
                        }

                        resultBox.innerHTML = data
                            .map((item) => {
                                // ============================
                                // Patient Information
                                // ============================

                                const label = escapeHtml(item.label);

                                // ============================
                                // Status Badges
                                // ============================

                                let statusBadges = "";

                                // 🟠 Recommended Patient
                                if (item.is_recommend) {
                                    statusBadges += `
                                        <span
                                            style="
                                                display: inline-block;
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
                                                display: inline-block;
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
                                                display: inline-block;
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
                                        onmouseover="
                                            this.style.background='#f8fafc'
                                        "
                                        onmouseout="
                                            this.style.background='#ffffff'
                                        "
                                        onclick="
                                            window.location.href='${escapeHtml(
                                                item.url,
                                            )}'
                                        "
                                    >

                                        <!-- Patient Information -->
                                        <span
                                            style="
                                                flex: 1;
                                                min-width: 0;
                                                font-size: 13px;
                                                font-weight: 500;
                                                text-align: left;
                                                line-height: 1.5;
                                            "
                                        >
                                            ${label}
                                        </span>

                                        <!-- Status Badges -->
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
                    })
                    .catch((error) => {
                        console.error(error);

                        resultBox.innerHTML = `
                            <div
                                class="p-3 text-danger text-center"
                                style="font-size: 13px;"
                            >
                                Error loading search results.
                            </div>
                        `;

                        resultBox.style.display = "block";
                    });
            }, 300);
        });

        // Hide results when clicking outside
        document.addEventListener("click", function (e) {
            if (!resultBox.contains(e.target) && e.target !== input) {
                resultBox.style.display = "none";
            }
        });
    });
});
