<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\TenderAwarded;
use App\Models\TenderProgress;
use App\Models\TenderLetter;
use App\Models\TenderCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class TenderCompletedController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $completedTenders = TenderCompleted::with([
                'tenderProgress.tenderAwarded.tenderParticipate.tender'
            ])->latest()->get();

            return DataTables::of($completedTenders)
                ->addIndexColumn()

                // Tender No
                ->addColumn('tender_no', function ($row) {
                    $tender = optional($row->tenderProgress->tenderAwarded->tenderParticipate->tender);
                    return $tender->tender_no
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . e($tender->tender_no) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Title
                ->addColumn('title', function ($row) {
                    $tender = optional($row->tenderProgress->tenderAwarded->tenderParticipate->tender);
                    return $tender->title
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . e($tender->title) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Tender Type
                ->addColumn('tender_type', function ($row) {
                    $type = optional($row->tenderProgress->tenderAwarded->tenderParticipate->tender)->tender_type;
                    return $type
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . e(ucfirst($type)) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })


                // Publication Date
                ->addColumn('publication_date', function ($row) {
                    $date = optional($row->tenderProgress->tenderAwarded->tenderParticipate->tender)->publication_date;
                    return $date
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Submission Date
                ->addColumn('submission_date', function ($row) {
                    $date = optional($row->tenderProgress->tenderAwarded->tenderParticipate->tender)->submission_date;
                    return $date
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Workorder No
                ->addColumn('workorder_no', function ($row) {
                    return $row->workorder_no
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . e($row->workorder_no) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Workorder Date
                ->editColumn('workorder_date', function ($row) {
                    return $row->workorder_date
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($row->workorder_date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Awarded Date
                ->editColumn('awarded_date', function ($row) {
                    return $row->awarded_date
                        ? '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($row->awarded_date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Delivery Type
                ->editColumn('delivery_type', function ($row) {
                    $type = $row->delivery_type === '1' ? 'Single' : 'Partial';
                    return '<a href="' . route('completed_tenders.show', $row->id) . '" class="hover-box">' . $type . '</a>';
                })

                ->addColumn(
                    'action',
                    fn($row) =>
                    '<a href="' . route('completed_tenders.letter', optional($row->tenderProgress->tenderAwarded->tenderParticipate->tender)->id) . '" class="btn btn-sm btn-primary">
                    <i class="fas fa-envelope"></i>
                </a>'
                )

                ->rawColumns([
                    'tender_no',
                    'title',
                    'tender_type',
                    'publication_date',
                    'submission_date',
                    'workorder_no',
                    'workorder_date',
                    'awarded_date',
                    'delivery_type',
                    'action',
                ])
                ->make(true);
        }

        return view('backend.tender.completed.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $progressTenders = TenderProgress::with(['tenderAwarded.tenderParticipate.tender'])
            ->whereHas('tenderAwarded')
            ->where('is_delivered', 1)
            ->where('is_inspection_completed', 1)
            ->where('is_inspection_accepted', 1)
            ->where('is_bill_submitted', 1)
            ->where('is_bill_received', 1)
            ->get();
        // dd($progressTenders);

        if ($progressTenders->isEmpty()) {
            return redirect()->back()->with('error', 'You can’t select any tender until its work progress is 100%.');
        }

        return view('backend.tender.completed.create', [
            'progressTenders' => $progressTenders,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tender_progress_id' => 'required|exists:tender_progress,id',
            'publication_date' => 'required|date',
            'submission_date' => 'required|date',
            'workorder_no' => 'required|string|max:255',
            'workorder_date' => 'required|date',
            'awarded_date' => 'required|date',
            'delivery_type' => 'required|in:1,partial',

            'is_warranty_complete' => 'required|boolean',
            'warranty_complete_date' => 'nullable|required_if:is_warranty_complete,1|date',

            'is_service_warranty' => 'required|boolean',
            'service_warranty_duration' => 'nullable|required_if:is_service_warranty,1|date',
        ]);

        // ✅ Get Tender Progress with relationships
        $progress = TenderProgress::with('tenderAwarded.tenderParticipate.tender')
            ->findOrFail($validated['tender_progress_id']);

        // ✅ Update warranty fields

        // ✅ Create TenderCompleted
        $completed = TenderCompleted::create([
            'tender_progress_id' => $progress->id,
            'publication_date' => $validated['publication_date'],
            'submission_date' => $validated['submission_date'],
            'workorder_no' => $validated['workorder_no'],
            'workorder_date' => $validated['workorder_date'],
            'awarded_date' => $validated['awarded_date'],
            'delivery_type' => $validated['delivery_type'],
        ]);

        $completed->is_warranty_complete = $validated['is_warranty_complete'];
        $completed->warranty_complete_date = $validated['is_warranty_complete'] ? $validated['warranty_complete_date'] : null;

        $completed->is_service_warranty = $validated['is_service_warranty'];
        $completed->service_warranty_duration = $validated['is_service_warranty'] ? $validated['service_warranty_duration'] : null;

        $completed->save(); // ✅ Save complete updates
        // ✅ Update Tender main status
        $tender = optional($progress->tenderAwarded->tenderParticipate)->tender;
        if ($tender) {
            $tender->status = 4; // 4 = Completed
            $tender->is_completed = true;
            $tender->save();
        }

        return redirect()->route('completed_tenders.index')
            ->with('success', 'Tender has been marked as completed.');
    }


    public function getTenderProgressDetails($participateId)
    {
        $tenderProgress = TenderProgress::with([
            'tenderAwarded.tenderParticipate.tender',
            'tenderAwarded.tenderParticipate.companies',
            'tenderAwarded.tenderParticipate.bg',
            'tenderAwarded.pg',
            'tenderAwarded.singleDelivery',
            'tenderAwarded.partialDeliveries',
        ])->whereHas('tenderAwarded', function ($query) use ($participateId) {
            $query->where('tender_awarded_id', $participateId);
        })->first();

        if (!$tenderProgress) {
            return response()->json(['message' => 'Tender Progress not found'], 404);
        }

        $tenderId = $tenderProgress->tenderAwarded->tenderParticipate->tender->id;

        // Correct letters query
        $participateLetters = TenderLetter::where('tender_id', $tenderId)
            ->where('type', 1)
            ->latest()
            ->get();

        $awardedLetters = TenderLetter::where('tender_id', $tenderId)
            ->where('type', 2)
            ->latest()
            ->get();

        $progressLetters = TenderLetter::where('tender_id', $tenderId)
            ->where('type', 3)
            ->latest()
            ->get();

        if (!$tenderProgress || !$tenderProgress->tenderAwarded->tenderParticipate || !$tenderProgress->tenderAwarded->tenderParticipate->tender) {
            return response()->json(['message' => 'Tender details not found'], 404);
        }


        $tenderAwarded = $tenderProgress->tenderAwarded;
        $participate = $tenderAwarded->tenderParticipate;

        return response()->json([
            // Tender Info
            'title' => $participate->tender->title ?? '',
            'offer_no' => $participate->offer_no ?? '',
            'offer_date' => $participate->offer_date ?? '',
            'offer_validity' => $participate->offer_validity ?? '',
            'procuring_authority' => $participate->tender->procuring_authority ?? '',
            'end_user' => $participate->tender->end_user ?? '',
            'financial_year' => $participate->tender->financial_year ?? '',
            'tender_type' => $participate->tender->tender_type ?? '',
            'items' => $participate->tender->items ?? [],
            'publication_date' => $participate->tender->publication_date ?? '',
            'submission_date' => $participate->tender->submission_date ?? '',
            'workorder_no' => $tenderAwarded->workorder_no ?? '',
            'workorder_date' => $tenderAwarded->workorder_date ?? '',
            'awarded_date' => $tenderAwarded->awarded_date ?? '',
            'delivery_type' => $tenderAwarded->delivery_type ?? '',

            // Flags
            'is_bg' => $participate->is_bg ?? 0,
            'is_pg' => $tenderAwarded->is_pg ?? 0,

            // Participating Companies
            'companies' => $participate->companies->map(function ($company) {
                return [
                    'name' => $company->company_name,
                    'price' => number_format($company->offered_price, 2) . ' ৳',
                ];
            }),

            // BG Info
            'bg' => $participate->bg ? [
                'bg_no' => $participate->bg->bg_no ?? '',
                'issue_in_bank' => $participate->bg->issue_in_bank ?? '',
                'issue_in_branch' => $participate->bg->issue_in_branch ?? '',
                'issue_date' => $participate->bg->issue_date,
                'expiry_date' => $participate->bg->expiry_date,
                'amount' => $participate->bg->amount ?? '',
                'attachment' => $participate->bg->attachment ?? '',
            ] : null,

            // Single Delivery
            'single_delivery' => $tenderAwarded->singleDelivery ? [
                'delivery_item' => $tenderAwarded->singleDelivery->delivery_item ?? '',
                'delivery_date' => $tenderAwarded->singleDelivery->delivery_date ?? '',
                'warranty' => $tenderAwarded->singleDelivery->warranty ?? '',
            ] : null,

            // Partial Deliveries
            'partial_deliveries' => $tenderAwarded->partialDeliveries->map(function ($delivery) {
                return [
                    'delivery_item' => $delivery->delivery_item ?? '',
                    'delivery_date' => $delivery->delivery_date ?? '',
                    'warranty' => $delivery->warranty ?? '',
                ];
            }),

            // PG Info
            'pg' => $tenderAwarded->pg ? [
                'pg_no' => $tenderAwarded->pg->pg_no ?? '',
                'issue_in_bank' => $tenderAwarded->pg->issue_in_bank ?? '',
                'issue_in_branch' => $tenderAwarded->pg->issue_in_branch ?? '',
                'issue_date' => $tenderAwarded->pg->issue_date,
                'expiry_date' => $tenderAwarded->pg->expiry_date,
                'amount' => $tenderAwarded->pg->amount ?? '',
                'attachment' => $tenderAwarded->pg->attachment ?? '',
            ] : null,

            'participate_letters' => $participateLetters->map(function ($letter, $index) {
                return [
                    'sl' => $index + 1,
                    'reference_no' => $letter->reference_no,
                    'remarks' => $letter->remarks,
                    'value' => $letter->value,
                    'date' => $letter->date ? \Carbon\Carbon::parse($letter->date)->format('d M, Y') : '',
                    'document' => $letter->document ? asset('uploads/documents/tender_letters/participate/' . $letter->document) : null,
                ];
            }),

            'awarded_letters' => $awardedLetters->map(function ($letter, $index) {
                return [
                    'sl' => $index + 1,
                    'reference_no' => $letter->reference_no,
                    'remarks' => $letter->remarks,
                    'value' => $letter->value,
                    'date' => $letter->date ? \Carbon\Carbon::parse($letter->date)->format('d M, Y') : '',
                    'document' => $letter->document ? asset('uploads/documents/tender_letters/awarded/' . $letter->document) : null,
                ];
            }),

            'progress_letters' => $progressLetters->map(function ($letter, $index) {
                return [
                    'sl' => $index + 1,
                    'reference_no' => $letter->reference_no,
                    'remarks' => $letter->remarks,
                    'value' => $letter->value,
                    'date' => $letter->date ? \Carbon\Carbon::parse($letter->date)->format('d M, Y') : '',
                    'document' => $letter->document ? asset('uploads/documents/tender_letters/progress/' . $letter->document) : null,
                ];
            }),

            // Progress Info
            'is_delivered' => $tenderProgress->is_delivered,
            'challan_no' => $tenderProgress->challan_no,
            'challan_date' => $tenderProgress->challan_date,
            'challan_doc' => $tenderProgress->challan_doc,
            'is_inspection_completed' => $tenderProgress->is_inspection_completed,
            'inspection_complete_date' => $tenderProgress->inspection_complete_date,
            'is_inspection_accepted' => $tenderProgress->is_inspection_accepted,
            'inspection_accept_date' => $tenderProgress->inspection_accept_date,
            'is_bill_submitted' => $tenderProgress->is_bill_submitted,
            'bill_no' => $tenderProgress->bill_no,
            'bill_submit_date' => $tenderProgress->bill_submit_date,
            'bill_doc' => $tenderProgress->bill_doc,
            'is_bill_received' => $tenderProgress->is_bill_received,
            'bill_cheque_no' => $tenderProgress->bill_cheque_no,
            'bill_receive_date' => $tenderProgress->bill_receive_date,
            'bill_amount' => $tenderProgress->bill_amount,
            'bill_bank_name' => $tenderProgress->bill_bank_name,
            'status' => $tenderProgress->status,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Load the completed tender and its nested relationships
        $completedTender = TenderCompleted::with([
            'tenderProgress.tenderAwarded.tenderParticipate.tender',
            'tenderProgress.tenderAwarded.tenderParticipate.companies',
            'tenderProgress.tenderAwarded.tenderParticipate.bg',
            'tenderProgress.tenderAwarded.pg',
            'tenderProgress.tenderAwarded.singleDelivery',
            'tenderProgress.tenderAwarded.partialDeliveries',
        ])->findOrFail($id);

        // Step up the relationship ladder
        $tenderProgress = $completedTender->tenderProgress;
        $tenderAwarded = $tenderProgress->tenderAwarded ?? null;
        $participate = $tenderAwarded->tenderParticipate ?? null;
        $tender = $participate?->tender;

        if (!$tender) {
            abort(404, 'Tender information not found.');
        }

        // Parse tender items
        $items = is_array($tender->items) ? $tender->items : json_decode($tender->items, true);
        $items = is_array($items) ? $items : [];

        // Calculate Grand Total
        $grandTotal = collect($items)->sum(function ($item) {
            return ((float) ($item['quantity'] ?? 0)) * ((float) ($item['unit_price'] ?? 0));
        });

        // Participants and Offered Price Ranking
        $participants = $participate?->companies->map(function ($company) {
            return [
                'company_name' => $company->company_name,
                'offered_price' => $company->offered_price ?? 0,
            ];
        })->sortBy('offered_price')->values() ?? collect();

        $currentTenderParticipants = collect([
            'Participants' => $participants
        ]);

        // Deliveries
        $singleDelivery = $completedTender->singleDelivery;
        $partialDeliveries = $completedTender->partialDeliveries ?? [];

        // PG Details
        $pg = $tenderAwarded->pg ?? (object) [
            'pg_no' => '',
            'issue_in_bank' => '',
            'issue_in_branch' => '',
            'issue_date' => null,
            'expiry_date' => null,
            'amount' => '',
            'attachment' => ''
        ];

        // Letters
        $participateLetters = $awardedLetters = collect();
        if ($participate && $participate->tender_id) {
            $query = TenderLetter::where('tender_id', $participate->tender_id);
            $participateLetters = (clone $query)->where('type', 1)->latest()->get();
            $awardedLetters = (clone $query)->where('type', 2)->latest()->get();
            $progressLetters = (clone $query)->where('type', 3)->latest()->get();
            $completedLetters = (clone $query)->where('type', 4)->latest()->get();
        }

        return view('backend.tender.completed.show', compact(
            'tender',
            'completedTender',
            'participate',
            'items',
            'grandTotal',
            'currentTenderParticipants',
            'singleDelivery',
            'partialDeliveries',
            'pg',
            'participateLetters',
            'awardedLetters',
            'progressLetters',
            'completedLetters'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function letter($tenderId)
    {
        $tComplete = TenderCompleted::with('tenderProgress.tenderAwarded.tenderParticipate.tender')
            ->whereHas('tenderProgress.tenderAwarded.tenderParticipate', function ($q) use ($tenderId) {
                $q->where('tender_id', $tenderId);
            })
            ->firstOrFail();

        $tenderLetters = TenderLetter::with('tender')
            ->where('tender_id', $tenderId)
            ->where('type', '4') // Only completed
            ->latest()
            ->get();

        return view('backend.tender.completed.letter', compact('tenderLetters', 'tenderId', 'tComplete'));
    }

    public function letterStore(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        $request->validate([
            'reference_no' => 'nullable|string',
            'remarks' => 'required|string',
            'value' => 'required|string',
            'date' => 'required|date',
            'document' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/documents/tender_letters/completed'), $filename);

        TenderLetter::create([
            'tender_id'    => $tender->id,
            'reference_no' => $request->reference_no,
            'remarks'      => $request->remarks,
            'value'      => $request->value,
            'date'         => $request->date,
            'document'     => $filename,
            'type'         => 4,
        ]);

        return redirect()->back()->with('success', 'Tender letter uploaded successfully.');
    }


    public function letterEdit($id)
    {
        $editLetter = TenderLetter::with('tender')->findOrFail($id);
        return view('backend.tender.completed.letter_edit', compact('editLetter'));
    }

    public function letterUpdate(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string',
            'date' => 'required|date',
            'value' => 'required|string',
            'document' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $letter = TenderLetter::findOrFail($id);

        $letter->remarks = $request->remarks;
        $letter->value = $request->value;
        $letter->date = $request->date;

        if ($request->hasFile('document')) {

            $oldPath = public_path('uploads/documents/tender_letters/completed/' . $letter->document);
            if ($letter->document && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('document');
            $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents/tender_letters/completed'), $filename);

            $letter->document = $filename;
        }

        $letter->save();

        return redirect()->route(
            'completed_tenders.letter',
            $letter->tender_id
        )->with('success', 'Tender letter updated successfully.');
    }



    public function letterDestroy($id)
    {
        $letter = TenderLetter::findOrFail($id);
        if ($letter->document && file_exists(public_path('uploads/tender_letters/' . $letter->document))) {
            unlink(public_path('uploads/documents/tender_letters/completed' . $letter->document));
        }
        $letter->delete();

        return redirect()->back()->with('success', 'Letter deleted successfully.');
    }
}
