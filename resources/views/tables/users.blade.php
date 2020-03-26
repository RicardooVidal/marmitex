@extends('layouts.index')

@section('content')
    <p><a href="/app/tabelas">Voltar para a página anterior</a></p>
    <h1 class="display-1">Tabela de Usuários</h1>
    <h3>Atenção: Usuários nesta tabela tem acesso total ao sistema</h3>
    <a class="btn btn-primary" id='insert' href="{{route('user.create')}}">Inserir</a>
    @if (count($users) === 0 || count($users) === 1)
        <div class="alert alert-danger" role="alert">
            Nenhum registro encontrado!
        </div>
    @endif
    @if(!empty($success))
        <div class="alert alert-success" role="success">
            <p>{{ $success }} </p>
        </div>
    @endif
    <ul class="list-group">
        @foreach($users as $user)
            @if($user['name'] != 'admin')
                <li class="list-group-item"> 
                    {{$user['name']}}
                    <div class="buttons-register">
                    <div id="btnDelete">
                        <form method="post" class="delete_form" action="{{action('UserController@destroy', $user['id'])}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE"/>                
                            <button type="submit" class="btn btn-danger">Deletar</button></div>
                        </form>
                    </div>
                </li>
            @endif
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