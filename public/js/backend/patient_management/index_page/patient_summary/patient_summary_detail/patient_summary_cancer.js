
/**
 * ==========================================================
 * Patient Summary - Cancer Reports
 * ==========================================================
 */

function loadCancerReports(patient) {
    const photosContainer = $("#viewPatientCancerPhotosContainer");

    photosContainer.empty();

    const reports = patient.cancer_photos || patient.cancerPhotos || [];

    if (!reports.length) {
        photosContainer.html(`

            <div class="col-12">

                <div class="alert alert-light mb-0">

                    <i class="fas fa-folder-open mr-2"></i>

                    No cancer reports found.

                </div>

            </div>

        `);

        return;
    }

    reports.forEach(function (report, index) {
        const totalCancer = report.total_cancer ?? 0;

        const remarks = report.cancer_remarks || "N/A";

        let description = report.xray_description || "N/A";

        if (Array.isArray(description)) {
            description = description.join("<br>");
        }

        const xrayPhotos = report.xray_photo || [];

        let html = `

            <div class="card shadow-sm border mb-4">

                <div class="card-header bg-danger text-white">

                    <strong>

                        <i class="fas fa-ribbon mr-2"></i>

                        Cancer Report #${index + 1}

                    </strong>

                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-3 mb-3">

                            <label class="font-weight-bold">

                                Total Cancer

                            </label>

                            <div class="form-control">

                                ${totalCancer}

                            </div>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="font-weight-bold">

                                Patient Remarks

                            </label>

                            <div
                                class="form-control"
                                style="
                                    min-height:70px;
                                    height:auto;
                                    white-space:pre-wrap;
                                ">

                                ${remarks}

                            </div>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="font-weight-bold">

                                X-Ray Description

                            </label>

                            <div
                                class="form-control"
                                style="
                                    min-height:70px;
                                    height:auto;
                                    white-space:pre-wrap;
                                ">

                                ${description}

                            </div>

                        </div>

                    </div>

        `;

        if (xrayPhotos.length) {
            html += `<div class="row">`;

            xrayPhotos.forEach(function (photo) {
                const fullPath = "/" + photo;

                html += `

                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-3">

                        <div class="card shadow-sm h-100">

                            <a
                                href="#"
                                data-bs-toggle="modal"
                                data-bs-target="#imageZoomModal"
                                data-bs-img-src="${fullPath}">

                                <img
                                    src="${fullPath}"
                                    class="card-img-top img-fluid"
                                    alt="Cancer Image"
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

            html += `</div>`;
        } else {
            html += `

                <div class="alert alert-warning mb-0">

                    No cancer images uploaded.

                </div>

            `;
        }

        html += `

                </div>

            </div>

        `;

        photosContainer.append(html);
    });
}
