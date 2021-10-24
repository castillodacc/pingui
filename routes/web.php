<?php

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

use App\Models\Organizer;
use Illuminate\Support\Facades\Config;

Route::get('/asd', function () {

//     $organizer = Organizer::first();

//     $payPalConfig = Config::get('paypal');
//     $payPalConfig['account']['client_id'] = $organizer->paypal_client_id;
//     $payPalConfig['account']['client_secret'] = $organizer->paypal_client_secret;

//     $apiContext = new \PayPal\Rest\ApiContext(
//         new \PayPal\Auth\OAuthTokenCredential(
//             $payPalConfig['account']['client_id'],
//             $payPalConfig['account']['client_secret']
//         )
//     );

//     dd($payPalConfig, $apiContext, payWithPayPal($payPalConfig, $apiContext));

//     // $this->apiContext->setConfig($payPalConfig['settings']);


});



Route::get('/', 'RouteController@front');
Route::get('competicion/{slug}', 'RouteController@publication')->name('publication.show');
Route::get('confirm/{slug}', 'RouteController@confirm');
Route::get('contacto', 'RouteController@contact');
Route::post('contact-save', 'RouteController@contactSave');
Route::get('competicion/{slug}/inscribir', 'RouteController@inscription')->name('publication.inscription');

Route::group(['middleware' => 'auth'], function () {
    Route::get('payment/status/{id}', 'InscriptionController@paymentStatus')->name('payment.status');
    Route::get('csv-competition/{tournament}', 'ReportController@csvCompetition');
});

Route::get('lista/{slug}', 'RouteController@list')->name('list');
Route::get('pdf-lista/{id}', 'ReportController@ListInscriptions');

/**
 * Rutas típicas de autentificación de la app.
 * reemplazando: Auth::routes();
 */
Route::group(['namespace' => 'Auth'], function () {
    // Rutas de Autentificación...
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        // Rutas de Registro... 
        if (config('frontend.registration_open')) {
            Route::get('registro', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register');
        }
    });
    Route::post('logout', 'LoginController@logout')->name('logout');
    // Route::get('logout', 'LoginController@logout');
});
Route::get('password/reiniciar', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reiniciar/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reiniciar', 'Auth\ResetPasswordController@reset');

Route::post('app', 'RouteController@dataForTemplate');

/**
 * Requieren autentificación.
 */
Route::group(['middleware' => ['auth', 'onlyAjax']], function () {

    Route::post('get-data', 'RouteController@data');

    /**
     * Admin, Acceso para usuarios con privilegios.
     * "/admin/*"
     */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::'], function () {

        // Users Routes...
        Route::resource('users', 'UsersController')->except(['create', 'edit']);
        Route::post('get-data-users', 'UsersController@dataForRegister');
        // Route::get('init-session-user/{id}', 'UsersController@initWithOneUser');

        // Roles Routes...
        Route::resource('roles', 'RolesController')->except(['create', 'edit']);
        Route::post('get-data-roles', 'RolesController@dataForRegister');

        // Permissions Routes...
        Route::resource('permissions', 'PermissionsController')->only(['index', 'show', 'update']);
    });

    Route::get('tournament/user', 'TournamentController@user');
    Route::resource('tournament', 'TournamentController')->except(['create', 'edit']);
    Route::post('get-tournament', 'TournamentController@dataForRegister');
    Route::post('upload/{name}', 'TournamentController@upload');
    Route::post('upload-file/{type_id}', 'TournamentController@uploadFile');

    Route::resource('organizer', 'OrganizerController')->except(['create', 'edit']);

    Route::resource('clubs', 'ClubsController')->except(['create', 'edit']);

    Route::resource('referees', 'RefereeController')->except(['create', 'edit']);

    Route::resource('category-s', 'CategorySController')->except(['create', 'edit']);
    Route::post('categories-s', 'CategorySController@dataForRegister');

    Route::resource('category-o', 'CategoryOController')->except(['create', 'edit']);
    Route::post('categories-o', 'CategoryOController@dataForRegister');

    Route::resource('category-l', 'CategoryLController')->except(['create', 'edit']);
    Route::post('categories-l', 'CategoryLController@dataForRegister');

    Route::resource('inscription', 'InscriptionController')->except(['create', 'edit']);
    Route::post('generate/{tournament}', 'InscriptionController@generateDorsales');
    Route::post('get-data-inscription', 'InscriptionController@getData');

    Route::group(['prefix' => '/', 'namespace' => 'Dashboard', 'as' => 'Dashboard::'], function () {
        Route::post('auto-deleted', 'ProfileController@autoDeleting');
        Route::get('profile', 'ProfileController@show');
        Route::post('subcategories', 'ProfileController@subcategories');
        Route::post('change-pass', 'ProfileController@editPassword');
        Route::post('update-user', 'ProfileController@editUser');
        Route::post('update-bailarin/{id}', 'ProfileController@bailarin');
        Route::post('update-pareja', 'ProfileController@pareja');
    });

    Route::post('admin/app', 'RouteController@canPermission');
});

Route::get('{any?}', 'RouteController@index')->where('any', '.*');
