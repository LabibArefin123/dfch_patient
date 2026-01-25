@extends('adminlte::page')
@section('title', 'Show Awarded Tender')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h1 class="mb-0">View Awarded Tender</h1>

        <a href="{{ route('awarded_tenders.edit', $awardedTender->id) }}"
            class="btn btn-sm btn-warning d-flex align-items-center gap-1 flex-shrink-0">
            Edit
        </a>
    </div>
@stop


@section('content')
    <div class="card">
        <div class="card-body">

            <ul class="nav nav-tabs" id="employeeTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tender-tab" data-toggle="tab" href="#tender" role="tab"
                        aria-selected="true">Tender Info</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pg-tab" data-bs-toggle="tab" href="#pgInfo" role="tab"
                        aria-controls="pgInfo" aria-selected="false">Performance Guarantee (PG) Info</a>
                </li>
            </ul>

            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="employeeTabContent">
                <div class="tab-pane fade show active" id="tender" role="tabpanel" aria-labelledby="tender-tab">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                {{-- Tender Number --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Tender Number</strong></label>
                                    <p class="form-control" readonly>{{ $tender->tender_no }}</p>
                                </div>

                                {{-- Tender Title --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Tender Title</strong></label>
                                    <p class="form-control" readonly>{{ $tender->title ?? '' }}</p>
                                </div>

                                {{-- Offer No --}}

                                {{-- Procuring Authority --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Procuring Authority</strong></label>
                                    <p class="form-control" readonly>{{ $tender->procuring_authority ?? '' }}</p>
                                </div>

                                {{-- End User --}}
                                <div class="form-group col-md-6">
                                    <label><strong>End User</strong></label>
                                    <p class="form-control" readonly>{{ $tender->end_user ?? '' }}</p>
                                </div>

                                {{-- Publication Date --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Publication Date</strong></label>
                                    <p class="form-control" readonly>{{ $tender->publication_date ?? '' }}</p>
                                </div>

                                {{-- End User --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Submission Date</strong></label>
                                    <p class="form-control" readonly>{{ $tender->submission_date ?? '' }}</p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><strong>Submission Time</strong></label>
                                    <p class="form-control" readonly>{{ $tender->submission_time ?? '' }}</p>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><strong>Financial Year (FY)</strong></label>
                                    <p class="form-control" readonly>{{ $tender->financial_year ?? '' }}</p>
                                </div>

                                {{-- Tender Type --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Tender Type</strong></label>
                                    <p class="form-control" readonly>{{ $tender->tender_type ?? '' }}</p>
                                </div>


                                <div class="w-100"></div>

                                <div class="form-group col-md-6">
                                    <label><strong>Tender Specification File</strong></label><br>
                                    @if (!empty($tender->spec_file))
                                        <a href="{{ asset('uploads/documents/spec_files/' . $tender->spec_file) }}"
                                            target="_blank"><i class="fas fa-file-pdf"></i> View
                                            Attachment</a>
                                    @else
                                        <p class="text-muted">No attachment uploaded</p>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label><strong>Tender Notice File</strong></label><br>
                                    @if (!empty($tender->notice_file))
                                        <a href="{{ asset('uploads/documents/notice_files/' . $tender->notice_file) }}"
                                            target="_blank"><i class="fas fa-file-pdf"></i> View
                                            Attachment</a>
                                    @else
                                        <p class="text-muted">No attachment uploaded</p>
                                    @endif
                                </div>

                                <div class="form-group col-12"><label
                                        class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">Participated
                                        Section</label></div>

                                <div class="form-group col-md-6">
                                    <label><strong>Offer No</strong></label>
                                    <p class="form-control" readonly>{{ $participate->offer_no ?? '' }}</p>
                                </div>

                                {{-- Offer Date --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Offer Date</strong></label>
                                    <div class="form-control" readonly>
                                        {{ \Carbon\Carbon::parse($participate->offer_date)->format('d F Y') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><strong>Offer Validity</strong></label>
                                    <div class="form-control" readonly>
                                        {{ \Carbon\Carbon::parse($participate->offer_validity)->format('d F Y') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label><strong>Offer Document</strong></label><br>
                                    @if (!empty($participate->offer_doc))
                                        <a href="{{ asset('uploads/documents/offer_docs/' . $participate->offer_doc) }}"
                                            target="_blank"><i class="fas fa-file-pdf"></i> View Attachment</a>
                                    @else
                                        <p class="text-muted">No attachment uploaded</p>
                                    @endif
                                </div>

                                {{-- Item Details Table --}}
                                <div class="form-group col-12">
                                    <label><strong>Item Details</strong></label>
                                    <table class="table table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>SL</th> <!-- New SL column -->
                                                <th>Item</th>
                                                <th>Deno</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $itemsToShow = $items ?? [
                                                    [
                                                        'item' => '',
                                                        'deno' => '',
                                                        'quantity' => '',
                                                        'unit_price' => '',
                                                        'total_price' => '',
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($itemsToShow as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td> <!-- Serial number -->
                                                    <td>{{ $item['item'] ?? '' }}</td>
                                                    <td>{{ $item['deno'] ?? '' }}</td>
                                                    <td>{{ $item['quantity'] ?? '' }}</td>
                                                    <td>{{ $item['unit_price'] ?? '' }}</td>
                                                    <td>{{ number_format(((float) ($item['quantity'] ?? 0)) * ((float) ($item['unit_price'] ?? 0)), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                                                <td>{{ number_format($grandTotal ?? 0, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


                                {{-- Tender Participants --}}
                                <div class="form-group col-md-12">
                                    <label><strong>Tender's Participants</strong></label>

                                    @php
                                        $participantsByDate = collect($currentTenderParticipants);
                                    @endphp

                                    @if ($participantsByDate->isEmpty())
                                        <p class="text-muted">No participants found for this tender.</p>
                                    @else
                                        @foreach ($participantsByDate as $date => $participants)
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">SL</th>
                                                        <th>Company</th>
                                                        <th class="text-center">Offered Price</th>
                                                        <th class="text-center">Position</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($participants as $index => $participant)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td>{{ $participant['company_name'] }}</td>
                                                            <td class="text-center">
                                                                {{ number_format($participant['offered_price'], 2) }}</td>
                                                            <td class="text-center">{{ $index + 1 }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endforeach
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

                                <div class="form-group col-12"><label
                                        class="form-label fw-bold text-uppercase text-primary border-bottom border-primary pb-1 d-inline-block">Awarded
                                        Section</label></div>

                                {{-- Work Order No/NOA No --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Work Order No/NOA No</strong></label>
                                    <p class="form-control" readonly>{{ $awardedTender->workorder_no ?? '' }}</p>
                                </div>

                                {{-- Work Order/NOA Date --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Work Order/NOA Date</strong></label>
                                    <div class="form-control" readonly>
                                        {{ \Carbon\Carbon::parse($awardedTender->workorder_date)->format('d F Y') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Work Order/NOA Doc</label><br>
                                    @if (!empty($awardedTender->workorder_doc))
                                        <a href="{{ asset('uploads/documents/workorder_docs/' . $awardedTender->workorder_doc) }}"
                                            target="_blank"> <i class="fas fa-file-pdf"></i>
                                            View Current Attachment
                                        </a>
                                    @else
                                        <span class="text-muted">No attachment available</span>
                                    @endif
                                </div>

                                <div class="w-100"></div>

                                {{-- Delivery Date --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Delivery Date</strong></label>
                                    <div class="form-control" readonly>
                                        {{ \Carbon\Carbon::parse($awardedTender->awarded_date)->format('d F Y') }}
                                    </div>
                                </div>

                                {{-- Delivery Type --}}
                                <div class="form-group col-md-6">
                                    <label><strong>Delivery Type</strong></label>
                                    <p class="form-control" readonly>
                                        @if (($awardedTender->delivery_type ?? '') == '1')
                                            Single
                                        @elseif (($awardedTender->delivery_type ?? '') == 'partial')
                                            Multiple
                                        @else
                                            N/A
                                        @endif
                                    </p>
                                </div>

                                {{-- Single Delivery Section --}}
                                @if (($awardedTender->delivery_type ?? '') == '1')
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
                                                    <td>{{ $singleDelivery->delivery_item ?? '' }}</td>
                                                    <td>{{ $singleDelivery && $singleDelivery->delivery_date ? \Carbon\Carbon::parse($singleDelivery->delivery_date)->format('d F Y') : '' }}
                                                    </td>
                                                    <td>{{ $singleDelivery->warranty ?? '' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                {{-- Partial Delivery Section --}}
                                @if (($awardedTender->delivery_type ?? '') == 'partial')
                                    <div class="form-group col-md-12">
                                        <h5 class="mt-4">Delivery Information (Multiple)</h5>
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
                                                @foreach ($partialDeliveries as $delivery)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $delivery->delivery_item ?? '' }}</td>
                                                        <td>{{ $delivery->delivery_date ? \Carbon\Carbon::parse($delivery->delivery_date)->format('d F Y') : '' }}
                                                        </td>
                                                        <td>{{ $delivery->warranty ?? '' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif

                                <div class="w-100"></div>

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

                            </div>
                        </div>
                        <div class="mt-4" style="height:50px;"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="pgInfo" role="tabpanel" aria-labelledby="pg-tab">
                    <div class="card">
                        <div class="card-body row">

                            {{-- PG Number --}}
                            <div class="form-group col-md-6">
                                <label><strong>PG Number</strong></label>
                                <p class="form-control" readonly>{{ $pg->pg_no ?? '-' }}</p>
                            </div>

                            {{-- Issue in Bank --}}
                            <div class="form-group col-md-6">
                                <label><strong>Issue in Bank</strong></label>
                                <p class="form-control" readonly>{{ $pg->issue_in_bank ?? '-' }}</p>
                            </div>

                            {{-- Issue in Branch --}}
                            <div class="form-group col-md-6">
                                <label><strong>Issue in Branch</strong></label>
                                <p class="form-control" readonly>{{ $pg->issue_in_branch ?? '-' }}</p>
                            </div>

                            <div class="form-group col-md-6">
                                <label><strong>PG Issue Date</strong></label>
                                <div class="form-control" readonly>
                                    {{ $pg->issue_date ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label><strong>PG Expiry Date</strong></label>
                                <div class="form-control" readonly>
                                    {{ $pg->expiry_date ?? '-' }}
                                </div>
                            </div>

                            {{-- PG Amount --}}
                            <div class="form-group col-md-6">
                                <label><strong>PG Amount</strong></label>
                                <p class="form-control" readonly>{{ $pg->amount ?? 'NA' }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
