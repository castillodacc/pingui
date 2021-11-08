<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubsController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RefereeController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CategoryLController;
use App\Http\Controllers\CategoryOController;
use App\Http\Controllers\CategorySController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Auth\PasswordResetLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RouteController::class, 'front']);
Route::get('competicion/{slug}', [RouteController::class, 'publication'])->name('publication.show');
Route::get('confirm/{slug}', [RouteController::class, 'confirm']);
Route::get('contacto', [RouteController::class, 'contact']);
Route::post('contact-save', [RouteController::class, 'contactSave']);
Route::get('competicion/{slug}/inscribir', [RouteController::class, 'inscription'])->name('publication.inscription');

Route::group(['middleware' => 'auth'], function () {
    Route::get('payment/status/{id}', [InscriptionController::class, 'paymentStatus'])->name('payment.status');
    Route::get('csv-competition/{tournament}', [ReportController::class, 'csvCompetition']);
});

Route::get('lista/{slug}', [RouteController::class, 'list'])->name('list');
Route::get('pdf-lista/{id}', [ReportController::class, 'listInscriptions']);

/**
 * Rutas típicas de autentificación de la app.
 * reemplazando: Auth::routes();
 */
// Rutas de Autentificación...
Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    // Rutas de Registro... 
    if (config('frontend.registration_open')) {
        Route::get('registro', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);
    }
});
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('password/reiniciar', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('password/email', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('password/reiniciar/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('password/reiniciar', [NewPasswordController::class, 'store'])->name('password.update');

Route::post('app', [RouteController::class, 'dataForTemplate']);

/**
 * Requieren autentificación.
 */
Route::group(['middleware' => ['auth', 'onlyAjax']], function () {

    Route::post('get-data', [RouteController::class, 'data']);

    /**
     * Admin, Acceso para usuarios con privilegios.
     * "/admin/*"
     */
    Route::group(['prefix' => 'admin', 'as' => 'admin::'], function () {

        // Users Routes...
        Route::resource('users', UsersController::class)->except(['create', 'edit']);
        Route::post('get-data-users', [UsersController::class, 'dataForRegister']);
        // Route::get('init-session-user/{id}', [UsersController::class, 'initWithOneUser']);

        // Roles Routes...
        Route::resource('roles', RolesController::class)->except(['create', 'edit']);
        Route::post('get-data-roles', [RolesController::class, 'dataForRegister']);

        // Permissions Routes...
        Route::resource('permissions', PermissionsController::class)->only(['index', 'show', 'update']);
    });

    Route::get('tournament/user', [TournamentController::class, 'user']);
    Route::resource('tournament', TournamentController::class)->except(['create', 'edit']);
    Route::post('get-tournament', [TournamentController::class, 'dataForRegister']);
    Route::post('upload/{name}', [TournamentController::class, 'upload']);
    Route::post('upload-file/{type_id}', [TournamentController::class, 'uploadFile']);

    Route::resource('organizer', OrganizerController::class)->except(['create', 'edit']);

    Route::resource('clubs', ClubsController::class)->except(['create', 'edit']);

    Route::resource('referees', RefereeController::class)->except(['create', 'edit']);

    Route::resource('category-s', CategorySController::class)->except(['create', 'edit']);
    Route::post('categories-s', [CategorySController::class, 'dataForRegister']);

    Route::resource('category-o', CategoryOController::class)->except(['create', 'edit']);
    Route::post('categories-o', [CategoryOController::class, 'dataForRegister']);

    Route::resource('category-l', CategoryLController::class)->except(['create', 'edit']);
    Route::post('categories-l', [CategoryLController::class, 'dataForRegister']);

    Route::resource('inscription', InscriptionController::class)->except(['create', 'edit']);
    Route::post('generate/{tournament}', [InscriptionController::class, 'generateDorsales']);
    Route::post('get-data-inscription', [InscriptionController::class, 'getData']);

    Route::group(['prefix' => '/', 'as' => 'Dashboard::'], function () {
        Route::post('auto-deleted', [ProfileController::class, 'autoDeleting']);
        Route::get('profile', [ProfileController::class, 'show']);
        Route::post('subcategories', [ProfileController::class, 'subcategories']);
        Route::post('change-pass', [ProfileController::class, 'editPassword']);
        Route::post('update-user', [ProfileController::class, 'editUser']);
        Route::post('update-bailarin/{id}', [ProfileController::class, 'bailarin']);
        Route::post('update-pareja', [ProfileController::class, 'pareja']);
    });

    Route::post('admin/app', [RouteController::class, 'canPermission']);
});

Route::get('{any?}', [RouteController::class, 'index'])->where('any', '.*');
