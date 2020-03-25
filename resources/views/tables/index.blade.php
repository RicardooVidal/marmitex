@extends('layouts.index')

@section('content')
    <p><a href="#">Voltar para a página anterior</a></p>
    <h1 class="display-1">Tabelas</h1>
    <ul class="list-group">
        <li><a href="/app/tabelas/restaurantes/" class="list-group-item">Restaurantes</a></li>
        <li><a href="/app/tabelas/funcionarios/" class="list-group-item">Funcionários</a></li>
        <li><a href="#" class="list-group-item">Usuários</a></li>
    </ul>
@endsection
