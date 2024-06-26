<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biils;
use App\Helpers;
use App\Employee;
use App\Restaurant;
use App\Order;
use Illuminate\Support\Facades\Validator;

class BillController extends Controller
{

    private $htmlPath;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        if (!HomeController::checkPermission()) {
            return view ('permission');
            die();
        }

        HomeController::checkGlobalMessage();

        $employees = Employee::all()->toArray();
        $orders = array();
        return view('bill.index')->with('employees',$employees)->with('orders', $orders);

    }

    public function generateBill(Request $request)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'data_inicial'  => 'required',
            'data_final'    => 'required',
        ], $messages);

        if ($validator->fails()) {
            return redirect('/app/cobranca')
                ->withErrors($validator)
                ->withInput();
        }

        $data_inicial  = $request->get('data_inicial');
        $data_final    = $request->get('data_final');
        $funcionario   = $request->get('funcionarios');
        $gerado        = $request->get('chgerado');

        if ($funcionario == 0) {
            if ($gerado == 1) {
                $orders = Order::where('situacao','=', 1)->where('quantidade','>=',1)->whereBetween('data',[$data_inicial,$data_final])->get();
            } else {
                $orders = Order::where('situacao','=', 0)->where('quantidade','>=',1)->whereBetween('data',[$data_inicial,$data_final])->get();
            }
        } else {
            if ($gerado == 1) {
                $orders = Order::where('situacao','=', 1)->where('quantidade','>=',1)->where('func_id','=', $funcionario)->whereBetween('data',[$data_inicial,$data_final])->get();
            } else {
                $orders = Order::where('situacao','=', 0)->where('quantidade','>=',1)->where('func_id','=', $funcionario)->whereBetween('data',[$data_inicial,$data_final])->get();
            }
        }

        if (count($orders) == 0) {
            $orders = 'nothing';
        }

        $restaurant = Restaurant::all();
        $employees = Employee::all();
        
        return view('bill.index')->with('employees',$employees)->with('restaurant', $restaurant)->with('orders', $orders)->with('data_inicial', $data_inicial)->with('data_final', $data_final)->with('funcionario', $funcionario);
    }

    public function generateDropOfBill(Request $request) {

        $data_inicial  = $request->get('data_inicial');
        $data_final    = $request->get('data_final');
        $funcionario   = $request->get('funcionario');
        $gerado        = $request->get('chgerado');
        $employees = Employee::all();

        if ($gerado == 0) {
            if ($funcionario == 0) {
                $name = 'TODOS-'.date("Y-m-d");
                $orders = Order::where('situacao','=', 0)->whereBetween('data',[$data_inicial,$data_final])->get();
            } else {
                $name = \App\Helpers\AppHelper::getEmployeeName($funcionario).'-'.date("d-m-Y");
                $orders = Order::where('situacao','=', 0)->where('func_id','=', $funcionario)->whereBetween('data',[$data_inicial,$data_final])->get();
            }
        }

        foreach ($orders as $o) {
            $o->situacao = 1;
            $o->save();
        }

        $content = $request['code'];
        \App\Helpers\AppHelper::instance()->exportToPdf($content, $name, $this->htmlPath);
        $employees = Employee::all()->toArray();
        $orders = [];
        return view('bill.index')->with('employees',$employees)->with('orders', $orders);
    }


}