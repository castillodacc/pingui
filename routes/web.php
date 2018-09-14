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

Route::get('/', 'RouteController@front');
Route::get('publicacion/{slug}', 'RouteController@publication')->name('publication.show');
Route::get('publicacion/{slug}/inscribir', 'RouteController@inscription')->name('publication.inscription');
Route::get('confirm/{slug}', 'RouteController@confirm');
Route::post('get-data', 'RouteController@data');

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
});

Route::post('app', 'RouteController@dataForTemplate');

/**
 * Requieren autentificación.
 */
Route::group(['middleware' => ['auth', 'onlyAjax']], function () {

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

    Route::resource('tournament', 'TournamentController')->except(['create', 'edit']);
    Route::post('get-tournament', 'TournamentController@dataForRegister');
    Route::post('upload/{name}', 'TournamentController@upload');

    Route::resource('organizer', 'OrganizerController')->except(['create', 'edit']);

    Route::resource('clubs', 'ClubsController')->except(['create', 'edit']);

    Route::resource('referees', 'RefereeController')->except(['create', 'edit']);

    Route::resource('category-s', 'CategorySController')->except(['create', 'edit']);
    Route::post('categories-s', 'CategorySController@dataForRegister');

    Route::resource('category-o', 'CategoryOController')->except(['create', 'edit']);
    Route::post('categories-o', 'CategoryOController@dataForRegister');

    Route::resource('category-l', 'CategoryLController')->except(['create', 'edit']);
    Route::post('categories-l', 'CategoryLController@dataForRegister');

    // Route::resource('inscriptions', 'InscriptionController')->except(['create', 'edit']);

    Route::group(['prefix' => '/', 'namespace' => 'Dashboard', 'as' => 'Dashboard::'], function () {
        Route::get('profile', 'ProfileController@show');
        Route::post('change-pass', 'ProfileController@editPassword');
        Route::post('update-user', 'ProfileController@editUser');
        Route::post('update-bailarin/{id}', 'ProfileController@bailarin');
        Route::post('update-pareja', 'ProfileController@pareja');
    });

    Route::post('admin/app', 'RouteController@canPermission');

});

Route::get('{any?}', 'RouteController@index')->where('any', '.*');
