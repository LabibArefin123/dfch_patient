<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Tender;
use App\Models\TenderParticipate;
use App\Models\PerformanceGuarantee;
use App\Models\TenderAwarded;
use App\Models\TenderProgress;
use App\Models\TenderCompleted;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\TenderLetter;

class TenderProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TenderProgress::with([
                'tenderAwarded.tenderParticipate.tender',
                'tenderAwarded.tenderParticipate.companies',
            ])
                ->get()
                ->sortByDesc(function ($progress) {
                    return optional(
                        $progress->tenderAwarded?->tenderParticipate?->tender
                    )->submission_date;
                })
                ->values(); // reset keys after sorting

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tender_no', function ($row) {
                    $tenderNo = optional($row->tenderAwarded->tenderParticipate->tender)->tender_no;
                    return $tenderNo
                        ? '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . e($tenderNo) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('title', function ($row) {
                    $tenderTitle = optional($row->tenderAwarded->tenderParticipate->tender)->title;
                    return $tenderTitle
                        ? '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . e($tenderTitle) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('publication_date', function ($row) {
                    $date = optional($row->tenderAwarded->tenderParticipate->tender)->publication_date;
                    return $date
                        ? '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('submission_date', function ($row) {
                    $date = optional($row->tenderAwarded->tenderParticipate->tender)->submission_date;
                    return $date
                        ? '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('workorder_no', function ($row) {
                    $value = $row->tenderAwarded->workorder_no ?? '-';
                    return '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . e($value) . '</a>';
                })
                ->addColumn('workorder_date', function ($row) {
                    $date = $row->tenderAwarded->workorder_date;
                    return $date
                        ? '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('awarded_date', function ($row) {
                    $date = $row->tenderAwarded->awarded_date;
                    return $date
                        ? '<a href="' . route('tender_progress.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($date)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })
                ->addColumn('delivery_type', function ($row) {
                    $type = $row->tenderAwarded?->delivery_type === '1' ? 'Single' : 'Partial';
                    return '<a href="' . route('tender_progress.show', $row->id) . '" class="badge bg-primary hover-box">' . $type . '</a>';
                })
                ->addColumn('position', function ($row) {
                    // Get organization name
                    $organization = Organization::first();
                    $orgName = $organization->name ?? null;

                    $companies = $row->tenderAwarded->tenderParticipate->companies ?? collect();

                    $filtered = $companies
                        ->filter(fn($c) => $c->offered_price !== null)
                        ->sortBy('offered_price')
                        ->values();

                    $position = $orgName ? $filtered->search(fn($c) => $c->company_name === $orgName) : false;

                    if ($position === false) {
                        return '<span class="text-muted">N/A</span>';
                    }

                    $rank = $position + 1;

                    // 🔑 Convert number to ordinal words
                    $words = [
                        1 => 'First',
                        2 => 'Second',
                        3 => 'Third',
                        4 => 'Fourth',
                        5 => 'Fifth',
                        6 => 'Sixth',
                        7 => 'Seventh',
                        8 => 'Eighth',
                        9 => 'Ninth',
                        10 => 'Tenth',
                        11 => 'Eleventh',
                        12 => 'Twelfth',
                        13 => 'Thirteenth',
                        14 => 'Fourteenth',
                        15 => 'Fifteenth',
                        16 => 'Sixteenth',
                        17 => 'Seventeenth',
                        18 => 'Eighteenth',
                        19 => 'Nineteenth',
                        20 => 'Twentieth',
                    ];

                    if (isset($words[$rank])) {
                        $word = $words[$rank];
                    } else {
                        // For 21, 22, 23 … etc
                        $tens = [
                            20 => 'Twentieth',
                            30 => 'Thirtieth',
                            40 => 'Fortieth',
                            50 => 'Fiftieth',
                            60 => 'Sixtieth',
                            70 => 'Seventieth',
                            80 => 'Eightieth',
                            90 => 'Ninetieth',
                        ];

                        if (isset($tens[$rank])) {
                            $word = $tens[$rank];
                        } else {
                            $tensPart = floor($rank / 10) * 10;
                            $ones = $rank % 10;

                            $tensWord = match ($tensPart) {
                                20 => 'Twenty',
                                30 => 'Thirty',
                                40 => 'Forty',
                                50 => 'Fifty',
                                60 => 'Sixty',
                                70 => 'Seventy',
                                80 => 'Eighty',
                                90 => 'Ninety',
                                default => ''
                            };

                            $onesWord = $words[$ones] ?? '';
                            $word = trim($tensWord . ' ' . $onesWord);
                        }
                    }

                    return '<span class="hover-box">' . $word . '</span>';
                })

                ->addColumn(
                    'action',
                    fn($row) =>
                    '<div class="d-flex gap-1">
                        <a href="' . route('tender_progress.edit', $row->id) . '" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="' . route('tender_progress.letter', optional($row->tenderAwarded->tenderParticipate->tender)->id) . '" class="btn btn-sm btn-primary">
                            <i class="fas fa-envelope"></i>
                        </a>
                    </div>'
                )

                ->rawColumns([
                    'tender_no',
                    'title',
                    'publication_date',
                    'submission_date',
                    'workorder_no',
                    'workorder_date',
                    'awarded_date',
                    'delivery_type',
                    'position',
                    'action'
                ])
                ->make(true);
        }

        $tenderProgress = TenderProgress::with('tenderAwarded')->get();

        $statuses = [
            'all' => ['Not Started' => 0, 'Ongoing' => 0, 'Completed' => 0]
        ];

        foreach ($tenderProgress as $progress) {
            $start = optional($progress->tenderAwarded)->workorder_date
                ? Carbon::parse($progress->tenderAwarded->workorder_date)
                : null;

            $end = optional($progress->tenderAwarded)->awarded_date
                ? Carbon::parse($progress->tenderAwarded->awarded_date)
                : null;

            // Skip if invalid dates
            if (!$start || !$end || $start->gte($end)) {
                continue;
            }

            $now = Carbon::now();
            $total = $start->diffInSeconds($end);
            $elapsed = $start->diffInSeconds($now);

            $percent = $elapsed <= 0 ? 0 : ($elapsed >= $total ? 100 : round(($elapsed / $total) * 100, 2));

            $status = match (true) {
                $percent === 0 => 'Not Started',
                $percent >= 100 => 'Completed',
                default => 'Ongoing',
            };

            // Add to global 'all' count
            $statuses['all'][$status]++;

            // Add per tender (using ID)
            $statuses[$progress->id] = [
                'Not Started' => $status === 'Not Started' ? 1 : 0,
                'Ongoing' => $status === 'Ongoing' ? 1 : 0,
                'Completed' => $status === 'Completed' ? 1 : 0,
            ];

            // Optionally: store percentage for dynamic chart/label
            $progress->percentage = $percent;
            $progress->status = $status;
        }

        return view('backend.tender.progress.index', compact('statuses', 'tenderProgress'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get tender_ids that already have progress created
        $alreadyInProgress = TenderProgress::pluck('tender_awarded_id')->toArray();

        // Fetch latest awarded tender per tender_id, excluding cancelled and already progressed
        $progressTenders = TenderAwarded::with(['tenderParticipate.tender:id,tender_no,title,status'])
            ->whereHas('tenderParticipate.tender', function ($query) {
                $query->whereNotIn('status', [4]); // Exclude cancelled tenders
            })
            ->whereNotIn('id', $alreadyInProgress) // Exclude already in progress
            ->latest() // Get latest awarded entries
            ->get()
            // Filter to keep only latest awarded per tender_id
            ->unique(function ($item) {
                return $item->tenderParticipate->tender_id;
            });

        return view('backend.tender.progress.create', [
            'progressTenders' => $progressTenders,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tender_awarded_id' => 'required|exists:tender_awardeds,id',

            'is_delivered' => 'required|boolean',
            'challan_no' => 'nullable|required_if:is_delivered,1|string',
            'challan_date' => 'nullable|required_if:is_delivered,1|date',
            'challan_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'is_inspection_completed' => 'required|boolean',
            'inspection_complete_date' => 'nullable|required_if:is_inspection_completed,1|date',
            'is_inspection_accepted' => 'required|boolean',
            'inspection_accept_date' => 'nullable|required_if:is_inspection_accepted,1|date',

            'is_bill_submitted' => 'required|boolean',
            'bill_no' => 'nullable|required_if:is_bill_submitted,1|string',
            'bill_submit_date' => 'nullable|required_if:is_bill_submitted,1|date',
            'bill_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'is_bill_received' => 'required|boolean',
            'bill_cheque_no' => 'nullable|required_if:is_bill_received,1|string',
            'bill_receive_date' => 'nullable|required_if:is_bill_received,1|date',
            'bill_bank_name' => 'nullable|required_if:is_bill_received,1|string',
            'bill_amount' => 'nullable|required_if:is_bill_received,1|numeric',
        ]);

        // ✅ Enforce dependencies
        if ($request->is_inspection_completed && !$request->is_delivered) {
            return redirect()->back()->withErrors(['is_inspection_completed' => 'Cannot complete inspection before delivery.'])->withInput();
        }

        if ($request->is_inspection_accepted && !$request->is_inspection_completed) {
            return redirect()->back()->withErrors(['is_inspection_accepted' => 'Cannot accept inspection before completion.'])->withInput();
        }

        $progressTender = new TenderProgress();
        $progressTender->tender_awarded_id = $validated['tender_awarded_id'];
        $progressTender->is_delivered = $validated['is_delivered'];
        $progressTender->is_inspection_completed = $validated['is_inspection_completed'];
        $progressTender->is_inspection_accepted = $validated['is_inspection_accepted'];
        $progressTender->is_bill_submitted = $validated['is_bill_submitted'];
        $progressTender->is_bill_received = $validated['is_bill_received'];

        // Challan fields
        if ($request->is_delivered) {
            $progressTender->challan_no = $request->challan_no;
            $progressTender->challan_date = $request->challan_date;

            if ($request->hasFile('challan_doc')) {
                $file = $request->file('challan_doc');
                $filename = time() . '_challan.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents/challan_docs'), $filename);
                $progressTender->challan_doc = $filename;
            }
        }

        // Inspection complete fields
        $progressTender->inspection_complete_date = $request->is_inspection_completed ? $request->inspection_complete_date : null;

        // Inspection accept fields
        $progressTender->inspection_accept_date = $request->is_inspection_accepted ? $request->inspection_accept_date : null;

        // Bill submitted fields
        if ($request->is_bill_submitted) {
            $progressTender->bill_no = $request->bill_no;
            $progressTender->bill_submit_date = $request->bill_submit_date;

            if ($request->hasFile('bill_doc')) {
                $file = $request->file('bill_doc');
                $filename = time() . '_bill.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents/bill_docs'), $filename);
                $progressTender->bill_doc = $filename;
            }
        }

        // Bill received fields
        $progressTender->bill_cheque_no = $request->is_bill_received ? $request->bill_cheque_no : null;
        $progressTender->bill_receive_date = $request->is_bill_received ? $request->bill_receive_date : null;
        $progressTender->bill_bank_name = $request->is_bill_received ? $request->bill_bank_name : null;
        $progressTender->bill_amount = $request->is_bill_received ? $request->bill_amount : null;

        // Default status
        $progressTender->status = 'In Progress';

        $progressTender->save();

        return redirect()->route('tender_progress.index')
            ->with('success', 'Progress Tender created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Load awarded tender with all necessary relationships
        $progressTender = TenderProgress::with([
            'tenderAwarded.tenderParticipate.tender',
            'tenderAwarded.tenderParticipate.companies',
            'tenderAwarded.tenderParticipate.bg',
            'tenderAwarded.pg',
            'tenderAwarded.singleDelivery',
            'tenderAwarded.partialDeliveries',
            'tenderAwarded.tenderProgresses',
        ])->findOrFail($id);

        $awardedTender = $progressTender->tenderAwarded;
        $participate = $awardedTender->tenderParticipate;
        $tender = $participate->tender;

        // Decode items from JSON safely
        $items = is_array($tender->items) ? $tender->items : json_decode($tender->items, true);
        $items = is_array($items) ? $items : [];

        // Calculate grand total from items
        $grandTotal = collect($items)->sum(function ($item) {
            return ((float) ($item['quantity'] ?? 0)) * ((float) ($item['unit_price'] ?? 0));
        });

        // Prepare sorted participants with position
        $participants = $participate->companies->map(function ($company) {
            return [
                'company_name' => $company->company_name,
                'offered_price' => $company->offered_price ?? 0,
            ];
        })->sortBy('offered_price')->values();

        $currentTenderParticipants = collect([
            'Participants' => $participants
        ]);

        // Deliveries
        $singleDelivery = $awardedTender->singleDelivery;
        $partialDeliveries = $awardedTender->partialDeliveries ?? [];

        // PG fallback
        $pg = $awardedTender->pg ?? (object) [
            'pg_no' => '',
            'issue_in_bank' => '',
            'issue_in_branch' => '',
            'issue_date' => null,
            'expiry_date' => null,
            'amount' => '',
            'attachment' => ''
        ];

        // Letters
        $query = TenderLetter::where('tender_id', $tender->id);
        $participateLetters = (clone $query)->where('type', 1)->latest()->get();
        $awardedLetters = (clone $query)->where('type', 2)->latest()->get();
        $progressLetters = (clone $query)->where('type', 3)->latest()->get();

        // Tender progress list
        $progresses = TenderProgress::where('tender_awarded_id', $awardedTender->id)->latest()->get();

        return view('backend.tender.progress.show', compact(
            'tender',
            'awardedTender',
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
            'progresses',
            'progressTender',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $progressTender = TenderProgress::with([
            'tenderAwarded.tenderParticipate.tender',
            'tenderAwarded.tenderParticipate.companies',
            'tenderAwarded.tenderParticipate.bg',
            'tenderAwarded.singleDelivery',
            'tenderAwarded.partialDeliveries',
            'tenderAwarded.pg'
        ])->findOrFail($id);

        $tenderParticipate = $progressTender->tenderAwarded->tenderParticipate ?? null;

        $items = json_decode($tenderParticipate->tender->items ?? '[]', true);

        $grandTotal = collect($items)->sum(function ($item) {
            return ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
        });

        $companies = $tenderParticipate->companies->map(function ($company) {
            return [
                'name'  => $company->company_name,
                'price' => number_format($company->offered_price, 2),
            ];
        });

        return view('backend.tender.progress.edit', [
            'progressTender'     => $progressTender,
            'tenderParticipate' => $tenderParticipate,
            'items'             => $items,
            'grandTotal'        => $grandTotal,
            'companies'         => $companies,
            'singleDelivery'    => $progressTender->tenderAwarded->singleDelivery ?? new \App\Models\TenderAwardedSingle(),
            'partialDeliveries' => $progressTender->tenderAwarded->partialDeliveries ?? collect(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            // 'tender_awarded_id' => 'required|exists:tender_awardeds,id',

            'is_delivered' => 'required|boolean',
            'challan_no' => 'nullable|required_if:is_delivered,1|string',
            'challan_date' => 'nullable|required_if:is_delivered,1|date',
            'challan_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'is_inspection_completed' => 'required|boolean',
            'inspection_complete_date' => 'nullable|required_if:is_inspection_completed,1|date',
            'is_inspection_accepted' => 'required|boolean',
            'inspection_accept_date' => 'nullable|required_if:is_inspection_accepted,1|date',
            // 'warranty_expiry_date' => 'nullable|required_if:is_inspection_accepted,1|date',

            'is_bill_submitted' => 'required|boolean',
            'bill_no' => 'nullable|required_if:is_bill_submitted,1|string',
            'bill_submit_date' => 'nullable|required_if:is_bill_submitted,1|date',
            'bill_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',

            'is_bill_received' => 'required|boolean',
            'bill_cheque_no' => 'nullable|required_if:is_bill_received,1|string',
            'bill_receive_date' => 'nullable|required_if:is_bill_received,1|date',
            'bill_bank_name' => 'nullable|required_if:is_bill_received,1|string',
            'bill_amount' => 'nullable|required_if:is_bill_received,1|numeric',
        ]);

        $tenderProgress = TenderProgress::findOrFail($id);

        // $tenderProgress->tender_awarded_id = $validated['tender_awarded_id'];
        $tenderProgress->is_delivered = $validated['is_delivered'];
        $tenderProgress->is_inspection_completed = $validated['is_inspection_completed'];
        $tenderProgress->is_inspection_accepted = $validated['is_inspection_accepted'];
        $tenderProgress->is_bill_submitted = $validated['is_bill_submitted'];
        $tenderProgress->is_bill_received = $validated['is_bill_received'];

        // ✅ Challan fields
        if ($request->is_delivered) {
            $tenderProgress->challan_no = $request->challan_no;
            $tenderProgress->challan_date = $request->challan_date;

            if ($request->hasFile('challan_doc')) {
                if ($tenderProgress->challan_doc && file_exists(public_path('uploads/documents/challan_docs/' . $tenderProgress->challan_doc))) {
                    unlink(public_path('uploads/documents/challan_docs/' . $tenderProgress->challan_doc));
                }

                $file = $request->file('challan_doc');
                $filename = time() . '_challan.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents/challan_docs'), $filename);
                $tenderProgress->challan_doc = $filename;
            }
        } else {
            // If delivery not done, nullify related fields
            $tenderProgress->challan_no = null;
            $tenderProgress->challan_date = null;
            $tenderProgress->challan_doc = null;
        }

        // Inspection complete fields
        if ($request->is_inspection_completed) {
            $tenderProgress->inspection_complete_date = $request->inspection_complete_date;
        } else {
            $tenderProgress->inspection_complete_date = null;
        }

        // Inspection accept fields
        if ($request->is_inspection_accepted) {
            $tenderProgress->inspection_accept_date = $request->inspection_accept_date;
            $tenderProgress->warranty_expiry_date = $request->warranty_expiry_date;
        } else {
            $tenderProgress->inspection_accept_date = null;
            $tenderProgress->warranty_expiry_date = null;
        }

        // ✅ Bill submitted fields
        if ($request->is_bill_submitted) {
            $tenderProgress->bill_no = $request->bill_no;
            $tenderProgress->bill_submit_date = $request->bill_submit_date;

            if ($request->hasFile('bill_doc')) {
                if ($tenderProgress->bill_doc && file_exists(public_path('uploads/documents/bill_docs/' . $tenderProgress->bill_doc))) {
                    unlink(public_path('uploads/documents/bill_docs/' . $tenderProgress->bill_doc));
                }

                $file = $request->file('bill_doc');
                $filename = time() . '_bill.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents/bill_docs'), $filename);
                $tenderProgress->bill_doc = $filename;
            }
        } else {
            $tenderProgress->bill_no = null;
            $tenderProgress->bill_submit_date = null;
            $tenderProgress->bill_doc = null;
        }

        // ✅ Bill received fields
        if ($request->is_bill_received) {
            $tenderProgress->bill_cheque_no = $request->bill_cheque_no;
            $tenderProgress->bill_receive_date = $request->bill_receive_date;
            $tenderProgress->bill_bank_name = $request->bill_bank_name;
            $tenderProgress->bill_amount = $request->bill_amount;
        } else {
            $tenderProgress->bill_cheque_no = null;
            $tenderProgress->bill_receive_date = null;
            $tenderProgress->bill_bank_name = null;
            $tenderProgress->bill_amount = null;
        }

        $tenderProgress->save();

        return redirect()->route('tender_progress.index')
            ->with('success', 'Progress Tender updated successfully.');
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
        $tProgress = TenderProgress::with('tenderAwarded.tenderParticipate.tender')
            ->whereHas('tenderAwarded.tenderParticipate', function ($q) use ($tenderId) {
                $q->where('tender_id', $tenderId);
            })
            ->firstOrFail();

        $tenderLetters = TenderLetter::with('tender')
            ->where('tender_id', $tenderId)
            ->where('type', '3') // Only Progress
            ->latest()
            ->get();

        return view('backend.tender.progress.letter', compact('tenderLetters', 'tenderId', 'tProgress'));
    }

    public function letterStore(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        $request->validate([
            'reference_no' => 'nullable|string',
            'remarks' => 'required|string',
            'value' => 'nullable|string',
            'date' => 'required|date',
            'document' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/documents/tender_letters/progress'), $filename);

        TenderLetter::create([
            'tender_id'    => $tender->id,
            'reference_no' => $request->reference_no,
            'remarks'      => $request->remarks,
            'value'      => $request->value,
            'date'         => $request->date,
            'document'     => $filename,
            'type'         => 3,
        ]);

        return redirect()->back()->with('success', 'Tender letter uploaded successfully.');
    }


    public function letterEdit($id)
    {
        $editLetter = TenderLetter::with('tender')->findOrFail($id);
        return view('backend.tender.progress.letter_edit', compact('editLetter'));
    }

    public function letterUpdate(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string',
            'date' => 'required|date',
            'value' => 'nullable|string',
            'document' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $letter = TenderLetter::findOrFail($id);
        $letter->remarks = $request->remarks;
        $letter->value = $request->value;
        $letter->date = $request->date;

        if ($request->hasFile('document')) {
            // Delete old file if exists
            $oldPath = public_path('uploads/documents/tender_letters/progress/' . $letter->document);
            if (file_exists($oldPath)) {
                unlink($oldPath); // remove old file
            }

            // Upload new file
            $file = $request->file('document');
            $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents/tender_letters/progress'), $filename);
            $letter->document = $filename;
        }


        $letter->save();

        return redirect()->route(
            'tender_progress.letter',
            $letter->tender_id
        )->with('success', 'Tender letter updated successfully.');
    }


    public function letterDestroy($id)
    {
        $letter = TenderLetter::findOrFail($id);
        if ($letter->document && file_exists(public_path('uploads/tender_letters/' . $letter->document))) {
            unlink(public_path('uploads/documents/tender_letters/participate' . $letter->document));
        }
        $letter->delete();

        return redirect()->back()->with('success', 'Letter deleted successfully.');
    }

    public function getTenderAwardedDetails($awardedId)
    {
        $tenderAwarded = TenderAwarded::with([
            'tenderParticipate.tender',
            'tenderParticipate.companies',
            'tenderParticipate.bg',
            'singleDelivery',
            'partialDeliveries',
            'pg'
        ])->find($awardedId);

        if (!$tenderAwarded) {
            return response()->json(['message' => 'Tender not found'], 404);
        }

        $tenderId = $tenderAwarded->tenderParticipate->tender->id;

        // Correct letters query
        $participateLetters = TenderLetter::where('tender_id', $tenderId)
            ->where('type', 1)
            ->latest()
            ->get();

        $awardedLetters = TenderLetter::where('tender_id', $tenderId)
            ->where('type', 2)
            ->latest()
            ->get();

        if (!$tenderAwarded || !$tenderAwarded->tenderParticipate || !$tenderAwarded->tenderParticipate->tender) {
            return response()->json(['message' => 'Tender details not found'], 404);
        }

        $tender = $tenderAwarded->tenderParticipate->tender;
        $participate = $tenderAwarded->tenderParticipate;

        return response()->json([
            'title' => $tender->title,
            'offer_no' => $participate->offer_no,
            'offer_date' => $participate->offer_date,
            'offer_validity' => $participate->offer_validity,
            'procuring_authority' => $tender->procuring_authority,
            'end_user' => $tender->end_user,
            'financial_year' => $tender->financial_year,
            'tender_type' => $tender->tender_type,
            'items' => is_string($tender->items) ? json_decode($tender->items, true) : $tender->items,
            'publication_date' => $tender->publication_date,
            'submission_date' => $tender->submission_date,
            'workorder_no' => $tenderAwarded->workorder_no,
            'workorder_date' => $tenderAwarded->workorder_date,
            'awarded_date' => $tenderAwarded->awarded_date,
            'delivery_type' => $tenderAwarded->delivery_type ?? '',


            'is_bg' => $participate->is_bg,
            'is_pg' => $tenderAwarded->is_pg,

            // Companies
            'companies' => $participate->companies->map(fn($company) => [
                'name' => $company->company_name,
                'price' => number_format($company->offered_price, 2) . ' ৳',
            ])->values(),

            // BG
            'bg' => ($participate->is_bg && $participate->bg) ? [
                'bg_no' => $participate->bg->bg_no,
                'issue_in_bank' => $participate->bg->issue_in_bank,
                'issue_in_branch' => $participate->bg->issue_in_branch,
                'issue_date' => $participate->bg->issue_date,
                'expiry_date' => $participate->bg->expiry_date,
                'amount' => $participate->bg->amount,
                'attachment' => $participate->bg->attachment,
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

            // PG
            'pg' => ($tenderAwarded->is_pg && $tenderAwarded->pg) ? [
                'pg_no' => $tenderAwarded->pg->pg_no,
                'issue_in_bank' => $tenderAwarded->pg->issue_in_bank,
                'issue_in_branch' => $tenderAwarded->pg->issue_in_branch,
                'issue_date' => $tenderAwarded->pg->issue_date,
                'expiry_date' => $tenderAwarded->pg->expiry_date,
                'amount' => $tenderAwarded->pg->amount,
                'attachment' => $tenderAwarded->pg->attachment,
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
        ]);
    }
}
