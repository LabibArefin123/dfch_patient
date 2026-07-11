const circle = document.querySelector(".progress-ring .progress");
const text = document.getElementById("progressText");
const bar = document.getElementById("progressBar");
const previewArea = document.getElementById("previewArea");
const pdfViewer = document.getElementById("pdfViewer");
const form = document.querySelector("form");

let percent = 0;
const radius = 50;
const circumference = 2 * Math.PI * radius;

circle.style.strokeDasharray = circumference;
circle.style.strokeDashoffset = circumference;

function updateProgress(val) {
    percent = val;
    const offset = circumference - (circumference * percent) / 100;
    circle.style.strokeDashoffset = offset;
    text.innerText = Math.round(percent) + "%";
    bar.style.width = Math.round(percent) + "%";
}

// =========================
// FILE CHANGE
// =========================
document.querySelectorAll(".file-input").forEach((input) => {
    input.addEventListener("change", function () {
        previewArea.innerHTML = "";
        updateProgress(0);

        const files = [...this.files];
        if (files.length === 0) return;

        let uploadedFiles = 0;

        files.forEach((file, index) => {
            const div = document.createElement("div");
            div.classList.add("preview-item");
            div.innerText = file.name;
            previewArea.appendChild(div);

            // PDF VIEW
            if (file.type.includes("pdf")) {
                const url = URL.createObjectURL(file);
                pdfViewer.src = url;
            }

            // Simulate small preview delay
            setTimeout(() => {
                uploadedFiles++;
                const newPercent = (uploadedFiles / files.length) * 100; // full 0-100%
                updateProgress(newPercent);

                if (uploadedFiles === files.length) {
                    document.getElementById("progressMessage").innerText =
                        "Files ready ✔";
                }
            }, 100 * index);
        });
    });
});

// =========================
// FORM SUBMIT (simulate real upload)
// =========================
form.addEventListener("submit", function (e) {
    e.preventDefault();

    const files = [...document.querySelector(".file-input:enabled").files];
    if (files.length === 0) {
        form.submit();
        return;
    }

    document.getElementById("progressMessage").innerText =
        "Uploading & processing...";

    let uploaded = 0;

    function uploadNext(index) {
        if (index >= files.length) {
            animateProgress(100, () => form.submit()); // ensure 100% at end
            return;
        }

        const file = files[index];
        setTimeout(() => {
            uploaded++;
            const newPercent = (uploaded / files.length) * 100; // full 0-100%
            updateProgress(newPercent);

            uploadNext(index + 1);
        }, 300); // simulate 0.3s per file
    }

    uploadNext(0);
});

// =========================
// Smooth animation helper
// =========================
function animateProgress(target, callback = null) {
    let current = percent;
    const step = target > current ? 2 : -2;

    const interval = setInterval(() => {
        if (
            (step > 0 && current >= target) ||
            (step < 0 && current <= target)
        ) {
            clearInterval(interval);
            updateProgress(target);
            if (callback) callback();
        } else {
            current += step;
            updateProgress(current);
        }
    }, 15);
}
