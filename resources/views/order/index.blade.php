<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "Fucking yeah";
        //header('location: /app/pedido');
    }
?>
@extends('layouts.index')

<style>
    #restaurantContainer {
        position: relative;
        margin: 0 auto;
        width: 900px;
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
        /*background-color: #ddd;*/
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
        visibility: hidden;
    }

    #observationContainer button{
        margin-top: 5px;
    }

    #orderConfirmed {
        width: 100%;
        position: relative;
    }

    #observationBlocked {
        display: none;
    }

    #viewOrder {
        width: 100%;
        margin: 0 auto;
        text-align: center;
        padding: 10px;
        display: block;
    }

    td, th {
        text-align: left;
        padding: 8px;
    }


    tr:nth-child(even) {
        background-color: #dddddd;
    }

</style>

@section('content')
    <p><a href="/">Voltar para a página anterior</a></p>
    @if(!empty(\Session::get('success')))
        <script>
            console.log('Pedido finalizado com sucesso');
            $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/confirmed_1.png') }}"></img></div><h3>Pedido efetuado</h3></center>');
        </script>
    @endif
    @if(!empty(\Session::get('timeOut')))
        <script>
            console.log('Pedido fora de horário');
            $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/clock.png') }}"></img></div><h4>Pedido não efetuado. Fora de horário</h4></center>');
        </script>
    @endif
    @if ($menu['p1'] === '' || $menu['data'] != date("Y-m-d"))
        <div class="alert alert-danger" role="alert">
            Cardápio não liberado!
        </div>
    @else
        @if(!empty($config['mensagem']) && $_SESSION['globalMessage'] == 0 )
            <?php $_SESSION['globalMessage'] = 1;
            ?>
            <script>
                var mensagem = ''
                @foreach ($config as $m)
                    mensagem = "MENSAGEM: {!! $config['mensagem'] !!}";
                @endforeach
                console.log('CONFIG: ' +mensagem );
                $.alert(mensagem);
            </script>
        @endif
        <h1 class="display-1">Cardápio do Dia - {{ date("d/m/Y")}} | <strong>{{ $config['horario'] != "" ? "Limite: " .$config['horario'] : "" }}</strong> </h1>
        <div id="restaurantContainer">
            <h4 id="restaurantTitle" class="display-1">Restaurante: {{ $restaurantDefault['nome'] }}</h4>
            <h4 id="restaurantResponsible" class="display-1">Responsável: {{ $restaurantDefault['responsavel'] }}</h4>
            <div id="restaurantTelephone" class="display-1"><h4>Telefone: {{ $restaurantDefault['telefone'] }}</h4></div>
            <div id="restaurantCellphone" class="display-1"><h4>Celular: {{ $restaurantDefault['celular'] }}</h4></div>
        </div>
        <div id="viewOrder" class="alert alert-info">
            <strong><a href="/app/pedido/visualizar">CLIQUE AQUI PARA VISUALIZAR O PEDIDO DO DIA</a></strong>
        </div>
        <br/>
        @if (Route::has('login'))
            @auth
            <div id="viewOrder" class="alert alert-danger">
                <strong><a href="/app/pedido/fechar">CLIQUE AQUI PARA FECHAR O PEDIDO</a></strong>
            </div>
            @endif
        @endif
        <div id="orderContainer">
            <div id="mealsContainer">
                <div class="alert alert-info">
                    <strong id="noticeOrder">Selecione um nome e em seguida clique no prato.</strong>
                </div>
                @for ($i = 1; $i <= 8; $i++)
                    @if ($menu['p'.$i ] != '')
                        <a href="#"><p id="prato{{$i}}" class="mealsLabels" value="{{$i}}">{{ $menu['p'.$i ]}}</p></a>
                        <input type="hidden" id="pr{{$i}}" name="preco" value="{{ $menu['pr'.$i ]}}">
                    @endif
                @endfor
                <div id="observationContainer">
                    <div class="alert alert-info">
                        <label for="observation">Observação</label>
                        <form id="formOrder"action="/app/pedido/pedir" method="POST">
                             {{csrf_field()}} 
                            <input type="hidden" id="fidrestaurant" name="restaurante" value="{{ $restaurantDefault['id'] }}">
                            <input type="hidden" id="fidemployee" name="funcionario">
                            <input type="hidden" id="fmealName" name="prato">
                            <input type="hidden" id="fprmeal" name="preco">
                            <input id="fobservation" type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fobservation" name="observacao" placeholder="Ex: Sem feijão" autocomplete="off" maxlength="55" disabled="">
                            <button id="confirmOrder" type="submit" class="btn btn-primary">Ok</button>
                        </form>
                        <button id="cancelOrder" onclick="cancelOrder()" class="btn btn-danger" style="position: absolute; left: 65px; top: 75px">Cancelar</button>
                    </div>
                </div>
            </div>
            <div id="employeesContainer">
                <label for="filtrar-tabela">Filtrar:</label>
                <input type="text" class="form-control" id="femployeesSearch" name="employeesSearch" placeholder="Digite para buscar">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Clique no nome:</th>
                        </tr>
                    </thead>
                    <tbody id="employeesTable">
                        @if (empty($employees))
                        <div class="alert alert-danger">
                            <strong>Erro ao listar funcionários</strong>
                        </div>
                        @endif
                        @foreach($employees as $employee)
                            <tr class="employee">
                                <td class="employeeName"><a id="employee{{$employee['id']}}" href="#" value="{{$employee['id']}}">{{$employee['nome'].' '.$employee['sobrenome']}}</a></td>
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

            $("#femployeesSearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $(".employee").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $("#formRestaurant").submit(function() {
                $("#fnome").unmask();
                $("#fendereco").unmask();
                $("#fnumero").unmask();
                $("#fbairro").unmask();
                $("#fcep").unmask();
                $("#ftelefone").unmask();
                $("#fcelular").unmask();
                $("#fvalor").unmask();
                $("#ffrete").unmask();
                $("#fadicional").unmask();
                $("#ffresponsavel").unmask();
            });

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
                $("#observationContainer").css({"visibility": "visible"});
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

        $(document).keyup(function(e) {
            if (e.keyCode === 27) cancelOrder();   // esc
            if (e.keyCode === 13) confirmOrder(); // enter
            //if (e.keyCode === 86) viewOrder(); // enter
        });

        function inicializaVariaveis() {
            var employeeId = 0;
            var mealID = 0;
            var prMeal = 0;
            var employeeName = '';
            var mealName = '';
            var jc = '';
            var hasOrdered = 0;
        }

        function selectEmployee(e) {
            employeeId = $(e.target).attr('value');
            employeeName = $(e.target).text();
            $("#noticeOrder").text('SELECIONADO: ' +employeeName);
            hasOrder();
            hasMessage();
            checkBlock();
            checkObservation();
            console.log(employeeName);
            console.log("Funcionário nº:"+employeeId);
        } 

        function selectMeal(e) {
            mealID = $(e.target).attr('value');
            mealName = $(e.target).text();
            prMeal = $('#pr'+mealID).val();
            $("#noticeOrder").text('SELECIONADO: ' +employeeName +' > PRATO: ' +mealName);
            console.log("Prato nº:"+mealID);
        }

        function confirmOrder(e) {
            $('#fidemployee').val(employeeId);
            $('#fmealName').val(mealName);
            $('#fprmeal').val(prMeal);
            jc = $.confirm({
                title: 'Confirmar Pedido',
                content: 'Funcionário: '+employeeName.toUpperCase() +'<br>' + ' ' +'Prato: ' +mealName + '<br>'+ 'Observação: '+ $("#fobservation").val(),
                escapeKey: 'cancelar',
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

        function checkBlock(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/app/pedido/bloqueio/"+employeeId,
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                },
                success:function(response){
                    if (response['isBlocked'] == 1) {
                        employeeBlocked();
                        cancelOrder();
                    } else {
                        $("#fobservation").prop("disabled", "");
                        $("#fobservation").attr("placeholder", "Ex: Sem Feijão"); 
                        $("#fobservation").val('');
                    }
                },
            });
        }

        function guest() {

        }

        function checkObservation() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/app/pedido/observacao/"+employeeId,
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                },
                success:function(response){
                    if (response['isBlocked'] == 2) {
                        observationBlocked();
                    }
                },
            });
        }

        function hasMessage() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/app/pedido/mensagem/"+employeeId,
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                },
                success:function(response){
                    if (response['hasMessage'].length == 0) {
                        console.log('Mensagem: SEM MENSAGEM');
                    } else {
                        console.log('Mensagem:' +response['hasMessage']);
                        messageEmployee(response['hasMessage']);
                    }
                },
            });
        }

        function hasOrder() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/app/pedido/pediu/"+employeeId,
                type:"POST",
                data:{
                    "_token": "{{ csrf_token() }}",
                },
                success:function(response){
                    if (response['hasOrder'] == 1) {
                        console.log(employeeName+ ' já pediu! Cancelando...');
                        alreadyOrdered();
                        cancelOrder();
                    }
                },
            });
        }

        function callSaveOrderControllerFromForm(e) {
            $( "#formOrder" ).submit();
        }

        function employeeBlocked() {
            $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/blocked.png') }}"></img></div><h3>Funcionário bloqueado.<br/></h3>Entre em contato com o administrador.</center>');
        }

        function observationBlocked() {
            $("#fobservation").prop("disabled", "true");
            $("#fobservation").attr("placeholder", "Observação desativada para este funcionário. Contate um administrador."); 
            //$("#observationBlocked").css({"display": "initial"});
        }

        function alreadyOrdered() {
            $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/exclamation.png') }}"></img></div><h3>'+employeeName+' já pediu!<br/></h3>Pedido cancelado.</center>');
        }

        function messageEmployee(msg) {
            $.alert('<h3>'+employeeName+',</h3><p>'+msg+'</p>');
        }

        function cancelOrder() {
            console.clear();
            console.log("Usuário nº:"+employeeId +" - "+ employeeName +" cancelou o pedido!");
            inicializaVariaveis();
            $("#employeesContainer").css({"pointer-events": "auto", "opacity": "1.0"});
            $("#mealsContainer a").css({"pointer-events": "none", "opacity": "0.5"});
            $("#observationContainer").css({"visibility": "hidden"});
            $("#noticeOrder").text('Selecione um nome e em seguida clique no prato.');
        }

        </script>
@endsection