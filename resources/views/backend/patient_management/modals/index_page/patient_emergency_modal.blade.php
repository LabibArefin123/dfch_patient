<div class="modal fade"
    id="patientEmergencyModal"
    tabindex="-1"
    aria-labelledby="patientEmergencyModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered">

        <form id="patientEmergencyForm" class="w-100">

            @csrf

            <input type="hidden" id="selectedPatients">

            <div class="modal-content border-0 shadow">

                {{-- =========================
                    Modal Header
                ========================== --}}
                @include('backend.patient_management.modals.index_page.patient_emergency.part_1_header')

                {{-- =========================
                    Modal Body
                ========================== --}}
                <div class="modal-body">

                    <div class="row g-4">

                        {{-- Left Section --}}
                        @include('backend.patient_management.modals.index_page.patient_emergency.part_2_left_form')

                        {{-- Right Section --}}
                        @include('backend.patient_management.modals.index_page.patient_emergency.part_3_selected_patients')

                    </div>

                </div>

                {{-- =========================
                    Modal Footer
                ========================== --}}
                @include('backend.patient_management.modals.index_page.patient_emergency.part_4_footer')

            </div>

        </form>

    </div>

</div>

{{-- =========================
    Submit Progress Modal
========================== --}}
@include('backend.patient_management.modals.index_page.patient_emergency.part_5_submit_progress_modal')