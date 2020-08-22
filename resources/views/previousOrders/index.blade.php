@extends('layouts.index')
<?php 
    $quantidade_geral = 0;
    $total_geral = 0;
    $total_desconto_geral = 0;
    $valor_geral = 0;
    $valor_desconto_geral = 0;
    $frete_geral = 0;
    $adicional_geral = 0;
?>

<style>

    .modal-dialog {
        text-align: center;
    }

    table {
        font-size: 13px;
    }

    .modal-body {
        font-size: 20px;
        height: 550px;
        overflow: scroll;
    }

    table {
        font-size:13px;
    }

    .employeeSignature {
        text-align: center;
    }

</style>

@section('content')

    <p><a href="/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Consulta de Pedido Anterior</h1>
    @if(!count($errors) == 0)
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <ul><li>{{$error}}</li></ul>
            @endforeach
        </div>
    @endif
    @if ($orders == 'nothing')
        <div class="alert alert-danger" role="alert">
            Não há pedido para o período selecionado!
        </div>
    @endif
    @if(is_object($orders) && $resumido == NULL)
        @if(!count($orders) == 0)
            <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="width: 75%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><strong>Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}}</strong></h3>
                        </div>
                        <div id="previousOrderDiv" class="modal-body">
                        <table class="table">
                            <tr>
                                <th>Nome</th>
                                <th>Restaurante</th>
                                <th>Prato</th>
                                <th>Observação</th>
                                <th>Valor</th>
                                <th>Frete</th>
                                <th>Adicional</th>
                                <th>Data</th>
                            </tr>
                            @foreach($orders as $order)
                                <tr class="order">
                                    <td id="name">{{\App\Helpers\AppHelper::getEmployeeName($order->func_id).' '.substr(\App\Helpers\AppHelper::getEmployeeSurname($order->func_id), 0,10)}}</td>
                                    <td id="restaurant">{{\App\Helpers\AppHelper::getRestaurantName($order->res_id)}}</td>
                                    <td id="meal">{{$order->prato}}</td>
                                    <td id="observation">{{substr($order->observacao, 0, 15)}}</td>
                                    <td class="priceDiscount">{{$order->valor_desconto}}</td>
                                    <td class="portage">{{$order->frete}}</td>
                                    <td class="additional">{{$order->adicional}}</td>
                                    <td class="date">{{date("d-m-Y", strtotime($order->data))}}</td>
                                    <?php 
                                        $quantidade_geral++;
                                        $valor_geral += $order->valor_desconto;
                                        $frete_geral += $order->frete;
                                        $adicional_geral += $order->adicional;
                                    ?>
                                </tr>
                            @endforeach
                            <?php $total_geral = $valor_geral + $frete_geral + $adicional_geral; ?>
                            <tr>
                                <td><strong>Quantidade: {{$quantidade_geral}}</strong></td>
                                <td></td>   
                                <td></td>   
                                <td></td>   
                                <td><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($valor_geral)}}</strong></td>   
                                <td><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($frete_geral)}}</strong></td>   
                                <td><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($adicional_geral)}}</strong></td>   
                                <td><strong>Total: {{\App\Helpers\AppHelper::instance()->convertToMoney($total_geral)}}</strong></td>   
                            </tr>
                        </table>
                        </div>
                        <div class="modal-footer">
                            <form id="previousOrderPrint" action="/app/consulta_pedido/imprimir" method="POST">
                                @csrf
                                <input type="hidden" id="previousOrderCode" name="code">
                                <button class="btn btn-primary" form="previousOrderPrint">Imprimir</button>
                            </form>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    @if(is_array($orders) && $resumido == 1)
        @if(!count($orders) == 0)
            <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="width: 75%;">
                    <div class="modal-content">
                        <div id="previousOrderDiv" class="modal-body">
                            <div class="modal-header">
                                <h3 class="modal-title"><strong> Resumido Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}}</strong></h3>
                            </div>
                            <table class="table">
                                <tr>
                                    <th>Nome</th>
                                    <th>Quantidade</th>
                                    <th class="right_money">Valor</th>
                                    <th class="right_money">Valor -50%</th>
                                    <th class="right_money">Frete</th>
                                    <th class="right_money">Adicional</th>
                                    <th class="right_money">Valor Total</th>
                                    <th class="right_money">Valor Total -50%</th>
                                </tr>
                                @for($i = 0; $i < count($orders);$i++)
                                    @if($orders[$i][0]['quantidade'] != 0)
                                        <tr class="order">
                                            <?php
                                                $func_id = $orders[$i][0]['func_id'];
                                                $quantidade = $orders[$i][0]['quantidade'];
                                                $valor = $orders[$i][0]['valor'];
                                                $valor_desconto = $orders[$i][0]['valor_desconto'];
                                                $frete = $orders[$i][0]['frete'];
                                                $adicional = $orders[$i][0]['adicional'];
                                                $total = ($quantidade*$valor) + $frete + $adicional;
                                                $total_desconto = ($quantidade*$valor_desconto) + $frete + $adicional;
                                            ?>
                                            <td id="name">{{\App\Helpers\AppHelper::getEmployeeName($func_id) ?? ''}} {{substr(\App\Helpers\AppHelper::getEmployeeSurname($func_id), 0,10) ?? ''}}</td>
                                            <td id="quantity">{{$quantidade}}</td>
                                            <td class="price right_money">{{\App\Helpers\AppHelper::instance()->convertToMoney($valor)}}</td>
                                            <td class="priceDiscount right_money">{{\App\Helpers\AppHelper::instance()->convertToMoney($valor_desconto)}}</td>
                                            <td class="portage right_money">{{\App\Helpers\AppHelper::instance()->convertToMoney($frete)}}</td>
                                            <td class="additional right_money">{{\App\Helpers\AppHelper::instance()->convertToMoney($adicional)}}</td>
                                            <td class="total right_money">{{\App\Helpers\AppHelper::instance()->convertToMoney($total)}}</td>
                                            <td class="total_desconto right_money">{{\App\Helpers\AppHelper::instance()->convertToMoney($total_desconto)}}</td>

                                            <?php 
                                                $quantidade_geral += $quantidade;
                                                $valor_geral += $valor;
                                                $valor_desconto_geral += $valor_desconto;
                                                $frete_geral += $frete;
                                                $adicional_geral += $adicional;
                                                $total_geral += $total;
                                                $total_desconto_geral += $total_desconto; 
                                            ?>
                                        </tr>
                                    @endif
                                @endfor
                                <?php $total = $valor + $frete + $adicional; ?>
                                <tr>
                                    <td></td>
                                    <td><strong>{{$quantidade_geral}}</strong></td>  
                                    <td class="right_money"><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($valor_geral)}}</strong></td>   
                                    <td class="right_money"><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($valor_desconto_geral)}}</strong></td>     
                                    <td class="right_money"><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($frete_geral)}}</strong></td>   
                                    <td class="right_money"><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($adicional_geral)}}</strong></td>   
                                    <td class="right_money"><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($total_geral)}}</strong></td>  
                                    <td class="right_money"><strong>{{\App\Helpers\AppHelper::instance()->convertToMoney($total_desconto_geral)}}</strong></td>  
                                </tr>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <form id="previousOrderPrint" action="/app/consulta_pedido/imprimir" method="POST">
                                @csrf
                                <input type="hidden" id="previousOrderCode" name="code">
                                <button class="btn btn-primary" form="previousOrderPrint">Imprimir</button>
                            </form>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <form id="formPreviousOrders"action="/app/consulta_pedido/consultar" method="POST">
        {{csrf_field()}}
        <li class="list-group-item"> 
            <div class="form-group">
                <label for="data_inicial">Data Inicial:</label>
                <input type="date"  class="form-control" id="fdata_inicial" name="data_inicial" placeholder="Data Inicial" value="{{old('data_inicial')}}" >
                <label for="data_final">Data Final:</label>
                <input type="date"  class="form-control" id="fdata_final" name="data_final" placeholder="Data Final" value="{{old('data_final')}}"> <br/>
                <label for="resumido">Resumido:</label>
                <input type="checkbox"  id="fresumido" name="resumido" value="1"> <br/>
                <input type="submit" class="btn btn-primary" value="Consultar">
            </div>
        </li>
    </form>
    <script>
        $("#getCodeModal").modal("show");
        $("#fbaixado").val($('#chgerado').val());
        getCurrentTableByPage();

        function getCurrentTableByPage() {

            var htmlContent = '<style>table {font-size:15px}{font-family: sans-serif;}</style>';
                htmlContent += '<style>.page-break {page-break-before: always;}{font-size: 15px;}</style>'
                htmlContent += '<style>#name {width:200px}</style>'
                htmlContent += '<style>th {text-align: left}</style>'
                htmlContent += '<style>.right_money {text-align: right}</style>'
                //htmlContent += '<style>.employeeSignature {text-align: center; }</style>'
                htmlContent += '<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">';
                htmlContent += $('#previousOrderDiv').html();
            $('#previousOrderCode').val(htmlContent);
        }
    </script>
@endsection