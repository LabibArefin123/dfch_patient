<?php

use App\Http\Controllers\WelcomePageController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\SystemUserController;
use App\Http\Controllers\BanUserController;
use App\Http\Controllers\SettingController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\ViewPermissionManagement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', [WelcomePageController::class, 'index'])->name('welcome');
Route::get('/prof-dr-akm-fazlul-hoque', [WelcomePageController::class, 'doc_1'])->name('doc_1');
Route::get('/dr-asif-almas-haque', [WelcomePageController::class, 'doc_2'])->name('doc_2');
Route::get('/dr-fatema-sharmin-anny', [WelcomePageController::class, 'doc_3'])->name('doc_3');
Route::get('/dr-sakib-sarwat-haque', [WelcomePageController::class, 'doc_4'])->name('doc_4');
Route::get('/dr-asma-husain-noora', [WelcomePageController::class, 'doc_5'])->name('doc_5');

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

    Route::resource('patients', PatientController::class);
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