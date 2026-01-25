@extends('adminlte::page')

@section('title', 'Tender Details')
@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1 class="mb-0">Tender Details</h1>

        @php
            use App\Models\TenderParticipate;
            use App\Models\TenderAwarded;

            $isParticipated = $tender->status == 2;
            $isAwarded = $tender->status == 3;
            $isCompleted = $tender->status == 4;

            $participation = TenderParticipate::where('tender_id', $tender->id)->first();
            $awarded = $participation
                ? TenderAwarded::where('tender_participate_id', $participation->id)->first()
                : null;
        @endphp

        @if ($isParticipated)
            {{-- Tender status: Participated --}}
            <a href="{{ $participation
                ? route('participated_tenders.edit', $participation->id)
                : route('participated_tenders.create', ['tender_id' => $tender->id]) }}"
                class="btn btn-warning btn-sm">
                {{ $participation ? 'Edit Participated' : 'Create Participated' }}
            </a>
        @elseif ($isAwarded)
            {{-- Tender status: Awarded --}}
            @if ($awarded)
                {{-- Awarded exists --}}
                <a href="{{ route('awarded_tenders.edit', $awarded->id) }}" class="btn btn-warning btn-sm">
                    Edit Awarded
                </a>
            @else
                {{-- Awarded missing → revert to participation --}}
                @php
                    // Revert tender status to 2 if awarded is missing
                    $tender->update(['status' => 2]);
                    $isParticipated = true;
                    $isAwarded = false;
                @endphp

                <a href="{{ route('participated_tenders.create', ['tender_id' => $tender->id]) }}"
                    class="btn btn-warning btn-sm">
                    Create Participated
                </a>
            @endif
        @elseif ($isCompleted)
            {{-- Tender status: Completed --}}
            <a href="{{ route('completed_tenders.edit', $tender->id) }}" class="btn btn-warning btn-sm">
                Edit Completed
            </a>
        @else
            {{-- Default to tender edit --}}
            <a href="{{ route('tenders.edit', $tender->id) }}" class="btn btn-warning btn-sm">
                Edit Tender
            </a>
        @endif

    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    {{-- Tender Number --}}
                    <div class="form-group col-md-6">
                        <label class="text">Tender Number</label>
                        <div class="data-box">{{ $tender->tender_no }}</div>
                    </div>

                    {{-- Title --}}
                    <div class="form-group col-md-6">
                        <label class="text">Title</label>
                        <div class="data-box">{{ $tender->title }}</div>
                    </div>

                    {{-- Procuring Authority --}}
                    <div class="form-group col-md-6">
                        <label class="text">Procuring Authority</label>
                        <div class="data-box">{{ $tender->procuring_authority }}</div>
                    </div>

                    {{-- End User --}}
                    <div class="form-group col-md-6">
                        <label class="text">End User</label>
                        <div class="data-box">{{ $tender->end_user }}</div>
                    </div>

                    @php
                        $items = json_decode($tender->items, true) ?? [];
                        $grandTotal = array_sum(
                            array_map(function ($item) {
                                return (float) ($item['total_price'] ?? 0);
                            }, $items),
                        );
                    @endphp

                    <div class="col-md-12 mt-4">
                        <label class="form-label">Item Details</label>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped shadow-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" width="10%">Sl</th>
                                        <th width="40%">Item</th>
                                        <th class="text-center" width="15%">Deno</th>
                                        <th class="text-center" width="10%">Quantity</th>
                                        <th class="text-center" width="15%">Unit Price</th>
                                        <th class="text-center" width="15%">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>{{ $item['item'] ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $item['deno'] ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $item['quantity'] ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $item['unit_price'] ?? 'N/A' }}</td>
                                            <td class="text-center">{{ $item['total_price'] ?? 'N/A' }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No item data found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                                <tfoot>
                                    <tr class="table-light">
                                        <td colspan="5" class="text-end fw-bold">Grand Total (৳)</td>
                                        <td class="fw-bold text-center">{{ number_format($grandTotal, 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    {{-- Publication Date --}}
                    <div class="form-group col-md-6">
                        <label class="text">Publication Date</label>
                        <div class="data-box">
                            {{ \Carbon\Carbon::parse($tender->publication_date)->format('d-F-Y') }}
                        </div>
                    </div>

                    {{-- Submission Date --}}
                    <div class="form-group col-md-6">
                        <label class="text">Submission Date</label>
                        <div class="data-box">
                            {{ \Carbon\Carbon::parse($tender->submission_date)->format('d-F-Y') }}
                        </div>
                    </div>

                    {{-- Submission Time --}}
                    <div class="form-group col-md-6">
                        <label class="text">Submission Time</label>
                        <div class="data-box">{{ $submissionTime }}</div>
                    </div>

                    {{-- Financial Year --}}
                    <div class="form-group col-md-6">
                        <label class="text">Financial Year</label>
                        <div class="data-box">{{ $tender->financial_year }}</div>
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Tender Specification File</strong></label><br>
                        @if (!empty($tender->spec_file))
                            <a class="form-control"
                                href="{{ asset('uploads/documents/spec_files/' . $tender->spec_file) }}"
                                target="_blank">View Attachment</a>
                        @else
                            <p class="text-muted">No attachment uploaded</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label><strong>Tender Notice File</strong></label><br>
                        @if (!empty($tender->notice_file))
                            <a class="form-control"
                                href="{{ asset('uploads/documents/notice_files/' . $tender->notice_file) }}"
                                target="_blank">View Attachment</a>
                        @else
                            <p class="text-muted">No attachment uploaded</p>
                        @endif
                    </div>


                    @if ($isParticipated)
                        {{-- Tender Participated Section --}}
                        <div class="form-group col-md-6">
                            <label>Tender Participated:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check me-4">
                                    <input class="form-check-input" type="radio" name="is_participated"
                                        id="participate_no" value="0"
                                        {{ old('is_participated', $tender->is_participate) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="participate_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_participated"
                                        id="participate_yes" value="1"
                                        {{ old('is_participated', $tender->is_participate) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="participate_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>

                        {{-- Participation Details --}}
                        <div class="form-group col-md-6">
                            <label>Offer No <span class="text-danger">*</span></label>
                            <input type="text" id="offer_no" name="offer_no" class="form-control"
                                value="{{ old('offer_no', $participation->offer_no ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Offered Price <span class="text-danger">*</span></label>
                            <input type="text" id="offered_price" name="offered_price" class="form-control"
                                value="{{ old('offered_price', $participationCompany->offered_price ?? 'N/A') }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Offer Date <span class="text-danger">*</span></label>
                            <input type="text" id="offer_date" name="offer_date" class="form-control"
                                value="{{ old('offer_date', $participation->offer_date ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Offer Validity <span class="text-danger">*</span></label>
                            <input type="text" id="offer_validity" name="offer_validity" class="form-control"
                                value="{{ old('offer_validity', $participation->offer_validity ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="offer_doc">Offer Document <span class="text-danger">*</span></label>
                            @if (!empty($participation?->offer_doc))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/offer_docs/' . $participation->offer_doc) }}"
                                    target="_blank"><i class="fas fa-file-pdf text-danger"></i> View Attachment</a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        {{-- Participants Table --}}
                        <div class="form-group col-md-12 mt-4">
                            <label><strong>Tender's Participants</strong></label>
                            @if ($currentTenderParticipants->isEmpty())
                                <p class="text-muted">No participants found for this tender.</p>
                            @else
                                @foreach ($currentTenderParticipants as $date => $participants)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Company</th>
                                                <th>Offered Price (৳)</th>
                                                <th class="text-center">Position</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($participants->sortBy('offered_price')->values() as $index => $participant)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $participant->company_name ?? 'N/A' }}</td>
                                                    <td>{{ number_format($participant->offered_price ?? 0, 2) }}</td>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            @endif
                        </div>

                        {{-- BG Section --}}
                        <div class="form-group col-md-6">
                            <label>Is Bid Guarantee (BG)?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check me-4">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_no"
                                        value="0"
                                        {{ old('is_bg', $participation->is_bg ?? 0) == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="bg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_yes"
                                        value="1"
                                        {{ old('is_bg', $participation->is_bg ?? 0) == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="bg_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label for="bg_no">BG Number</label>
                            <input type="text" name="bg_no" class="form-control"
                                value="{{ old('bg_no', $bg->bg_no ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank</label>
                            <input type="text" name="issue_in_bank" class="form-control"
                                value="{{ old('issue_in_bank', $bg->issue_in_bank ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch</label>
                            <input type="text" name="issue_in_branch" class="form-control"
                                value="{{ old('issue_in_branch', $bg->issue_in_branch ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_date">BG Issue Date</label>
                            <input type="text" class="form-control"
                                value="{{ old('issue_date', $bg->issue_date ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">BG Expiry Date</label>
                            <input type="text" class="form-control"
                                value="{{ old('expiry_date', $bg->expiry_date ?? 'N/A') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount">BG Amount</label>
                            <input type="number" name="amount" class="form-control"
                                value="{{ old('amount', $bg->amount ?? '0') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>BG Attachment</label><br>
                            @if (!empty($bg?->attachment))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/bg_attachments/' . $bg->attachment) }}"
                                    target="_blank"><i class="fas fa-file-pdf text-danger"></i> View Attachment</a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        <div class="w-100"></div>

                        {{-- Correspondence --}}
                        <div class="form-group col-md-12">
                            <strong>Participated Tender Correspondence</strong>
                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($participateLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no ?? 'N/A' }}</td>
                                            <td>{{ $letter->remarks ?? 'N/A' }}</td>
                                            <td>{{ $letter->value ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') ?? 'N/A' }}
                                            </td>
                                            <td class="text-center">
                                                @if (!empty($letter->document))
                                                    <a href="{{ asset('uploads/documents/tender_letters/participate/' . $letter->document) }}"
                                                        target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-file-pdf"></i> View
                                                    </a>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No letters uploaded yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if ($isAwarded)
                        <div style="width: 100%; height: 2px; background-color: #ddd; margin: 20px 0;"></div>
                        <div class="form-group col-md-12 mt-4">
                            <label><strong>Tender's Participants</strong></label>

                            @if ($currentTenderParticipants->isEmpty())
                                <p class="text-muted">No participants found for this tender.</p>
                            @else
                                @foreach ($currentTenderParticipants as $date => $participants)
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Company</th>
                                                <th>Offered Price (৳)</th>
                                                <th class="text-center">Position</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($participants->sortBy('offered_price')->values() as $index => $participant)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $participant->company_name }}</td>
                                                    <td>{{ number_format($participant->offered_price, 2) }}</td>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label>Tender Participated:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_participated"
                                        id="participate_no" value="0"
                                        {{ old('is_participated', $tender->is_participate) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="participate_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_participated"
                                        id="participate_yes" value="1"
                                        {{ old('is_participated', $tender->is_participate) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="participate_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label>Offer No <span class="text-danger">*</span></label>
                            <input type="text" id="offer_no" name="offer_no" class="form-control"
                                value="{{ old('offer_no', $participation->offer_no ?? '') }}" readonly>

                            @error('offer_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Offered Price <span class="text-danger">*</span></label>
                            <input type="text" id="offered_price" name="offered_price" class="form-control"
                                value="{{ old('offered_price', $participationCompany->offered_price ?? '') }}" readonly>

                            @error('offered_price')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Offer Date <span class="text-danger">*</span></label>
                            <input type="text" id="offer_date" name="offer_date" class="form-control"
                                value="{{ old('offer_date', $participation->offer_date ?? '') }}" readonly>

                            @error('offer_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Offer Validity <span class="text-danger">*</span></label>
                            <input type="text" id="offer_validity" name="offer_validity" class="form-control"
                                value="{{ old('offer_validity', $participation->offer_validity ?? '') }}" readonly>

                            @error('offer_validity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="offer_doc">Offer Document <span class="text-danger">*</span></label>

                            @if (!empty($participation->offer_doc))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/offer_doc/' . $participation->offer_doc) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>
                        <div class="form-group col-md-12">

                            <strong>Participated Tender Correspondence</strong>

                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($participateLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('uploads/documents/tender_letters/participate/' . $letter->document) }}"
                                                    target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No letters
                                                uploaded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- Tender Awarded --}}

                        <div style="width: 100%; height: 2px; background-color: #ddd; margin: 20px 0;"></div>

                        <div class="form-group col-md-6">
                            <label>Tender Awarded:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_awarded" id="awarded_no"
                                        value="0" {{ old('is_awarded', $tender->is_awarded) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="awarded_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_awarded" id="awarded_yes"
                                        value="1" {{ old('is_awarded', $tender->is_awarded) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="awarded_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>
                        {{-- Work Order --}}

                        <div class="form-group col-md-6">
                            <label for="workorder_no">Work Order No/NOA No</label>
                            <input type="text" name="workorder_no" class="form-control"
                                value="{{ old('workorder_no', optional($tenderAwarded)->workorder_no ?? '-') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">Work Order No/NOA Date</label>
                            <input type="text" class="form-control"
                                value="{{ !empty($tenderAwarded->workorder_date)
                                    ? \Carbon\Carbon::parse($tenderAwarded->workorder_date)->format('d F Y')
                                    : '-' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="offer_doc">Work Order No/NOA Doc <span class="text-danger">*</span></label>
                            @if (!empty($tenderAwarded->workorder_doc))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/workorder_docs/' . $tenderAwarded->workorder_doc) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        <div class="w-100"></div>

                        {{-- BG Section --}}
                        <div class="form-group col-md-6">
                            <label>Is Bid Guarantee (BG)?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_no"
                                        value="0"
                                        {{ old('is_bg', optional($participation)->is_bg ?? 0) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="bg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_bg" id="bg_yes"
                                        value="1"
                                        {{ old('is_bg', optional($participation)->is_bg ?? 0) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="bg_yes">Yes</label>
                                </div>
                            </div>
                        </div>


                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label for="bg_no">BG Number</label>
                            <input type="text" name="bg_no" class="form-control"
                                value="{{ old('bg_no', $bg['bg_no'] ?? '') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank</label>
                            <input type="text" name="issue_in_bank" class="form-control"
                                value="{{ old('issue_in_bank', $bg['issue_in_bank'] ?? '') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch</label>
                            <input type="text" name="issue_in_branch" class="form-control"
                                value="{{ old('issue_in_branch', $bg['issue_in_branch'] ?? '') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_date">BG Issue Date</label>
                            <input type="text" class="form-control"
                                value="{{ !empty($bg['issue_date']) ? \Carbon\Carbon::parse($bg['issue_date'])->format('d F Y') : '-' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">BG Expiry Date</label>
                            <input type="text" class="form-control"
                                value="{{ !empty($bg['expiry_date']) ? \Carbon\Carbon::parse($bg['expiry_date'])->format('d F Y') : '-' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount">BG Amount</label>
                            <input type="number" name="amount" class="form-control"
                                value="{{ old('amount', $bg['amount'] ?? '') }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>BG Attachment</label><br>
                            @if (!empty($bg['attachment']))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/bg_attachments/' . $bg['attachment']) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        <div class="w-100"></div>

                        {{-- Delivery Date & Type --}}
                        <div class="form-group col-md-6">
                            <label for="awarded_date">Delivery Date</label>
                            <input type="text" name="awarded_date" class="form-control"
                                value="{{ !empty($tenderAwarded->awarded_date)
                                    ? \Carbon\Carbon::parse($tenderAwarded->awarded_date)->format('d F Y')
                                    : '-' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="delivery_type">Delivery Type</label>
                            <select name="delivery_type" id="delivery_type" class="form-control" disabled>
                                <option value="">-- Select --</option>
                                <option value="1"
                                    {{ old('delivery_type', $tenderAwarded->delivery_type ?? '') == '1' ? 'selected' : '' }}>
                                    Single</option>
                                <option value="partial"
                                    {{ old('delivery_type', $tenderAwarded->delivery_type ?? '') == 'partial' ? 'selected' : '' }}>
                                    Multiple</option>
                            </select>
                        </div>

                        @php
                            $warranties = [
                                '7 days',
                                '30 days',
                                '45 days',
                                '60 days',
                                '90 days',
                                '6 months',
                                '12 months',
                                '2 years',
                                '3 years',
                            ];
                            $deliveryType = old('delivery_type', $tenderAwarded->delivery_type ?? '');
                        @endphp

                        {{-- Single Delivery --}}
                        @if ($deliveryType == '1')
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Single)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ old('deliveries.0.delivery_item', $singleDelivery->delivery_item ?? '-') }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ !empty($singleDelivery->delivery_date)
                                                        ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('d F Y')
                                                        : '-' }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                @php $selectedWarranty = old('deliveries.0.warranty', $singleDelivery->warranty ?? ''); @endphp
                                                <select class="form-control" disabled>
                                                    <option value="">-- Select --</option>
                                                    @foreach ($warranties as $warranty)
                                                        <option value="{{ $warranty }}"
                                                            {{ $selectedWarranty == $warranty ? 'selected' : '' }}>
                                                            {{ $warranty }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- Partial Delivery --}}
                        @if ($deliveryType == 'partial')
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Multiple)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (old('deliveries', $partialDeliveries->toArray() ?? []) as $index => $delivery)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ $delivery['delivery_item'] ?? '-' }}" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        value="{{ !empty($delivery['delivery_date'])
                                                            ? \Carbon\Carbon::parse($delivery['delivery_date'])->format('d F Y')
                                                            : '-' }}"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <select class="form-control" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach ($warranties as $warranty)
                                                            <option value="{{ $warranty }}"
                                                                {{ ($delivery['warranty'] ?? '') == $warranty ? 'selected' : '' }}>
                                                                {{ $warranty }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- PG Section --}}
                        <div class="form-group col-md-6">
                            <label>Is Performance Guarantee (PG)?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_no"
                                        value="0"
                                        {{ old('is_pg', optional($tenderAwarded)->is_pg ?? 0) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_yes"
                                        value="1"
                                        {{ old('is_pg', optional($tenderAwarded)->is_pg ?? 0) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label for="pg_no">PG Number</label>
                            <input type="text" class="form-control"
                                value="{{ old('pg_no', optional(optional($tenderAwarded)->pg)->pg_no ?? '-') }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank</label>
                            <input type="text" class="form-control"
                                value="{{ old('issue_in_bank', optional(optional($tenderAwarded)->pg)->issue_in_bank ?? '-') }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch</label>
                            <input type="text" class="form-control"
                                value="{{ old('issue_in_branch', optional(optional($tenderAwarded)->pg)->issue_in_branch ?? '-') }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_date">PG Issue Date</label>
                            <input type="text" class="form-control"
                                value="{{ !empty(optional(optional($tenderAwarded)->pg)->issue_date)
                                    ? \Carbon\Carbon::parse(optional($tenderAwarded->pg)->issue_date)->format('d F Y')
                                    : '-' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">PG Expiry Date</label>
                            <input type="text" class="form-control"
                                value="{{ !empty(optional(optional($tenderAwarded)->pg)->expiry_date)
                                    ? \Carbon\Carbon::parse(optional($tenderAwarded->pg)->expiry_date)->format('d F Y')
                                    : '-' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount">PG Amount</label>
                            <input type="number" class="form-control"
                                value="{{ old('amount', optional(optional($tenderAwarded)->pg)->amount ?? '-') }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>PG Attachment</label><br>
                            @if (!empty(optional(optional($tenderAwarded)->pg)->attachment))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/pg_attachments/' . optional($tenderAwarded->pg)->attachment) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        <div class="form-group col-md-12">
                            <strong>Awarded Tender Correspondence</strong>

                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($awardedLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('uploads/documents/tender_letters/awarded/' . $letter->document) }}"
                                                    target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No letters
                                                uploaded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @endif
                    @if ($isCompleted)
                        <div class="form-group col-md-12">
                            <div class="form-group col-md-6">
                                <label>Tender Participated:</label>
                                <div class="d-flex gap-3 align-items-center mt-1">
                                    <div class="form-check" style="margin-right: 25px;">
                                        <input class="form-check-input" type="radio" name="is_participated"
                                            id="participate_no" value="0"
                                            {{ old('is_participated', $tender->is_participate) == 0 ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="participate_no">No</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_participated"
                                            id="participate_yes" value="1"
                                            {{ old('is_participated', $tender->is_participate) == 1 ? 'checked' : '' }}
                                            disabled>
                                        <label class="form-check-label" for="participate_yes">Yes</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Offer No <span class="text-danger">*</span></label>
                                    <input type="text" id="offer_no" name="offer_no" class="form-control"
                                        value="{{ old('offer_no', $participation->offer_no ?? '') }}" readonly>

                                    @error('offer_no')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Offered Price <span class="text-danger">*</span></label>
                                    <input type="text" id="offered_price" name="offered_price" class="form-control"
                                        value="{{ old('offered_price', $participationCompany->offered_price ?? '') }}"
                                        readonly>

                                    @error('offered_price')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Offer Date <span class="text-danger">*</span></label>
                                    <input type="text" id="offer_date" name="offer_date" class="form-control"
                                        value="{{ old('offer_date', $participation->offer_date ?? '') }}" readonly>

                                    @error('offer_date')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Offer Validity <span class="text-danger">*</span></label>
                                    <input type="text" id="offer_validity" name="offer_validity" class="form-control"
                                        value="{{ old('offer_validity', $participation->offer_validity ?? '') }}"
                                        readonly>

                                    @error('offer_validity')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="offer_doc">Offer Document <span class="text-danger">*</span></label>

                                    @if (!empty($participation->offer_doc))
                                        <a class="form-control"
                                            href="{{ asset('uploads/documents/offer_doc/' . $participation->offer_doc) }}"
                                            target="_blank">
                                            <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                        </a>
                                    @else
                                        <span class="text-muted">No attachment available</span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group col-md-12 mt-4">
                                <label><strong>Tender's Participants</strong></label>

                                @if ($currentTenderParticipants->isEmpty())
                                    <p class="text-muted">No participants found for this tender.</p>
                                @else
                                    @foreach ($currentTenderParticipants as $date => $participants)
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Sl</th>
                                                    <th>Company</th>
                                                    <th>Offered Price (৳)</th>
                                                    <th class="text-center">Position</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($participants->sortBy('offered_price')->values() as $index => $participant)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $participant->company_name }}</td>
                                                        <td>{{ number_format($participant->offered_price, 2) }}</td>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                @endif
                            </div>

                            <strong>Participated Tender Correspondence</strong>

                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($participateLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('uploads/documents/tender_letters/participate/' . $letter->document) }}"
                                                    target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No letters
                                                uploaded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Tender Awarded:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_awarded" id="awarded_no"
                                        value="0" {{ old('is_awarded', $tender->is_awarded) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="awarded_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_awarded" id="awarded_yes"
                                        value="1" {{ old('is_awarded', $tender->is_awarded) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="awarded_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label for="workorder_no">Work Order No/NOA No</label>
                            <input type="text" class="form-control" value="{{ $tenderAwarded->workorder_no }}"
                                readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="workorder_date">Work Order Date/NOA Date</label>
                            <input type="date" class="form-control" value="{{ $tenderAwarded->workorder_date }}"
                                readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="offer_doc">Work Order Date/NOA Doc<span class="text-danger">*</span></label>

                            @if (!empty($tenderAwarded->workorder_doc))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/workorder_docs/' . $tenderAwarded->workorder_doc) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>
                        {{-- BG Section --}}

                        <div class="w-100"></div>
                        {{-- Delivery Date & Type --}}
                        <div class="form-group col-md-6">
                            <label>Delivery Date</label>
                            <input type="text" class="form-control"
                                value="{{ $tenderAwarded->awarded_date ? \Carbon\Carbon::parse($tenderAwarded->awarded_date)->format('d F Y') : '' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Delivery Type</label>
                            <select class="form-control" disabled>
                                <option value="">-- Select --</option>
                                <option value="1" {{ $tenderAwarded->delivery_type == '1' ? 'selected' : '' }}>
                                    Single</option>
                                <option value="partial"
                                    {{ $tenderAwarded->delivery_type == 'partial' ? 'selected' : '' }}>Multiple
                                </option>
                            </select>
                        </div>

                        {{-- Single Delivery --}}
                        @if ($tenderAwarded->delivery_type == '1' && $singleDelivery)
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Single)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $singleDelivery->delivery_item }}" readonly>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control"
                                                    value="{{ $singleDelivery->delivery_date ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('d F Y') : '' }}"
                                                    readonly>
                                            </td>
                                            <td>
                                                <select class="form-control" disabled>
                                                    <option value="">-- Select --</option>
                                                    @foreach (['7 days', '30 days', '45 days', '60 days', '90 days', '6 months', '12 months', '2 years', '3 years'] as $warranty)
                                                        <option value="{{ $warranty }}"
                                                            {{ $singleDelivery->warranty == $warranty ? 'selected' : '' }}>
                                                            {{ $warranty }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        @endif

                        {{-- Partial Deliveries --}}
                        @if ($tenderAwarded->delivery_type == 'partial' && $partialDeliveries)
                            <div class="form-group col-md-12">
                                <h5 class="mt-4">Delivery Information (Multiple)</h5>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Delivery Item</th>
                                            <th>Delivery Date</th>
                                            <th>Warranty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($partialDeliveries as $delivery)
                                            <tr>
                                                <td><input type="text" class="form-control"
                                                        value="{{ $delivery->delivery_item }}" readonly></td>
                                                <td><input type="date" class="form-control"
                                                        value="{{ $delivery->delivery_date }}" readonly></td>
                                                <td>
                                                    <select class="form-control" disabled>
                                                        <option value="">-- Select --</option>
                                                        @foreach (['7 days', '30 days', '45 days', '60 days', '90 days', '6 months', '12 months', '2 years', '3 years'] as $warranty)
                                                            <option value="{{ $warranty }}"
                                                                {{ $delivery->warranty == $warranty ? 'selected' : '' }}>
                                                                {{ $warranty }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        <div class="form-group col-md-12">
                            <strong>Awarded Tender Correspondence</strong>

                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($awardedLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('uploads/documents/tender_letters/awarded/' . $letter->document) }}"
                                                    target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No letters
                                                uploaded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group col-md-12">
                            <strong>Progress Tenders Correspondence</strong>

                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($progressLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('uploads/documents/tender_letters/progress/' . $letter->document) }}"
                                                    target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No letters
                                                uploaded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Bid Guarantee (BG) ?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $participation->is_bg == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $participation->is_bg == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label for="bg_no">BG Number</label>
                            <input type="text" class="form-control" value="{{ $bg->bg_no ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank</label>
                            <input type="text" class="form-control" value="{{ $bg->issue_in_bank ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch</label>
                            <input type="text" class="form-control" value="{{ $bg->issue_in_branch ?? '' }}"
                                readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">BG Expiry Date</label>
                            <input type="text" class="form-control" value="{{ $bg->issue_date ?? '-' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">BG Expiry Date</label>
                            <input type="text" class="form-control" value="{{ $bg->expiry_date ?? '-' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount">BG Amount</label>
                            <input type="text" class="form-control" value="{{ $bg->amount ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>BG Attachment</label><br>
                            @if (!empty($bg->attachment))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/bg_attachments/' . $bg->attachment) }}"
                                    target="_blank">
                                    View Attachment
                                </a>
                            @else
                                <span class="form-control text-muted bg-light">No attachment available</span>
                            @endif
                        </div>
                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label>Is Delivery?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_delivered == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_delivered == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Challan No <span class="text-danger">*</span></label>
                            <input type="text" id="challan_no" name="challan_no" class="form-control"
                                value="{{ $completeTenders->tenderProgress->challan_no ?? '' }}" readonly>

                            @error('challan_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Challan Date <span class="text-danger">*</span></label>
                            <input type="text" id="challan_date" name="challan_date" class="form-control"
                                value="{{ $completeTenders->tenderProgress->challan_date ? \Carbon\Carbon::parse($completeTenders->tenderProgress->challan_date)->format('d F Y') : '' }}"
                                readonly>

                            @error('offer_validity')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="challan_doc">Challan Document <span class="text-danger">*</span></label>

                            @if (!empty($completeTenders->tenderProgress->challan_doc))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/challan_docs/' . $completeTenders->tenderProgress->challan_doc) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>
                        <div class="w-100"></div>

                        <div class="form-group col-md-6">
                            <label>Is Inspection Completed?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_inspection_completed == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_inspection_completed == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Inspection Complete Date <span class="text-danger">*</span></label>
                            <input type="text" id="inspection_complete_date" name="inspection_complete_date"
                                class="form-control"
                                value="{{ $completeTenders->tenderProgress->inspection_complete_date ? \Carbon\Carbon::parse($completeTenders->tenderProgress->inspection_complete_date)->format('d F Y') : '' }}"
                                readonly>

                            @error('inspection_complete_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Inspection Accepted?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_inspection_accepted == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_inspection_accepted == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Inspection Accept Date <span class="text-danger">*</span></label>
                            <input type="text" id="inspection_accept_date" name="inspection_accept_date"
                                class="form-control"
                                value="{{ $completeTenders->tenderProgress->inspection_accept_date ? \Carbon\Carbon::parse($completeTenders->tenderProgress->inspection_accept_date)->format('d F Y') : '' }}"
                                readonly>

                            @error('inspection_accept_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Bill Submitted?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_bill_submitted == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_bill_submitted == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Bill No <span class="text-danger">*</span></label>
                            <input type="text" id="bill_no" name="bill_no" class="form-control"
                                value="{{ $completeTenders->tenderProgress->bill_no ?? '' }}" readonly>

                            @error('bill_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Bill Submit Date <span class="text-danger">*</span></label>
                            <input type="text" id="bill_submit_date" name="bill_submit_date" class="form-control"
                                value="{{ $completeTenders->tenderProgress->bill_submit_date ? \Carbon\Carbon::parse($completeTenders->tenderProgress->bill_submit_date)->format('d F Y') : '' }}"
                                readonly>

                            @error('bill_submit_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="bill_doc">Bill Document <span class="text-danger">*</span></label>

                            @if (!empty($completeTenders->tenderProgress->bill_doc))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/bill_docs/' . $completeTenders->tenderProgress->bill_doc) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Is Bill Received?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_bill_received == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        {{ $completeTenders->tenderProgress->is_bill_received == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Bill Cheque No <span class="text-danger">*</span></label>
                            <input type="text" id="bill_cheque_no" name="bill_cheque_no" class="form-control"
                                value="{{ $completeTenders->tenderProgress->bill_cheque_no ?? '' }}" readonly>

                            @error('bill_cheque_no')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Bill Receive Date <span class="text-danger">*</span></label>
                            <input type="text" id="bill_receive_date" name="bill_receive_date" class="form-control"
                                value="{{ $completeTenders->tenderProgress->bill_receive_date ? \Carbon\Carbon::parse($completeTenders->tenderProgress->bill_receive_date)->format('d F Y') : '' }}"
                                readonly>

                            @error('bill_receive_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Bill Amount <span class="text-danger">*</span></label>
                            <input type="text" id="bill_amount" name="bill_amount" class="form-control"
                                value="{{ $completeTenders->tenderProgress->bill_amount ?? '' }}" readonly>

                            @error('bill_amount')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Bank Name <span class="text-danger">*</span></label>
                            <input type="text" id="bill_amount" name="bill_bank_name" class="form-control"
                                value="{{ $completeTenders->tenderProgress->bill_bank_name ?? '' }}" readonly>

                            @error('bill_bank_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Performance Guarentee (PG) ?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_no"
                                        value="0" {{ old('is_pg', $tenderAwarded->is_pg) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_pg" id="pg_yes"
                                        value="1" {{ old('is_pg', $tenderAwarded->is_pg) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="pg_yes">Yes</label>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label for="pg_no">PG Number</label>
                            <input type="text" name="pg_no" class="form-control"
                                value="{{ $tenderAwarded->pg->pg_no ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_bank">Issue in Bank</label>
                            <input type="text" name="issue_in_bank" class="form-control"
                                value="{{ $tenderAwarded->pg->issue_in_bank ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_in_branch">Issue in Branch</label>
                            <input type="text" name="issue_in_branch" class="form-control"
                                value="{{ $tenderAwarded->pg->issue_in_branch ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="issue_date">PG Issue Date</label>
                            <input type="text" name="issue_date" class="form-control"
                                value="{{ $tenderAwarded->pg->issue_date ?? '-' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="expiry_date">PG Expiry Date</label>
                            <input type="text" name="expiry_date" class="form-control"
                                value="{{ $tenderAwarded->pg->expiry_date ?? '-' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="amount">PG Amount</label>
                            <input type="number" name="amount" class="form-control"
                                value="{{ $tenderAwarded->pg->amount ?? '' }}" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label>PG Attachment</label><br>
                            @if (!empty($tenderAwarded->pg->attachment))
                                <a class="form-control"
                                    href="{{ asset('uploads/documents/pg_attachments/' . $tenderAwarded->pg->attachment) }}"
                                    target="_blank">
                                    <i class="fas fa-file-pdf text-danger"></i> View Attachment
                                </a>
                            @else
                                <span class="text-muted">No attachment available</span>
                            @endif
                        </div>

                        <div class="w-100"></div>

                        {{-- Tender Completed --}}
                        <div class="form-group col-md-6">
                            <label>Tender Completed:</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_completed" id="completed_no"
                                        value="0"
                                        {{ old('is_completed', $tender->is_completed) == 0 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="completed_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_completed"
                                        id="completed_yes" value="1"
                                        {{ old('is_completed', $tender->is_completed) == 1 ? 'checked' : '' }} disabled>
                                    <label class="form-check-label" for="completed_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="w-100"></div>
                        <div class="form-group col-md-6">
                            <label>Is Warranty Complete?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_warranty_complete"
                                        id="is_warranty_complete_no" value="0"
                                        {{ old('is_warranty_complete', $completeTenders->is_warranty_complete) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="is_warranty_complete_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_warranty_complete"
                                        id="is_warranty_complete_yes" value="1"
                                        {{ old('is_warranty_complete', $completeTenders->is_warranty_complete) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="is_warranty_complete_yes">Yes</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group col-md-6">
                            <label>Warranty Date <span class="text-danger">*</span></label>
                            <input type="text" id="warranty_complete_date" name="warranty_complete_date"
                                class="form-control"
                                value="{{ $completeTenders->warranty_complete_date ? \Carbon\Carbon::parse($completeTenders->warranty_complete_date)->format('d F Y') : '' }}"
                                readonly>

                            @error('warranty_complete_date')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label>Is Service Warranty?</label>
                            <div class="d-flex gap-3 align-items-center mt-1">
                                <div class="form-check" style="margin-right: 25px;">
                                    <input class="form-check-input" type="radio" name="is_service_warranty"
                                        id="is_warranty_service_no" value="0"
                                        {{ old('is_service_warranty', $completeTenders->is_service_warranty) == 0 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="is_warranty_service_no">No</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_service_warranty"
                                        id="is_warranty_service_yes" value="1"
                                        {{ old('is_service_warranty', $completeTenders->is_service_warranty) == 1 ? 'checked' : '' }}
                                        disabled>
                                    <label class="form-check-label" for="is_warranty_service_yes">Yes</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label>Service Warranty Duration <span class="text-danger">*</span></label>
                            <input type="text" id="service_warranty_duration" name="service_warranty_duration"
                                class="form-control" value="{{ $completeTenders->service_warranty_duration ?? '' }}"
                                readonly>

                            @error('service_warranty_duration')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="w-100"></div>


                        <div class="form-group col-md-12">
                            <strong>Completed Tender Correspondence</strong>

                            <table class="table table-striped table-hover table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 60px;">SL</th>
                                        <th>Ref No</th>
                                        <th>Remarks</th>
                                        <th>Value</th>
                                        <th class="text-center" style="width: 140px;">Date</th>
                                        <th class="text-center">PDF</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($completeLetters as $key => $letter)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $letter->reference_no }}</td>
                                            <td>{{ $letter->remarks }}</td>
                                            <td>{{ $letter->value }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($letter->date)->format('d M, Y') }}
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ asset('uploads/documents/tender_letters/completed/' . $letter->document) }}"
                                                    target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-file-pdf"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">No letters
                                                uploaded yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mt-4" style="height:50px;"></div>

@endsection

@section('css')
    <style>
        .data-box {
            background-color: #f1f1f1;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: 500;
            min-height: 45px;
            display: flex;
            align-items: center;

        }
    </style>
@endsection
