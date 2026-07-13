/**
|--------------------------------------------------------------------------
| Patient Document Content
|--------------------------------------------------------------------------
| Load and display patient recommendation documents.
|--------------------------------------------------------------------------
*/

$(document).on("click", ".patient-summary-documents", function (e) {
    e.preventDefault();

    const patientId = $(this).data("id");

    const url = patientDocumentContentsUrl.replace(":id", patientId);

    $("#patientDocumentContentBody").html(`
        <div class="col-12 text-center py-5">

            <div class="spinner-border text-primary mb-3"></div>

            <div class="text-muted">
                Loading patient documents...
            </div>

        </div>
    `);

    $("#documents-tab").tab("show");

    $("#patientDocumentContent").html(`
        <div class="text-center py-5">

            <i class="fas fa-spinner fa-spin fa-2x"></i>

        </div>
        `);

    $.ajax({
        url: url,
        type: "GET",

        success: function (res) {
            const body = $("#patientDocumentContent");

            body.empty();

            if (!res.status || !res.documents.length) {
                body.html(`
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-folder-open fa-2x mb-3"></i>
                        <h5>No Recommendation Documents</h5>
                        <p class="mb-0 text-muted">
                            No uploaded recommendation documents found.
                        </p>
                    </div>
                `);
                return;
            }

            body.append('<div class="row"></div>');

            const row = body.find(".row");

            $.each(res.documents, function (_, doc) {
                let preview = "";
                let footer = "";

                if (doc.is_image) {
                    preview = `
                        <img
                            src="${doc.path}"
                            class="card-img-top patient-document-image-preview"
                            data-image="${doc.path}"
                            style="
                                height:260px;
                                object-fit:cover;
                                cursor:pointer;
                            ">
                    `;

                    footer = `
                        <button
                            class="btn btn-primary btn-sm patient-document-image-preview"
                            data-image="${doc.path}">
                            <i class="fas fa-search-plus mr-1"></i>
                            Preview
                        </button>
                    `;
                } else if (doc.is_pdf) {
                    preview = `
                        <iframe
                            src="${doc.path}"
                            style="
                                width:100%;
                                height:260px;
                                border:0;
                            ">
                        </iframe>
                    `;

                    footer = `
                            <a
                                href="${doc.path}"
                                target="_blank"
                                class="btn btn-danger btn-sm">
                                <i class="fas fa-file-pdf mr-1"></i>
                                Open PDF
                            </a>
                        `;
                } else {
                    preview = `
                        <div
                            class="d-flex align-items-center justify-content-center"
                            style="height:260px;">
                            <i class="fas fa-file fa-5x text-secondary"></i>
                        </div>
                    `;

                    footer = `
                        <a
                            href="${doc.path}"
                            target="_blank"
                            class="btn btn-secondary btn-sm">
                            Download
                        </a>
                    `;
                }

                row.append(`
                    <div class="col-lg-6 col-md-6 mb-4">
                        <div class="card border-0 shadow-sm h-100">
                            ${preview}
                            <div class="card-body">
                                <h6 class="text-truncate mb-0">
                                    ${doc.name}
                                </h6>
                            </div>

                            <div class="card-footer bg-white text-center">
                                ${footer}
                            </div>
                        </div>
                    </div>
                `);
            });
        },

        error: function () {
            $("#patientDocumentContentBody").html(`
                <div class="col-12">

                    <div class="alert alert-danger text-center mb-0">

                        Unable to load patient documents.

                    </div>

                </div>
            `);
        },
    });
});

/*
|--------------------------------------------------------------------------
| Document Image Preview
|--------------------------------------------------------------------------
*/

$(document).on("click", ".patient-document-image-preview", function () {
    const image = $(this).data("image");

    $("#documentOverlayImage").attr("src", image).css("transform", "scale(1)");

    $("#documentImageOverlay").removeClass("d-none").hide().fadeIn(200);
});

/*
|--------------------------------------------------------------------------
| Close Overlay
|--------------------------------------------------------------------------
*/

$(document).on("click", "#closeDocumentImageOverlay", function () {
    $("#documentImageOverlay").fadeOut(200, function () {
        $(this).addClass("d-none");

        $("#documentOverlayImage").attr("src", "");
    });
});

/*
|--------------------------------------------------------------------------
| Click Outside
|--------------------------------------------------------------------------
*/

$("#documentImageOverlay").on("click", function (e) {
    if (e.target.id === "documentImageOverlay") {
        $("#closeDocumentImageOverlay").click();
    }
});

/*
|--------------------------------------------------------------------------
| ESC Key
|--------------------------------------------------------------------------
*/

$(document).keyup(function (e) {
    if (e.key === "Escape") {
        $("#closeDocumentImageOverlay").click();
    }
});

/*
|--------------------------------------------------------------------------
| Image Zoom
|--------------------------------------------------------------------------
*/

let documentZoom = 1;

$(document).on("click", "#documentOverlayImage", function () {
    documentZoom = documentZoom === 1 ? 2 : 1;

    $(this).css("transform", `scale(${documentZoom})`);
});
