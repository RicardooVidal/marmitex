<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/app/tabelas', 'TableController@tables')->name('tables');
Route::get('/app/tabelas/restaurantes', 'RestaurantsController@index')->name('restaurant');
Route::get('/app/tabelas/restaurantes/inserir', 'RestaurantsController@create')->name('restaurant.create');
Route::post('/app/tabelas/restaurantes/inserir', 'RestaurantsController@store')->name('restaurant.store');