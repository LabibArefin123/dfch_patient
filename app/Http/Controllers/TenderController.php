<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\SupplierCompanyProfile;
use App\Models\Tender;
use App\Models\TenderItem;
use App\Models\TenderLetter;
use App\Models\TenderParticipate;
use App\Models\TenderParticipateCompany;
use App\Models\TenderAwarded;
use App\Models\TenderProgress;
use App\Models\TenderCompleted;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TenderController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getTenders();
        }

        return view('backend.tender.index');
    }

    private function getTenders()
    {
        $tenders = Tender::active()->orderBy('submission_date', 'desc')->get();

        return DataTables::of($tenders)
            ->addIndexColumn()

            ->editColumn(
                'tender_no',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' . e($t->tender_no) . '</a>'
            )

            ->editColumn(
                'title',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box" title="' . e($t->title) . '">' .
                    (strlen($t->title) > 25 ? e(substr($t->title, 0, 25)) . '...' : e($t->title)) . '</a>'
            )

            ->editColumn(
                'procuring_authority',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' . e($t->procuring_authority) . '</a>'
            )

            ->editColumn(
                'end_user',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' . e($t->end_user) . '</a>'
            )

            ->addColumn('item', function ($t) {
                $item = optional(json_decode($t->items, true))[0]['item'] ?? 'N/A';
                $short = strlen($item) > 25 ? substr($item, 0, 25) . '...' : $item;
                return '<a href="' . route('tenders.show', $t->id) . '" class="hover-box" title="' . e($item) . '">' . e($short) . '</a>';
            })

            ->addColumn(
                'deno',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' .
                    (optional(json_decode($t->items, true))[0]['deno'] ?? 'N/A') . '</a>'
            )

            ->addColumn(
                'quantity',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' .
                    (optional(json_decode($t->items, true))[0]['quantity'] ?? 'N/A') . '</a>'
            )

            ->editColumn(
                'publication_date',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' .
                    ($t->publication_date ? Carbon::parse($t->publication_date)->format('d-F-Y') : '') . '</a>'
            )

            ->editColumn(
                'submission_date',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' .
                    ($t->submission_date ? Carbon::parse($t->submission_date)->format('d-F-Y') : '') . '</a>'
            )

            ->editColumn(
                'submission_time',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' .
                    ($t->submission_time ? Carbon::parse($t->submission_time)->format('g:i A') : '') . '</a>'
            )

            ->editColumn(
                'financial_year',
                fn($t) =>
                '<a href="' . route('tenders.show', $t->id) . '" class="hover-box">' . e($t->financial_year) . '</a>'
            )

            ->addColumn('status', function ($t) {
                $now = now();
                $submissionDateTime = Carbon::parse($t->submission_date . ' ' . $t->submission_time);

                if ($submissionDateTime->lt($now) && $t->status == 0) {
                    return '<span class="badge bg-danger">Expired</span>';
                }

                return match ($t->status) {
                    0 => '<span class="badge bg-secondary">Pending</span>',
                    1 => '<span class="badge bg-info">Not Participated</span>',
                    2 => '<span class="badge bg-primary">Participated</span>',
                    3 => '<span class="badge bg-success">Awarded</span>',
                    4 => '<span class="badge bg-dark">Completed</span>',
                    default => '<span class="badge bg-light text-dark">Unknown</span>',
                };
            })

            ->addColumn('noticeFile', function ($t) {
                if (!$t->notice_file) return '<span class="text-muted">No Notice</span>';
                return '<a href="' . route('tenders.downloadNotice', $t->id) . '" target="_blank">'
                    . '<i class="fas fa-file-pdf text-danger"></i></a>';
            })

            ->addColumn('specFile', function ($t) {
                if (!$t->spec_file) return '<span class="text-muted">No Spec</span>';
                return '<a href="' . route('tenders.downloadSpec', $t->id) . '" target="_blank">'
                    . '<i class="fas fa-file-pdf text-danger"></i></a>';
            })

            ->addColumn('action', function ($t) {
                $editUrl = route('tenders.edit', $t->id);
                $deleteUrl = route('tenders.destroy', $t->id);
                return '
                <a href="' . $editUrl . '" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                <form action="' . $deleteUrl . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                    ' . csrf_field() . method_field('DELETE') . '
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                </form>';
            })

            ->rawColumns([
                'tender_no',
                'title',
                'procuring_authority',
                'end_user',
                'item',
                'deno',
                'quantity',
                'publication_date',
                'submission_date',
                'submission_time',
                'financial_year',
                'status',
                'noticeFile',
                'specFile',
                'action'
            ])

            ->make(true);
    }

    public function addSupplierOption(Request $request)
    {
        $request->validate([
            'field_type' => 'required|in:procuring_authority,end_user',
            'value' => 'required|string|max:255',
        ]);

        $data = new SupplierCompanyProfile();

        if ($request->field_type === 'procuring_authority') {
            $data->procuring_authority = $request->value;
        } else {
            $data->end_user = $request->value;
        }

        $data->save();

        return response()->json([
            'success' => true,
            'value' => $request->value,
            'field_type' => $request->field_type,
            'message' => ucfirst(str_replace('_', ' ', $request->field_type)) . ' "' . $request->value . '" added successfully.',
        ]);
    }

    public function create()
    {
        $procuringAuthorities = SupplierCompanyProfile::whereNotNull('procuring_authority')
            ->distinct()
            ->pluck('procuring_authority');

        $endUsers = SupplierCompanyProfile::whereNotNull('end_user')
            ->distinct()
            ->pluck('end_user');

        return view('backend.tender.create', compact('procuringAuthorities', 'endUsers'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'tender_no'           => 'required|unique:tenders,tender_no',
            'title'               => 'required|string|max:255',
            'procuring_authority' => 'required|string|max:255',
            'end_user'            => 'required|string|max:255',
            'financial_year'      => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'tender_type'         => 'required|string|max:100',
            'publication_date'    => 'required|string',
            'submission_date'     => 'required|string',
            'submission_time'     => 'required|string',
            'spec_file'           => 'required|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpeg,jpg,png|max:10240',
            'notice_file'         => 'required|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpeg,jpg,png|max:10240',
            'items'               => 'required|array',
        ]);

        // Convert to proper date
        $publicationDate = Carbon::createFromFormat('j F Y', $request->publication_date)->format('Y-m-d');
        $submissionDate = Carbon::createFromFormat('j F Y', $request->submission_date)->format('Y-m-d');

        $submissionDateTime = Carbon::parse($submissionDate . ' ' . $request->submission_time);
        $status = $submissionDateTime->isPast() ? 0 : 0; // as per your logic

        // Handle file uploads
        $specFileName = null;
        $noticeFileName = null;

        if ($request->hasFile('spec_file')) {
            $specFile = $request->file('spec_file');
            $specFileName = now()->format('Ymd_His') . '_spec.' . $specFile->getClientOriginalExtension();
            $specFile->move(public_path('uploads/documents/spec_files/'), $specFileName);
        }

        if ($request->hasFile('notice_file')) {
            $noticeFile = $request->file('notice_file');
            $noticeFileName = now()->format('Ymd_His') . '_notice.' . $noticeFile->getClientOriginalExtension();
            $noticeFile->move(public_path('uploads/documents/notice_files/'), $noticeFileName);
        }

        // Create Tender
        $tender = Tender::create([
            'tender_no'           => $request->tender_no,
            'title'               => $request->title,
            'procuring_authority' => $request->procuring_authority,
            'end_user'            => $request->end_user,
            'financial_year'      => $request->financial_year,
            'tender_type'         => $request->tender_type,
            'publication_date'    => $publicationDate,
            'submission_date'     => $submissionDate,
            'submission_time'     => $request->submission_time,
            'spec_file'           => $specFileName,
            'notice_file'         => $noticeFileName,
            'items'               => json_encode($request->items),
            'status'              => $status,
        ]);

        return redirect()->route('tenders.index')->with('success', 'Tender saved successfully.');
    }


    public function show($id)
    {
        $tender = Tender::findOrFail($id);

        // Format submission time as 12-hour with AM/PM
        $submissionTime = \Carbon\Carbon::parse($tender->submission_time)->format('h:i A');

        // For viewing participated tender part
        $participation = TenderParticipate::where('tender_id', $tender->id)->first();
        $participationCompany = null;
        $currentTenderParticipants = collect();
        $bg = null;

        if ($participation) {
            $participationCompany = TenderParticipateCompany::where('tender_participate_id', $participation->id)->first();
            $allCompanies = $participation->companies ?? collect();
            $currentTenderParticipants = $allCompanies->groupBy(function ($item) {
                return \Carbon\Carbon::parse($item->participated_on)->format('Y-m-d');
            });
            $bg = optional($participation)->bg;
        }

        // For viewing awarded tender part
        $tenderAwarded = $participation
            ? TenderAwarded::where('tender_participate_id', $participation->id)->first()
            : null;

        $singleDelivery = null;
        $partialDeliveries = collect();

        if ($tenderAwarded) {
            if ($tenderAwarded->delivery_type == '1') {
                $singleDelivery = $tenderAwarded->singleDelivery;
            } elseif ($tenderAwarded->delivery_type == 'partial') {
                $partialDeliveries = $tenderAwarded->partialDeliveries;
            }
        }

        $completeTenders = TenderCompleted::with('tenderProgress.tenderAwarded')->first();
        // Safe query for letters if participation exists
        $participateLetters = collect();
        $awardedLetters = collect();
        $progressLetters = collect();
        $completeLetters = collect();

        if ($participation) {
            $query = TenderLetter::where('tender_id', $participation->tender_id);
            $participateLetters = (clone $query)->where('type', 1)->latest()->get();
            $awardedLetters = (clone $query)->where('type', 2)->latest()->get();
            $progressLetters = (clone $query)->where('type', 3)->latest()->get();
            $completeLetters = (clone $query)->where('type', 4)->latest()->get();
        }

        return view('backend.tender.show', compact(
            'tender',
            'submissionTime',
            'participation',
            'participationCompany',
            'currentTenderParticipants',
            'bg',
            'tenderAwarded',
            'singleDelivery',
            'partialDeliveries',
            'participateLetters',
            'awardedLetters',
            // 'progressTenders',
            'progressLetters',
            'completeTenders',
            'completeLetters',
        ));
    }

    public function edit(Tender $tender)
    {
        $tender->items = json_decode($tender->items ?? '[]', true);

        $denoOptions = TenderItem::whereNotNull('deno')
            ->orderBy('deno')
            ->pluck('deno')
            ->toArray();

        $participation = TenderParticipate::where('tender_id', $tender->id)->first();
        $tenderAwarded = TenderAwarded::where('tender_participate_id', optional($participation)->id)->first();
        $organization = Organization::first();

        $singleDelivery = null;
        $partialDeliveries = collect();

        if ($tenderAwarded) {
            if ($tenderAwarded->delivery_type == '1') {
                $singleDelivery = $tenderAwarded->singleDelivery;
            } elseif ($tenderAwarded->delivery_type == 'partial') {
                $partialDeliveries = $tenderAwarded->partialDeliveries;
            }
        }

        $bg = optional($participation)->bg;

        $tenderParticipated = TenderParticipateCompany::where('tender_participate_id', optional($participation)->id)
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return optional($item->participated_on ?? $item->created_at)->format('Y-m-d');
            });

        $userParticipated = TenderParticipateCompany::where('tender_participate_id', optional($participation)->id)
            ->where('company_name', optional($organization)->company_name)
            ->first();

        $participated = $userParticipated !== null;
        $alreadyParticipated = $tender->status === 2;

        //Letter part load 
        $participatedLetters = TenderLetter::where('type', 1)
            ->where('tender_id', $tender->id)
            ->latest()
            ->get();

        $awardedLetters = TenderLetter::where('type', 2)
            ->where('tender_id', $tender->id)
            ->latest()
            ->get();

        $progressLetters = TenderLetter::where('type', 4)
            ->where('tender_id', $tender->id)
            ->latest()
            ->get();

        $completedLetters = TenderLetter::where('type', 5)
            ->where('tender_id', $tender->id)
            ->latest()
            ->get();

        return view('backend.tender.edit', compact(
            'tender',
            'denoOptions',
            'organization',
            'participation',
            'tenderAwarded',
            'singleDelivery',
            'partialDeliveries',
            'bg',
            'tenderParticipated',
            'userParticipated',
            'participated',
            'alreadyParticipated',
            'participatedLetters',
            'awardedLetters',
            'progressLetters',
            'completedLetters'
        ));
    }

    public function update(Request $request, Tender $tender)
    {
        $organization = Organization::first();
        $isParticipating = $request->input('is_participate') == 1;
        $isAwardedOrCompleted = in_array($tender->status, [3, 4]);
        $requiresParticipationValidation = $isParticipating && !$isAwardedOrCompleted;

        // Validation rules
        $rules = [
            'tender_no'           => 'required|unique:tenders,tender_no,' . $tender->id,
            'title'               => 'required|string|max:255',
            'procuring_authority' => 'required|string|max:255',
            'end_user'            => 'required|string|max:255',
            'deno'                => 'nullable|string|max:100',
            'tender_type'         => 'required|string|max:100',
            'financial_year'      => ['required', 'string', 'regex:/^\d{4}-\d{4}$/'],
            'quantity'            => 'nullable|string|max:10',
            'spec_file'           => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpeg,jpg,png|max:10240',
            'notice_file'         => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,csv,jpeg,jpg,png|max:10240',
            'publication_date'    => 'required|date',
            'submission_date'     => 'required|date',
            'submission_time'     => 'nullable|string',
            'is_participate'      => 'nullable|in:0,1',
            'items'               => 'nullable|array',
            'items.*.item'        => 'required_with:items|string|max:255',
            'items.*.deno'        => 'required_with:items|string|max:100',
            'items.*.quantity'    => 'required_with:items|string|max:50',
        ];

        if ($requiresParticipationValidation) {
            $rules['items.*.unit_price'] = 'required_with:items|string|max:50';
            $rules['offer_no'] = 'required|string|max:255';
            $rules['offer_date'] = 'required|string|max:255';
            $rules['offer_validity'] = 'required|date';
            $rules['offer_doc'] = 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240';
        }

        $validated = $request->validate($rules);

        DB::beginTransaction();

        try {
            // Update basic tender fields
            $tender->fill($request->only([
                'tender_no',
                'title',
                'procuring_authority',
                'end_user',
                'deno',
                'tender_type',
                'financial_year',
                'quantity',
                'publication_date',
                'submission_date',
                'submission_time',
            ]));

            // File uploads
            foreach (['spec_file' => 'spec_files', 'notice_file' => 'notice_files'] as $input => $folder) {
                if ($request->hasFile($input)) {
                    if ($tender->$input && file_exists(public_path("uploads/documents/{$folder}/" . $tender->$input))) {
                        unlink(public_path("uploads/documents/{$folder}/" . $tender->$input));
                    }
                    $file = $request->file($input);
                    $filename = now()->format('Ymd_His') . "_{$input}." . $file->getClientOriginalExtension();
                    $file->move(public_path("uploads/documents/{$folder}"), $filename);
                    $tender->$input = $filename;
                }
            }

            // Prepare and save items
            $filteredItems = $request->filled('items')
                ? array_values(array_filter($request->items, function ($item) use ($isParticipating, $requiresParticipationValidation) {
                    return !empty($item['item']) && !empty($item['deno']) && !empty($item['quantity']) &&
                        (!$requiresParticipationValidation || !empty($item['unit_price']));
                }))
                : [];

            $tender->items = json_encode($filteredItems);

            // Update participation flag and status (only if editable)
            if (!$isAwardedOrCompleted && $request->has('is_participate')) {
                $tender->is_participate = $request->is_participate;
                $tender->status = $isParticipating ? 2 : 0;
            }

            // Flags for award and completion
            $tender->is_awarded = $tender->status == 3 ? 1 : 0;
            $tender->is_completed = $tender->status == 4 ? 1 : 0;

            $tender->save();

            // Participation handling
            if ($requiresParticipationValidation) {
                $tenderParticipate = TenderParticipate::updateOrCreate(
                    ['tender_id' => $tender->id],
                    [
                        'offer_no' => $request->offer_no,
                        'offer_date' => $request->offer_date,
                        'offer_validity' => $request->offer_validity,
                    ]
                );

                if ($request->hasFile('offer_doc')) {
                    if ($tenderParticipate->offer_doc) {
                        $old = public_path('uploads/documents/offer_docs/' . $tenderParticipate->offer_doc);
                        if (file_exists($old)) unlink($old);
                    }
                    $file = $request->file('offer_doc');
                    $filename = now()->format('Ymd_His') . '_offer.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/documents/offer_docs/'), $filename);
                    $tenderParticipate->offer_doc = $filename;
                    $tenderParticipate->save();
                }

                // Save own company price
                TenderParticipateCompany::updateOrCreate(
                    [
                        'tender_participate_id' => $tenderParticipate->id,
                        // use "name" from organization model, but store it in company_name column
                        'company_name' => $organization->name,
                    ],
                    ['offered_price' => $request->price]
                );

                // Save other company prices
                if ($request->has('tender_participates') && is_array($request->tender_participates)) {
                    // Delete old entries except current organization
                    TenderParticipateCompany::where('tender_participate_id', $tenderParticipate->id)
                        ->where('company_name', '!=', $organization->name)
                        ->delete();

                    foreach ($request->tender_participates as $entries) {
                        foreach ($entries as $entry) {
                            if (
                                !empty($entry['company']) && !empty($entry['price']) &&
                                strtolower($entry['company']) !== strtolower($organization->name) // ✅ fixed here
                            ) {
                                TenderParticipateCompany::create([
                                    'tender_participate_id' => $tenderParticipate->id,
                                    'company_name' => $entry['company'],
                                    'offered_price' => $entry['price'],
                                ]);
                            }
                        }
                    }
                }


                DB::commit();
                return redirect()->route('participated_tenders.edit', $tenderParticipate->id)
                    ->with('success', 'Tender updated successfully.');
            }

            DB::commit();

            // Final redirect
            $message = 'Tender updated successfully';
            if ($tender->status == 3) $message .= ' (Awarded state).';
            elseif ($tender->status == 4) $message .= ' (Completed state).';

            return redirect()->route('tenders.index')->with('success', $message);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('Something went wrong: ' . $e->getMessage());
        }
    }

    public function destroy(Tender $tender)
    {
        try {
            // Delete associated spec file if exists
            if ($tender->spec_file && file_exists(public_path($tender->spec_file))) {
                unlink(public_path($tender->spec_file));
            }

            // Delete associated notice file if exists
            if ($tender->notice_file && file_exists(public_path($tender->notice_file))) {
                unlink(public_path($tender->notice_file));
            }

            // Optionally: Delete related records (e.g., participations) if needed
            // TenderParticipates::where('tender_id', $tender->id)->delete();

            // Delete the tender
            $tender->delete();

            return redirect()->route('tenders.index')
                ->with('success', 'Tender deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('tenders.index')
                ->with('error', 'Error deleting tender: ' . $e->getMessage());
        }
    }

    public function participated()
    {
        return view('backend.tender.participated.index');
    }

    public function bg_pg()
    {
        $bgs = TenderParticipate::with(['bg', 'tender'])
            ->has('bg')
            ->latest()
            ->get();


        $pgs = TenderAwarded::with(['pg', 'tenderParticipate.tender'])
            ->has('pg')
            ->latest()
            ->get();

        return view('backend.tender.bg_pg', compact('bgs', 'pgs'));
    }

    public function updateStatus(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);
        $tender->status = $request->status;
        $tender->save();

        return response()->json(['success' => true]);
    }

    public function downloadSpec($id)
    {
        $tender = Tender::findOrFail($id);

        if ($tender->spec_file) {
            $filePath = public_path('uploads/documents/spec_files/' . $tender->spec_file);

            if (file_exists($filePath)) {
                // Get the file extension from the original uploaded file
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                // Generate a safe custom filename with correct extension
                $filename = 'spec_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $tender->tender_no . '_' . $tender->title) . '.' . $extension;

                // Stream the file in browser with custom name
                return response()->file($filePath, [
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]);
            }
        }

        return redirect()->back()->with('error', 'Specification file not found.');
    }

    public function downloadNotice($id)
    {
        $tender = Tender::findOrFail($id);

        if ($tender->notice_file) {
            $filePath = public_path('uploads/documents/notice_files/' . $tender->notice_file);

            if (file_exists($filePath)) {
                // Get the file extension from the original uploaded file
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);

                // Generate a safe custom filename with correct extension
                $filename = 'notice_' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $tender->tender_no . '_' . $tender->title) . '.' . $extension;

                // Stream the file in browser with custom name
                return response()->file($filePath, [
                    'Content-Disposition' => 'inline; filename="' . $filename . '"'
                ]);
            }
        }

        return redirect()->back()->with('error', 'Specification file not found.');
    }


    public function downloadNoticeX($id)
    {
        $tender = Tender::findOrFail($id);

        if ($tender->notice_file) {
            $filePath = public_path('uploads/documents/notice_files/' . $tender->notice_file);
            // dd($filePath);

            if (file_exists($filePath)) {

                return response()->file($filePath); // 👉 stream in browser
            }
        }

        return redirect()->back()->with('error', 'Notice file not found.');
    }
}
