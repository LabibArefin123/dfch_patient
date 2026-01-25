<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\BigGuarantee;
use App\Models\Tender;
use App\Models\TenderLetter;
use App\Models\TenderParticipate;
use App\Models\TenderParticipateCompany;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TenderParticipatedController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $tenderParticipates = TenderParticipate::with('tender', 'companies')
                ->whereHas('tender', fn($q) => $q->where('status', 2))
                ->select('tender_participates.*')
                ->selectRaw('(SELECT submission_date FROM tenders WHERE tenders.id = tender_participates.tender_id) as submission_date')
                ->orderBy('submission_date', 'desc');

            $organization = Organization::first();
            $orgName = $organization->name ?? null;

            return DataTables::of($tenderParticipates)
                ->addIndexColumn()

                // Status
                ->editColumn('status', fn($t) => '<span class="badge bg-success">Participated</span>')

                // Tender No
                ->addColumn('tender_no', fn($t) => optional($t->tender)->tender_no
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . e($t->tender->tender_no) . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Title
                ->addColumn('title', fn($t) => optional($t->tender)->title
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . e($t->tender->title) . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Procuring Authority
                ->addColumn('procuring_authority', fn($t) => optional($t->tender)->procuring_authority
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . e($t->tender->procuring_authority) . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // End User
                ->addColumn('end_user', fn($t) => optional($t->tender)->end_user
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . e($t->tender->end_user) . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Publication Date
                ->editColumn('publication_date', fn($t) => optional($t->tender)->publication_date
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . \Carbon\Carbon::parse($t->tender->publication_date)->format('d-F-Y') . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Submission Date
                ->editColumn('submission_date', fn($t) => optional($t->tender)->submission_date
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . \Carbon\Carbon::parse($t->tender->submission_date)->format('d-F-Y') . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Submission Time
                ->editColumn('submission_time', fn($t) => optional($t->tender)->submission_time
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . \Carbon\Carbon::parse($t->tender->submission_time)->format('h:i A') . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Offered Price
                ->addColumn('offered_price', function ($t) use ($orgName) {
                    $company = $t->companies->where('company_name', $orgName)->first();
                    if ($company && $company->offered_price) {
                        return '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">'
                            . number_format($company->offered_price, 2) . ' ৳</a>';
                    }
                    return '<span class="text-muted">N/A</span>';
                })

                // Offer Date
                ->addColumn('offer_date', function ($t) {
                    $offerDate = optional($t)->offer_date;

                    if ($offerDate) {
                        $formatted = \Carbon\Carbon::parse($offerDate)->format('d-F-Y');
                        return '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . $formatted . '</a>';
                    }

                    return '<span class="text-muted">N/A</span>';
                })

                // Offer Validity
                ->addColumn('offer_validity', function ($t) {
                    $offerValidity = optional($t)->offer_validity;

                    if ($offerValidity) {
                        $formatted = \Carbon\Carbon::parse($offerValidity)->format('d-F-Y');
                        return '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . $formatted . '</a>';
                    }

                    return '<span class="text-muted">N/A</span>';
                })

                // Position
                ->addColumn('position', function ($t) use ($orgName) {
                    $companies = $t->companies->filter(fn($c) => !is_null($c->offered_price))->sortBy('offered_price')->values();
                    $position = $companies->search(fn($c) => $c->company_name === $orgName);
                    if ($position === false) return '<span class="text-muted">N/A</span>';
                    $place = $position + 1;
                    $words = [1 => 'First', 2 => 'Second', 3 => 'Third', 4 => 'Fourth', 5 => 'Fifth', 6 => 'Sixth', 7 => 'Seventh', 8 => 'Eighth', 9 => 'Ninth', 10 => 'Tenth'];
                    return $words[$place] ?? $place . 'th';
                })

                // Financial Year
                ->addColumn('financial_year', fn($t) => optional($t->tender)->financial_year
                    ? '<a href="' . route('participated_tenders.show', $t->id) . '" class="hover-box">' . e($t->tender->financial_year) . '</a>'
                    : '<span class="text-muted">N/A</span>')

                // Notice & Spec Files
                ->addColumn('noticeFile', fn($t) => optional($t->tender)->notice_file
                    ? '<a href="' . route('tenders.downloadNotice', $t->tender->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-download"></i></a>'
                    : '<span class="text-muted">No Notice</span>')
                ->addColumn('specFile', fn($t) => optional($t->tender)->spec_file
                    ? '<a href="' . route('tenders.downloadSpec', $t->tender->id) . '" class="btn btn-info btn-sm"><i class="fas fa-download"></i></a>'
                    : '<span class="text-muted">No Spec</span>')

                // Actions
                ->addColumn('action', fn($t) => '
                <div class="d-flex gap-1">
                    <a href="' . route('participated_tenders.edit', $t->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                    <a href="' . route('participated_tenders.letter', $t->tender_id) . '" class="btn btn-sm btn-primary" title="Letter"><i class="fas fa-envelope"></i></a>
                </div>')

                ->rawColumns([
                    'status',
                    'tender_no',
                    'title',
                    'procuring_authority',
                    'end_user',
                    'publication_date',
                    'submission_date',
                    'submission_time',
                    'offered_price',
                    'offer_date',
                    'offer_validity',
                    'financial_year',
                    'noticeFile',
                    'specFile',
                    'action'
                ])
                ->make(true);
        }

        return view('backend.tender.participate.index');
    }


    public function create()
    {
        $now = now();

        // ✅ Get tender IDs that already have participation records
        $participatedTenderIds = \App\Models\TenderParticipate::pluck('tender_id')->toArray();
        $organization = Organization::first();

        // ✅ Fetch tenders:
        // - Expired (status 0 AND submission_date < now)
        // - OR Participated (status 2)
        // - Exclude pending ones (status 0 with future submission date)
        $tenders = Tender::where(function ($q) use ($now) {
            $q->where(function ($sub) use ($now) {
                $sub->where('status', 0)
                    ->whereRaw("STR_TO_DATE(CONCAT(submission_date,' ',submission_time), '%Y-%m-%d %H:%i:%s') < ?", [$now]);
            })
                ->orWhere('status', 2);
        })
            ->whereNotIn('id', $participatedTenderIds)
            ->latest()
            ->get();

        // ✅ Default today's date tab for new companies
        $today = Carbon::today()->format('Y-m-d');

        // ✅ Initialize with one blank row for today's date
        $groupedCompanies = collect([
            $today => collect([
                (object)[
                    'company_name' => '',
                    'offered_price' => '',
                ]
            ])
        ]);

        return view('backend.tender.participate.create', compact('tenders', 'groupedCompanies', 'today', 'organization'));
    }


    public function store(Request $request)
    {
        // dd($request->all());
        $rules = [
            'tender_id' => 'required|exists:tenders,id',
            'offer_no' => 'required|string|max:255',
            'offer_date' => 'required|date',
            'offer_validity' => 'required|date',
            'offer_doc' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ];

        // Validate base inputs
        $request->validate($rules);

        // Nested tender_participates validation
        if ($request->has('tender_participates')) {
            foreach ($request->input('tender_participates') as $date => $companies) {
                foreach ($companies as $index => $company) {
                    $request->validate([
                        "tender_participates.$date.$index.company" => 'required|string|max:255',
                        "tender_participates.$date.$index.price" => 'required|numeric|min:0',
                    ]);
                }
            }
        }
        // Bank Guarantee validation if is_bg == 1
        if ($request->is_bg == 1) {
            $request->validate([
                'bg_no' => 'required|string|max:255',
                'issue_in_bank' => 'required|string|max:255',
                'issue_in_branch' => 'required|string|max:255',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after_or_equal:issue_date',
                'amount' => 'required|numeric|min:0',
                'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            ]);
        }

        DB::beginTransaction();

        try {
            // Load Tender model
            $tender = Tender::findOrFail($request->tender_id);

            // Save items if provided
            if ($request->has('items') && is_array($request->items)) {
                $items = collect($request->items)->map(function ($item) {
                    return [
                        'item' => $item['item'] ?? null,
                        'deno' => $item['deno'] ?? null,
                        'quantity' => $item['quantity'] ?? null,
                        'unit_price' => $item['unit_price'] ?? null,
                        'total_price' => $item['total_price'] ?? null,
                    ];
                });
                $tender->items = $items->toJson();
                $tender->save();
            }

            // Create TenderParticipate
            $participation = new TenderParticipate();
            $participation->tender_id = $request->tender_id;
            $participation->offer_no = $request->offer_no;
            $participation->offer_date = $request->offer_date;
            $participation->offer_validity = $request->offer_validity;
            $participation->is_bg = $request->is_bg ?? 0;

            if ($request->hasFile('offer_doc')) {
                $file = $request->file('offer_doc');
                $filename = time() . '_offer_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/documents/offer_docs'), $filename);
                $participation->offer_doc = $filename;
            }

            $participation->save();

            // Save participate companies
            if ($request->has('tender_participates')) {
                foreach ($request->input('tender_participates') as $date => $companies) {
                    foreach ($companies as $companyData) {
                        TenderParticipateCompany::create([
                            'tender_participate_id' => $participation->id,
                            'company_name' => $companyData['company'],
                            'offered_price' => $companyData['price'],
                            'participated_on' => $date,
                        ]);
                    }
                }
            }

            // Save Bank Guarantee if applicable
            if ($request->is_bg == 1) {
                $bg = new BigGuarantee();
                $bg->tender_participate_id = $participation->id;
                $bg->bg_no = $request->bg_no;
                $bg->issue_in_bank = $request->issue_in_bank;
                $bg->issue_in_branch = $request->issue_in_branch;
                $bg->issue_date = $request->issue_date;
                $bg->expiry_date = $request->expiry_date;
                $bg->amount = $request->amount;

                if ($request->hasFile('attachment')) {
                    $bgFile = $request->file('attachment');
                    $bgFilename = time() . '_bg_' . $bgFile->getClientOriginalName();
                    $bgFile->move(public_path('uploads/documents/bg_attachments'), $bgFilename);
                    $bg->attachment = $bgFilename;
                }

                $bg->save();
            }

            $tender->update([
                'is_participate' => 1, // True or Yes
                'status' => 2, // Status 2 means participated
            ]);

            DB::commit();

            return redirect()->route('participated_tenders.index')
                ->with('success', 'Participated Tender added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $participated = TenderParticipate::with(['tender', 'companies'])->findOrFail($id);
        $tender = $participated->tender;

        // Load items from 'offer_items' (if exists), fallback to tender items
        $items = $participated->offer_items ?? $tender->items;

        $items = is_array($items) ? $items : json_decode($items, true);
        $items = is_array($items) ? $items : [];

        // Calculate grand total
        $grandTotal = collect($items)->sum(function ($item) {
            return ((float) ($item['quantity'] ?? 0)) * ((float) ($item['unit_price'] ?? 0));
        });

        // All companies who participated under this tender_participate_id
        $allCompanies = $participated->companies;

        // Group them by participated_on date
        $currentTenderParticipants = $allCompanies->groupBy(function ($item) {
            return \Carbon\Carbon::parse($item->participated_on)->format('Y-m-d');
        });

        $query = TenderLetter::where('tender_id', $participated->tender_id);
        $participateLetters = $query->where('type', 1)->latest()->get();

        return view('backend.tender.participate.show', compact(
            'participated',
            'tender',
            'items',
            'grandTotal',
            'currentTenderParticipants',
            'participateLetters'
        ));
    }

    public function edit($id)
    {
        $tenderParticipate = TenderParticipate::with('tender', 'companies', 'bg')->findOrFail($id);

        // Return a flat list of companies, but still use the name `$groupedCompanies`
        $groupedCompanies = $tenderParticipate->companies;

        return view('backend.tender.participate.edit', compact('tenderParticipate', 'groupedCompanies'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'tender_id' => 'required|string|max:255',
            // 'offered_price' => 'required|numeric',
            'offer_date' => 'required|date',
            'offer_validity' => 'required|date',
            'offer_doc' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ];

        if ($request->is_bg == 1) {
            $rules = array_merge($rules, [
                'bg_no' => 'required|string|max:255',
                'issue_in_bank' => 'required|string|max:255',
                'issue_in_branch' => 'required|string|max:255',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date|after_or_equal:issue_date',
                'amount' => 'required|numeric|min:0',
                'attachment' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png',
            ]);
        }

        $request->validate($rules);

        $tenderParticipate = TenderParticipate::with('tender', 'companies')->findOrFail($id);
        $tender = $tenderParticipate->tender;

        if (!$tender) {
            abort(404, 'Related Tender not found.');
        }

        // ✅ Update offer_doc if uploaded
        if ($request->hasFile('offer_doc')) {
            $existingPath = public_path('uploads/documents/offer_docs/' . $tenderParticipate->offer_doc);
            if ($tenderParticipate->offer_doc && file_exists($existingPath)) {
                unlink($existingPath);
            }

            $file = $request->file('offer_doc');
            $filename = time() . '_offer_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents/offer_docs'), $filename);
            $tenderParticipate->offer_doc = $filename;
        }

        // ✅ Update main fields
        $tenderParticipate->tender_id = $request->tender_id;
        // $tenderParticipate->offered_price = $request->offered_price;
        $tenderParticipate->offer_date = $request->offer_date;
        $tenderParticipate->offer_validity = $request->offer_validity;
        $tenderParticipate->is_bg = $request->is_bg == 1 ? 1 : 0;
        $tenderParticipate->save();

        // ✅ Update tender record
        $tender->status = 2;
        $tender->is_participate = 1;

        if ($request->has('items')) {
            $tender->items = collect($request->items)->map(function ($item) {
                return [
                    'item' => $item['item'] ?? null,
                    'deno' => $item['deno'] ?? null,
                    'quantity' => $item['quantity'] ?? null,
                    'unit_price' => $item['unit_price'] ?? null,
                    'total_price' => $item['total_price'] ?? null,
                ];
            })->toJson();
        }

        $tender->save();

        if ($request->has('tender_participates')) {
            foreach ($request->tender_participates as $data) {
                $companyName = $data['company'] ?? null;
                $price = $data['offered_price'] ?? $data['price'] ?? null;

                if (!$companyName || !$price) {
                    continue;
                }

                $pc = $tenderParticipate->companies
                    ->where('company_name', $companyName)
                    ->first() ?? new \App\Models\TenderParticipateCompany();

                $pc->tender_participate_id = $tenderParticipate->id;
                $pc->company_name = $companyName;
                $pc->offered_price = $price;
                $pc->save();
            }
        }

        // ✅ Update BG info
        if ($request->is_bg == 1 && $request->filled([
            'bg_no',
            'issue_in_bank',
            'issue_in_branch',
            'issue_date',
            'expiry_date',
            'amount'
        ])) {
            $bg = BigGuarantee::firstOrNew([
                'tender_participate_id' => $tenderParticipate->id
            ]);

            $bg->fill([
                'bg_no' => $request->bg_no,
                'issue_in_bank' => $request->issue_in_bank,
                'issue_in_branch' => $request->issue_in_branch,
                'issue_date' => $request->issue_date,
                'expiry_date' => $request->expiry_date,
                'amount' => $request->amount,
            ]);

            if ($request->hasFile('attachment')) {
                $existingAttachment = public_path('uploads/documents/bg_attachments/' . $bg->attachment);
                if ($bg->attachment && file_exists($existingAttachment)) {
                    unlink($existingAttachment);
                }

                $file = $request->file('attachment');
                $filename = time() . '_bg_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/documents/bg_attachments'), $filename);
                $bg->attachment = $filename;
            }

            $bg->save();
        }

        if ($request->has('others') && is_array($request->others)) {

            // Get organization name
            $organization = Organization::first();
            $orgName = $organization->name ?? null;

            // Delete other companies except your organization
            \App\Models\TenderParticipateCompany::where('tender_participate_id', $tenderParticipate->id)
                ->when($orgName, fn($q) => $q->where('company_name', '!=', $orgName))
                ->delete();

            // Add new companies from the request
            foreach ($request->others as $entry) {
                if (!empty($entry['company']) && !empty($entry['offered_price'])) {
                    \App\Models\TenderParticipateCompany::create([
                        'tender_participate_id' => $tenderParticipate->id,
                        'company_name' => $entry['company'],
                        'offered_price' => $entry['offered_price'],
                        'position' => $entry['position'] ?? null,
                    ]);
                }
            }
        }


        return redirect()->route('participated_tenders.index')
            ->with('success', 'Participated Tender updated successfully.');
    }

    public function letter($id)
    {
        $tParticipate = Tender::findOrFail($id);
        $letters = TenderLetter::where('tender_id', $id)
            ->where('type', '1') // Only Participate
            ->latest()
            ->get();

        return view('backend.tender.participate.letter', compact('tParticipate', 'letters'));
    }

    public function letterStore(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);

        $request->validate([
            'value' => 'nullable|string',
            'reference_no' => 'required|string',
            'remarks' => 'required|string',
            'date' => 'required|date',
            'document' => 'required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $file = $request->file('document');
        $filename = now()->format('Ymd_His') . '_participate_letter_'  . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/documents/tender_letters/participate'), $filename);

        TenderLetter::create([
            'tender_id' => $tender->id,
            'reference_no' => $request->reference_no,
            'remarks' => $request->remarks,
            'date' => $request->date,
            'document' => $filename,
            'value' => $request->value,
            'type' => $request->type, // 1 is participated
        ]);

        return redirect()->back()->with('success', 'Tender letter uploaded successfully.');
    }

    public function letterEdit($id)
    {
        $editLetter = TenderLetter::findOrFail($id);
        $letters = TenderLetter::where('tender_id', $editLetter->tender_id)->get();
        $tParticipate = Tender::findOrFail($editLetter->tender_id); // this is important!

        return view('backend.tender.participate.letter', compact('letters', 'editLetter', 'tParticipate'));
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
        $letter->date = $request->reference_no;
        $letter->remarks = $request->remarks;
        $letter->date = $request->date;
        $letter->date = $request->value;

        if ($request->hasFile('document')) {
            // Delete old file if exists
            $oldPath = public_path('uploads/documents/tender_letters/participate/' . $letter->document);
            if (file_exists($oldPath)) {
                unlink($oldPath); // remove old file
            }

            // Upload new file
            $file = $request->file('document');
            $filename = now()->format('Ymd_His') . '_participate_letter_'  . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/documents/tender_letters/participate'), $filename);
            $letter->document = $filename;
        }


        $letter->save();

        return redirect()->route('participated_tenders.letter.edit', $id)
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
