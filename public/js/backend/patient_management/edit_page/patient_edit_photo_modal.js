let selectedFile = null;

const photoInput = document.getElementById("photoInput");
const hiddenInput = document.getElementById("hiddenPhotoInput");
const confirmBtn = document.getElementById("confirmUpload");
const preview = document.getElementById("previewImage");
const mainPreview = document.getElementById("mainPreview");

if (photoInput && hiddenInput && confirmBtn && preview && mainPreview) {
    photoInput.addEventListener("change", function (e) {
        const file = e.target.files[0];

        if (!file) {
            return;
        }

        selectedFile = file;

        const img = new Image();
        const reader = new FileReader();

        reader.onload = function (event) {
            img.src = event.target.result;
            preview.src = img.src;
            preview.style.display = "block";
        };

        reader.readAsDataURL(file);

        img.onload = function () {
            let percent = 0;

            // File Type
            if (["image/jpeg", "image/png"].includes(file.type)) {
                percent += 25;
            }

            // File Size (2MB)
            if (file.size <= 2 * 1024 * 1024) {
                percent += 25;
            }

            // Image Dimension
            let type = "";

            if (img.width === img.height) {
                type = "Square";
            } else if (img.height > img.width) {
                type = "Portrait";
            } else {
                type = "Landscape";
            }

            percent += 25;

            // Loaded Successfully
            percent += 25;

            const progressCircle = document.getElementById("progressCircle");
            const fileInfo = document.getElementById("fileInfo");

            if (progressCircle) {
                progressCircle.innerText = percent + "%";
                progressCircle.style.background = `conic-gradient(#28a745 ${percent}%, #e9ecef ${percent}%)`;
            }

            if (fileInfo) {
                fileInfo.innerHTML = `
                    <b>Size:</b> ${(file.size / 1024).toFixed(1)} KB <br>
                    <b>Type:</b> ${file.type} <br>
                    <b>Dimension:</b> ${img.width} × ${img.height} (${type})
                `;
            }

            confirmBtn.disabled = percent !== 100;
        };
    });

    confirmBtn.addEventListener("click", function () {
        if (!selectedFile) {
            return;
        }

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(selectedFile);

        hiddenInput.files = dataTransfer.files;

        mainPreview.src = URL.createObjectURL(selectedFile);

        $("#photoModal").modal("hide");
    });
}
