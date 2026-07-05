document.addEventListener("DOMContentLoaded", function () {
    const addDescriptionBtn = document.getElementById("addDescription");
    const descriptionArea = document.getElementById("descriptionArea");

    if (!addDescriptionBtn || !descriptionArea) {
        return;
    }

    /**
     * Build description input row
     */
    function buildDescriptionRow() {
        const wrapper = document.createElement("div");
        wrapper.className = "input-group mb-2 patient-cancer-description-row";

        wrapper.innerHTML = `
            <input
                type="text"
                name="xray_description[]"
                class="form-control"
                placeholder="Enter X-Ray Description"
            >
            <div class="input-group-append">
                <button type="button" class="btn btn-danger removeDescription">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

        return wrapper;
    }

    /**
     * Add new description row
     */
    addDescriptionBtn.addEventListener("click", function () {
        descriptionArea.appendChild(buildDescriptionRow());
    });

    /**
     * Remove description row
     */
    descriptionArea.addEventListener("click", function (e) {
        const removeBtn = e.target.closest(".removeDescription");
        if (!removeBtn) return;

        const row = removeBtn.closest(".patient-cancer-description-row");
        if (row) {
            row.remove();
        }
    });
});
