document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("xray_photo");
    const preview = document.getElementById("previewContainer");

    if (!input || !preview) {
        return;
    }

    let selectedFiles = [];

    input.addEventListener("change", function () {
        selectedFiles = Array.from(this.files);

        renderPreview();
    });

    function renderPreview() {
        preview.innerHTML = "";

        selectedFiles.forEach((file, index) => {
            if (!file.type.startsWith("image/")) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                preview.insertAdjacentHTML(
                    "beforeend",
                    createCard(e.target.result, file.name, index),
                );
            };

            reader.readAsDataURL(file);
        });

        bindRemoveButtons();
    }

    function createCard(src, fileName, index) {
        return `
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4 preview-item">

            <div class="card preview-card shadow-sm border-0">

                <button
                    type="button"
                    class="btn btn-danger btn-sm preview-remove"
                    data-index="${index}">

                    <i class="fas fa-times"></i>

                </button>

                <img
                    src="${src}"
                    class="card-img-top preview-image"
                    alt="${fileName}">

                <div class="card-footer bg-white text-center">

                    <small class="text-muted">

                        ${fileName}

                    </small>

                </div>

            </div>

        </div>
        `;
    }

    function bindRemoveButtons() {
        document.querySelectorAll(".preview-remove").forEach((btn) => {
            btn.onclick = function () {
                const index = Number(this.dataset.index);

                selectedFiles.splice(index, 1);

                const dt = new DataTransfer();

                selectedFiles.forEach((file) => dt.items.add(file));

                input.files = dt.files;

                renderPreview();
            };
        });
    }
});
