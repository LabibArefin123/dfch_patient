<div class="form-control mb-3" style="height:auto;">
    {!! $patient->patient_problem_description ?? '-' !!}
</div>
<h6 class="text-muted">Drug Information</h6>
<div class="form-control mb-3" style="height:auto;">
    {!! $patient->patient_drug_description ?? '-' !!}
</div>
<h6 class="text-muted">Remarks</h6>
<div class="form-control mb-3" style="height:auto;">
    {!! $patient->remarks ?? '-' !!}
</div>
