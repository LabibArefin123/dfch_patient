/**
|--------------------------------------------------------------------------
| Patient Recommendation Document Animation
|--------------------------------------------------------------------------
| Responsible only for:
| - Doctor Recommendation
| - Recommendation Note
| - Recommendation Documents
|--------------------------------------------------------------------------
*/

window.PatientDocumentAnimate = (() => {
    /**
     * Render Recommendation Section
     */
    function render(patient) {
        if (!patient.is_recommend) {
            $("#patientAnimationDocumentContainer").html(`
                <div class="patient-document-wrapper d-none">

                    <div class="alert alert-warning shadow-sm mb-4">

                        <i class="fas fa-info-circle mr-2"></i>

                        This patient has no doctor recommendation.

                    </div>

                </div>
            `);

            return;
        }

        let imageHtml = "";
        let pdfHtml = "";

        const documents = (patient.documents || []).filter(
            (doc) => doc.document_type === "recommendation",
        );

        if (documents.length) {
            documents.forEach((doc) => {
                const ext = doc.file_path.split(".").pop().toLowerCase();

                // ===============================
                // IMAGE
                // ===============================

                if (["jpg", "jpeg", "png", "webp"].includes(ext)) {
                    imageHtml += `

                        <div class="col-xl-3 col-lg-3 col-md-4 col-6 mb-3">

                            <div class="card border-0 shadow-sm h-100">

                                <img
                                    src="/${doc.file_path}"

                                    class="card-img-top recommendation-preview-image"

                                    style="
                                        height:200px;
                                        object-fit:cover;
                                        cursor:pointer;
                                    "

                                    data-bs-toggle="modal"
                                    data-bs-target="#imageZoomModal"
                                    data-image="/${doc.file_path}"
                                >

                                <div class="card-body p-2">

                                    <small
                                        class="text-muted d-block text-truncate"
                                        title="${doc.document_name}">

                                        ${doc.document_name}

                                    </small>

                                </div>

                            </div>

                        </div>

                    `;
                }

                // ===============================
                // PDF
                // ===============================
                else {
                    pdfHtml += `

                        <div class="col-md-6 mb-3">

                            <div class="card shadow-sm border">

                                <div class="card-body d-flex justify-content-between align-items-center">

                                    <div>

                                        <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>

                                        <strong>

                                            ${doc.document_name}

                                        </strong>

                                    </div>

                                    <a
                                        href="/${doc.file_path}"
                                        target="_blank"
                                        class="btn btn-primary btn-sm">

                                        <i class="fas fa-eye mr-1"></i>

                                        View PDF

                                    </a>

                                </div>

                            </div>

                        </div>

                    `;
                }
            });
        }

        const html = `

            <div class="patient-document-wrapper d-none">

                <div class="card shadow-sm border-0 mb-4">

                    <div class="card-header bg-success text-white">

                        <div class="d-flex align-items-center">

                            <div
                                class="rounded-circle bg-white text-success d-flex align-items-center justify-content-center mr-3"
                                style="width:45px;height:45px;">

                                <i class="fas fa-file-medical"></i>

                            </div>

                            <div>

                                <h5 class="mb-0">

                                    Doctor Recommendation Analysis

                                </h5>

                                <small class="patient-document-status">

                                    Preparing recommendation...

                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="card-body">

                        <!-- Doctor -->

                        <div class="row mb-3">

                            <label class="col-md-3 col-form-label text-muted">

                                Doctor Name

                            </label>

                            <div class="col-md-9">

                                <input
                                    class="form-control"
                                    value="${patient.recommend_doctor_name || "N/A"}"
                                    disabled>

                            </div>

                        </div>

                        <!-- Note -->

                        <div class="row mb-4">

                            <label class="col-md-3 col-form-label text-muted">

                                Doctor Note

                            </label>

                            <div class="col-md-9">

                                <div
                                    class="border rounded bg-light p-3"
                                    style="min-height:120px;">

                                    ${patient.recommend_note || "<span class='text-muted'>No note provided.</span>"}

                                </div>

                            </div>

                        </div>

                        <!-- Images -->

                        <h5 class="text-success mb-3">

                            <i class="fas fa-images mr-2"></i>

                            Recommendation Images

                        </h5>

                        <div class="row">

                            ${
                                imageHtml ||
                                `
                                <div class="col-12">

                                    <div class="alert alert-light border">

                                        No recommendation images found.

                                    </div>

                                </div>
                                `
                            }

                        </div>

                        <!-- PDFs -->

                        <h5 class="text-danger mt-4 mb-3">

                            <i class="fas fa-file-pdf mr-2"></i>

                            PDF Reports

                        </h5>

                        <div class="row">

                            ${
                                pdfHtml ||
                                `
                                <div class="col-12">

                                    <div class="alert alert-light border">

                                        No PDF documents found.

                                    </div>

                                </div>
                                `
                            }

                        </div>

                    </div>

                </div>

            </div>

        `;

        $("#patientAnimationDocumentContainer").html(html);
    }
    /**
     * Animate Section
     */
    function animate() {
        $(".patient-document-wrapper").removeClass("d-none").hide().fadeIn(700);
    }

    /**
     * Typing Animation
     */
    function typing(message, speed = 25) {
        return new Promise((resolve) => {
            const target = $(".patient-document-status");

            target.text("");

            let i = 0;

            const interval = setInterval(() => {
                target.text(message.substring(0, i + 1));

                i++;

                if (i >= message.length) {
                    clearInterval(interval);

                    resolve();
                }
            }, speed);
        });
    }

    /**
     * AI Thinking Animation
     */
    function thinking(seconds = 2) {
        return new Promise((resolve) => {
            const target = $(".patient-document-status");

            let dots = 0;

            const interval = setInterval(() => {
                dots++;

                target.text(
                    "Analyzing Recommendation Documents" + ".".repeat(dots % 4),
                );
            }, 400);

            setTimeout(() => {
                clearInterval(interval);

                resolve();
            }, seconds * 1000);
        });
    }

    /**
     * Complete Animation
     */
    function complete() {
        $(".patient-document-status")
            .removeClass("text-warning")
            .addClass("text-success").html(`
                <i class="fas fa-check-circle mr-1"></i>

                Recommendation Analysis Completed Successfully
            `);
    }

    /**
     * Clear Container
     */
    function clear() {
        $("#patientAnimationDocumentContainer").empty();
    }

    /**
     * Image Zoom
     */
    $(document).on("click", ".recommendation-preview-image", function () {
        const image = $(this).data("image");

        // Update according to your modal image id
        $("#imageZoomModal img").attr("src", image);
    });

    /**
     * Public Methods
     */
    return {
        render,

        animate,

        typing,

        thinking,

        complete,

        clear,
    };
})();
