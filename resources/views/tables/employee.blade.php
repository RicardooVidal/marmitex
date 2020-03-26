@extends('layouts.index')

<style>
    #imgBlocked img {
        position: absolute;
        top: 3px;
        width: 25px;
        height: 25px;
    }
</style>


@section('content')
    <p><a href="/app/tabelas">Voltar para a página anterior</a></p>
    <h1 class="display-1">Tabela de Funcionários</h1>
    <a class="btn btn-primary" id='insert' href="{{route('employee.create')}}">Inserir</a>
    @if (count($employees) === 0)
        <div class="alert alert-danger" role="alert">
            Nenhum registro encontrado!
        </div>
    @endif
    @if(!empty($success))
        <div class="alert alert-success" role="success">
            <p>{{ $success }}</p>
        </div>
    @endif
    <ul class="list-group">
    @foreach($employees as $employee)
        <li class="list-group-item"> 
            {{$employee['nome'].' '.$employee['sobrenome']}}
            <div class="buttons-register">
            @if($employee['bloqueado'] == 1)
                <div id="imgBlocked"><img src="{{ asset('assets/images/blocked.png') }}"></img></div>
            @endif
            <div id="btnEdit"><a class='btn btn-primary' href="/app/tabelas/funcionarios/editar/{{$employee['id']}}">Editar</a></div>
            <div id="btnDelete">
                <form method="post" class="delete_form" action="{{action('EmployeeController@destroy', $employee['id'])}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method" value="DELETE"/>                
                    <button type="submit" class="btn btn-danger">Deletar</button></div>
                </form>
            </div>
        </li>
    @endforeach
    </ul>
    <script>
        $(document).ready(function(){
            $('.delete_form').on('submit', function(){
                if(confirm("Confirma exclusão?")) {
                    return true;
                } else {
                    return false;
                }
            })
        })
    </script>

@endsection