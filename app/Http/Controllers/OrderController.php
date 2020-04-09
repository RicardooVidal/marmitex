<?php

namespace App\Http\Controllers;
use App\Menu;
use App\Restaurant;
use App\Employee;
use App\Order;
use App\Config;

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
        $config = Config::find(1)->toArray();
        return view('order.index')->with('restaurantDefault', $restaurantDefault)->with('menu', $menu)->with('employees', $employees)->with('config', $config);
    }

    public function store(Request $request) 
    {

        $res_id      = $request->get('restaurante');
        $prato       = $request->get('prato');
        $vlr_m       = (double) $request->get('preco');
        $funcionario = $request->get('funcionario');
        $observacao  = $request->get('observacao');

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
        $horario = $this->time();
        
        if ($horario) {
            $menu = Menu::find(1)->toArray();
            $employees = Employee::all()->sortBy('nome')->toArray();
            $restaurantDefault = Restaurant::find($res_id)->toArray();
            return redirect()->back()->with('restaurantDefault', $restaurantDefault)->with('menu', $menu)->with('employees', $employees)->with('timeOut', ['Pedido não efetuado. Fora de horário.']);
        }

        $order->save();
        $menu = Menu::find(1)->toArray();
        $employees = Employee::all()->sortBy('nome')->toArray();
        $restaurantDefault = Restaurant::find($res_id)->toArray();
        return redirect()->back()->with('restaurantDefault', $restaurantDefault)->with('menu', $menu)->with('employees', $employees)->with('success', ['Pedido inserido com sucesso.']);
    }

    public function time(): bool 
    {
        $config = Config::find(1)->get();
        $horario = '';
        foreach ($config as $c) {
            $horario = strtotime($c->horario);
        }

        $horaatual = strtotime("now");
        
        if($horario > $horaatual){
            return true;
        }

        return false;
    }

    public function block($id) 
    {
        $employee = Employee::where('id', '=', $id)->get();
        foreach ($employee as $e)
        {
            $block = $e->bloqueado;
        }
        if ($block === 1) {
            return response()->json([
                'isBlocked' => $block,
              ]);
        }
    }

    public function observation($id) 
    {
        $employee = Employee::where('id', '=', $id)->get();
        foreach ($employee as $e)
        {
            $block = $e->observacao;
        }
        if ($block === 2) {
            return response()->json([
                'isBlocked' => $block,
              ]);
        }
    }

    public function message($id) 
    {
        $employee = Employee::where('id', '=', $id)->get();
        foreach ($employee as $e)
        {
            $msg = $e->mensagem;
        }
        if (!empty($msg)) {
            return response()->json([
                'hasMessage' => $msg,
              ]);
        }
    }
}
