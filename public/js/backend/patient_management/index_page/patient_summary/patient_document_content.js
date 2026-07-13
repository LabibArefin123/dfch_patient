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

    $("#patientDocumentContentModal").modal("show");

    $.ajax({
        url: url,
        type: "GET",

        success: function (res) {
            const body = $("#patientDocumentContentBody");

            body.empty();

            if (!res.status || res.documents.length === 0) {
                body.html(`
                    <div class="col-12">

                        <div class="alert alert-warning text-center mb-0">

                            <i class="fas fa-folder-open mr-2"></i>

                            No recommendation documents found.

                        </div>

                    </div>
                `);

                return;
            }

            $.each(res.documents, function (index, doc) {
                let preview = "";

                if (doc.is_image) {
                    preview = `
                        <img
                            src="${doc.path}"
                            class="card-img-top"
                            style="
                                height:220px;
                                object-fit:cover;
                            ">
                    `;
                } else if (doc.is_pdf) {
                    preview = `
                        <iframe
                            src="${doc.path}"
                            style="
                                width:100%;
                                height:220px;
                                border:0;
                            ">
                        </iframe>
                    `;
                } else {
                    preview = `
                        <div
                            class="d-flex
                                   align-items-center
                                   justify-content-center"
                            style="height:220px;">

                            <i class="fas fa-file fa-5x text-secondary"></i>

                        </div>
                    `;
                }

                body.append(`
                    <div class="col-lg-4 col-md-6 mb-4">

                        <div class="card shadow-sm h-100">

                            ${preview}

                            <div class="card-body">

                                <h6
                                    class="card-title text-truncate"
                                    title="${doc.name}">

                                    ${doc.name}

                                </h6>

                            </div>

                            <div class="card-footer bg-white text-center">

                                <a
                                    href="${doc.path}"
                                    target="_blank"
                                    class="btn btn-primary btn-sm">

                                    <i class="fas fa-eye mr-1"></i>

                                    View

                                </a>

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
