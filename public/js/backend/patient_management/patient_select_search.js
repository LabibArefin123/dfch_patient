document.addEventListener("DOMContentLoaded", function () {
    const patientSelect = document.getElementById("patientSelect");
    if (!patientSelect) return;

    const PAGE_SIZE = 15;

    let visibleCount = PAGE_SIZE;
    let currentSearchTerm = "";
    let highlightedIndex = -1;
    let dropdownOpen = false;

    // -----------------------------------
    // Collect original options
    // -----------------------------------
    const originalOptions = [];
    Array.from(patientSelect.options).forEach((option, index) => {
        if (index === 0) return; // skip placeholder

        originalOptions.push({
            value: option.value,
            text: (option.textContent || "").trim(),
            name: (option.dataset.name || "").trim(),
            code: (option.dataset.code || "").trim(),
            selected: option.selected,
        });
    });

    // -----------------------------------
    // Build custom UI
    // -----------------------------------
    patientSelect.style.display = "none";

    const wrapper = document.createElement("div");
    wrapper.className = "patient-custom-select";

    wrapper.innerHTML = `
        <div class="patient-custom-trigger" tabindex="0">
            <div class="patient-custom-trigger-text">Select Patient</div>
            <div class="patient-custom-trigger-icon">
                <svg width="16" height="16" viewBox="0 0 20 20" fill="none">
                    <path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>

        <div class="patient-custom-dropdown">
            <div class="patient-custom-search-wrap">
                <input
                    type="text"
                    class="patient-custom-search"
                    placeholder="Search patient by name or code..."
                    autocomplete="off"
                >
            </div>

            <div class="patient-custom-results"></div>

            <div class="patient-custom-footer" style="display:none;">
                <button type="button" class="patient-show-more-btn">Show more</button>
            </div>
        </div>
    `;

    patientSelect.parentNode.insertBefore(wrapper, patientSelect.nextSibling);

    const trigger = wrapper.querySelector(".patient-custom-trigger");
    const triggerText = wrapper.querySelector(".patient-custom-trigger-text");
    const dropdown = wrapper.querySelector(".patient-custom-dropdown");
    const searchInput = wrapper.querySelector(".patient-custom-search");
    const resultsBox = wrapper.querySelector(".patient-custom-results");
    const footer = wrapper.querySelector(".patient-custom-footer");
    const showMoreBtn = wrapper.querySelector(".patient-show-more-btn");

    // -----------------------------------
    // Helpers
    // -----------------------------------
    function escapeHtml(str) {
        return String(str || "")
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function escapeRegExp(str) {
        return String(str || "").replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    }

    function highlightText(text, searchTerm) {
        const safeText = escapeHtml(text);

        if (!searchTerm || !searchTerm.trim()) {
            return safeText;
        }

        const escapedSearch = escapeRegExp(searchTerm.trim());
        if (!escapedSearch) return safeText;

        const regex = new RegExp(`(${escapedSearch})`, "ig");
        return safeText.replace(
            regex,
            '<mark class="patient-search-highlight">$1</mark>',
        );
    }

    function getFilteredPatients(searchTerm = "") {
        const normalized = searchTerm.trim().toLowerCase();

        if (!normalized) {
            return [...originalOptions];
        }

        return originalOptions.filter((item) => {
            const name = String(item.name || "").toLowerCase();
            const code = String(item.code || "").toLowerCase();
            const text = String(item.text || "").toLowerCase();

            return (
                name.includes(normalized) ||
                code.includes(normalized) ||
                text.includes(normalized)
            );
        });
    }

    function getPatientDisplayName(item) {
        if (item.name && item.code) {
            return `${item.name} (${item.code})`;
        }
        return item.name || item.text || "Select Patient";
    }

    function getSelectedPatient() {
        const selectedValue = patientSelect.value;
        return (
            originalOptions.find((item) => item.value === selectedValue) || null
        );
    }

    function updateTriggerText() {
        const selected = getSelectedPatient();
        triggerText.textContent = selected
            ? getPatientDisplayName(selected)
            : "Select Patient";
    }

    function syncSelectValue(value) {
        patientSelect.value = value || "";
        patientSelect.dispatchEvent(new Event("change", { bubbles: true }));
        updateTriggerText();
    }

    function openDropdown() {
        dropdown.classList.add("is-open");
        wrapper.classList.add("is-open");
        trigger.classList.add("is-open");
        dropdownOpen = true;

        setTimeout(() => {
            searchInput.focus();
            searchInput.setSelectionRange(
                searchInput.value.length,
                searchInput.value.length,
            );
        }, 0);
    }

    function closeDropdown() {
        dropdown.classList.remove("is-open");
        wrapper.classList.remove("is-open");
        trigger.classList.remove("is-open");
        dropdownOpen = false;
        highlightedIndex = -1;
    }

    function renderResults() {
        const filtered = getFilteredPatients(currentSearchTerm);
        const visibleItems = filtered.slice(0, visibleCount);
        const hasMore = filtered.length > visibleCount;

        resultsBox.innerHTML = "";

        if (!visibleItems.length) {
            resultsBox.innerHTML = `
                <div class="patient-empty-state">
                    No patient found
                </div>
            `;
            footer.style.display = "none";
            highlightedIndex = -1;
            return;
        }

        visibleItems.forEach((item, index) => {
            const row = document.createElement("button");
            row.type = "button";
            row.className = "patient-option-item";
            row.dataset.value = item.value;
            row.dataset.index = index;

            const title = item.name || item.text;
            const subtitle = item.code ? `Code: ${item.code}` : "";

            row.innerHTML = `
                <div class="patient-option-title">
                    ${highlightText(title, currentSearchTerm)}
                </div>
                ${
                    subtitle
                        ? `<small class="patient-option-subtitle">${highlightText(subtitle, currentSearchTerm)}</small>`
                        : ""
                }
            `;

            row.addEventListener("click", function () {
                syncSelectValue(item.value);
                closeDropdown();
            });

            resultsBox.appendChild(row);
        });

        footer.style.display = hasMore ? "block" : "none";

        const activeRows = resultsBox.querySelectorAll(".patient-option-item");
        activeRows.forEach((row, index) => {
            row.classList.toggle("is-highlighted", index === highlightedIndex);
        });
    }

    function resetSearchAndRender() {
        visibleCount = PAGE_SIZE;
        highlightedIndex = -1;
        renderResults();
    }

    function moveHighlight(direction) {
        const rows = Array.from(
            resultsBox.querySelectorAll(".patient-option-item"),
        );

        if (!rows.length) return;

        if (highlightedIndex < 0) {
            highlightedIndex = direction > 0 ? 0 : rows.length - 1;
        } else {
            highlightedIndex += direction;

            if (highlightedIndex < 0) highlightedIndex = rows.length - 1;
            if (highlightedIndex >= rows.length) highlightedIndex = 0;
        }

        rows.forEach((row, index) => {
            row.classList.toggle("is-highlighted", index === highlightedIndex);
        });

        const activeRow = rows[highlightedIndex];
        if (activeRow) {
            activeRow.scrollIntoView({
                block: "nearest",
                behavior: "smooth",
            });
        }
    }

    function selectHighlighted() {
        const rows = Array.from(
            resultsBox.querySelectorAll(".patient-option-item"),
        );

        if (!rows.length) return;

        if (highlightedIndex < 0) {
            highlightedIndex = 0;
        }

        const activeRow = rows[highlightedIndex];
        if (activeRow) {
            activeRow.click();
        }
    }

    // -----------------------------------
    // Events
    // -----------------------------------
    trigger.addEventListener("click", function () {
        if (dropdownOpen) {
            closeDropdown();
        } else {
            openDropdown();
        }
    });

    trigger.addEventListener("keydown", function (e) {
        if (e.key === "Enter" || e.key === " ") {
            e.preventDefault();
            if (dropdownOpen) {
                closeDropdown();
            } else {
                openDropdown();
            }
        }

        if (e.key === "ArrowDown") {
            e.preventDefault();
            if (!dropdownOpen) {
                openDropdown();
            } else {
                moveHighlight(1);
            }
        }
    });

    searchInput.addEventListener("input", function (e) {
        currentSearchTerm = e.target.value || "";
        visibleCount = PAGE_SIZE;
        highlightedIndex = -1;
        renderResults();
    });

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "ArrowDown") {
            e.preventDefault();
            moveHighlight(1);
        } else if (e.key === "ArrowUp") {
            e.preventDefault();
            moveHighlight(-1);
        } else if (e.key === "Enter") {
            e.preventDefault();
            selectHighlighted();
        } else if (e.key === "Escape") {
            e.preventDefault();
            closeDropdown();
            trigger.focus();
        }
    });

    showMoreBtn.addEventListener("click", function () {
        visibleCount += PAGE_SIZE;
        renderResults();
        searchInput.focus();
    });

    document.addEventListener("click", function (e) {
        if (!wrapper.contains(e.target)) {
            closeDropdown();
        }
    });

    patientSelect.addEventListener("change", function () {
        updateTriggerText();
    });

    // -----------------------------------
    // Init
    // -----------------------------------
    updateTriggerText();
    renderResults();

    // if you want dropdown closed search to reset each time, uncomment this:
    trigger.addEventListener("click", function () {
        if (!dropdownOpen) {
            currentSearchTerm = "";
            searchInput.value = "";
            visibleCount = PAGE_SIZE;
            highlightedIndex = -1;
            renderResults();
        }
    });
});
