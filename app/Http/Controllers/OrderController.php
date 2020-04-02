<?php

namespace App\Http\Controllers;
use App\Menu;
use App\Restaurant;
use App\Employee;
use App\Order;

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
        $res_id      = $request->get('restaurante');
        $prato       = $request->get('prato');
        $vlr_m       = $request->get('preco');
        $funcionario = $request->get('funcionario');
        $observacao  = $request->get('observacao');
        //teste p/git
        $order = new Order([
            'res_id'         => $res_id,
            'func_id'        => $funcionario,
            'prato'          => $prato,
            'quantidade'     => 1,
            'data'           => date("Y-m-d"),
            'valor'          => $vlr_m,
            'valor_desconto' => $vlr_m*0.50,
            'situacao'       => 0,
            'observacao'     => $observacao
        ]);
        $order->save();
        $menu = Menu::find(1)->toArray();
        $employees = Employee::all()->sortBy('nome')->toArray();
        $restaurantDefault = Restaurant::find($res_id)->toArray();
        return view('order.index')->with('restaurantDefault', $restaurantDefault)->with('menu', $menu)->with('employees', $employees)->with('success', 'Pedido inserido com sucesso.');
    }
}
