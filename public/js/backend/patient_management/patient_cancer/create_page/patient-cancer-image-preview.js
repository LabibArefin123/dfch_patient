document.addEventListener("DOMContentLoaded", function () {
    const xrayPhotoInput = document.getElementById("xray_photo");
    const previewContainer = document.getElementById("previewContainer");

    if (!xrayPhotoInput || !previewContainer) {
        return;
    }

    /**
     * Build preview card HTML
     */
    function buildPreviewCard(imageSrc, fileName) {
        return `
            <div class="col-md-3 mb-3">
                <div class="card h-100 shadow-sm border-0">
                    <img
                        src="${imageSrc}"
                        class="card-img-top"
                        style="height:220px; object-fit:cover;"
                        alt="${fileName}"
                    >
                    <div class="card-footer text-center bg-white">
                        <small class="text-muted">${fileName}</small>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Render selected image previews
     */
    function renderImagePreviews(files) {
        previewContainer.innerHTML = "";

        if (!files || !files.length) {
            return;
        }

        Array.from(files).forEach(function (file) {
            if (!file.type.startsWith("image/")) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                previewContainer.insertAdjacentHTML(
                    "beforeend",
                    buildPreviewCard(e.target.result, file.name),
                );
            };

            reader.readAsDataURL(file);
        });
    }

    /**
     * File input change event
     */
    xrayPhotoInput.addEventListener("change", function () {
        renderImagePreviews(this.files);
    });
});
