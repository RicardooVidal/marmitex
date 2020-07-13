<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\HomeController;
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
                'p9'       => '',
                'p10'      => '',
                'p11'      => '',
                'p12'      => '',
                'p13'      => '',
                'p14'      => '',
                'p15'      => '',
                'p16'      => '',
                'p17'      => '',
                'p18'      => '',
                'pr1'      => 0,
                'pr2'      => 0,
                'pr3'      => 0,
                'pr4'      => 0,
                'pr5'      => 0,
                'pr6'      => 0,
                'pr7'      => 0,
                'pr8'      => 0,
                'pr9'      => 0,
                'pr10'     => 0,
                'pr11'     => 0,
                'pr12'     => 0,
                'pr13'     => 0,
                'pr14'     => 0,
                'pr15'     => 0,
                'pr16'     => 0,
                'pr17'     => 0,
                'pr18'     => 0,
                'fechado'     => 0,
                'data'     => date("Y-m-d")
            ]);
            $menu->save();    
        }
        $this->middleware('auth');
    }

    public function index()
    {
        if (!HomeController::checkPermission()) {
            return view ('permission');
            die();
        }

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
        $pr9 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr9'));
        $pr10 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr10'));
        $pr11 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr11'));
        $pr12 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr12'));
        $pr13 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr13'));
        $pr14 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr14'));
        $pr15 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr15'));
        $pr16 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr16'));
        $pr17 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr17'));
        $pr18 = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('pr18'));


        $menu->p1  = $request->get('p1');
        $menu->p2  = $request->get('p2');
        $menu->p3  = $request->get('p3');
        $menu->p4  = $request->get('p4');
        $menu->p5  = $request->get('p5');
        $menu->p6  = $request->get('p6');
        $menu->p7  = $request->get('p7');
        $menu->p8  = $request->get('p8');
        $menu->p9  = $request->get('p9');
        $menu->p10 = $request->get('p10');
        $menu->p11 = $request->get('p11');
        $menu->p12 = $request->get('p12');
        $menu->p13 = $request->get('p13');
        $menu->p14 = $request->get('p14');
        $menu->p15 = $request->get('p15');
        $menu->p16 = $request->get('p16');
        $menu->p17 = $request->get('p17');
        $menu->p18 = $request->get('p18');

        $menu->pr1 = $pr1;
        $menu->pr2 = $pr2;
        $menu->pr3 = $pr3;
        $menu->pr4 = $pr4;
        $menu->pr5 = $pr5;
        $menu->pr6 = $pr6;
        $menu->pr7 = $pr7;
        $menu->pr8 = $pr8;
        $menu->pr9 = $pr9;
        $menu->pr10 = $pr10;
        $menu->pr11 = $pr11;
        $menu->pr12 = $pr12;
        $menu->pr13 = $pr13;
        $menu->pr14 = $pr14;
        $menu->pr15 = $pr15;
        $menu->pr16 = $pr16;
        $menu->pr17 = $pr17;
        $menu->pr18 = $pr18;

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
                $menu->p9 = '';
                $menu->p10 = '';
                $menu->p11 = '';
                $menu->p12 = '';
                $menu->p13 = '';
                $menu->p14 = '';
                $menu->p15 = '';
                $menu->p16 = '';
                $menu->p17 = '';
                $menu->p18 = '';
                $menu->pr1 = $vlr_m;
                $menu->pr2 = $vlr_m;
                $menu->pr3 = $vlr_m;
                $menu->pr4 = $vlr_m;
                $menu->pr5 = $vlr_m;
                $menu->pr6 = $vlr_m;
                $menu->pr7 = $vlr_m;
                $menu->pr8 = $vlr_m;
                $menu->pr9 = $vlr_m;
                $menu->pr10 = $vlr_m;
                $menu->pr11 = $vlr_m;
                $menu->pr12 = $vlr_m;
                $menu->pr13 = $vlr_m;
                $menu->pr14 = $vlr_m;
                $menu->pr15 = $vlr_m;
                $menu->pr16 = $vlr_m;
                $menu->pr17 = $vlr_m;
                $menu->pr18 = $vlr_m;
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
