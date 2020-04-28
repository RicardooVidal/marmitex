@extends('layouts.index')
<?php 
    
    $quantidade = 0;
    $total = 0;
    $valor = 0;
    $frete = 0;
    $adicional = 0;

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
    @if(is_object($orders))
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
                                    <td id="name">{{$employees[$order->func_id-1]->nome.' '.substr($employees[$order->func_id-1]->sobrenome, 0,10)}}</td>
                                    <td id="restaurant">{{$restaurant[$order->res_id-1]->nome}}</td>
                                    <td id="meal">{{$order->prato}}</td>
                                    <td id="observation">{{substr($order->observacao, 0, 15)}}</td>
                                    <td class="priceDiscount">{{$order->valor_desconto}}</td>
                                    <td class="portage">{{$order->frete}}</td>
                                    <td class="additional">{{$order->adicional}}</td>
                                    <td class="date">{{date("d-m-Y", strtotime($order->data))}}</td>
                                    <?php $quantidade++;
                                        $valor += $order->valor_desconto;
                                        $frete += $order->frete;
                                        $adicional += $order->adicional;
                                    ?>
                                </tr>
                            @endforeach
                            <?php $total = $valor + $frete + $adicional; ?>
                            <tr>
                                <td><strong>Quantidade: {{$quantidade}}</strong></td>
                                <td></td>   
                                <td></td>   
                                <td></td>   
                                <td><strong>{{number_format($valor,2)}}</strong></td>   
                                <td><strong>{{number_format($frete,2)}}</strong></td>   
                                <td><strong>{{number_format($adicional,2)}}</strong></td>   
                                <td><strong>Total: {{number_format($total,2)}}</strong></td>   
                            </tr>
                        </table>
                        </div>
                        <div class="modal-footer">
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

                <input type="submit" class="btn btn-primary" value="Consultar">
            </div>
        </li>
    </form>
    <script>
        $("#getCodeModal").modal("show");
    </script>
@endsection