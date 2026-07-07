document.addEventListener("DOMContentLoaded", function () {
    const config = window.Laravel || {};
    if (!config.searchUrl) return;

    // 🔍 Robust selection list for AdminLTE search components
    const navbarForms = document.querySelectorAll(
        ".navbar-search-block form, form.navbar-search, .navbar-nav form, .form-inline",
    );

    navbarForms.forEach((form) => {
        // Fallback checks to locate the input element
        const input =
            form.querySelector('input[name="term"]') ||
            form.querySelector('input[type="search"]') ||
            form.querySelector('input[type="text"]');

        if (!input) return;

        // 🎨 Premium floating results dropdown container
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

        // 🧩 Bind and force parent to display floating elements
        const parentGroup =
            input.closest(".input-group") || input.parentElement;
        if (parentGroup) {
            parentGroup.style.position = "relative";
            parentGroup.style.overflow = "visible"; // Prevents parent from clipping the dropdown
            parentGroup.appendChild(resultBox);
        }

        let searchTimer = null;

        // Prevent full page reload on input submit
        form.addEventListener("submit", (e) => e.preventDefault());

        input.addEventListener("input", function () {
            const query = this.value.trim();
            clearTimeout(searchTimer);

            if (query.length < 2) {
                resultBox.style.display = "none";
                return;
            }

            searchTimer = setTimeout(() => {
                fetch(`${config.searchUrl}?term=${encodeURIComponent(query)}`)
                    .then((res) => {
                        if (!res.ok) throw new Error("Search server error");
                        return res.json();
                    })
                    .then((data) => {
                        if (!Array.isArray(data) || data.length === 0) {
                            resultBox.innerHTML = `
                                <div class="p-3 text-muted text-center" style="font-size: 13.5px;">
                                    No patients found matching "<strong>${query}</strong>"
                                </div>
                            `;
                        } else {
                            resultBox.innerHTML = data
                                .map((item) => {
                                    // 🏷️ Only show a type badge if it is returned by the server
                                    const typeBadge = item.type
                                        ? `<span style="font-size: 10px; background: #e2e8f0; color: #475569; padding: 2px 6px; border-radius: 4px; font-weight: 600; text-transform: uppercase; margin-left: 8px;">${item.type}</span>`
                                        : "";

                                    return `
                                    <div class="search-item"
                                        style="
                                            padding: 10px 15px;
                                            cursor: pointer;
                                            display: flex;
                                            justify-content: space-between;
                                            align-items: center;
                                            border-bottom: 1px solid #f1f5f9;
                                            transition: background 0.15s ease-in-out;
                                            color: #1e293b;
                                        "
                                        onmouseover="this.style.background='#f8fafc'"
                                        onmouseout="this.style.background='#ffffff'"
                                        onclick="window.location='${item.url}'">
                                        
                                        <span style="font-size: 13px; font-weight: 500; text-align: left; line-height: 1.4;">
                                            ${item.label}
                                        </span>
                                        ${typeBadge}
                                    </div>
                                `;
                                })
                                .join("");
                        }
                        resultBox.style.display = "block";
                    })
                    .catch((err) => {
                        console.error(err);
                        resultBox.innerHTML = `
                            <div class="p-3 text-danger text-center" style="font-size: 13px;">
                                Error loading search results.
                            </div>
                        `;
                        resultBox.style.display = "block";
                    });
            }, 300);
        });

        // Hide search results box if clicked outside input area
        document.addEventListener("click", function (e) {
            if (!resultBox.contains(e.target) && e.target !== input) {
                resultBox.style.display = "none";
            }
        });
    });
});
    