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
        return view(
            'backend.dashboard',
        );
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
