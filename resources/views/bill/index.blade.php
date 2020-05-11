@extends('layouts.index')
<?php 
    
    $quantidade = 0;
    $total = 0;

?>

<style>

    /* .modal-dialog {
        text-align: center;
    } */

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
    <h1 class="display-1">Cobrança</h1>
    @if(!count($errors) == 0)
        <div class="alert alert-danger" role="alert">
            @foreach($errors->all() as $error)
                <ul><li>{{$error}}</li></ul>
            @endforeach
        </div>
    @endif
    @if(!empty($success))
        <div class="alert alert-success" role="success">
            <p>{{ $success }}</p>
        </div>
    @endif
    @if ($orders == 'nothing')
        <div class="alert alert-danger" role="alert">
            Não há cobrança para o período selecionado!
        </div>
    @endif
    @if(is_object($orders))
        @if(!count($orders) == 0)
            @if($funcionario == 0)
                <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width: 75%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title"><strong>Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}}</strong></h3>
                            </div>
                            <div id="billDiv" class="modal-body">
                                    @foreach($employees as $employee)
                                        <?php $tem=0; ?>
                                        @foreach($orders as $order)
                                            @if ($order->func_id == $employee->id && $order->quantidade >= 1) 
                                                <?php $tem = 1; ?>
                                            @endif
                                        @endforeach 
                                        @if ($tem == 1 )
                                            <div class="page-break"><h3><strong><Nome:</strong> {{$employee->nome.' '.$employee->sobrenome}}</h3> <p> Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}}</p></div><br/><br/><br/>
                                            <table id="billTable" class="table" style="font-size:15px;">
                                                <?php 
                                                    $quantidade = 0 ;
                                                    $total = 0;
                                                    $adicional = 0;
                                                    $frete = 0;
                                                    $valor = 0;
                                                ?>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Restaurante</th>
                                                    <th>Prato</th>
                                                    <th width="20%">Observação</th>
                                                    <th class="right_money">Valor</th>
                                                    <th class="right_money">Frete</th>
                                                    <th class="right_money">Adicional</th>
                                                    <th>Data</th>
                                                </tr>
                                                @foreach($orders as $order)
                                                    <tr class="order">
                                                        @if ($order->func_id == $employee->id)
                                                            <td id="name">{{\App\Helpers\AppHelper::getEmployeeName($order->func_id).' '.substr(\App\Helpers\AppHelper::getEmployeeSurname($order->func_id), 0,10)}}</td>
                                                            <td id="restaurant">{{\App\Helpers\AppHelper::getRestaurantName($order->res_id)}}</td>
                                                            <td id="meal">{{$order->prato}}</td>
                                                            <td id="observation">{{substr($order->observacao, 0, 15)}}</td>
                                                            <td class="priceDiscount right_money">{{$order->valor_desconto}}</td>
                                                            <td class="portage right_money">{{$order->frete}}</td>
                                                            <td class="additional right_money">{{$order->adicional}}</td>
                                                            <td class="date">{{date("d-m-Y", strtotime($order->data))}}</td>
                                                            <?php $quantidade++;
                                                                $valor += $order->valor_desconto;
                                                                $frete += $order->frete;
                                                                $adicional += $order->adicional;
                                                            ?>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                <?php $total = $valor + $frete + $adicional; ?>
                                                <tr>
                                                    <td><strong>Quantidade: {{$quantidade}}</strong></td>
                                                    <td></td>   
                                                    <td></td>   
                                                    <td></td>   
                                                    <td class="right_money"><strong>{{number_format($valor,2)}}</strong></td>   
                                                    <td class="right_money"><strong>{{number_format($frete,2)}}</strong></td>   
                                                    <td class="right_money"><strong>{{number_format($adicional,2)}}</strong></td>   
                                                    <td class="right_money"><strong>Total: {{number_format($total,2)}}</strong></td>   
                                                </tr>
                                            </table>
                                                <div class="employeeSignature">
                                                <p>&nbsp;</p>
                                                <p>&nbsp;</p>
                                                <p>&nbsp;</p>
                                                <p>____________________________________________</p>
                                                <p></p>
                                                <p>{{$employee->nome.' '.$employee->sobrenome}}</p>
                                            </div>
                                        @endif
                                    @endforeach
                            </div>
                            <div class="modal-footer">
                            <form id="billGenerateForm" action="/app/cobranca/gerar" method="POST">
                                {{csrf_field()}} 
                                <input type="hidden" id="billCode" name="code">
                                <input type="hidden" id="ffuncionario" name="funcionario" value="{{$funcionario}}">
                                <input type="hidden" id="fbaixado" name="baixado">
                                <input type="hidden" id="fdata_inicial" name="data_inicial" value="{{$data_inicial}}">
                                <input type="hidden" id="fdata_final" name="data_final" value="{{$data_final}}">
                                <button class="btn btn-primary" form="billGenerateForm">Gerar cobrança</button>
                            </form>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" style="width: 75%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title"><strong>Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}} </strong></h3>
                        </div>
                        <div id="billDiv" class="modal-body">
                            <h3><strong><Nome:</strong> {{\App\Helpers\AppHelper::getEmployeeName($funcionario).' '.\App\Helpers\AppHelper::getEmployeesSurname($funcionario)}} </h3> 
                            <p>Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}} </p>
                            <table id="billTable" class="table">
                                <?php 
                                    $quantidade = 0 ;
                                    $total = 0;
                                    $adicional = 0;
                                    $frete = 0;
                                    $valor = 0;
                                ?>
                                <td></td>
                                <tr>
                                    <th>Nome</th>
                                    <th>Restaurante</th>
                                    <th>Prato</th>
                                    <th width="20%">Observação</th>
                                    <th class="right_money">Valor</th>
                                    <th class="right_money">Frete</th>
                                    <th class="right_money">Adicional</th>
                                    <th>Data</th>
                                </tr>
                                @foreach($orders as $order)
                                    <tr class="order">
                                    <td id="name">{{\App\Helpers\AppHelper::getEmployeeName($order->func_id).' '.substr(\App\Helpers\AppHelper::getEmployeeSurname($order->func_id), 0,10)}}</td>
                                        <td id="restaurant">{{\App\Helpers\AppHelper::getRestaurantName($order->res_id)}}</td>
                                        <td id="meal">{{$order->prato}}</td>
                                        <td id="observation">{{substr($order->observacao, 0, 15)}}</td>
                                        <td class="priceDiscount right_money">{{$order->valor_desconto}}</td>
                                        <td class="portage right_money">{{$order->frete}}</td>
                                        <td class="additional right_money">{{$order->adicional}}</td>
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
                                    <td></td>
                                    <td></td>   
                                    <td></td>   
                                    <td></td>   
                                    <td class="right_money"><strong>{{number_format($valor,2)}}</strong></td>   
                                    <td class="right_money"><strong>{{number_format($frete,2)}}</strong></td>   
                                    <td class="right_money"><strong>{{number_format($adicional,2)}}</strong></td>   
                                    <td class="right_money"><strong>Total: {{number_format($total,2)}}</strong></td>   
                                </tr>
                            </table>
                            <div class="employeeSignature">
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>____________________________________________</p>
                                <p></p>
                                <p>{{\App\Helpers\AppHelper::getEmployeeName($order->func_id).' '.\App\Helpers\AppHelper::getEmployeeSurname($order->func_id)}}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form id="billGenerateForm" action="/app/cobranca/gerar" method="POST">
                                {{csrf_field()}} 
                                <input type="hidden" id="billCode" name="code">
                                <input type="hidden" id="ffuncionario" name="funcionario" value="{{$funcionario}}">
                                <input type="hidden" id="fbaixado" name="baixado">
                                <input type="hidden" id="fdata_inicial" name="data_inicial" value="{{$data_inicial}}">
                                <input type="hidden" id="fdata_final" name="data_final" value="{{$data_final}}">
                                <button class="btn btn-primary" form="billGenerateForm">Gerar cobrança</button>
                            </form>
                            <button type="button" class="btn btn-white" data-dismiss="modal">Fechar</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif
    @endif

    <form id="formCobranca"action="/app/cobranca" method="POST">
        {{csrf_field()}}
        <li class="list-group-item"> 
            <div class="form-group">
                <label for="data_inicial">Data Inicial:</label>
                <input type="date"  class="form-control" id="fdata_inicial" name="data_inicial" placeholder="Data Inicial" value="{{old('data_inicial')}}" >
                <label for="data_final">Data Final:</label>
                <input type="date"  class="form-control" id="fdata_final" name="data_final" placeholder="Data Final" value="{{old('data_final')}}">
                <label for="bairro">Funcionário:</label>
                <select name="funcionarios" class="form-control">
                    <option value="0">TODOS</option>
                    @foreach($employees as $employee)
                        <option value="{{$employee['id']}}">{{$employee['nome'] .' '. $employee['sobrenome']}}</option>
                    @endforeach
                </select>
                <label for="filtro">Filtro:</label>
                <input type="checkbox" id="chgerado" name="chgerado" value = 1>
                <label for="chgerado">Baixado</label><br/>
                <input type="submit" class="btn btn-primary" value="Gerar Cobrança">
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
                htmlContent += '<style>#observation {width:200px}</style>'
                htmlContent += '<style>th {text-align: left}</style>'
                htmlContent += '<style>.right_money {text-align: right}</style>'
                htmlContent += '<style>.employeeSignature {text-align: center; }</style>'
                htmlContent += '<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">';
                htmlContent += $('#billDiv').html();
            $('#billCode').val(htmlContent);
            // console.log(htmlContent);
            // saveAs(htmlContent, "dynamic.html");
            //fs.writeFile('page.html', htmlContent, (error) => { /* handle error */ });
            // var field = document.getElementById("billOrder");
            // fieldvalue= field.value;
            // console.log(fieldvalue);
        }
    </script>
@endsection