<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        if (!HomeController::checkPermission()) {
            return view ('permission');
            die();
        }
        $users = User::all()->toArray();
        return view('tables.users', compact('users'));
    }

    // Retorna view Inserir Usuário
    public function create()
    {
        return view('tables.users.create');
    }

    // Retorna view Alterar Usuário
    public function edit($id)
    {
        $user = User::find($id);
        return view('tables.users.edit', compact('user', 'id'));
    }

    // Inserir Usuário 
    public function store(Request $request)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'usuario'        => 'required|max:8',
            'senha'    => 'required|max:10',
        ], $messages);

       if ($validator->fails()) {
            return redirect('/app/tabelas/usuarios/inserir')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where([['name','=', $request->get('usuario')]])->first();

        if ($user) {
            $users = User::all()->toArray();
            return view('tables.users.create')->with('users', $users)->with('exists', 'Usuário já cadastrado!.');
        }

        $user = new User([
            'name'        => $request->get('usuario'),
            'password'    => bcrypt($request->get('senha')),
        ]);
        $user->save();
        $users = User::all()->toArray();
        return view('tables.users')->with('users', $users)->with('success', 'Usuário adicionado com Sucesso.');

    }

    // Alterar Usuário
    public function update(Request $request, $id)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'usuario'        => 'required|max:8',
            'senha'    => 'required|max:10',
        ], $messages);

        $user = User::find($id);
        if ($validator->fails()) {
            return redirect('/app/tabelas/usuarios/editar/'.$id)
                ->withErrors($validator)
                ->withInput();
        }

        $user->name         = $request->get('usuario');
        $user->password     = $request->get('senha');
        $user->save();

        $users = User::all()->toArray();
        return view('tables.users')->with('users', $users)->with('success', 'Usuário atualizado com sucesso.');
    }

    // Deleta Usuário
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $users = User::all()->toArray();
        return view('tables.users')->with('users', $users)->with('success', 'Usuário excluído com sucesso.');
    }

}