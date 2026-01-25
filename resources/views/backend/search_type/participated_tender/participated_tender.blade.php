 <div class="form-group col-md-6">
     <label>Tender No</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender->tender_no }}">
 </div>

 <div class="form-group col-md-6">
     <label>Tender Title</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender->title }}">
 </div>

 <div class="form-group col-md-6">
     <label>Procuring Authority</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender->procuring_authority }}">
 </div>

 <div class="form-group col-md-6">
     <label>End User</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender->end_user }}">
 </div>

 <div class="form-group col-md-6">
     <label for="expiry_date">Publication Date </label>
     <input type="text" class="form-control"
         value="{{ $data->tender->publication_date ? \Carbon\Carbon::parse($data->tender->publication_date)->format('d F Y') : '' }}"
         readonly>
 </div>

 <div class="form-group col-md-6">
     <label for="expiry_date">Submission Date</label>
     <input type="text" class="form-control"
         value="{{ $data->tender->submission_date ? \Carbon\Carbon::parse($data->tender->submission_date)->format('d F Y') : '' }}"
         readonly>
 </div>

 <div class="form-group col-md-6">
     <label>Tender Type</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender->tender_type }}">
 </div>

 <div class="form-group col-md-6">
     <label>Financial Year</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender->financial_year }}">
 </div>

 <div class="form-group col-12">
     <label class="form-label">Item Details <span class="text-danger">*</span></label>
     <table class="table table-bordered" id="item-table">
         <thead class="table-light">
             <tr>
                 <th width="25%">Item</th>
                 <th width="15%">Deno</th>
                 <th width="10%">Qty</th>
                 <th width="15%">Unit Price</th>
                 <th width="15%">Total Price</th>
                 <th width="10%">Action</th>
             </tr>
         </thead>
         <tbody id="item-tbody">
             @php
                 // Use old input if exists, else items from DB, else show one blank
                 $oldItems = old(
                     'items',
                     $items ?? [
                         [
                             'item' => '',
                             'deno' => '',
                             'quantity' => '',
                             'unit_price' => '',
                             'total_price' => '',
                         ],
                     ],
                 );
             @endphp

             @foreach ($items as $index => $item)
                 <tr>
                     <td>
                         <input type="text" name="items[{{ $index }}][item]" class="form-control"
                             value="{{ $item['item'] ?? '' }}" readonly>
                     </td>
                     <td>
                         <input type="text" name="items[{{ $index }}][deno]" class="form-control"
                             value="{{ $item['deno'] ?? '' }}" readonly>
                     </td>
                     <td>
                         <input type="number" name="items[{{ $index }}][quantity]" class="form-control"
                             value="{{ $item['quantity'] ?? '' }}" readonly>
                     </td>
                     <td>
                         <input type="number" name="items[{{ $index }}][unit_price]" class="form-control"
                             value="{{ $item['unit_price'] ?? '' }}" readonly>
                     </td>
                     <td>
                         <input type="number" name="items[{{ $index }}][total_price]" class="form-control"
                             value="{{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2, '.', '') }}"
                             readonly>
                     </td>
                     <td class="text-center">
                         <button type="button" class="btn btn-secondary btn-sm" disabled>
                             <i class="fas fa-ban"></i>
                         </button>
                     </td>
                 </tr>
             @endforeach

         </tbody>
         <tfoot>
             <tr>
                 <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                 <td colspan="2">
                     <input type="number" id="grand-total" class="form-control"
                         value="{{ number_format(old('grandTotal', $grandTotal ?? 0), 2, '.', '') }}" readonly>
                 </td>
             </tr>
         </tfoot>
     </table>
 </div>

 <div class="form-group col-md-6">
     <label><strong>Tender Specification Files</strong></label><br>
     @if (!empty($data->tender->spec_file))
         <a class="form-control" href="{{ asset('uploads/documents/spec_files/' . $data->tender->spec_file) }}"
             target="_blank">View
             Attachment</a>
     @else
         <p class="text-muted">No attachment uploaded</p>
     @endif
 </div>

 <div class="form-group col-md-6">
     <label><strong>Tender Notice File</strong></label><br>
     @if (!empty($data->tender->notice_file))
         <a class="form-control" href="{{ asset('uploads/documents/notice_files/' . $data->tender->notice_file) }}"
             target="_blank">View
             Attachment</a>
     @else
         <p class="text-muted">No attachment uploaded</p>
     @endif
 </div>

 @php
     $statusLabel = match ($data->tender->status) {
         0 => 'Pending',
         1 => 'Not Participated',
         2 => 'Participated',
         3 => 'Awarded',
         4 => 'Completed',
         default => 'Unknown',
     };

     $now = now();
     $submissionDateTime = \Carbon\Carbon::parse($data->tender->submission_date . ' ' . $data->tender->submission_time);

     if ($data->tender->status === 0 && $submissionDateTime->lt($now)) {
         $statusLabel = 'Expired';
     }
 @endphp
 <div class="form-group col-md-6">
     <label>Tender Status</label>
     <input type="text" readonly class="form-control" value="{{ $statusLabel }}">
 </div>

 <div class="form-group col-md-6">
     <label>Offer No</label>
     <input type="text" readonly class="form-control" value="{{ $data->offer_no }}">
 </div>

 <div class="form-group col-md-6">
     <label>Offer Date</label>
     <input type="text" readonly class="form-control" value="{{ formatDateSafe($data->offer_validity) }}">
 </div>

 <div class="form-group col-md-6">
     <label>Offer Validity</label>
     <input type="text" readonly class="form-control" value="{{ formatDateSafe($data->offer_validity) }}">
 </div>

 <div class="form-group col-md-6">
     <label><strong>Offer Document</strong></label><br>
     @if (!empty($data->offer_doc))
         <a class="form-control" href="{{ asset('uploads/documents/offer_docs/' . $data->offer_doc) }}"
             target="_blank">View
             Attachment</a>
     @else
         <p class="text-muted">No attachment uploaded</p>
     @endif
 </div>

 <div class="form-group col-md-12 mt-3">
     <label><strong>Tender's Participants</strong></label>
     @if (!empty($currentTenderParticipants) && count($currentTenderParticipants))
         <table class="table table-bordered">
             <thead>
                 <tr>
                     <th>Company</th>
                     <th>Offered Price</th>
                     <th class="text-center">Position</th>
                 </tr>
             </thead>
             <tbody>
                 @foreach ($currentTenderParticipants as $index => $participant)
                     <tr>
                         <td>{{ $participant->company_name }}</td>
                         <td>{{ number_format($participant->offered_price, 2) }}</td>
                         <td class="text-center">{{ $index + 1 }}</td>
                     </tr>
                 @endforeach
             </tbody>
         </table>
     @else
         <p class="text-muted">No participants found for this tender.</p>
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

 <div class="form-group col-md-6">
     <label>Is Bid Guarantee (BG) ?</label>
     <input type="text" readonly class="form-control" value="{{ $data->is_bg == 1 ? 'Yes' : 'No' }}">
     <input type="hidden" name="is_bg" value="{{ $data->is_bg }}">
 </div>

 <div class="w-100"></div>

 @if ($data->is_bg == 1)
     <div class="form-group col-md-6">
         <label for="bg_no">BG Number</label>
         <input type="text" class="form-control" value="{{ optional($data->bg)->bg_no ?? '-' }}" readonly>
     </div>

     <div class="form-group col-md-6">
         <label for="issue_in_bank">Issue in Bank</label>
         <input type="text" class="form-control" value="{{ optional($data->bg)->issue_in_bank ?? '-' }}"
             readonly>
     </div>

     <div class="form-group col-md-6">
         <label for="issue_in_branch">Issue in Branch</label>
         <input type="text" class="form-control" value="{{ optional($data->bg)->issue_in_branch ?? '-' }}"
             readonly>
     </div>

     <div class="form-group col-md-6">
         <label for="expiry_date">BG Issue Date </label>
         <input type="text" class="form-control"
             value="{{ $data->bg->issue_date ? \Carbon\Carbon::parse($data->bg->issue_date)->format('d F Y') : '' }}"
             readonly>
     </div>

     <div class="form-group col-md-6">
         <label for="expiry_date">BG Expiry Date</label>
         <input type="text" class="form-control"
             value="{{ $data->bg->expiry_date ? \Carbon\Carbon::parse($data->bg->expiry_date)->format('d F Y') : '' }}"
             readonly>
     </div>

     <div class="form-group col-md-6">
         <label for="amount">BG Amount</label>
         <input type="number" class="form-control" value="{{ optional($data->bg)->amount ?? '' }}" readonly>
     </div>

     <div class="form-group col-md-6">
         <label>BG Attachment</label><br>
         @if (!empty(optional($data->bg)->attachment))
             <a class="form-control" href="{{ asset('uploads/documents/bg_attachments/' . $data->bg->attachment) }}"
                 target="_blank">
                 View Current Attachment
             </a>
         @else
             <span class="text-muted">No attachment available</span>
         @endif
     </div>
 @endif
