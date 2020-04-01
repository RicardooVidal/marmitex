<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Restaurant;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller
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

    // Retorna view Inserir Restaurante
    public function create()
    {
        return view('tables.restaurant.create');
    }

    // Retorna view Alterar Restaurante
    public function edit($id)
    {
        $restaurant = Restaurant::find($id);
        return view('tables.restaurant.edit', compact('restaurant', 'id'));
    }

    // Inserir Restaurante 
    public function store(Request $request)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'nome'        => 'required|max:255',
            //'endereco'    => 'required|max:255',
            //'numero'      => 'required|max:255',
            //'bairro'      => 'required|max:255',
            //'cep'         => 'required|max:8',
            'celular'     => 'required|max:11',
            'valor'       => 'required',
            'responsavel' => 'required'
        ], $messages);

       if ($validator->fails()) {
            return redirect('/app/tabelas/restaurantes/inserir')
                ->withErrors($validator)
                ->withInput();
        }
        $this->verificaPadrao($request->get('chpadrao'), 0);
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
        $restaurants = Restaurant::all()->toArray();
        return view('tables.restaurant')->with('restaurants', $restaurants)->with('success', 'Restaurante adicionado com Sucesso.');

    }

    // Alterar Restaurante
    public function update(Request $request, $id)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'nome'        => 'required|max:255',
            //'endereco'    => 'required|max:255',
            //'numero'      => 'required|max:255',
            //'bairro'      => 'required|max:255',
            //'cep'         => 'required|max:8',
            'celular'     => 'required|max:11',
            'valor'       => 'required',
            'responsavel' => 'required'
        ], $messages);

        $restaurant = Restaurant::find($id);
        if ($validator->fails()) {
            return redirect('/app/tabelas/restaurantes/editar/'.$id)
                ->withErrors($validator)
                ->withInput();
        }
        $this->verificaPadrao($request->get('chpadrao'), $id);
        $restaurant->nome         = $request->get('nome');
        $restaurant->endereco     = $request->get('endereco');
        $restaurant->numero       = $request->get('numero');
        $restaurant->bairro       = $request->get('bairro');
        $restaurant->cep          = $request->get('cep');
        $restaurant->celular      = $request->get('celular');
        $restaurant->vlr_m        = $request->get('valor');
        $restaurant->telefone     = $request->get('telefone');
        $restaurant->frete        = $request->get('frete');
        $restaurant->responsavel  = $request->get('responsavel');
        $restaurant->cobfr        = $request->get('chfrete');
        $restaurant->cobad        = $request->get('chadicional');
        $restaurant->padrao       = $request->get('chpadrao');
        
        $restaurant->save();

        $restaurants = Restaurant::all()->toArray();
        return view('tables.restaurant')->with('restaurants', $restaurants)->with('success', 'Restaurante atualizado com Sucesso.');
    }

    // Deleta Restaurante
    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        $restaurant->delete();
        //return redirect()->route('restaurant.index')->with('success', 'Restaurante excluído com êxito');
        $restaurants = Restaurant::all()->toArray();
        return view('tables.restaurant')->with('restaurants', $restaurants)->with('success', 'Restaurante excluído com Sucesso.');
    }

    // Verifica restaurante padr�o
    public function verificaPadrao($padrao, $id)
    {
        $restaurants = Restaurant::where('padrao', '=', '1')->get();
        if ($padrao == 1) {
            foreach ($restaurants as $restaurant) {
                if ($restaurant->id != $id) {
                    $restaurant->padrao = 0;
                    $restaurant->save();
                }
            }
        }
    }
}