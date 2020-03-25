@extends('layouts.index')

<style>
    #imgDefault img {
        position: absolute;
        top: 3px;
        width: 25px;
        height: 25px;
    }
</style>


@section('content')
    <p><a href="/app/tabelas">Voltar para a página anterior</a></p>
    <h1 class="display-1">Tabela de Restaurantes</h1>
    <a class="btn btn-primary" id='insert' href="{{route('restaurant.create')}}">Inserir</a>
    @if (count($restaurants) === 0)
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
    @foreach($restaurants as $restaurant)
        <li class="list-group-item"> 
            {{$restaurant['nome']}}
            <div id="padrao">
            <div class="buttons-register">
                @if($restaurant['padrao'] == 1)
                    <div id="imgDefault"><img src="{{ asset('assets/images/confirmed.png') }}"></img></div>
                @endif
                <div id="btnEdit"><a class='btn btn-primary' href="/app/tabelas/restaurantes/editar/{{$restaurant['id']}}">Editar</a></div>
                <div id="btnDelete"><form method="post" class="delete_form" action="{{action('RestaurantController@destroy', $restaurant['id'])}}">
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