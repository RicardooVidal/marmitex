<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employee;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
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

        HomeController::checkGlobalMessage();

        $employees = Employee::all()->toArray();
        return view('tables.employee', compact('employees'));
    }

    // Retorna view Inserir Funcionário
    public function create()
    {
        return view('tables.employee.create');
    }

    // Retorna view Alterar Funcionário
    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('tables.employee.edit', compact('employee', 'id'));
    }

    // Inserir Funcionário
    public function store(Request $request)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'nome'        => 'required|max:255',
        ], $messages);

       if ($validator->fails()) {
            return redirect('/app/tabelas/funcionarios/inserir')
                ->withErrors($validator)
                ->withInput();
        }

        $employee = new Employee([
            'nome'        => $request->get('nome'),
            'sobrenome'   => $request->get('sobrenome'),
            'bloqueado'    => $request->get('bloqueado'),
            'observacao'      => $request->get('observacao'),
            'mensagem'      => $request->get('mensagem'),
        ]);
        $employee->save();
        $employees = Employee::all()->toArray();
        return view('tables.employee')->with('employees', $employees)->with('success', 'Funcionário adicionado com Sucesso.');

    }

    // Alterar Funcionário
    public function update(Request $request, $id)
    {

        $messages = [
            'required' => 'O campo :attribute deve ser preenchido.',
        ];

        $validator = Validator::make($request->all(), [
            'nome'        => 'required|max:255',
        ], $messages);

        $employee = Employee::find($id);
        if ($validator->fails()) {
            return redirect('/app/tabelas/funcionarios/editar/'.$id)
                ->withErrors($validator)
                ->withInput();
        }

        $employee->nome       = $request->get('nome');
        $employee->sobrenome  = $request->get('sobrenome');
        $employee->mensagem   = $request->get('endereco');
        $employee->bloqueado  = $request->get('bloqueado');
        $employee->observacao = $request->get('observacao');
        $employee->save();

        $employees = Employee::all()->toArray();
        return view('tables.employee')->with('employees', $employees)->with('success', 'Funcionário atualizado com Sucesso.');
    }


    // Deleta Funcionário
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        //return redirect()->route('restaurant.index')->with('success', 'Restaurante excluÃ­do com Ãªxito');
        $employees = Employee::all()->toArray();
        return view('tables.employee')->with('employees', $employees)->with('success', 'Funcionário excluído com Sucesso.');
    }

}