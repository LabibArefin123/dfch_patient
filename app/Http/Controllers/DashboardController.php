<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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

        $today = Carbon::today();

        $totalPatients = Patient::count();

        $todayPatients = Patient::whereDate('date_of_patient_added', $today)->count();

        $weeklyPatients = Patient::whereBetween(
            'date_of_patient_added',
            [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]
        )->count();

        $monthlyPatients = Patient::whereMonth('date_of_patient_added', $today->month)
            ->whereYear('date_of_patient_added', $today->year)
            ->count();

        return view('backend.dashboard', compact(
            'totalPatients',
            'todayPatients',
            'weeklyPatients',
            'monthlyPatients'
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
        $term = trim($request->input('term'));
        Log::info('Global search term: ' . $term);

        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        $results = [];

        /* ==========================
       Try to parse date
    ========================== */
        $parsedDate = null;
        try {
            $parsedDate = Carbon::parse($term)->format('Y-m-d');
        } catch (\Exception $e) {
            // ignore
        }

        /* ==========================
       Patient Query
    ========================== */
        $patients = Patient::query()
            ->where(function ($q) use ($term) {
                $q->where('patient_name', 'like', "%{$term}%")
                    ->orWhere('patient_code', 'like', "%{$term}%")
                    ->orWhere('phone_1', 'like', "%{$term}%")
                    ->orWhere('phone_2', 'like', "%{$term}%")
                    ->orWhere('phone_f_1', 'like', "%{$term}%")
                    ->orWhere('phone_m_1', 'like', "%{$term}%")
                    ->orWhere('patient_f_name', 'like', "%{$term}%")
                    ->orWhere('patient_m_name', 'like', "%{$term}%")
                    ->orWhere('district', 'like', "%{$term}%")
                    ->orWhere('city', 'like', "%{$term}%");
            })
            ->when($parsedDate, function ($q) use ($parsedDate) {
                $q->orWhereDate('date_of_patient_added', $parsedDate);
            })
            ->limit(15)
            ->get();

        /* ==========================
       Build Results
    ========================== */
        foreach ($patients as $patient) {

            $name = $this->highlightMatch($patient->patient_name, $term);
            $code = $this->highlightMatch($patient->patient_code, $term);
            $fathers_name = $this->highlightMatch($patient->patient_f_name, $term);
            $mothers_name = $this->highlightMatch($patient->patient_m_name, $term);

            $results[] = [
                'label' => "{$name} ({$code}) [Father's Name - {$fathers_name}] [Mother's Name - {$mothers_name}]",
                'url'   => route('patients.show', $patient->id),
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
            '<span style="color:#ff6b6b;">$1</span>',
            e($text)
        );
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
