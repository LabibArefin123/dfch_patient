<?php

namespace App\Http\Controllers;

use App\Models\Tender;
use App\Models\TenderLetter;
use App\Models\TenderParticipate;
use App\Models\TenderParticipateCompany;
use App\Models\TenderAwarded;
use App\Models\TenderProgress;
use App\Models\TenderCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::user();
        $company = $user->company_name;
        $today = Carbon::today();
        $daysToCheck = [15, 7, 3, 2, 1];

        // Summary stats
        $totalTenders = Tender::count();
        $totalParticipated = Tender::where('status', 2)->count();
        $totalAwardedTender = Tender::where('status', 3)->count();
        $totalCompletedTenders = Tender::where('status', 4)->count();
        $totalArchivedTenders = Tender::archived()->count();

        // Generate date range array for upcoming checks
        $validityDates = collect($daysToCheck)->map(fn($d) => $today->copy()->addDays($d)->toDateString());

        // Expiring items
        $totalBGExpiring = TenderParticipate::whereHas(
            'bg',
            fn($q) =>
            $validityDates->each(fn($d) => $q->orWhereDate('expiry_date', $d))
        )->count();

        $totalPGExpiring = TenderAwarded::whereHas(
            'pg',
            fn($q) =>
            $validityDates->each(fn($d) => $q->orWhereDate('expiry_date', $d))
        )->count();

        $totalOfferValidity = TenderParticipate::whereIn('offer_validity', $validityDates)->count();

        $notifications = [];
        $followUpNoitifications = [];

        // TENDER DEADLINE NOTIFICATIONS
        $tenders = Tender::where('status', 0)->whereDate('submission_date', '>=', $today)->get();

        foreach ($tenders as $tender) {
            $submissionDate = Carbon::parse($tender->submission_date);
            $daysLeft = $today->diffInDays($submissionDate, false);

            if (in_array($daysLeft, $daysToCheck)) {
                $notifications[] = [
                    'type' => 'tender',
                    'tender_id' => $tender->id,
                    'title' => "{$tender->title} ({$tender->tender_no})",
                    'days_left' => $daysLeft,
                    'submission_date' => $submissionDate->format('d F Y'),
                ];
            }
        }

        // BG NOTIFICATIONS
        $bgList = TenderParticipate::with(['bg', 'tender'])->whereHas('bg', function ($query) use ($today, $daysToCheck) {
            foreach ($daysToCheck as $days) {
                $query->orWhereDate('expiry_date', $today->copy()->addDays($days));
            }
        })->get();

        foreach ($bgList as $participate) {
            $bg = $participate->bg;
            $tender = $participate->tender;

            if ($bg && $tender) {
                $expiryDate = Carbon::parse($bg->expiry_date);
                $daysLeft = $today->diffInDays($expiryDate);

                if (in_array($daysLeft, $daysToCheck)) {
                    $notifications[] = [
                        'type' => 'bg',
                        'tender_id' => $participate->tender_id,
                        'title' => "BG Expiry: {$tender->title} ({$tender->tender_no})",
                        'days_left' => $daysLeft,
                        'submission_date' => $expiryDate->format('d F Y'),
                    ];
                }
            }
        }

        // PG NOTIFICATIONS
        $pgList = TenderAwarded::with(['pg', 'tenderParticipate.tender'])->whereHas('pg', function ($query) use ($today, $daysToCheck) {
            foreach ($daysToCheck as $days) {
                $query->orWhereDate('expiry_date', $today->copy()->addDays($days));
            }
        })->get();

        foreach ($pgList as $awarded) {
            $pg = $awarded->pg;
            $tender = $awarded->tenderParticipate->tender ?? null;

            if ($pg && $tender) {
                $expiryDate = Carbon::parse($pg->expiry_date);
                $daysLeft = $today->diffInDays($expiryDate);

                if (in_array($daysLeft, $daysToCheck)) {
                    $notifications[] = [
                        'type' => 'pg',
                        'tender_id' => $awarded->tender_participate_id,
                        'title' => "PG Expiry: {$tender->title} ({$tender->tender_no})",
                        'days_left' => $daysLeft,
                        'submission_date' => $expiryDate->format('d F Y'),
                    ];
                }
            }
        }

        // OFFER VALIDITY NOTIFICATIONS
        $offerValidityList = TenderParticipate::with('tender')
            ->whereBetween('offer_validity', [$today, $today->copy()->addDays(30)])
            ->get();

        foreach ($offerValidityList as $participation) {
            $validityDate = Carbon::parse($participation->offer_validity);
            $daysLeft = $today->diffInDays($validityDate);
            $tender = $participation->tender;

            if ($tender && in_array($daysLeft, $daysToCheck)) {
                $notifications[] = [
                    'type' => 'offer_validity',
                    'tender_id' => $participation->tender_id,
                    'title' => "Offer Validity: {$tender->title} ({$tender->tender_no})",
                    'days_left' => $daysLeft,
                    'submission_date' => $validityDate->format('d F Y'),
                ];
            }
        }

        // AWARDED DATE NOTIFICATIONS
        $awardedDateList = TenderAwarded::with('tenderParticipate.tender')
            ->whereBetween('awarded_date', [$today, $today->copy()->addDays(max($daysToCheck))])
            ->whereHas('tenderParticipate.tender', function ($q) {
                $q->where('status', '!=', 4); // exclude completed
            })
            ->get();

        $totalAwardedDate = 0;

        foreach ($awardedDateList as $awarded) {
            $awardedDate = Carbon::parse($awarded->awarded_date);
            $daysLeft = $today->diffInDays($awardedDate);
            $tender = $awarded->tenderParticipate->tender ?? null;

            if ($tender && in_array($daysLeft, $daysToCheck)) {
                $totalAwardedDate++;
                $notifications[] = [
                    'type' => 'awarded_notification',
                    'tender_id' => $awarded->tender_participate_id,
                    'title' => "Awarding Soon: {$tender->title} ({$tender->tender_no})",
                    'days_left' => $daysLeft,
                    'submission_date' => $awardedDate->format('d F Y'),
                ];
            }
        }

        // Chart data
        $progressData = TenderProgress::with('tenderAwarded.tenderParticipate.tender')->get();

        $chartData = $progressData->map(function ($progress) {
            $tender = $progress->tenderAwarded->tenderParticipate->tender;
            $participate = $progress->tenderAwarded->tenderParticipate;
            $offerValidityDate = $participate->offer_validity_date ?? null;

            $daysRemaining = $offerValidityDate
                ? Carbon::parse($offerValidityDate)->diffInDays(Carbon::now(), false)
                : null;

            return [
                'id' => $progress->id,
                'tender_name' => $tender->tender_no ?? 'N/A',
                'offer_validity' => $daysRemaining ?? 0,
                'is_delivered' => $progress->is_delivered,
                'is_inspection_completed' => $progress->is_inspection_completed,
                'is_inspection_accepted' => $progress->is_inspection_accepted,
                'is_bill_submitted' => $progress->is_bill_submitted,
                'is_bill_received' => $progress->is_bill_received,
            ];
        });

        // Group notifications for view
        $groupedNotifications = collect($notifications)->groupBy('type');
        // Pass totals to config
        config([
            'adminlte.notification_counts.tender' => $totalTenders,
            'adminlte.notification_counts.offer_validity' => $totalOfferValidity,
            'adminlte.notification_counts.bg' => $totalBGExpiring,
            'adminlte.notification_counts.pg' => $totalPGExpiring,
            'adminlte.notification_counts.awarded_notification' => $totalAwardedDate,
        ]);

        return view('backend.dashboard', compact(
            'company',
            'totalTenders',
            'totalParticipated',
            'totalAwardedTender',
            'totalCompletedTenders',
            'totalArchivedTenders',
            'totalBGExpiring',
            'totalPGExpiring',
            'totalOfferValidity',
            'notifications',
            'groupedNotifications',
            'chartData'
        ));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    public function globalSearch(Request $request)
    {
        $term = $request->input('term');
        Log::info('Global search term: ' . $term);

        $results = [];

        // Try to parse date
        $parsedDate = null;
        try {
            $parsedDate = Carbon::parse($term)->format('Y-m-d');
        } catch (\Exception $e) {
        }

        $now = now()->toDateString();

        $tenders = Tender::query()
            ->where(function ($q) use ($term) {
                $q->where('tender_no', 'like', "%{$term}%")
                    ->orWhere('title', 'like', "%{$term}%");
            })
            ->when($parsedDate, function ($q) use ($parsedDate) {
                $q->orWhereDate('publication_date', $parsedDate)
                    ->orWhereDate('submission_date', $parsedDate);
            })
            ->get();

        foreach ($tenders as $tender) {

            // 🔹 Status text from SINGLE source
            $statusText = match ($tender->status) {
                0 => ($tender->submission_date && $tender->submission_date < $now)
                    ? 'Expired'
                    : 'Pending',
                1 => 'Not Participated',
                2 => 'Participated',
                3 => 'Awarded',
                4 => 'In Progress',
                5 => 'Completed',
                default => 'Unknown',
            };

            $title    = $this->highlightMatch($tender->title, $term);
            $tenderNo = $this->highlightMatch($tender->tender_no, $term);

            $results[] = [
                'label' => "[{$statusText}] {$title} ({$tenderNo})",
                'url'   => route('search.result', [
                    'id'   => $tender->id,
                    'type' => 'tender', // 🔥 always tender
                ]),
            ];
        }

        return response()->json($results);
    }

    protected function highlightMatch(string $text, string $term): string
    {
        if (!$term) {
            return e($text);
        }

        return preg_replace(
            "/(" . preg_quote($term, '/') . ")/i",
            '<span style="color:#ff9900;">$1</span>',
            e($text)
        );
    }

    public function searchResult(Request $request)
    {
        $tender = Tender::findOrFail($request->id);

        $participate = null;
        $awarded     = null;
        $progress    = null;
        $completed   = null;

        /**
         * 1️⃣ PARTICIPATE
         */
        if ($tender->status >= 2) {
            $participate = TenderParticipate::with('tender')
                ->where('tender_id', $tender->id)
                ->latest()
                ->first();
        }

        /**
         * 2️⃣ AWARDED
         */
        if ($tender->status >= 3 && $participate) {
            $awarded = TenderAwarded::with(['singleDelivery', 'partialDeliveries'])
                ->where('tender_participate_id', $participate->id)
                ->latest()
                ->first();
        }

        /**
         * 3️⃣ PROGRESS
         */
        if ($tender->status >= 4 && $awarded) {
            $progress = TenderProgress::where('tender_awarded_id', $awarded->id)
                ->latest()
                ->first();
        }

        /**
         * 4️⃣ CHECK COMPLETION BY ALL 5 STAGES
         */
        $isCompletedByProgress = false;

        if ($progress) {
            $isCompletedByProgress =
                $progress->is_delivered == 1 &&
                $progress->is_inspection_completed == 1 &&
                $progress->is_inspection_accepted == 1 &&
                $progress->is_bill_submitted == 1 &&
                $progress->is_bill_received == 1;
        }

        /**
         * 5️⃣ COMPLETED
         */
        if (($tender->status == 5 || $isCompletedByProgress) && $awarded) {
            $completed = TenderCompleted::with([
                'tenderProgress.tenderAwarded.singleDelivery',
                'tenderProgress.tenderAwarded.partialDeliveries',
            ])
                ->whereHas('tenderProgress', function ($q) use ($awarded) {
                    $q->where('tender_awarded_id', $awarded->id);
                })
                ->latest()
                ->first();
        }

        /**
         * 6️⃣ FINAL TYPE DECISION (🔥 FIXED)
         */
        $type = match (true) {
            $tender->status <= 1          => 'tender',
            $tender->status == 2          => 'participate',
            $tender->status == 3          => 'awarded',
            $isCompletedByProgress        => 'completed', // ✅ MAIN FIX
            $tender->status == 5          => 'completed',
            $progress !== null            => 'progress',
            default                       => 'tender',
        };

        /**
         * 7️⃣ UNIFIED DATA FOR VIEW
         */
        $data = match ($type) {
            'tender'      => $tender,
            'participate' => $participate,
            'awarded'     => $awarded,
            'progress'    => $progress,
            'completed'   => $completed ?? $progress,
            default       => $tender,
        };

        /**
         * 8️⃣ LETTERS
         */
        $participateLetters = TenderLetter::where('tender_id', $tender->id)->where('type', 1)->latest()->get();
        $awardedLetters     = TenderLetter::where('tender_id', $tender->id)->where('type', 2)->latest()->get();
        $progressLetters    = TenderLetter::where('tender_id', $tender->id)->where('type', 3)->latest()->get();
        $completedLetters   = TenderLetter::where('tender_id', $tender->id)->where('type', 4)->latest()->get();

        /**
         * 9️⃣ ITEMS & TOTAL
         */
        $items = json_decode($tender->items ?? '[]', true);

        $grandTotal = collect($items)->sum(
            fn($item) => ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0)
        );

        /**
         * 🔟 PARTICIPANTS
         */
        $currentTenderParticipants = collect();

        if ($participate) {
            $currentTenderParticipants = TenderParticipateCompany::where(
                'tender_participate_id',
                $participate->id
            )
                ->orderBy('offered_price', 'asc')
                ->get();
        }

        /**
         * 1️⃣1️⃣ DELIVERY
         */
        $singleDelivery    = $awarded?->singleDelivery;
        $partialDeliveries = $awarded?->partialDeliveries ?? collect();

        return view('backend.search_result', compact(
            'data',
            'tender',
            'type',
            'items',
            'grandTotal',
            'currentTenderParticipants',
            'singleDelivery',
            'partialDeliveries',
            'participateLetters',
            'awardedLetters',
            'progressLetters',
            'completedLetters',
            'participate',
            'awarded',
            'completed'
        ));
    }

    public function system_index()
    {
        // -----------------------------
        // Total Users
        // -----------------------------
        $totalUsers = User::count();

        // -----------------------------
        // Table Row Counts + Last Updated Time
        // -----------------------------
        $dbName = DB::getDatabaseName();

        $tables = DB::select("
            SELECT 
                TABLE_NAME,
                UPDATE_TIME
            FROM information_schema.tables
            WHERE table_schema = ?
        ", [$dbName]);

        $tableCounts = [];
        $totalRecords = 0;

        foreach ($tables as $table) {
            $tableName = $table->TABLE_NAME;

            if (in_array($tableName, ['migrations', 'failed_jobs'])) {
                continue;
            }

            $count = DB::table($tableName)->count();

            $tableCounts[$tableName] = [
                'count' => $count,
                'updated_at' => $table->UPDATE_TIME
                    ? date('Y-m-d H:i:s', strtotime($table->UPDATE_TIME))
                    : null,
            ];

            $totalRecords += $count;
        }


        // -----------------------------
        // Database Size
        // -----------------------------
        $dbSize = DB::selectOne("
            SELECT 
                ROUND(SUM(data_length + index_length) / 1024 / 1024, 2) AS size
            FROM information_schema.tables
            WHERE table_schema = ?
        ", [$dbName]);

        $databaseSize = $dbSize->size ?? 0;

        // -----------------------------
        // Last Backup Time
        // -----------------------------
        $backupPath = storage_path('app');
        $lastBackupTime = 'No backup found';

        if (File::exists($backupPath)) {
            $files = collect(File::files($backupPath))
                ->filter(fn($file) => $file->getExtension() === 'sql');

            if ($files->isNotEmpty()) {
                $latestFile = $files->sortByDesc(fn($f) => $f->getMTime())->first();
                $lastBackupTime = date('Y-m-d H:i:s', $latestFile->getMTime());
            }
        }

        return view('backend.system_dashboard', compact(
            'totalUsers',
            'totalRecords',
            'tableCounts',
            'databaseSize',
            'lastBackupTime'
        ));
    }
}
