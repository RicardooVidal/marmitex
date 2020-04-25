@extends('layouts.index')
<?php 
    
    $quantidade = 0;
    $total = 0;

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

    <p><a href="/app/tabelas/restaurantes/">Voltar para a página anterior</a></p>
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
                                        <div class="page-break"><h3><strong><Nome:</strong> {{$employee->nome.' '.$employee->sobrenome}}</h3> <p> Período: {{date("d-m-Y", strtotime($data_inicial))}} até {{date("d-m-Y", strtotime($data_final))}}</p></div><br/><br/><br/>
                                        <table id="billTable" class="table">
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
                                                <th>Observação</th>
                                                <th>Valor</th>
                                                <th>Frete</th>
                                                <th>Adicional</th>
                                                <th>Data</th>
                                            </tr>
                                            @foreach($orders as $order)
                                                <tr class="order">
                                                    @if ($order->func_id == $employee->id)
                                                        <td id="name">{{$employees[$order->func_id-1]->nome.' '.substr($employees[$order->func_id-1]->sobrenome, 0,10)}}</td>
                                                        <td id="restaurant">{{$restaurant[$order->res_id-1]->nome}}</td>
                                                        <td id="meal">{{$order->prato}}</td>
                                                        <td id="observation">{{substr($order->observacao, 0, 15)}}</td>
                                                        <td class="priceDiscount">{{$order->valor_desconto}}</td>
                                                        <td class="portage">{{$order->frete}}</td>
                                                        <td class="additional">{{$order->adicional}}</td>
                                                        <td class="date">{{$order->data}}</td>
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
                                                <td><strong>{{number_format($valor,2)}}</strong></td>   
                                                <td><strong>{{number_format($frete,2)}}</strong></td>   
                                                <td><strong>{{number_format($adicional,2)}}</strong></td>   
                                                <td><strong>Total: {{number_format($total,2)}}</strong></td>   
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
                            <h3><strong><Nome:</strong> {{$employees[$funcionario-1]->nome.' '.$employees[$funcionario-1]->sobrenome}} </h3> 
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
                                        <td class="date">{{$order->data}}</td>
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
                                    <td><strong>{{number_format($valor,2)}}</strong></td>   
                                    <td><strong>{{number_format($frete,2)}}</strong></td>   
                                    <td><strong>{{number_format($adicional,2)}}</strong></td>   
                                    <td><strong>Total: {{number_format($total,2)}}</strong></td>   
                                </tr>
                            </table>
                            <div class="employeeSignature">
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                                <p>____________________________________________</p>
                                <p></p>
                                <p>{{$employees[$order->func_id-1]->nome.' '.$employees[$order->func_id-1]->sobrenome}}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form id="billGenerateForm" action="/app/cobranca/gerar" method="POST">
                                {{csrf_field()}} 
                                <input type="hidden" id="billCode" name="code">
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

            var htmlContent = '<style>table {font-size:11px}</style>';
                htmlContent += '<style>.page-break {page-break-before: always; height: 0; }</style>'
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