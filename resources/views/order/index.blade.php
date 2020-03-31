@extends('layouts.index')

<style>
    #restaurantContainer {
        position: relative;
        margin: 0 auto;
        width: 900px;
        border: 1px solid;
        padding: 10px;
        margin-bottom: 10px;
    }

    #restaurantContainer #restaurantTelephone {
        position: absolute;
        right: 0;
        top: 10px;
    }

    #restaurantContainer #restaurantCellphone {
        position: absolute;
        right: 0;
        top: 40px;
    }

    #orderContainer {
        width: 900px;
        margin: 0 auto;
        position: relative;
    }

    #mealsContainer {
        width: 600px;
        padding: 10px;
    }

    #mealsContainer p {
        padding: 10px;
        font: 15px arial, sans-serif;
    }

    #mealsContainer p:hover {
        background-color: #ddd;
        font-weight: bold;
    }

    #employeesContainer {
        position: absolute;
        right: 0;
        top: 0;
        width: 285px;
    }

    #employeesContainer table {
        font: 13px arial, sans-serif;
        background-color: #ddd;
        height: 20px;
        overflow: scroll;
    }

    #employeesContainer thead, tbody{
        display: block;  
    }

    #employeesContainer tbody{
        overflow-y: scroll;
        width: 100%;
        height: 450px;
    }

    #employeesContainer table a {
        display: block;
        color: #000;
    }

    #mealsContainer a {
        display: block;
        color: #000;
    }

    #employeesContainer table td:hover {
        background-color: #ccc;
        font-weight: bold;
    }

    #employeesContainer input {
        margin-bottom: 10px;
    }

    #employeesContainer thead {
        background-color: #000;
        color: #fff;
    }

    #employeesContainer .table th,
                        .table td {
        width:20%;
    }

</style>

@section('content')
    <p><a href="/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Cardápio do Dia - {{ date("d/m/Y")}}</h1>
    <div id="restaurantContainer">
        <h4 id="restaurantTitle" class="display-1">Restaurante: {{ $restaurantDefault['nome'] }}</h4>
        <h4 id="restaurantResponsible" class="display-1">Responsável: {{ $restaurantDefault['responsavel'] }}</h4>
        <div id="restaurantTelephone" class="display-1"><h4>Telefone: {{ $restaurantDefault['telefone'] }}</h4></div>
        <div id="restaurantCellphone" class="display-1"><h4>Celular: {{ $restaurantDefault['celular'] }}</h4></div>
    </div>
    <div id="orderContainer">
        <div id="mealsContainer">
            <a href="#"><p id="prato1" class="mealsLabels" value="1">1.{{ $menu['p1']}}</p></a>
            <a href="#"><p id="prato2" class="mealsLabels" value="2">2.{{ $menu['p2']}}</p></a>
            <a href="#"><p id="prato3" class="mealsLabels" value="3">3.{{ $menu['p3']}}</p></a>
            <a href="#"><p id="prato4" class="mealsLabels" value="4">4.{{ $menu['p4']}}</p></a>
            <a href="#"><p id="prato5" class="mealsLabels" value="5">5.{{ $menu['p5']}}</p></a>
            <a href="#"><p id="prato6" class="mealsLabels" value="6">6.{{ $menu['p6']}}</p></a>
            <a href="#"><p id="prato7" class="mealsLabels" value="7">7.{{ $menu['p7']}}</p></a>
            <a href="#"><p id="prato8" class="mealsLabels" value="8">8.{{ $menu['p8']}}</p></a>
        </div>
        <div id="employeesContainer">
            <input type="text" class="form-control" id="employeesSearch" name="employeesSearch" placeholder="Digite para buscar"></input>
            <table class="table">
                <thead>
                    <tr>
                        <th>Clique no nome:</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr>
                            <td><a id="employee{{$employee['id']}}" href="#" value="{{$employee['id']}}">{{$employee['nome'].' '.$employee['sobrenome']}}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function(){
        var id = 0;
        $('td').click(function(event) {
            event.preventDefault();
            $('employeesContainer td').attr('disabled', true);
            $('#employeesContainer td').click(function(e) {
                id = $(e.target).attr('value');
                console.log(id);
            }); 
        });
    });
    </script>
@endsection