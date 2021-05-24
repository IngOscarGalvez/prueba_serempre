<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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





Route::group(['middleware' => ['role:Admin']], function () {

    // Frontend Admin - para permanecer en pagina
    Route::get('/admin/users', 'SpaController@index');
    Route::get('/admin/cities', 'SpaController@index');
    Route::get('/admin/clients', 'SpaController@index');

    Route::apiResources([
        'users' => 'api\UsersController',
        'cities' => 'api\CityController',
        'clients' => 'api\ClientController',
    ]);

    //Route::post('/dependencias/estado', 'api\DependenciaController@estado');

    Route::get('/listarroles', 'api\UsersController@listarRoles');
    Route::get('/user/getrole', 'api\UsersController@getRolUser');
    Route::post('/user/select', 'api\UsersController@selectUser');
    Route::post('/user/updateUser', 'api\UsersController@UpdateUser');
    Route::post('/user/updateUser', 'api\UsersController@UpdateUser');

    Route::get('/listCities', 'api\CityController@listCities');
});

Route::group(['middleware' => ['role:Admin|User']], function () {

    Route::get('/acount', 'api\AcountContoller@AcountUser');
});

Route::group(['middleware' => ['role:User']], function () {
});


Route::get('/', function () {
    return redirect('/login');
});


Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');

Route::get('/send_email', 'Auth\RegisterController@sendEmail')->name('send_email');
Route::get('/register_user', 'Auth\RegisterController@register')->name('register_validate');
Route::get('/register_user_validated', 'Auth\RegisterController@createUser')->name('create_user');

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index');
