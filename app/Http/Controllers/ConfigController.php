<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
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
        $config = Config::all()->toArray();
        if (count($config) == 0 ) {
            $config = new Config([
                'horario'   => '',
                'mensagem'  => '',
                'zebra'  => '',
            ]);
            $config->save();    
        }
        $config = Config::find(1);
        return view('config.index', compact('config'));
    }

    // Alterar Configurações
    public function update(Request $request)
    {
        $config = Config::find(1);
        $config->horario  = $request->get('horario');
        $config->mensagem = $request->get('mensagem');
        $config->zebra = $request->get('zebra');
        $config->save();

        return view('config.index')->with('config', $config)->with('success', 'Dados atualizados com sucesso.');
    }
}