<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;
use App\Employee;
use App\Restaurant;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class PreviousOrderController extends Controller
{

    private $htmlPath;

    public function index()
    {
        if (!HomeController::checkPermission()) {
            return view ('permission');
            die();
        }

        HomeController::checkGlobalMessage();

        $orders = array();
        $resumido = NULL;
        return view('previousOrders.index')->with('orders',$orders)->with('resumido',$resumido);

    }

    public function consultPrevious(Request $request) {
        $resumido = $request->get('resumido');

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];
    
        $validator = Validator::make($request->all(), [
            'data_inicial'  => 'required',
            'data_final'    => 'required',
        ], $messages);
    
        if ($validator->fails()) {
            return redirect('/app/consulta_pedido')
                ->withErrors($validator)
                ->withInput();
        }
    
        $data_inicial  = $request->get('data_inicial');
        $data_final    = $request->get('data_final');

        $employees = Employee::all();
    
        if ($resumido == NULL) {
            $orders = Order::whereBetween('data',[$data_inicial,$data_final])->get();
        } else {
            $orders= [];
            foreach($employees as $employee) {
                $id = $employee->id;

                $orders[] = Order::select('func_id','quantidade','valor','valor_desconto','frete','adicional',
                    DB::raw('SUM(quantidade) AS quantidade'),
                    DB::raw('SUM(valor) AS valor'),
                    DB::raw('SUM(valor_desconto) AS valor_desconto'), 
                    DB::raw('SUM(frete) AS frete'),
                    DB::raw('SUM(adicional) AS adicional')
                )
                ->where('func_id',$id)->whereBetween('data',[$data_inicial,$data_final])
                ->get()
                ->toArray();
            }
        }
        if (count($orders) == 0) {
            $orders = 'nothing';
        }

        $restaurant = Restaurant::all();
        $employees = Employee::all();

        return view('previousOrders.index')->with('employees',$employees)->with('restaurant', $restaurant)->with('orders', $orders)->with('data_inicial', $data_inicial)->with('data_final', $data_final)->with('resumido', $resumido);
    }

    public function print(Request $request)
    {
        $content = $request['code'];
        $name = 'RESUMIDO-'.date("Y-m-d");
        \App\Helpers\AppHelper::instance()->exportToPdf($content, $name, $this->htmlPath);
    }
}
