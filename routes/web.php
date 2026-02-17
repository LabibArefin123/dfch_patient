<?php

use App\Http\Controllers\WelcomePageController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;


use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SystemUserController;
use App\Http\Controllers\BanUserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemProblemController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [WelcomePageController::class, 'index'])->name('welcome');
Route::post('/system-problem/store', [WelcomePageController::class, 'system_problem_store'])->name('system_problem.store');

//Specialist Part
Route::get('/prof-dr-akm-fazlul-hoque', [WelcomePageController::class, 'doc_1'])->name('doc_1');
Route::get('/dr-asif-almas-haque', [WelcomePageController::class, 'doc_2'])->name('doc_2');
Route::get('/dr-fatema-sharmin-anny', [WelcomePageController::class, 'doc_3'])->name('doc_3');
Route::get('/dr-sakib-sarwat-haque', [WelcomePageController::class, 'doc_4'])->name('doc_4');
Route::get('/dr-asma-husain-noora', [WelcomePageController::class, 'doc_5'])->name('doc_5');

//Facility Part 
Route::get('/emergency-department', [WelcomePageController::class, 'facility_1_emergency'])->name('facility_1');
Route::get('/intensive-care-unit-icu', [WelcomePageController::class, 'facility_2_icu'])->name('facility_2');
Route::get('/operation-theater-ot', [WelcomePageController::class, 'facility_3_ot'])->name('facility_3');
Route::get('/post-operative-recovery-room', [WelcomePageController::class, 'facility_4_post_op'])->name('facility_4');
Route::get('/ward', [WelcomePageController::class, 'facility_5_ward'])->name('facility_5');
Route::get('/cabin', [WelcomePageController::class, 'facility_6_cabin'])->name('facility_6');
Route::get('/laboratory', [WelcomePageController::class, 'facility_7_laboratory'])->name('facility_7');
Route::get('/radiology-and-imaging', [WelcomePageController::class, 'facility_8_radiology_and_image'])->name('facility_8');
Route::get('/ecg', [WelcomePageController::class, 'facility_9_ecg'])->name('facility_9');
Route::get('/colonoscopy', [WelcomePageController::class, 'facility_10_colonoscopy'])->name('facility_10');
Route::get('/pharmacy', [WelcomePageController::class, 'facility_11_pharmacy'])->name('facility_11');
Route::get('/24-hour-ambulance-service', [WelcomePageController::class, 'facility_12_emergency'])->name('facility_12');

Route::get('/user_profile', function () {
    return view('user_profile');
})->middleware(['auth', 'verified'])->name('profile');

