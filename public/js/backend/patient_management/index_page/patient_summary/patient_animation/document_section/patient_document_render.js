(function () {
    function render(patient) {
        if (!patient.is_recommend) {
            $("#patientAnimationDocumentContainer").html(`
            <div class="alert alert-warning shadow-sm mb-4">
                <i class="fas fa-info-circle mr-2"></i>
                This patient has no doctor recommendation.
            </div>
        `);
            console.log("Patient Response:", patient);
            return;
        }

        let imageHtml = "";
        let pdfHtml = "";

        const documents = (patient.documents || []).filter(
            (doc) => doc.document_type === "recommendation",
        );

        documents.forEach((doc) => {
            const ext = doc.file_path.split(".").pop().toLowerCase();

            if (["jpg", "jpeg", "png", "webp"].includes(ext)) {
                imageHtml += `
                <div class="col-xl-3 col-lg-3 col-md-4 col-6 mb-3">

                    <div class="card border-0 shadow-sm h-100">

                        <img
                            src="${doc.file_path}"
                            class="card-img-top recommendation-preview-image"
                            style="height:200px;object-fit:cover;cursor:pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#imageZoomModal"
                            data-image="${doc.file_path}"
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
            } else {
                pdfHtml += `
                <div class="col-md-6 mb-3">

                    <div class="card shadow-sm border">

                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div>

                                <i class="fas fa-file-pdf fa-2x text-danger mr-3"></i>

                                <strong>${doc.document_name}</strong>

                            </div>

                            <a href="${doc.file_path}"
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

        const html = `YOUR BIG HTML HERE`;

        $("#patientAnimationDocumentContainer").html(html);
    }

    window.PatientDocumentAnimate.render = render;
})();
