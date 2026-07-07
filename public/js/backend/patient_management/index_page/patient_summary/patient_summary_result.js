function renderPatientResults(patients) {
    let html = "";

    $.each(patients, function (i, p) {
        html += `
<div class="card mb-2 shadow-sm">

    <div class="card-body p-2">

        <div class="row align-items-center">

            <div class="col-md-2 text-center">

                <img src="${p.patient_photo}"
                    class="rounded border"
                    style="width:55px;height:55px;object-fit:cover;">

            </div>

            <div class="col-md-8">

                <strong>${p.patient_name}</strong>

                <br>

                <small class="text-muted">

                    ${p.patient_code}

                </small>

                <br>

                <small>

                    ${p.age} Years |
                    ${p.gender} |
                    ${p.phone}

                </small>

            </div>

            <div class="col-md-2 text-right">

                <button
                    class="btn btn-primary btn-sm patient-summary-show"
                    data-patient='${JSON.stringify(p)}'>

                    Show

                </button>

            </div>

        </div>

    </div>

</div>
`;
    });

    $("#patientSearchResult").html(html);
}
