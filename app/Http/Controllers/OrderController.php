<?php

namespace App\Http\Controllers;
use App\Menu;
use App\Restaurant;
use App\Employee;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth'); Não precisa de login
    }

    public function index()
    {
        $menu = Menu::find(1)->get();
        $res_id = 0;
        foreach ($menu as $m) {
            $res_id = $m->res_id;
        }
        $menu = Menu::find(1)->toArray();
        $employees = Employee::all()->sortBy('nome')->toArray();
        $restaurantDefault = Restaurant::find($res_id)->toArray();
        return view('order.index')->with('restaurantDefault', $restaurantDefault)->with('menu', $menu)->with('employees', $employees);
    }

    public function store(Request $request) 
    {

        // if ($validator->fails()) {
        //     return redirect('/app/tabelas/funcionarios/inserir')
        //         ->withErrors($validator)
        //         ->withInput();
        // }

        $res_id = $request->get('restaurante');
        $prato = $request->get('restaurante');

        $restaurantDefault = Restaurant::find($res_id)->toArray();
        $vlr_m = 0;
        $menu = Menu::where('valor', '!=', date("Y-m-d"))->get();
        foreach ($Menu as $m) {
            $valor = $m->valor;
        }
        $order = new Order([
            'res_id '    => $request->get('restaurante'),
            'func_id'    => $request->get('funcionario'),
            'prato'      => $request->get('prato'),
            'quantidade' => 1,
            'data'       => date("Y-m-d"),
            'valor'      => $menu
        ]);
        $employee->save();
        $employees = Employee::all()->toArray();
        return view('tables.employee')->with('employees', $employees)->with('success', 'Funcionário adicionado com Sucesso.');
    }
}
