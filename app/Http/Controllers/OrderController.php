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

        $menu = Menu::find(1);
        $restaurantDefault = Restaurant::find($res_id)->toArray();

        $order = new Order([
            'res_id '        => $request->get('restaurante'),
            'func_id'   => $request->get('funcionario'),
            'prato'    => $request->get('prato'),
            'quantidade'      => 1,
            'data'      => date("Y-m-d"),

            'mensagem'      => $request->get('mensagem'),
        ]);
        $employee->save();
        $employees = Employee::all()->toArray();
        return view('tables.employee')->with('employees', $employees)->with('success', 'Funcionário adicionado com Sucesso.');

        echo $request->get('funcionario');
        echo $request->get('prato');
        echo $request->get('observacao');
        echo $request->get('restaurante');
    }
}
