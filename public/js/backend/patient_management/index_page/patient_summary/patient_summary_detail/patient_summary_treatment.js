/**Patient Summary - Treatment Section*/
function loadTreatmentSection(patient) {
    const treatmentContainer = $("#viewPatientTreatmentContainer");

    let html = `
        <div class="col-12 mt-4">
            <div class="card border-primary shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-procedures mr-2"></i>
                    Treatment Information
                </div>
                <div class="card-body">
    `;

    if (!patient.is_treatment) {
        html += `
            <div class="alert alert-light mb-0">
                <i class="fas fa-info-circle mr-2"></i>
                No treatment information found.
            </div>
        `;

        html += `
                </div>
            </div>
        </div>
        `;

        treatmentContainer.html(html);
        return;
    }

    const infos = patient.treatment_information || [];
    const images = patient.treatment_images || [];
    const types = patient.treatment_type || [];

    infos.forEach((info, index) => {
        const treatmentType = types[index] || "N/A";

        const treatmentImages = Array.isArray(images[index])
            ? images[index]
            : images[index]
              ? [images[index]]
              : [];

        html += `
            <div class="border rounded p-3 mb-4 bg-light">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="font-weight-bold">Treatment Type</label>
                        <div class="form-control">${treatmentType}</div>
                    </div>

                    <div class="col-md-9 mb-3">
                        <label class="font-weight-bold">
                            Treatment Description
                        </label>

                        <div
                            class="form-control"
                            style="
                                min-height:80px;
                                height:auto;
                                white-space:pre-wrap;
                            ">
                            ${info || "N/A"}
                        </div>
                    </div>
                </div>
        `;

        if (treatmentImages.length > 0) {
            html += `
                <div class="row">
            `;

            treatmentImages.forEach((image) => {
                const fullPath = "/" + image;
                html += `
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-3">
                        <div class="card shadow-sm h-100">
                            <a href="#"
                               data-bs-toggle="modal"
                               data-bs-target="#imageZoomModal"
                               data-bs-img-src="${fullPath}">

                                <img
                                    src="${fullPath}"
                                    class="card-img-top img-fluid"
                                    alt="Treatment Image"
                                    style="
                                        height:180px;
                                        object-fit:cover;
                                        cursor:zoom-in;
                                    ">
                            </a>
                        </div>
                    </div>
                `;
            });

            html += `
                </div>
            `;
        } else {
            html += `
                <div class="alert alert-warning mt-3 mb-0">
                    No treatment images uploaded.
                </div>
            `;
        }

        html += `
            </div>
        `;
    });

    html += `
                </div>
            </div>
        </div>
    `;
    treatmentContainer.html(html);
}
