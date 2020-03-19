@extends('layouts.index')
    <style>
        .bg-modal {
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7); 
            position: absolute;
            justify-content: center;
            align-items: center;
            top: 0;
            display: none;
        }

        .modal-content {
            padding: 10px;
            width: 600px;
            height: 615px;
            background-color: white;
            border-radius: 4px;
            opacity: 1;
            position: relative;
            fade: 0.5;
        }

        .close {
            position: absolute;
            top: 0;
            right: 14px;
            font-size: 42px;
            transform: rotate(45deg);
            cursor: pointer;
        }

        .checkbox-modal {
            position: relative;
            padding: 10px;
        }

        .alert-danger.error {
            display: none;
        }
    </style>

@section('content')
    <p><a href="javascript: history.go(-1)">Voltar para a página anterior</a></p>
    <h1 class="display-1">Tabela de Restaurantes</h1>
    <a class="btn btn-primary" id='insert' href="{{route('restaurant.create')}}">Inserir</a>
    @if (count($restaurants) === 0)
        <div class="alert alert-danger" role="alert">
            Nenhum registro encontrado!
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success" role="success">
            <p>{{\Session::get('success')}}</p>
        </div>
    @endif
    <ul class="list-group">
    @foreach($restaurants as $restaurant)
        <li class="list-group-item">  
            {{$restaurant['nome']}}
            <div class="buttons-register">
                <a class='btn btn-primary' href="/app/tabelas/restaurantes/editar/{{$restaurant['id']}}">Editar</a>
                <a class='btn btn-danger' href='#'>Excluir</a>
            </div>
        </li>
    @endforeach
    </ul>

@endsection