<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Restaurant;
use App\Menu;
use App\Helpers;

class MenuController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $menu = Menu::all()->toArray();
        if (count($menu) == 0 ) {
            $menu = new Menu([
                'res_id'   => 1,
                'p1'       => '',
                'p2'       => '',
                'p3'       => '',
                'p4'       => '',
                'p5'       => '',
                'p6'       => '',
                'p7'       => '',
                'p8'       => '',
                'pr1'      => 0,
                'pr2'      => 0,
                'pr3'      => 0,
                'pr4'      => 0,
                'pr5'      => 0,
                'pr6'      => 0,
                'pr7'      => 0,
                'pr8'      => 0,
                'fechado'     => 0,
                'data'     => date("Y-m-d")
            ]);
            $menu->save();    
        }
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = Restaurant::where('padrao', '=', '1')->get();
        $id = 0;
        foreach ($restaurant as $r) {
            $id = $r->id;
        }
        if ($id === 0) {
            $restaurantDefault = null;
        } else {
            $restaurantDefault = Restaurant::find($id)->toArray();
        }

        if(!$this->verificaPedido($id)) {
            $this->cardapioDoDia();
            $menu = Menu::find(1);
            $restaurantDefault = Restaurant::find($menu->res_id)->toArray();
            return view('menu.index')->with('restaurantDefault', $restaurantDefault)->with('menu', $menu);
        }
        $menu = Menu::find(1);
        return view('menu.index')->with('restaurantDefault', $restaurantDefault)->with('menu', $menu);
    }

    // Atualiza cardápio
    public function update(Request $request, $res_id) {
        $menu = Menu::find(1);
        $pr1 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr1'));
        $pr2 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr2'));
        $pr3 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr3'));
        $pr4 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr4'));
        $pr5 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr5'));
        $pr6 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr6'));
        $pr7 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr7'));
        $pr8 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr8'));
        $menu->p1  = $request->get('p1');
        $menu->p2  = $request->get('p2');
        $menu->p3  = $request->get('p3');
        $menu->p4  = $request->get('p4');
        $menu->p5  = $request->get('p5');
        $menu->p6  = $request->get('p6');
        $menu->p7  = $request->get('p7');
        $menu->p8  = $request->get('p8');
        $menu->pr1 = $pr1;
        $menu->pr2 = $pr2;
        $menu->pr3 = $pr3;
        $menu->pr4 = $pr4;
        $menu->pr5 = $pr5;
        $menu->pr6 = $pr6;
        $menu->pr7 = $pr7;
        $menu->pr8 = $pr8;
        $menu->save();
        $menu = Menu::find(1);
        $restaurantDefault = Restaurant::find($res_id)->toArray();
        return view('menu.index')->with('restaurantDefault', $restaurantDefault)->with('menu', $menu);
    }

    // Checa se a data é a mesma do dia em questão. Se não, prepara
    public function cardapioDoDia()
    {
        $menuOfDay = Menu::where('data', '!=', date("Y-m-d"))->get();
        $data = 0;
        foreach ($menuOfDay as $m) {
            $data = $m->data;
        }
        $restaurant = Restaurant::where('padrao', '=', '1')->get();
        $vlr_m = 0;
        $res_id = 0;
        foreach ($restaurant as $r) {
            $res_id = $r->id;
            $vlr_m = $r->vlr_m;
        }
        
        if ($data != date("Y-m-d")) {
            foreach ($menuOfDay as $menu) {
                $menu->res_id = $res_id;
                $menu->p1 = '';
                $menu->p2 = '';
                $menu->p3 = '';
                $menu->p4 = '';
                $menu->p5 = '';
                $menu->p6 = '';
                $menu->p7 = '';
                $menu->p8 = '';
                $menu->pr1 = $vlr_m;
                $menu->pr2 = $vlr_m;
                $menu->pr3 = $vlr_m;
                $menu->pr4 = $vlr_m;
                $menu->pr5 = $vlr_m;
                $menu->pr6 = $vlr_m;
                $menu->pr7 = $vlr_m;
                $menu->pr8 = $vlr_m;
                $menu->fechado = 0;
                $menu->data = date("Y-m-d");
                $menu->save();
            }
        }
    }

    // Verifica se já existe pedido do dia
    public function verificaPedido($id): bool
    {
        //$restaurant = Restaurant::where('padrao', '=', '1')->get();
        //$menu = Menu::where('res_id', '=', 3)->get();
        $menus = Menu::where('data', '=', date("Y-m-d"))->where('res_id', '=', $id)->get();
        $id = 0;
        foreach ($menus as $menu) {
            $id = $menu->id;
        }

        if (!empty($id)) {
            return true;
        }
        return false;

    }

}
