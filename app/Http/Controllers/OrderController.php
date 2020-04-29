<?php

namespace App\Http\Controllers;
use App\Menu;
use App\Restaurant;
use App\Employee;
use App\Order;
use App\Config;
use App\Helpers;
use App\ZebraPrinter;
use App\Http\Controllers\Auth;
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
            $fechado = $m->fechado;
        }
        if ($fechado == 1) {
            return view('home')->with('orderClosed', 'Pedido fechado com sucesso.');
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
        $vlr_m       = \App\Helpers\AppHelper::instance()->convertToMoney($request->get('preco'));
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

    public function generateOrder(Request $request) 
    {
        $this->middleware('auth');

        if (\Auth::user()) {
            
            $quantidade = 0;
            $orders = Order::where('data', '=', date("Y-m-d"))->get();
            if (count($orders) == 0 ) {
                $menu = Menu::find(1)->get();
                $res_id = 0;
                foreach ($menu as $m) {
                    $res_id = $m->res_id;
                }
                $employees = Employee::all();
                $restaurantDefault = Restaurant::find($res_id)->toArray();
                $orders = Order::where('data', '=', date("Y-m-d"))->get();
                return redirect()->back()->with('orders', $orders)->with('menu',$menu)->with('employees',$employees)->with('restaurantDefault',$restaurantDefault)->with('hasNoOrders',['Não há pedido para ser gerado!.']);
            }
            $menu = Menu::find(1)->toArray();

            $adicional     = $request->get('valor');
            $qtdAdicional  = $request->get('adicional');
            $tipo_adicional = $request->get('tipo_adicional');
            $frete         = $request->get('frete');
            $total         = $request->get('total');

            $troco         = $request->get('troco');
            $observacao    = $request->get('observacao');
            $cobra_adicional = $request->get('cobra_adicional');
            $cobra_frete = $request->get('cobra_frete');

            $content = "Copie e cole o seguinte texto para o responsavel do Restaurante:" .PHP_EOL.

            PHP_EOL. "  Bom Dia, segue o pedido:".PHP_EOL;
            
            foreach ($orders as $o) {
                $prato =$o->prato;
                $content .= "    ".$o->quantidade . " " . $prato. PHP_EOL;
                $quantidade++;
            }
            
            $content .= PHP_EOL. "  Total: ".  $quantidade. " Marmitex". PHP_EOL;
            $content .="  Frete: ".  $frete. PHP_EOL;
            $content .="  ".$qtdAdicional." " .$tipo_adicional. " Valor: " .$adicional .PHP_EOL;
            $content .= "  Valor total: ".$total .PHP_EOL;
            $content .= "  Troco p/: ".$troco .PHP_EOL;
            $content .= "  Observação: ".$observacao .PHP_EOL;
            $content .= "  Obrigado";

            $menu = Menu::find(1)->get();
            $res_id = 0;
            foreach ($menu as $m) {
                $res_id = $m->res_id;
            }
            $menu = Menu::find(1)->toArray();
            $employees = Employee::all();
            $restaurantDefault = Restaurant::find($res_id)->toArray();
            $orders = Order::where('data', '=', date("Y-m-d"))->get();

            // Txt foi gerado
            if (\App\Helpers\AppHelper::instance()->generateTxt('pedido',$content)) {
                $this->divideCosts($cobra_adicional, $cobra_frete, $adicional, $frete);
                return redirect()->back()->with('orders', $orders)->with('menu',$menu)->with('employees',$employees)->with('restaurantDefault',$restaurantDefault)->with('success',['Pedido excluído com sucesso.']);
            } else {
                return redirect()->back()->with('orders', $orders)->with('menu',$menu)->with('employees',$employees)->with('restaurantDefault',$restaurantDefault)->with('error',['Erro ao gerar o pedido.']);
            }
        } else {
            return redirect('/login');
        }
    }

    // @ Parameters: check-adicional, check-frete, adicional, frete

    public function divideCosts($cobra_adicional, $cobra_frete, $adicional, $frete) {
        $orders = Order::where('data', '=', date("Y-m-d"))->get();

        $adicional = str_replace(',','.',$adicional);
        $adicional = (float) number_format($adicional,2);

        $frete = str_replace(',','.',$frete);
        $frete = (float) number_format($frete,2);

        $adicionais = $adicional / count($orders);
        $fretes = $frete / count($orders);

        if ($cobra_frete == 1) {
            foreach($orders as $o) {
                $o->frete = $fretes;
                $o->save();
            }
        }

        if ($cobra_adicional == 1) {
            foreach($orders as $o) {
                $o->adicional = $adicionais;
                $o->save();
            }
        }
    }

    public function destroy($id) 
    {
        $menu = Menu::find(1)->get();
        foreach ($menu as $m) {
            $res_id = $m->res_id;
        }
        $order = Order::find($id);
        $order->delete();
        $menu = Menu::find(1)->toArray();
        $employees = Employee::all();
        $restaurantDefault = Restaurant::find($res_id)->toArray();
        $orders = Order::where('data', '=', date("Y-m-d"))->get();
        return redirect()->back()->with('orders', $orders)->with('menu',$menu)->with('employees',$employees)->with('restaurantDefault',$restaurantDefault)->with('deleted',['Pedido excluído com sucesso.']);
    }

    public function view() 
    {
        $menu = Menu::find(1)->get();
        $employees = Employee::all();
        foreach ($menu as $m) {
            $res_id = $m->res_id;
        }
        $menu = Menu::find(1)->toArray();
        $restaurantDefault = Restaurant::find($res_id)->toArray();
        $orders = Order::where('data', '=', date("Y-m-d"))->get();
        return view('order.view')->with('orders', $orders)->with('menu',$menu)->with('employees',$employees)->with('restaurantDefault',$restaurantDefault);

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
        if ($block === 2) {
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

    public function ordered($id) 
    {
        $orders = Order::where('data', '=', date("Y-m-d"))->get();
        $ordered = 0;
        foreach ($orders as $o)
        {
            if ($o->func_id == $id) {
                $ordered = 1;
            }
        }
        if ($ordered == 1) {
            return response()->json([
                'hasOrder' => 1,
              ]);
        } else {
            return response()->json([
                'hasOrder' => 0,
              ]);
        }
    }

    public function generateTags()
    {
        $orders = Order::where('data', '=', date("Y-m-d"))->get(); 
        $menu = Menu::find(1)->toArray();
        $employees = Employee::all();

        $tags = " ".'\n';
        $tags = "@ prow()+1,00 say 'N'\n";
        $tags .= "@ prow()+1,00 say 'R01,01'\n";
        $tags .= "@ prow()+1,00 say 'S3'\n";

        foreach ($orders as $o) {
            $tags .= "@ prow()+1,00 say 'A010,10,0,3,2,1,N,"."'".'"'."+alltrim('".trim($employees[$o->func_id-1]->nome)."')+".'"'."\n";
            $tags .= "@ prow()+1,00 say 'A010,50,0,3,1,1,N,"."'".'"'."+alltrim('".trim($o->prato)."')+".'"'."\n";

            $tags .= "@ prow()+1,00 say 'A460,10,0,3,2,1,N,"."'".'"'."+alltrim('".trim($employees[$o->func_id-1]->nome)."')+".'"'."\n";
            $tags .= "@ prow()+1,00 say 'A460,50,0,3,1,1,N,"."'".'"'."+alltrim('".trim($o->prato)."')+".'"'."\n";

            $tags .= "@ prow()+1,00 say 'A460,100,0,3,1,1,N,"."'".'"'."+alltrim('".trim($o->observacao)."')+".'"'."\n";
            $tags .= "@ prow()+1,00 say 'A460,120,0,3,1,1,N,"."'".'"'."+dtoc('".date("d-m-Y", strtotime($o->data))."')+".'"'."\n";
            $tags .= "@ prow()+1,00 say 'A460,140,0,3,1,1,N,"."'".'"'."+alltrim('".trim(" ")."')+".'"'."\n";

            $tags .= "@ prow()+1,00 say 'A010,100,0,3,1,1,N,"."'".'"'."+alltrim('".trim($o->observacao)."')+".'"'."\n";
            $tags .= "@ prow()+1,00 say 'A010,120,0,3,1,1,N,"."'".'"'."+dtoc('".date("d-m-Y", strtotime($o->data))."')+".'"'."\n";
            $tags .= "@ prow()+1,00 say 'A010,140,0,3,1,1,N,"."'".'"'."+alltrim('".trim(" ").'"'."')+"."\n";

        }

        $tags .= "@ prow()+1,00 say 'P1,1'\n";

        // Txt foi gerado
        if (\App\Helpers\AppHelper::instance()->generateTxt('etiqueta',$tags)) {
            shell_exec("tags_api.exe");
            return redirect()->back()->with('orders', $orders)->with('menu',$menu)->with('employees',$employees);
        } else {
            return redirect()->back()->with('orders', $orders)->with('menu',$menu)->with('employees',$employees);
        }
    }

    public function openLastOrder() 
    {

        $this->middleware('auth');

        if (\Auth::user()) {

            $today = date("Y-m-d");
            $menu = Menu::where('data', '=', $today)->get(); 

            foreach ($menu as $m) {
                $m->fechado = 0;
                $m->save();
            }

            if (count($menu) == 0) {
                return view('home')->with('orderNotOpened', 'Pedido do dia não encontrado.');
            }

            return view('home')->with('orderOpened', 'Pedido aberto com sucesso.');
        }

        return view('home');

        
    }

    public function closeOrder() {
        $today = date("Y-m-d");
        $menu = Menu::where('data', '=', $today)->get(); 

        foreach ($menu as $m) {
            $m->fechado = 1;
            $m->save();
        }

        return view('home')->with('orderClosed', 'Pedido fechado com sucesso.');

    }

}
