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
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/app/tabelas', 'TableController@tables')->name('tables');

/* Restaurantes */
Route::get('/app/tabelas/restaurantes', 'RestaurantController@index')->name('restaurant.index');
Route::get('/app/tabelas/restaurantes/inserir', 'RestaurantController@create')->name('restaurant.create');
Route::post('/app/tabelas/restaurantes/inserir', 'RestaurantController@store')->name('restaurant.store');
Route::get('/app/tabelas/restaurantes/editar/{id}', 'RestaurantController@edit')->name('restaurant.edit');
Route::post('/app/tabelas/restaurantes/editar/{id}', 'RestaurantController@update')->name('restaurant.update');
Route::delete('/app/tabelas/restaurantes/deletar/{id}', 'RestaurantController@destroy')->name('restaurant.destroy');

/* Funcionários */
Route::get('/app/tabelas/funcionarios', 'EmployeeController@index')->name('employee.index');
Route::get('/app/tabelas/funcionarios/inserir', 'EmployeeController@create')->name('employee.create');
Route::post('/app/tabelas/funcionarios/inserir', 'EmployeeController@store')->name('employee.store');
Route::get('/app/tabelas/funcionarios/editar/{id}', 'EmployeeController@edit')->name('employee.edit');
Route::post('/app/tabelas/funcionarios/editar/{id}', 'EmployeeController@update')->name('employee.update');
Route::delete('/app/tabelas/funcionarios/deletar/{id}', 'EmployeeController@destroy')->name('employee.destroy');
