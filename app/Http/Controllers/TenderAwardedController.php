<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Tender;
use App\Models\PerformanceGuarantee;
use App\Models\TenderAwarded;
use App\Models\TenderProgress;
use App\Models\ParticipatedTender;
use App\Models\TenderCompleted;
use App\Models\TenderParticipate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Models\TenderLetter;

class TenderAwardedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TenderAwarded::with(['tenderParticipate.tender', 'tenderParticipate.companies'])
                ->whereHas('tenderParticipate.tender', function ($query) {
                    $query->where('status', '!=', 4);
                })
                ->join('tender_participates', 'tender_awardeds.tender_participate_id', '=', 'tender_participates.id')
                ->join('tenders', 'tender_participates.tender_id', '=', 'tenders.id')
                ->orderBy('tenders.submission_date', 'desc')
                ->select('tender_awardeds.*')
                ->get();

            // ✅ Pull first organization for current user
            $organization = Organization::first();
            $orgName = $organization->name ?? null;

            return DataTables::of($data)
                ->addIndexColumn()

                // Tender No
                ->addColumn('tender_no', function ($row) {
                    $tenderNo = optional($row->tenderParticipate->tender)->tender_no;

                    return $tenderNo
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box">' . e($tenderNo) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Title
                ->addColumn('title', function ($row) {
                    $title = optional($row->tenderParticipate->tender)->title;

                    return $title
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box">' . e($title) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Tender Type
                ->addColumn('tender_type', function ($row) {
                    $tenderType = optional($row->tenderParticipate->tender)->tender_type;

                    return $tenderType
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box">' . e($tenderType) . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Publication Date
                ->addColumn('publication_date', function ($row) {
                    $publicationDate = optional($row->tenderParticipate->tender)->publication_date;

                    return $publicationDate
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box">'
                        . \Carbon\Carbon::parse($publicationDate)->format('d F Y') .
                        '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                // Submission Date
                ->addColumn('submission_date', function ($row) {
                    $submissionDate = optional($row->tenderParticipate->tender)->submission_date;

                    return $submissionDate
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box">' . \Carbon\Carbon::parse($submissionDate)->format('d F Y') . '</a>'
                        : '<span class="text-muted">N/A</span>';
                })

                ->addColumn(
                    'workorder_no',
                    fn($row) =>
                    '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box" title="' . e($row->workorder_no ?? '-') . '">' .
                        e($row->workorder_no ?? '-') .
                        '</a>'
                )

                ->editColumn(
                    'workorder_date',
                    fn($row) =>
                    $row->workorder_date
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box" title="' . Carbon::parse($row->workorder_date)->format('d-F-Y') . '">' .
                        Carbon::parse($row->workorder_date)->format('d-F-Y') .
                        '</a>'
                        : '-'
                )

                ->editColumn(
                    'awarded_date',
                    fn($row) =>
                    $row->awarded_date
                        ? '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box" title="' . Carbon::parse($row->awarded_date)->format('d-F-Y') . '">' .
                        Carbon::parse($row->awarded_date)->format('d-F-Y') .
                        '</a>'
                        : '-'
                )

                ->editColumn(
                    'delivery_type',
                    fn($row) =>
                    '<a href="' . route('awarded_tenders.show', $row->id) . '" class="hover-box" title="' . ($row->delivery_type === '1' ? 'Single' : 'Partial') . '">' .
                        ($row->delivery_type === '1' ? 'Single' : 'Partial') .
                        '</a>'
                )

                ->addColumn('position', function ($t) use ($orgName) {
                    $participate = $t->tenderParticipate;

                    if (!$participate || !$participate->relationLoaded('companies')) {
                        return '<span class="text-muted">N/A</span>';
                    }

                    $companies = $participate->companies
                        ->filter(fn($c) => !is_null($c->offered_price))
                        ->sortBy('offered_price')
                        ->values();

                    if ($companies->isEmpty()) {
                        return '<span class="text-muted">N/A</span>';
                    }

                    $position = $companies->search(fn($c) => $c->company_name === $orgName);

                    if ($position === false) {
                        return '<span class="text-muted">N/A</span>';
                    }

                    $place = $position + 1;

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
                        10 => 'Tenth'
                    ];

                    $label = $words[$place] ?? $place . 'th';

                    return '<a href="' . route('awarded_tenders.show', $t->id) . '" class="hover-box" title="Your company\'s rank: ' . $label . '">' . $label . '</a>';
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('awarded_tenders.edit', $row->id);
                    $letterUrl = route('awarded_tenders.letter', $row->tenderParticipate->tender->id);
                    return '<div class="d-flex gap-1">
                    <a href="' . $editUrl . '" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                         <a href="' . $letterUrl . '" class="btn btn-sm btn-primary" title="Letter">
                                <i class="fas fa-envelope"></i>
                            </a></div>';
                })

                ->rawColumns([
                    'tender_no',
                    'title',
                    'tender_type',
                    'type',
                    'workorder_no',
                    'publication_date',
                    'submission_date',
                    'workorder_date',
                    'awarded_date',
                    'delivery_type',
                    'position',
                    'action'
                ])
                ->make(true);
        }

        return view('backend.tender.awarded.index');
    }

    public function create()
    {
        $participateTenders = TenderParticipate::with(['tender:id,tender_no,title,status'])
            ->whereHas('tender', function ($query) {
                $query->whereNotIn('status', [3, 4]); // ✅ exclude both 3 and 4
            })
            ->latest()
            ->get();

        return view('backend.tender.awarded.create', [
            'participateTenders' => $participateTenders,
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'tender_participate_id' => 'required|exists:tender_participates,id',
            'items' => 'required|array|min:1',
            'items.*.item' => 'required|string',
            'items.*.deno' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
            'workorder_no' => 'required|string',
            'workorder_date' => 'required|date',
            'workorder_doc' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'awarded_date' => 'required|date',
            'delivery_type' => 'required|in:1,partial',
        ];

        if ($request->is_pg == 1) {
            $pgRules = [
                'pg_no' => 'required|string|max:255',
                'issue_in_bank' => 'required|string|max:255',
                'issue_in_branch' => 'required|string|max:255',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after_or_equal:issue_date',
                'amount' => 'required|numeric|min:0',
                'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ];
            $rules = array_merge($rules, $pgRules);
        }

        // ✅ Validate
        $validated = $request->validate($rules);

        // ✅ Save Workorder File
        $workorderDoc = $request->file('workorder_doc');
        $workorderDocName = now()->format('Ymd_His') . '_workorder.' . $workorderDoc->getClientOriginalExtension();
        $workorderDoc->move(public_path('uploads/documents/workorder_docs/'), $workorderDocName);

        // ✅ Save Awarded Tender
        $awardedTender = new TenderAwarded();
        $awardedTender->tender_participate_id = $validated['tender_participate_id'];
        $awardedTender->workorder_no = $validated['workorder_no'];
        $awardedTender->workorder_date = $validated['workorder_date'];
        $awardedTender->workorder_doc = $workorderDocName;
        $awardedTender->awarded_date = $validated['awarded_date'];
        $awardedTender->delivery_type = $validated['delivery_type'];
        $awardedTender->is_pg = $request->is_pg == 1 ? 1 : 0;
        $awardedTender->save();

        // ✅ Update TenderParticipate and Tender
        $tenderParticipate = TenderParticipate::with('tender')->find($validated['tender_participate_id']);
        $tenderParticipate->is_awarded = 1;
        $tenderParticipate->save();

        $tender = $tenderParticipate->tender;
        $tender->is_awarded = 1;
        $tender->status = 3;
        $tender->save();

        // ✅ Handle Delivery Info
        $awardedTender->singleDelivery()->delete();
        $awardedTender->partialDeliveries()->delete();

        if ($validated['delivery_type'] === '1') {
            $delivery = $request->input('deliveries.0');
            if ($delivery) {
                $awardedTender->singleDelivery()->create([
                    'delivery_item' => $delivery['delivery_item'],
                    'delivery_date' => $delivery['delivery_date'],
                    'warranty' => $delivery['warranty'] ?? null,
                ]);
            }
        } elseif ($validated['delivery_type'] === 'partial') {
            foreach ($request->input('partial_deliveries', []) as $d) {
                if (!empty($d['delivery_item']) && !empty($d['delivery_date'])) {
                    $awardedTender->partialDeliveries()->create([
                        'delivery_item' => $d['delivery_item'],
                        'delivery_date' => $d['delivery_date'],
                        'warranty' => $d['warranty'] ?? null,
                    ]);
                }
            }
        }

        // ✅ Store PG Attachment if any
        if ($request->is_pg == 1 && $request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/documents/pg_attachments');
            $file->move($destinationPath, $filename);

            $awardedTender->pg()->create([
                'pg_no' => $validated['pg_no'],
                'issue_in_bank' => $validated['issue_in_bank'],
                'issue_in_branch' => $validated['issue_in_branch'],
                'issue_date' => $validated['issue_date'],
                'expiry_date' => $validated['expiry_date'],
                'amount' => $validated['amount'],
                'attachment' => $filename,
            ]);
        }

        return redirect()->route('awarded_tenders.index')->with('success', 'Awarded Tender saved successfully.');
    }


    public function edit($id)
    {
        $awardedTender = TenderAwarded::with([
            'tenderParticipate.tender',
            'tenderParticipate.companies',
            'tenderParticipate.bg',
            'singleDelivery',
            'partialDeliveries',
            'pg'
        ])->findOrFail($id);

        $tenderParticipate = $awardedTender->tenderParticipate;

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

        return view('backend.tender.awarded.edit', [
            'awardedTender'     => $awardedTender,
            'tenderParticipate' => $tenderParticipate,
            'items'             => $items,
            'grandTotal'        => $grandTotal,
            'companies'         => $companies,
            'singleDelivery'    => $awardedTender->singleDelivery ?? new \App\Models\TenderAwardedSingle(),
            'partialDeliveries' => $awardedTender->partialDeliveries ?? collect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'tender_participate_id' => 'required|exists:tender_participates,id',
            'items' => 'required|array|min:1',
            'items.*.item' => 'required|string',
            'items.*.deno' => 'nullable|string',
            'items.*.quantity' => 'required|numeric|min:0',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.total_price' => 'required|numeric|min:0',
            'workorder_no' => 'required|string',
            'workorder_date' => 'required|date',
            'workorder_doc' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            'awarded_date' => 'required|date',
            'delivery_type' => 'required|in:1,partial',
        ];

        if ($request->is_pg == 1) {
            $rules = array_merge($rules, [
                'pg_no' => 'required|string|max:255',
                'issue_in_bank' => 'required|string|max:255',
                'issue_in_branch' => 'required|string|max:255',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after_or_equal:issue_date',
                'amount' => 'required|numeric|min:0',
                'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);
        }

        $validated = $request->validate($rules);

        $awardedTender = TenderAwarded::findOrFail($id);

        // Handle workorder document update
        if ($request->hasFile('workorder_doc')) {
            // Delete old file if exists
            if ($awardedTender->workorder_doc && file_exists(public_path('uploads/documents/workorder_docs/' . $awardedTender->workorder_doc))) {
                unlink(public_path('uploads/documents/workorder_docs/' . $awardedTender->workorder_doc));
            }

            $file = $request->file('workorder_doc');
            $filename = time() . '_workorder.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents/workorder_docs'), $filename);
            $awardedTender->workorder_doc = $filename;
        }

        $awardedTender->tender_participate_id = $validated['tender_participate_id'];
        $awardedTender->workorder_no = $validated['workorder_no'];
        $awardedTender->workorder_date = $validated['workorder_date'];
        $awardedTender->awarded_date = $validated['awarded_date'];
        $awardedTender->delivery_type = $validated['delivery_type'];
        $awardedTender->is_pg = $request->is_pg == 1 ? 1 : 0;
        $awardedTender->save();

        // Update related TenderParticipate and Tender
        $tenderParticipate = TenderParticipate::with('tender')->find($validated['tender_participate_id']);
        $tenderParticipate->is_awarded = 1;
        $tenderParticipate->save();

        $tender = $tenderParticipate->tender;
        $tender->is_awarded = 1;
        $tender->status = 3;
        $tender->save();

        // Clear existing deliveries
        $awardedTender->singleDelivery()->delete();
        $awardedTender->partialDeliveries()->delete();

        // Add updated delivery info
        if ($validated['delivery_type'] === '1') {
            $delivery = $request->input('deliveries.0');
            if ($delivery) {
                $awardedTender->singleDelivery()->create([
                    'delivery_item' => $delivery['delivery_item'],
                    'delivery_date' => $delivery['delivery_date'],
                    'warranty' => $delivery['warranty'] ?? null,
                ]);
            }
        } else {
            foreach ($request->input('partial_deliveries', []) as $d) {
                if (!empty($d['delivery_item']) && !empty($d['delivery_date'])) {
                    $awardedTender->partialDeliveries()->create([
                        'delivery_item' => $d['delivery_item'],
                        'delivery_date' => $d['delivery_date'],
                        'warranty' => $d['warranty'] ?? null,
                    ]);
                }
            }
        }

        // Handle PG update
        $pg = $awardedTender->pg;
        $pgFilename = $pg?->attachment;

        if ($request->is_pg == 1) {
            if ($request->hasFile('attachment')) {
                if ($pg && $pg->attachment && file_exists(public_path('uploads/documents/pg_attachments/' . $pg->attachment))) {
                    unlink(public_path('uploads/documents/pg_attachments/' . $pg->attachment));
                }

                $timestamp = date('Ymd_His');
                $file = $request->file('attachment');
                $extension = $file->getClientOriginalExtension();
                $pgFilename = "{$timestamp}_pg.{$extension}";
                $file->move(public_path('uploads/documents/pg_attachments'), $pgFilename);
            }

            if ($pg) {
                $pg->update([
                    'pg_no' => $validated['pg_no'],
                    'issue_in_bank' => $validated['issue_in_bank'],
                    'issue_in_branch' => $validated['issue_in_branch'],
                    'issue_date' => $validated['issue_date'],
                    'expiry_date' => $validated['expiry_date'],
                    'amount' => $validated['amount'],
                    'attachment' => $pgFilename,
                ]);
            } else {
                $awardedTender->pg()->create([
                    'pg_no' => $validated['pg_no'],
                    'issue_in_bank' => $validated['issue_in_bank'],
                    'issue_in_branch' => $validated['issue_in_branch'],
                    'issue_date' => $validated['issue_date'],
                    'expiry_date' => $validated['expiry_date'],
                    'amount' => $validated['amount'],
                    'attachment' => $pgFilename,
                ]);
            }
        } else {
            if ($pg) {
                if ($pg->attachment && file_exists(public_path('uploads/documents/pg_attachments/' . $pg->attachment))) {
                    unlink(public_path('uploads/documents/pg_attachments/' . $pg->attachment));
                }
                $pg->delete();
            }
        }

        return redirect()->route('awarded_tenders.index')->with('success', 'Awarded Tender updated successfully.');
    }

    public function show($id)
    {
        // Load awarded tender with all necessary relationships
        $awardedTender = TenderAwarded::with([
            'tenderParticipate.tender',
            'tenderParticipate.companies',
            'tenderParticipate.bg',
            'pg',
            'singleDelivery',
            'partialDeliveries',
        ])->findOrFail($id);

        $participate = $awardedTender->tenderParticipate;
        $tender = $participate->tender;

        // Decode items from JSON
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

        // Load delivery and PG info
        $singleDelivery = $awardedTender->singleDelivery;
        $partialDeliveries = $awardedTender->partialDeliveries ?? [];

        // ✅ Avoid null PG by assigning an empty object with default properties
        $pg = $awardedTender->pg ?? (object) [
            'pg_no' => '',
            'issue_in_bank' => '',
            'issue_in_branch' => '',
            'issue_date' => null,
            'expiry_date' => null,
            'amount' => '',
            'attachment' => ''
        ];

        $query = TenderLetter::where('tender_id', $awardedTender->tenderParticipate->tender_id);

        $participateLetters = (clone $query)->where('type', 1)->latest()->get();
        $awardedLetters = (clone $query)->where('type', 2)->latest()->get();

        // Send everything to view
        return view('backend.tender.awarded.show', compact(
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
            'awardedLetters'
        ));
    }

    public function getTenderParticipateDetails($tenderId)
    {
        $tenderParticipate = TenderParticipate::with(['tender', 'companies', 'bg'])
            ->where('tender_id', $tenderId)
            ->first();

        if (!$tenderParticipate) {
            return response()->json(['message' => 'Tender Participate not found'], 404);
        }

        // Fetch letters for this tender where type = 1
        $tenderLetters = TenderLetter::where('tender_id', $tenderId)
            ->where('type', 1)
            ->latest()
            ->get();

        return response()->json([
            'title' => $tenderParticipate->tender->title,
            'offer_no' => $tenderParticipate->offer_no,
            'offer_date' => $tenderParticipate->offer_date,
            'offer_validity' => $tenderParticipate->offer_validity,
            'procuring_authority' => $tenderParticipate->tender->procuring_authority,
            'end_user' => $tenderParticipate->tender->end_user,
            'financial_year' => $tenderParticipate->tender->financial_year,
            'tender_type' => $tenderParticipate->tender->tender_type,
            'items' => $tenderParticipate->tender->items,
            'publication_date' => $tenderParticipate->tender->publication_date,
            'submission_date' => $tenderParticipate->tender->submission_date,
            'is_bg' => $tenderParticipate->is_bg,

            'companies' => $tenderParticipate->companies->map(function ($company) {
                return [
                    'name' => $company->company_name,
                    'price' => number_format($company->offered_price, 2) . ' ৳',
                ];
            }),

            'bg' => ($tenderParticipate->is_bg == 1 && $tenderParticipate->bg)
                ? [
                    'bg_no' => $tenderParticipate->bg->bg_no,
                    'issue_in_bank' => $tenderParticipate->bg->issue_in_bank,
                    'issue_in_branch' => $tenderParticipate->bg->issue_in_branch,
                    'issue_date' => $tenderParticipate->bg->issue_date,
                    'expiry_date' => $tenderParticipate->bg->expiry_date,
                    'amount' => $tenderParticipate->bg->amount,
                    'attachment' => $tenderParticipate->bg->attachment,
                ]
                : null,

            // Send letters to the view/JS
            'letters' => $tenderLetters->map(function ($letter, $index) {
                return [
                    'sl'           => $index + 1,
                    'reference_no' => $letter->reference_no,
                    'remarks'      => $letter->remarks,
                    'value'        => $letter->value,
                    'date'         => $letter->date
                        ? \Carbon\Carbon::parse($letter->date)->format('d M, Y')
                        : '',
                    'document'     => $letter->document
                        ? asset('uploads/documents/tender_letters/participate/' . $letter->document)
                        : null,
                ];
            }),
        ]);
    }

    public function letter($tenderId)
    {
        // Find the awarded record by tender_id via relationship
        $tAwarded = TenderAwarded::with('tenderParticipate.tender')
            ->whereHas('tenderParticipate', function ($q) use ($tenderId) {
                $q->where('tender_id', $tenderId);
            })
            ->firstOrFail(); // will throw 404 if not found

        // Fetch letters for this tender
        $tenderLetters = TenderLetter::with('tender')
            ->where('tender_id', $tenderId)
            ->where('type', '2') // Only Awarded
            ->latest()
            ->get();

        return view('backend.tender.awarded.letter', compact('tenderLetters', 'tAwarded', 'tenderId'));
    }


    public function letterStore(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        $request->validate([
            'reference_no' => 'nullable|string',
            'remarks' => 'required|string',
            'value' => ' nullable|string',
            'date' => 'required|date',
            'document' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/documents/tender_letters/awarded'), $filename);

        TenderLetter::create([
            'tender_id'    => $tender->id,
            'reference_no' => $request->reference_no,
            'remarks'      => $request->remarks,
            'value'      => $request->value,
            'date'         => $request->date,
            'document'     => $filename,
            'type'         => 2,
        ]);

        return redirect()->back()->with('success', 'Tender letter uploaded successfully.');
    }


    public function letterEdit($id)
    {
        $editLetter = TenderLetter::with('tender')->findOrFail($id);
        return view('backend.tender.awarded.letter_edit', compact('editLetter'));
    }

    public function letterUpdate(Request $request, $id)
    {
        $request->validate([
            'reference_no' => 'required|string',
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
            $oldPath = public_path('uploads/documents/tender_letters/awarded/' . $letter->document);
            if (file_exists($oldPath)) {
                unlink($oldPath); // remove old file
            }

            // Upload new file
            $file = $request->file('document');
            $filename = now()->format('Ymd_His') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents/tender_letters/awarded'), $filename);
            $letter->document = $filename;
        }


        $letter->save();

        return redirect()->route('awarded_tenders.letter.edit', $id)
            ->with('success', 'Tender letter updated successfully.');
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
}
