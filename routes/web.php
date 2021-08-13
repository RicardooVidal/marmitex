<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckLicense;

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

// Route::get('/', function () {
//     return view('home');
// });

Route::middleware([CheckLicense::class])->group(function () {
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

    /* Usuários */
    Route::get('/app/tabelas/usuarios', 'UserController@index')->name('user.index');
    Route::get('/app/tabelas/usuarios/inserir', 'UserController@create')->name('user.create');
    Route::post('/app/tabelas/usuarios/inserir', 'UserController@store')->name('user.store');
    Route::get('/app/tabelas/usuarios/editar/{id}', 'UserController@edit')->name('user.edit'); // Desativado no menu
    Route::post('/app/tabelas/usuarios/editar/{id}', 'UserController@update')->name('user.update'); // Desativado
    Route::delete('/app/tabelas/usuarios/deletar/{id}', 'UserController@destroy')->name('user.destroy');

    /*Configurações */
    Route::get('/app/configuracoes', 'ConfigController@index')->name('config.index');
    Route::post('/app/configuracoes/salvar', 'ConfigController@update')->name('config.update'); 

    /*Cardápio*/
    Route::get('/app/cardapio', 'MenuController@index')->name('menu.index');
    Route::post('/app/cardapio/editar/{res_id}', 'MenuController@update')->name('menu.update');

    /* Pedido */
    Route::get('/app/pedido', 'OrderController@index')->name('order.index');
    Route::post('/app/pedido/pedir', 'OrderController@store')->name('order.store');
    Route::post('/app/pedido/bloqueio/{id}', 'OrderController@block')->name('order.block');
    Route::delete('/app/pedido/deletar/{id}', 'OrderController@destroy')->name('order.destroy');
    Route::post('/app/pedido/observacao/{id}', 'OrderController@observation')->name('order.observation');
    Route::post('/app/pedido/mensagem/{id}', 'OrderController@message')->name('order.message');
    Route::post('/app/pedido/pediu/{id}', 'OrderController@ordered')->name('order.ordered');
    Route::get('/app/pedido/visualizar', 'OrderController@view')->name('order.view');
    Route::post('/app/pedido/gerar', 'OrderController@generateOrder')->name('order.generate');
    Route::get('/app/pedido/etiquetas', 'OrderController@generateTags')->name('order.tags');
    Route::get('/app/pedido/abrir', 'OrderController@openLastOrder')->name('order.open');
    Route::get('/app/pedido/fechar', 'OrderController@closeOrder')->name('order.close');

    /* Cobrança */

    Route::get('/app/cobranca', 'BillController@index')->name('bill.index');
    Route::post('/app/cobranca', 'BillController@generateBill')->name('bill.generateBill');
    Route::post('/app/cobranca/gerar', 'BillController@generateDropOfBill')->name('bill.dropBill');

    /* Cobrança */

    Route::get('/app/cobranca', 'BillController@index')->name('bill.index');
    Route::post('/app/cobranca', 'BillController@generateBill')->name('bill.generateBill');
    Route::post('/app/cobranca/gerar', 'BillController@generateDropOfBill')->name('bill.dropBill');

    /* Consulta de Pedido Anterior */
    Route::get('/app/consulta_pedido', 'PreviousOrderController@index')->name('previous.index');
    Route::post('/app/consulta_pedido/consultar', 'PreviousOrderController@consultPrevious')->name('previous.consult');
    Route::post('/app/consulta_pedido/imprimir', 'PreviousOrderController@print')->name('previous.print');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/app/tabelas', 'TableController@tables')->name('tables');
Route::get('/check', 'BillingController@check')->name('billing.check');