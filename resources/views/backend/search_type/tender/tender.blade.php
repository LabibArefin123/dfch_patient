 <div class="form-group col-md-6">
     <label>Tender No</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender_no }}">
 </div>

 <div class="form-group col-md-6">
     <label>Tender Title</label>
     <input type="text" readonly class="form-control" value="{{ $data->title }}">
 </div>

 <div class="form-group col-md-6">
     <label>Procuring Authority</label>
     <input type="text" readonly class="form-control" value="{{ $data->procuring_authority }}">
 </div>

 <div class="form-group col-md-6">
     <label>End User</label>
     <input type="text" readonly class="form-control" value="{{ $data->end_user }}">
 </div>

 <div class="form-group col-md-6">
     <label>Financial Year</label>
     <input type="text" readonly class="form-control" value="{{ $data->financial_year }}">
 </div>

 <div class="form-group col-md-6">
     <label>Tender Type</label>
     <input type="text" readonly class="form-control" value="{{ $data->tender_type }}">
 </div>

 <div class="form-group col-12">
     <label class="form-label">Item Details <span class="text-danger">*</span></label>
     <table class="table table-bordered" id="item-table">
         <thead class="table-light">
             <tr>
                 <th width="5%">SL</th>
                 <th width="25%">Item</th>
                 <th width="15%">Deno</th>
                 <th width="10%">Qty</th>
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
                         ],
                     ],
                 );
             @endphp

             @foreach ($items as $index => $item)
                 <tr>
                     <td>{{ $loop->iteration }}</td>
                     <td>
                         <input type="text" name="items[{{ $index }}][item]" class="form-control"
                             value="{{ $item['item'] ?? '' }}" readonly>
                     </td>
                     <td>
                         <input type="text" name="items[{{ $index }}][deno]" class="form-control"
                             value="{{ $item['deno'] ?? '' }}" readonly>
                     </td>

                     <td>
                         <input type="text" name="items[{{ $index }}][quantity]" class="form-control"
                             value="{{ $item['quantity'] ?? '' }}" readonly>
                     </td>

                     <td class="text-center">
                         <button type="button" class="btn btn-secondary btn-sm" disabled>
                             <i class="fas fa-ban"></i>
                         </button>
                     </td>
                 </tr>
             @endforeach
         </tbody>
     </table>
 </div>

 <div class="form-group col-md-6">
     <label>Status</label>
     @php
         $status = match ($data->status) {
             0 => 'Expired',
             1 => 'Not Participated',
             2 => 'Participated',
             3 => 'Awarded',
             4 => 'Completed',
             default => 'Unknown',
         };
     @endphp
     <input type="text" readonly class="form-control" value="{{ $status }}">
 </div>

 <div class="form-group col-md-6">
     <label>Publication Date</label>
     <input type="text" readonly class="form-control" value="{{ formatDateSafe($data->publication_date) }}">
 </div>

 <div class="form-group col-md-6">
     <label>Submission Date</label>
     <input type="text" readonly class="form-control" value="{{ formatDateSafe($data->submission_date) }}">
 </div>

 <div class="form-group col-md-6">
     <label>Submission Time</label>
     <input type="text" readonly class="form-control" value="{{ formatTime($data->submission_time) }}">
 </div>

 <div class="form-group col-md-6">
     <label><strong>Tender Specification Files</strong></label><br>
     @if (!empty($data->spec_file))
         <a class="form-control" href="{{ asset('uploads/documents/spec_files/' . $data->spec_file) }}"
             target="_blank">View
             Attachment</a>
     @else
         <p class="text-muted">No attachment uploaded</p>
     @endif
 </div>

 <div class="form-group col-md-6">
     <label><strong>Tender Notice File</strong></label><br>
     @if (!empty($data->notice_file))
         <a class="form-control" href="{{ asset('uploads/documents/notice_files/' . $data->notice_file) }}"
             target="_blank">View
             Attachment</a>
     @else
         <p class="text-muted">No attachment uploaded</p>
     @endif
 </div>
