/**
 * ==========================================================
 * Patient Summary - Referred Documents
 * ==========================================================
 */

function loadPatientDocuments(patient) {
    const docsContainer = $("#viewPatientDocsContainer");

    docsContainer.empty();

    const docs = patient.documents || [];

    if (!docs.length) {
        docsContainer.html(`

            <div class="col-12">

                <div class="alert alert-light mb-0">

                    <i class="fas fa-folder-open mr-2"></i>

                    No referred documents uploaded.

                </div>

            </div>

        `);

        return;
    }

    docs.forEach(function (doc) {
        const fileName = doc.document_name || "Document";

        const filePath = "/" + doc.file_path;

        const extension = filePath.split(".").pop().toLowerCase();

        const isImage = ["jpg", "jpeg", "png", "webp", "gif"].includes(
            extension,
        );

        if (isImage) {
            docsContainer.append(`

                <div class="col-lg-4 col-md-4 col-sm-6 mb-4">

                    <div class="card shadow-sm border h-100">

                        <img
                            src="${filePath}"
                            class="card-img-top"
                            alt="${fileName}"
                            style="
                                height:220px;
                                object-fit:contain;
                            ">

                        <div class="card-body text-center">

                            <h6
                                class="text-truncate mb-3"
                                title="${fileName}">

                                ${fileName}

                            </h6>

                            <button
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#imageZoomModal"
                                data-bs-img-src="${filePath}">

                                <i class="fas fa-search-plus mr-1"></i>

                                View Image

                            </button>

                        </div>

                    </div>

                </div>

            `);
        } else {
            docsContainer.append(`

                <div class="col-lg-6 mb-3">

                    <div class="card shadow-sm border h-100">

                        <div class="card-body d-flex justify-content-between align-items-center">

                            <div
                                class="text-truncate mr-3"
                                style="max-width:70%;">

                                <i class="fas fa-file-pdf text-danger mr-2"></i>

                                <span
                                    title="${fileName}"
                                    style="font-size:14px;">

                                    ${fileName}

                                </span>

                            </div>

                            <a
                                href="${filePath}"
                                target="_blank"
                                class="btn btn-success btn-sm">

                                <i class="fas fa-eye mr-1"></i>

                                View PDF

                            </a>

                        </div>

                    </div>

                </div>

            `);
        }
    });
}
