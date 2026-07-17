<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientEmergency;
use App\Models\PatientCancerPhoto;
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

        /*
    |--------------------------------------------------------------------------
    | Patient Count
    |--------------------------------------------------------------------------
    */

        $totalPatients = Patient::count();

        $todayPatients = Patient::whereDate(
            'date_of_patient_added',
            $today
        )->count();

        $weeklyPatients = Patient::whereBetween(
            'date_of_patient_added',
            [
                $today->copy()->startOfWeek(),
                $today->copy()->endOfWeek()
            ]
        )->count();

        $monthlyPatients = Patient::whereMonth(
            'date_of_patient_added',
            $today->month
        )
            ->whereYear(
                'date_of_patient_added',
                $today->year
            )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | Recommended Patients Count
    |--------------------------------------------------------------------------
    */

        $totalRecommendedPatients = Patient::where(
            'is_recommend',
            1
        )->count();

        $todayRecommendedPatients = Patient::where(
            'is_recommend',
            1
        )
            ->whereDate(
                'date_of_patient_added',
                $today
            )
            ->count();

        $weeklyRecommendedPatients = Patient::where(
            'is_recommend',
            1
        )
            ->whereBetween(
                'date_of_patient_added',
                [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ]
            )
            ->count();

        $monthlyRecommendedPatients = Patient::where(
            'is_recommend',
            1
        )
            ->whereMonth(
                'date_of_patient_added',
                $today->month
            )
            ->whereYear(
                'date_of_patient_added',
                $today->year
            )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | Emergency Patient History Count
    |--------------------------------------------------------------------------
    */

        $totalEmergencyPatientHistory =
            PatientEmergency::count();

        $todayEmergencyPatientHistory =
            PatientEmergency::whereDate(
                'created_at',
                $today
            )->count();

        $weeklyEmergencyPatientHistory =
            PatientEmergency::whereBetween(
                'created_at',
                [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ]
            )->count();

        $monthlyEmergencyPatientHistory =
            PatientEmergency::whereMonth(
                'created_at',
                $today->month
            )
            ->whereYear(
                'created_at',
                $today->year
            )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | Cancer Patient History Count
    |--------------------------------------------------------------------------
    */

        $totalCancerPatientHistory =
            PatientCancerPhoto::count();

        $todayCancerPatientHistory =
            PatientCancerPhoto::whereDate(
                'created_at',
                $today
            )->count();

        $weeklyCancerPatientHistory =
            PatientCancerPhoto::whereBetween(
                'created_at',
                [
                    $today->copy()->startOfWeek(),
                    $today->copy()->endOfWeek()
                ]
            )->count();

        $monthlyCancerPatientHistory =
            PatientCancerPhoto::whereMonth(
                'created_at',
                $today->month
            )
            ->whereYear(
                'created_at',
                $today->year
            )
            ->count();


        /*
    |--------------------------------------------------------------------------
    | Dashboard View
    |--------------------------------------------------------------------------
    */

        return view(
            'backend.dashboard_page.dashboard',
            compact(

                'totalPatients',
                'todayPatients',
                'weeklyPatients',
                'monthlyPatients',

                'totalRecommendedPatients',
                'todayRecommendedPatients',
                'weeklyRecommendedPatients',
                'monthlyRecommendedPatients',

                'totalEmergencyPatientHistory',
                'todayEmergencyPatientHistory',
                'weeklyEmergencyPatientHistory',
                'monthlyEmergencyPatientHistory',

                'totalCancerPatientHistory',
                'todayCancerPatientHistory',
                'weeklyCancerPatientHistory',
                'monthlyCancerPatientHistory'
            )
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
        $term = trim($request->input('term'));

        Log::info('Global search term: ' . $term);

        if (!$term || strlen($term) < 2) {
            return response()->json([]);
        }

        $results = [];

        /*
    |--------------------------------------------------------------------------
    | Try to Parse Date
    |--------------------------------------------------------------------------
    */

        $parsedDate = null;

        try {
            $parsedDate = Carbon::parse($term)->format('Y-m-d');
        } catch (\Exception $e) {
            // Ignore invalid date
        }

        /*
    |--------------------------------------------------------------------------
    | Patient Search
    |--------------------------------------------------------------------------
    */

        $patients = Patient::query()
            ->where(function ($q) use ($term, $parsedDate) {

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

                /*
            |--------------------------------------------------------------------------
            | Search Patient Added Date
            |--------------------------------------------------------------------------
            */

                if ($parsedDate) {
                    $q->orWhereDate(
                        'date_of_patient_added',
                        $parsedDate
                    );
                }
            })
            ->limit(15)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Build Search Results
    |--------------------------------------------------------------------------
    */

        foreach ($patients as $patient) {

            $name = $this->highlightMatch(
                $patient->patient_name,
                $term
            );

            $code = $this->highlightMatch(
                $patient->patient_code,
                $term
            );

            $fathersName = $this->highlightMatch(
                $patient->patient_f_name,
                $term
            );

            $mothersName = $this->highlightMatch(
                $patient->patient_m_name,
                $term
            );

            $results[] = [

                /*
            |--------------------------------------------------------------------------
            | Patient Display Information
            |--------------------------------------------------------------------------
            */

                'label' =>
                "{$name} ({$code}) " .
                    "[Father's Name - {$fathersName}] " .
                    "[Mother's Name - {$mothersName}]",

                /*
            |--------------------------------------------------------------------------
            | Patient URL
            |--------------------------------------------------------------------------
            */

                'url' => route(
                    'patients.show',
                    $patient->id
                ),

                /*
            |--------------------------------------------------------------------------
            | Patient Statuses
            |--------------------------------------------------------------------------
            */

                'is_recommend' => (bool) $patient->is_recommend,

                'is_old_cancer' => (bool) $patient->is_old_cancer,

                'is_emergency' => (bool) $patient->is_emergency,
            ];
        }

        return response()->json($results);
    }


    protected function highlightMatch(
        ?string $text,
        string $term
    ): string {
        // Handle null or empty text
        if (empty($text)) {
            return '';
        }

        // If search term is empty, safely return escaped text
        if (empty($term)) {
            return e($text);
        }

        /*
    |--------------------------------------------------------------------------
    | Escape the full text first
    |--------------------------------------------------------------------------
    */

        $escapedText = e($text);

        /*
    |--------------------------------------------------------------------------
    | Escape the search term
    |--------------------------------------------------------------------------
    */

        $escapedTerm = e($term);

        /*
    |--------------------------------------------------------------------------
    | Highlight matched text
    |--------------------------------------------------------------------------
    */

        return preg_replace(
            '/' . preg_quote($escapedTerm, '/') . '/i',
            '<span style="color:#ff6b6b; font-weight:700;">$0</span>',
            $escapedText
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
        $backupDir = storage_path('app/backups');
        $lastBackupTime = 'No backup found';

        if (File::exists($backupDir)) {
            $files = collect(File::files($backupDir))
                ->filter(fn($file) => strtolower($file->getExtension()) === 'sql');

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
