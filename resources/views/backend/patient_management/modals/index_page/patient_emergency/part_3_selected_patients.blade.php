<!-- ==========================================
     Right Panel
     - Selected Patients
========================================== -->
<div class="col-lg-5">

    <div class="card border-danger shadow-sm h-100">

        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">

            <div>

                <i class="fas fa-users me-2"></i>

                Selected Patients

            </div>

            <span id="selectedPatientBadge" class="badge bg-light text-danger">

                0

            </span>

        </div>

        <div class="card-body d-flex flex-column">

            <!-- Total Selected -->
            <div class="alert alert-light border">

                <strong id="selectedPatientCount">

                    0

                </strong>

                patient(s) selected

            </div>

            <!-- Patient List -->
            <div id="selectedPatientList" class="border rounded bg-light flex-grow-1 p-2"
                style="min-height:320px; max-height:420px; overflow-y:auto;">

                <div class="text-center text-muted pt-5">

                    <i class="fas fa-user-slash fa-3x mb-3"></i>

                    <p class="mb-0">

                        No patients selected.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>
