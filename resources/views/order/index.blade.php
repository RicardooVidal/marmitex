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

    #observationContainer{
        position: relative;
        display: none;
    }

    #observationContainer button{
        margin-top: 5px;
    }

    #orderConfirmed {
        width: 100%;
        position: relative;
    }

    #orderConfirmed img {
        width: 50px;
        height: 50px;
    }

</style>

@section('content')
    <p><a href="/">Voltar para a página anterior</a></p>
    @if(!empty($success))
        <script>
            console.log('Pedido finalizado com sucesso');
            $.alert('<center><div id="orderConfirmed"><img src="{{ asset('assets/images/confirmed_1.png') }}"></img></div><br><p>Pedido efetuado</p></center>');
        </script>
    @endif
    @if ($menu['p1'] === '')
        <div class="alert alert-danger" role="alert">
            Cardápio não liberado!
        </div>
    @else
        <h1 class="display-1">Cardápio do Dia - {{ date("d/m/Y")}}</h1>
        <div id="restaurantContainer">
            <h4 id="restaurantTitle" class="display-1">Restaurante: {{ $restaurantDefault['nome'] }}</h4>
            <h4 id="restaurantResponsible" class="display-1">Responsável: {{ $restaurantDefault['responsavel'] }}</h4>
            <div id="restaurantTelephone" class="display-1"><h4>Telefone: {{ $restaurantDefault['telefone'] }}</h4></div>
            <div id="restaurantCellphone" class="display-1"><h4>Celular: {{ $restaurantDefault['celular'] }}</h4></div>
        </div>
        <div id="orderContainer">
            <div id="mealsContainer">
                <div class="alert alert-info">
                    <strong>Selecione um nome e em seguida clique no prato.</strong>
                </div>
                @for ($i = 1; $i <= 8; $i++)
                    @if ($menu['p'.$i ] != '')
                        <a href="#"><p id="prato{{$i}}" class="mealsLabels" value="{{$i}}">{{$i}}.{{ $menu['p'.$i ]}}</p></a>
                        <input type="hidden" id="pr{{$i}}" name="preco" value="{{ $menu['pr'.$i ]}}">
                    @endif
                @endfor
                <div id="observationContainer">
                    <div class="alert alert-info">
                        <label for="observation">Observação</label>
                        <form id="formOrder"action="" method="POST">
                             {{csrf_field()}} 
                            <input type="hidden" id="fidrestaurant" name="restaurante" value="{{ $restaurantDefault['id'] }}">
                            <input type="hidden" id="fidemployee" name="funcionario">
                            <input type="hidden" id="fidmeal" name="prato">
                            <input type="hidden" id="fprmeal" name="preco">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fobservation" name="observacao" placeholder="Ex: Sem feijão">
                            <button id="confirmOrder" type="submit" class="btn btn-primary">Ok</button>
                        </form>
                        <button id="cancelOrder" onclick="cancelOrder()" class="btn btn-danger" style="position: absolute; left: 65px; top: 75px">Cancelar</button>
                    </div>
                </div>
            </div>
            <div id="employeesContainer">
                <input type="text" class="form-control" id="femployeesSearch" name="employeesSearch" placeholder="Digite para buscar">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Clique no nome:</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($employees))
                        <div class="alert alert-danger">
                            <strong>Erro ao listar funcionários</strong>
                        </div>
                        @endif
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
    @endif
        <script>
        $(document).ready(function(){
            inicializaVariaveis();
            $("#mealsContainer a").css({"pointer-events": "none", "opacity": "0.5"});

            $('#formOrder').submit(function(e) {
                event.preventDefault();
                confirmOrder(e)
            });

            $('#employeesContainer a').click(function(e) {
                event.preventDefault();
                $("#employeesContainer").css({"pointer-events": "none", "opacity": "0.5"});
                $("#mealsContainer a").css({"pointer-events": "auto", "opacity": "1.0"});
                selectEmployee(e);
            });
            
            $('#mealsContainer a').click(function(e) {
                event.preventDefault();
                $("#mealsContainer a").css({"pointer-events": "none", "opacity": "0.5"});
                $("#observationContainer").css({"display": "initial"});
                $('body,html').animate({ scrollTop: $('body').height() }, 800);
                $( "#observationContainer input" ).focus();
                selectMeal(e);
            });

            // $('td').click(function(event) {
            //     event.preventDefault();
            //     $('employeesContainer td').attr('disabled', true);
            //     $('#employeesContainer td').click(function(e) {
            //         id = $(e.target).attr('value');
            //         console.log(id);
            //     }); 
            // });
        });

        function inicializaVariaveis() {
            var employeeId = 0;
            var mealID = 0;
            var prMeal = 0;
            var employeeName = '';
            var mealName = '';
            var jc = '';
        }

        function selectEmployee(e) {
            employeeId = $(e.target).attr('value');
            employeeName = $(e.target).text();
            console.log(employeeName);
            console.log("Funcionário nº:"+employeeId);
        } 

        function selectMeal(e) {
            mealID = $(e.target).attr('value');
            mealName = $(e.target).text();
            prMeal = $('#pr'+mealID).val();
            console.log("Prato nº:"+mealID);
        }

        function confirmOrder(e) {
            $('#fidemployee').val(employeeId);
            $('#fidmeal').val(mealID);
            $('#fprmeal').val(prMeal);
            jc = $.confirm({
                title: 'Confirmar Pedido',
                content: 'Funcionário: '+employeeName.toUpperCase() +'<br>' + ' ' +'Prato: ' +mealName + '<br>'+ 'Observação: '+ $("#fobservation").val(),
                buttons: {
                    confirmar: function () {
                        callSaveOrderControllerFromForm(e);
                    },
                    cancelar: function () {
                        this.close();
                    },
                }
            });
        }

        function callSaveOrderControllerFromForm(e) {
            $( "#formOrder" ).submit();
        }

        function cancelOrder() {
            console.clear();
            console.log("Usuário nº:"+employeeId +" - "+ employeeName +" cancelou o pedido!");
            inicializaVariaveis();
            $("#employeesContainer").css({"pointer-events": "auto", "opacity": "1.0"});
            $("#mealsContainer a").css({"pointer-events": "none", "opacity": "0.5"});
            $("#observationContainer").css({"display": "none"});
        }
        </script>
@endsection