//Route::group(['middleware' => ['auth', 'permission']], function () {
Route::group(['middleware' => 'auth'], function () {

    // Profile Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/system_dashboard', [DashboardController::class, 'system_index'])->name('dashboard.system');
    Route::get('/global-search', [DashboardController::class, 'globalSearch'])->name('global.search');
    Route::get('/search/result', [DashboardController::class, 'searchResult'])->name('search.result');

    // Organization Routes
    Route::resource('organizations', OrganizationController::class);

    Route::get('/user_profile', [ProfileController::class, 'user_profile_show'])->name('user_profile_show');
    Route::get('/user_profile_edit', [ProfileController::class, 'user_profile_edit'])->name('user_profile_edit');
    Route::put('/user_profile_edit', [ProfileController::class, 'user_profile_update'])->name('user_profile_update');
    Route::put('/user_password_update', [ProfileController::class, 'updatePassword'])->name('user_password_update');
    Route::get('/user_password_edit', [ProfileController::class, 'editPassword'])->name('user_password_edit');
    Route::get('/user_password_reset', [ProfileController::class, 'resetPassword'])->name('user_password_reset');

    Route::get('/patients/recommend', [PatientController::class, 'patient_recommend'])->name('patients.recommend');
    Route::get('patients/export-excel', [PatientController::class, 'exportExcel'])->name('patients.export.excel');
    Route::get('patients/export-pdf', [PatientController::class, 'exportPdf'])->name('patients.export.pdf');
    Route::post('patients/import-excel', [PatientController::class, 'importExcel'])->name('patients.import.excel');
    Route::post('patients/import-word', [PatientController::class, 'importWord'])->name('patients.import.word');
    Route::get('/patients/{id}/print-card', [PatientController::class, 'printCard'])->name('patients.print_card');
    Route::post('patients/delete-selected', [PatientController::class, 'deleteSelected'])->name('patients.delete_selected');
    Route::resource('patients', PatientController::class);

    //Report Module
    Route::get('daily_report', [ReportController::class, 'daily_report'])->name('report.daily');
    Route::get('daily_report/pdf', [ReportController::class, 'daily_report_pdf'])->name('report.daily.pdf');
    Route::get('reports/weekly', [ReportController::class, 'weekly_report'])->name('report.weekly');
    Route::get('reports/weekly/pdf', [ReportController::class, 'weekly_report_pdf'])->name('report.weekly.pdf');
    Route::get('reports/monthly', [ReportController::class, 'monthly_report'])->name('report.monthly');
    Route::get('reports/monthly/pdf', [ReportController::class, 'monthly_report_pdf'])->name('report.monthly.pdf');
    Route::get('reports/yearly', [ReportController::class, 'yearly_report'])->name('report.yearly');
    Route::get('reports/yearly/pdf', [ReportController::class, 'yearly_report_pdf'])->name('report.yearly.pdf');
    Route::get('daily_report/excel', [ReportController::class, 'daily_report_excel'])->name('report.daily.excel');
    Route::get('reports/weekly/excel', [ReportController::class, 'weekly_report_excel'])->name('report.weekly.excel');
    Route::get('reports/monthly/excel', [ReportController::class, 'monthly_report_excel'])->name('report.monthly.excel');
    Route::get('reports/yearly/excel', [ReportController::class, 'yearly_report_excel'])->name('report.yearly.excel');

    //Setting Management
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('/permissions/delete-selected', [PermissionController::class, 'deleteSelected'])->name('permissions.deleteSelected');
    Route::resource('system_users', SystemUserController::class);
    Route::resource('ban_users', BanUserController::class);
    Route::resource('system_problems', SystemProblemController::class);
    Route::post('/system-users/{user}/change-password', [SystemUserController::class, 'updatePassword'])->name('system_users.password.update');
    //Setting 
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('/settings/password_policy', [SettingController::class, 'password_policy'])->name('settings.password_policy');
    Route::get('/settings/2fa', [SettingController::class, 'show2FA'])->name('settings.2fa');
    Route::post('/settings/toggle-2fa', [SettingController::class, 'toggle2FA'])->name('settings.toggle2fa');
    Route::get('/settings/2fa/resend', [SettingController::class, 'resend'])->name('settings.2fa.resend');
    Route::post('/settings/2fa/verify', [SettingController::class, 'verify'])->name('settings.2fa.verify');
    Route::get('/settings/timeout', [SettingController::class, 'showTimeout'])->name('settings.timeout');
    Route::post('/settings/timeout', [SettingController::class, 'updateTimeout'])->name('settings.timeout.update');
    Route::get('/settings/database-backup', [SettingController::class, 'databaseBackup'])->name('settings.database.backup');
    Route::post('/settings/database-backup/download', [SettingController::class, 'downloadDatabase'])->name('settings.database.backup.download');
    Route::get('/settings/logs', [SettingController::class, 'logs'])->name('settings.logs');
    Route::post('/settings/logs/clear', [SettingController::class, 'clearLogs'])->name('settings.clearLogs');
    Route::get('/settings/maintenance', [SettingController::class, 'maintenance'])->name('settings.maintenance');
    Route::post('/settings/maintenance', [SettingController::class, 'maintenanceUpdate'])->name('settings.maintenance.update');
    Route::get('/settings/language', [SettingController::class, 'language'])->name('settings.language');
    Route::post('/settings/language/update', [SettingController::class, 'updateLanguage'])->name('settings.language.update');
    Route::get('/settings/datetime', [SettingController::class, 'dateTime'])->name('settings.datetime');
    Route::post('/settings/datetime/update', [SettingController::class, 'updateDateTime'])->name('settings.datetime.update');
    Route::get('/settings/theme', [SettingController::class, 'theme'])->name('settings.theme');
    Route::post('/settings/theme/update', [SettingController::class, 'updateTheme'])->name('settings.theme.update');
});

Auth::routes([
    'register' => false, // disables register
]);
