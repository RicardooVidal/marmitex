<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers;
use App\Employee;
use App\Restaurant;
use App\Order;
use Illuminate\Support\Facades\Validator;


class PreviousOrderController extends Controller
{

    public function index()
    {
        if (!HomeController::checkPermission()) {
            return view ('permission');
            die();
        }
        $orders = array();
        return view('previousOrders.index')->with('orders',$orders);

    }

    public function consultPrevious(Request $request) {
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
    
        $orders = Order::whereBetween('data',[$data_inicial,$data_final])->get();
    
        if (count($orders) == 0) {
            $orders = 'nothing';
        }
    
        $restaurant = Restaurant::all();
        $employees = Employee::all();

        return view('previousOrders.index')->with('employees',$employees)->with('restaurant', $restaurant)->with('orders', $orders)->with('data_inicial', $data_inicial)->with('data_final', $data_final);
    }
}
