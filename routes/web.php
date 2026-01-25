<?php

use App\Http\Controllers\WelcomePageController;
use App\Http\Controllers\TenderAwardedController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SystemUserController;
use App\Http\Controllers\BanUserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\BGController;
use App\Http\Controllers\PGController;
use App\Http\Controllers\TenderProgressController;
use App\Http\Controllers\TenderCompletedController;
use App\Http\Controllers\TenderParticipatedController;
use App\Http\Controllers\TenderArchivedController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ViewPermissionManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [WelcomePageController::class, 'index'])->name('welcome');

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

    // Tender Routes
    Route::resource('organizations', OrganizationController::class);
    Route::post('/add-supplier-option', [TenderController::class, 'addSupplierOption'])->name('supplier.create');

    Route::resource('tenders', TenderController::class);
    Route::get('tenders/{id}/download-spec', [TenderController::class, 'downloadSpec'])->name('tenders.downloadSpec');
    Route::get('tenders/{id}/download-notice', [TenderController::class, 'downloadNotice'])->name('tenders.downloadNotice');
    Route::post('tenders/mark-status/{id}', [TenderController::class, 'updateStatus'])->name('tenders.updateStatus');

    Route::get('/pg_bg_management', [TenderController::class, 'bg_pg'])->name('bg_pg.index');
    Route::resource('bg', BGController::class);
    Route::resource('pg', PGController::class);

    // Tender Archived
    Route::resource('/archived_tenders', TenderArchivedController::class);

    // Tender Participated
    Route::get('/tender_participated/data', [TenderController::class, 'participatedData'])->name('tenders.participated.data');
    Route::get('/tender_participated-letter/{id}', [TenderParticipatedController::class, 'letter'])->name('participated_tenders.letter');
    Route::post('/tender_participated-letter-store/{id}', [TenderParticipatedController::class, 'letterStore'])->name('participated_tenders.letter.store');
    Route::get('/tender_participated-letter-edit/{id}', [TenderParticipatedController::class, 'letterEdit'])->name('participated_tenders.letter.edit');
    Route::put('/tender_participated-letter-update/{id}', [TenderParticipatedController::class, 'letterUpdate'])->name('participated_tenders.letter.update');
    Route::delete('/tender_participated-letter-delete/{id}', [TenderParticipatedController::class, 'letterDestroy'])->name('participated_tenders.letter.destroy');
    Route::resource('participated_tenders', TenderParticipatedController::class);

    // Tender Awarded
    Route::get('/get-tender-participate-details/{tenderId}', [TenderAwardedController::class, 'getTenderParticipateDetails'])->name('participate.data');
    Route::get('/tender_awarded-letter/{tenderId}', [TenderAwardedController::class, 'letter'])->name('awarded_tenders.letter');
    Route::post('/tender_awarded-letter-store/{id}', [TenderAwardedController::class, 'letterStore'])->name('awarded_tenders.letter.store');
    Route::get('/tender_awarded-letter-edit/{id}', [TenderAwardedController::class, 'letterEdit'])->name('awarded_tenders.letter.edit');
    Route::put('/tender_awarded-letter-update/{id}', [TenderAwardedController::class, 'letterUpdate'])->name('awarded_tenders.letter.update');
    Route::delete('/tender_awarded-letter-delete/{id}', [TenderAwardedController::class, 'letterDestroy'])->name('awarded_tenders.letter.destroy');
    Route::get('/awarded_tenders/first-time-data', [TenderAwardedController::class, 'firstTimeData'])->name('awarded_tenders.first_time_data');
    Route::get('/awarded_tenders/partial-data', [TenderAwardedController::class, 'partialData'])->name('awarded_tenders.partial_data');
    Route::resource('awarded_tenders', TenderAwardedController::class);

    //Tender Progress
    Route::get('/get-tender-awarded-details/{awardedId}', [TenderProgressController::class, 'getTenderAwardedDetails'])->name('awarded.data');
    Route::get('/tender_progress-letter/{tenderId}', [TenderProgressController::class, 'letter'])->name('tender_progress.letter');
    Route::post('/tender_progress-letter-store/{id}', [TenderProgressController::class, 'letterStore'])->name('tender_progress.letter.store');
    Route::get('/tender_progress-letter-edit/{id}', [TenderProgressController::class, 'letterEdit'])->name('tender_progress.letter.edit');
    Route::put('/tender_progress-letter-update/{id}', [TenderProgressController::class, 'letterUpdate'])->name('tender_progress.letter.update');
    Route::delete('/tender_progress-letter-delete/{id}', [TenderProgressController::class, 'letterDestroy'])->name('tender_progress.letter.destroy');
    Route::resource('tender_progress', TenderProgressController::class);

    // Tender Completed
    Route::get('/completed_tenders-letter/{tenderId}', [TenderCompletedController::class, 'letter'])->name('completed_tenders.letter');
    Route::post('/completed_tenders-letter-store/{id}', [TenderCompletedController::class, 'letterStore'])->name('completed_tenders.letter.store');
    Route::get('/completed_tenders-letter-edit/{id}', [TenderCompletedController::class, 'letterEdit'])->name('completed_tenders.letter.edit');
    Route::put('/completed_tenders-letter-update/{id}', [TenderCompletedController::class, 'letterUpdate'])->name('completed_tenders.letter.update');
    Route::delete('/completed_tenders-letter-delete/{id}', [TenderCompletedController::class, 'letterDestroy'])->name('completed_tenders.letter.destroy');
    Route::resource('completed_tenders', TenderCompletedController::class);
    Route::get('/get-tender-awarded-progress-details/{participateId}', [TenderCompletedController::class, 'getTenderProgressDetails'])->name('progress.data');

    Route::get('/user_profile', [ProfileController::class, 'user_profile_show'])->name('user_profile_show');
    Route::get('/user_profile_edit', [ProfileController::class, 'user_profile_edit'])->name('user_profile_edit');
    Route::put('/user_profile_edit', [ProfileController::class, 'user_profile_update'])->name('user_profile_update');
    Route::put('/user_password_update', [ProfileController::class, 'updatePassword'])->name('user_password_update');
    Route::get('/user_password_edit', [ProfileController::class, 'editPassword'])->name('user_password_edit');
    Route::get('/user_password_reset', [ProfileController::class, 'resetPassword'])->name('user_password_reset');

    // Permissions & Roles
    // Route::get('/all-permissions', [Roles_And_Permissions::class, 'permissionsIndex'])->name('permissions.index');
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('/permissions/delete-selected', [PermissionController::class, 'deleteSelected'])->name('permissions.deleteSelected');
    Route::resource('system_users', SystemUserController::class);
    Route::resource('ban_users', BanUserController::class);
    Route::post( '/system-users/{user}/change-password',[SystemUserController::class, 'updatePassword'])->name('system_users.password.update');
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
    Route::get('/organization_menu', fn() => abort(403))->name('organization_menu');
    Route::get('/tender_menu', fn() => abort(403))->name('tender_menu');
    Route::get('/setting_menu', fn() => abort(403))->name('setting_menu');
});

Auth::routes([
    'register' => false, // disables register
]);

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth')->name('logout');