<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;

class RestaurantsController extends Controller
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

        $restaurants = Restaurant::all()->toArray();
        return view('tables.restaurant', compact('restaurants'));
    }

    // Inserir Restaurante 
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome' => 'required',
            'endereco' => 'required',
            'numero'   => 'required',
            'bairro'   => 'required',
            'cep'      => 'required',
            'celular'  => 'required',
            'valor'    => 'required'
        ]);

        $restaurant = new Restaurant([
            'nome'        => $request->get('nome'),
            'endereco'    => $request->get('endereco'),
            'numero'      => $request->get('numero'),
            'bairro'      => $request->get('bairro'),
            'cep'         => $request->get('cep'),
            'celular'     => $request->get('celular'),
            'vlr_m'       => $request->get('valor'),
            'telefone'    => $request->get('telefone'),
            'frete'       => $request->get('frete'),
            'responsavel' => $request->get('responsavel'),
            'cobfr'       => $request->get('chfrete'),
            'cobad'       => $request->get('chadicional'),
            'padrao'      => $request->get('chpadrao')
        ]);
        $restaurant->save();
        return redirect()->route('restaurant.create')->with('success', 'Restaurante adicionado com Sucesso');
    }

    public function create()
    {
        return view('tables.restaurant.create');
    }
}
