<!-- =========================================================
     PATIENT LOST DATA NOTIFICATION
========================================================= -->

<div id="patientLostDataNotification" class="patient-lost-data-notification" style="display: none;">
    <div class="patient-lost-data-icon">
        <i class="fas fa-bolt"></i>
    </div>

    <div class="patient-lost-data-content">

        <div class="patient-lost-data-title">
            Lost Patient Data
        </div>

        <div class="patient-lost-data-message">
            You have
            <strong id="lostPatientDataCount">1</strong>
            unfinished patient data record
            due to an unexpected interruption.
        </div>

        <div class="patient-lost-data-actions">

            <button type="button" id="recoverPatientDataBtn" class="btn btn-success btn-sm">
                <i class="fas fa-history mr-1"></i>
                Yes, Restore
            </button>

            <button type="button" id="discardPatientDataBtn" class="btn btn-outline-secondary btn-sm">
                No
            </button>

        </div>

    </div>

    <button type="button" id="closePatientLostDataNotification" class="patient-lost-data-close">
        &times;
    </button>
</div>
