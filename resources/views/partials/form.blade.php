<div class="form-group">
    <label>Supplier Name</label>
    <input type="text" name="supplier_name" class="form-control" value="{{ old('supplier_name', $supplier->supplier_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Contact Person</label>
    <input type="text" name="contact_person" class="form-control" value="{{ old('contact_person', $supplier->contact_person ?? '') }}">
</div>

<div class="form-group">
    <label>Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $supplier->email ?? '') }}">
</div>

<div class="form-group">
    <label>Phone</label>
    <input type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone ?? '') }}">
</div>

<div class="form-group">
    <label>Notes</label>
    <textarea name="notes" class="form-control">{{ old('notes', $supplier->notes ?? '') }}</textarea>
</div>

<div class="form-group">
    <label>Score (%)</label>
    <input type="number" name="score" class="form-control" value="{{ old('score', $supplier->score ?? '') }}" min="0" max="100">
</div>

<div class="form-group">
    <label>Compliance Status</label><br>
    <input type="checkbox" name="compliance_status" value="1" {{ old('compliance_status', $supplier->compliance_status ?? false) ? 'checked' : '' }}> Compliant
</div>

<div class="form-group">
    <label>Approval Status</label>
    <select name="approval_status" class="form-control">
        <option value="Pending" {{ old('approval_status', $supplier->approval_status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
        <option value="Approved" {{ old('approval_status', $supplier->approval_status ?? '') == 'Approved' ? 'selected' : '' }}>Approved</option>
        <option value="Rejected" {{ old('approval_status', $supplier->approval_status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
    </select>
</div>

<div class="form-group">
    <label>Proposal Document (PDF only)</label>
    <input type="file" name="proposal_document" class="form-control-file">
    @if(!empty($supplier->proposal_document))
        <br>
        <a href="{{ Storage::url($supplier->proposal_document) }}" target="_blank">View Current Proposal</a>
    @endif
</div>
