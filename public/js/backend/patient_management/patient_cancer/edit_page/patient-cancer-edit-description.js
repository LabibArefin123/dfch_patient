document.addEventListener("DOMContentLoaded", function () {
    const descriptionArea = document.getElementById("descriptionArea");

    if (!descriptionArea) {
        return;
    }

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

    descriptionArea.addEventListener("click", function (e) {
        const addBtn = e.target.closest("#addDescription");
        if (addBtn) {
            descriptionArea.appendChild(buildDescriptionRow());
            return;
        }

        const removeBtn = e.target.closest(".removeDescription");
        if (removeBtn) {
            const row = removeBtn.closest(".patient-cancer-description-row");
            if (row) {
                row.remove();
            }
        }
    });
});
