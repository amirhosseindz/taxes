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

use Illuminate\Routing\Router;

Route::get('/', function () {
    return redirect(route('home'));
});

Auth::routes();

Route::group(['middleware' => 'auth'], function (Router $router) {
    $router->get('home', 'HomeController@index')->name('home');

    $router->group(['prefix' => 'profile', 'as' => 'profile'], function (Router $router) {
        $router->get('/', 'ProfileController@index');
        $router->post('updateInfo', 'ProfileController@updateInfo')->name('.info');
        $router->post('updatePass', 'ProfileController@updatePass')->name('.pass');
    });

    $router->resource('states', 'StateController')->except(['show']);
});

