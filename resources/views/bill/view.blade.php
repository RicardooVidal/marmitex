@extends('layouts.pdf')

@section('content')
    @if(!count($orders) == 0)
        @if($funcionario == 0)
            <table class="table">
                @foreach($employees as $employee)
                    <?php 
                        $quantidade = 0 ;
                        $total = 0;
                        $adicional = 0;
                        $frete = 0;
                        $valor = 0;
                    ?>
                    <td><h3><strong><Nome:</strong> {{$employee->nome.' '.$employee->sobrenome}}</h3></td>
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
                                <td id="name">{{\App\Helpers\AppHelper::getEmployeeName($order->func_id).' '.\App\Helpers\AppHelper::getEmployeeSurname($order->func_id)}}</td>
                                <td id="restaurant">{{\App\Helpers\AppHelper::getRestaurantName($order->res_id)}}</td>
                                <td id="meal">{{$order->prato}}</td>
                                <td id="observation">{{$order->observacao}}</td>
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
                        <td><strong>Total Geral: {{number_format($total,2)}}</strong></td>   
                    </tr>
                @endforeach
            </table>
        @else
            <table class="table">
                <?php 
                    $quantidade = 0 ;
                    $total = 0;
                    $adicional = 0;
                    $frete = 0;
                    $valor = 0;
                ?>
                <td><h3><strong><Nome:</strong> {{\App\Helpers\AppHelper::getEmployeeName($funcionario).' '.\App\Helpers\AppHelper::getEmployeeSurname($funcionario)}}</h3></td>
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
                        <td id="name">{{\App\Helpers\AppHelper::getEmployeeName($order->func_id).' '.\App\Helpers\AppHelper::getEmployeeSurname($order->func_id)}}</td>
                        <td id="restaurant">{{\App\Helpers\AppHelper::getRestaurantName($order->res_id)}}</td>
                        <td id="meal">{{$order->prato}}</td>
                        <td id="observation">{{$order->observacao}}</td>
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
                    <td><strong>Total Geral: {{number_format($total,2)}}</strong></td>   
                </tr>
            </table>
            @endif
        @endif
@endsection
