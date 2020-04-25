@extends('layouts.index')

<?php     
    $quantidade = 0;
    $total = 0;
?>
<style>
    #orderViewHeader {
        position: relative
    }

    #orderViewHeader #btnDoOrder {
        position: absolute;
        right: 0;
        bottom: 0px;
    }

    #orderViewHeader #btnEtiquetitas {
        position: absolute;
        right: 125px;
        bottom: 0px;
    }

</style>
@section('content')
    <p><a href="/app/pedido">Voltar para a página anterior</a></p>
    <div id="orderViewHeader">
        <h1 class="display-1">Pedido do dia - {{ date("d/m/Y")}}</h1>
        <div id="btnDoOrder"><button type="button" CLASS="btn btn-primary" data-toggle="modal" data-target="#modalGenerateOrder">Gerar Pedido</button></div>
        <div id="btnEtiquetitas"><a class='btn btn-primary' href="/app/pedido/etiquetas">Etiquetas</a></div>
    </div>
    @if(!empty(\Session::get('deleted')))
        <div class="alert alert-success" role="deleted">
            <p>Pedido excluído com sucesso</p>
        </div>
    @endif
    @if(!empty(\Session::get('error')))
        <div class="alert alert-danger" role="error">
            <p>Erro ao gerar o pedido. Tente novamente. Se o problema persistir, entre em contato em contato@ricardovidal.xyz</p>
        </div>
    @endif
    @if(!empty(\Session::get('success')))
        <script>            
            var file = document.location.hostname + ':8000/pedido.txt/'
            $.get('http://localhost:8000/pedido.txt', function(data) {
                alert(data);          
            });
        </script>
    @endif
    <table class="table table-striped">
        <thead>
            <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Prato</th>
            <th>Observação</th>
            <th>Preço</th>
            <th>Preço -50%</th>
            @if (Route::has('login'))
                @auth
                    <th scope="col">Adm</th>
                @endif
            @endif
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr class="order">
                    <td id="id"><strong>{{$order->id}}</strong></td>
                    <td id="name">{{$employees[$order->func_id-1]->nome.' '.$employees[$order->func_id-1]->sobrenome}}</td>
                    <td id="meal">{{$order->prato}}</td>
                    <td id="observation">{{substr($order->observacao,0, 55)}}</td>
                    <td class="price">{{$order->valor}}</td>
                    <td class="priceDiscount">{{$order->valor_desconto}}</td>
                    @if (Route::has('login'))
                        @auth
                        <form method="post" class="delete_form" action="{{action('OrderController@destroy', $order['id'])}}">
                            {{csrf_field()}}
                            <input type="hidden" name="_method" value="DELETE"/>                
                            <td><button type="submit" class="btn btn-danger">Deletar</button></td>
                        </form>
                        @endif
                    @endif
                    <?php $quantidade++;
                          $total = $total + $order->valor;
                    ?>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
            <td>Quantidade: </td>
            <td>{{$quantidade}}</td>
            <td></td>
            <td></td>
            <td>Total: </td>
            <td>{{number_format($total,2)}}</td>
            </tr>
        </tfoot>
    </table>
<!-- Modal -->
<div class="modal fade" id="modalGenerateOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title">Gerar Pedido</h2>
      </div>
        <form method="post" id="generateOrder" action="/app/pedido/gerar">
            {{csrf_field()}}
            <div class="modal-body">
                <label for="adicional">Adicional:</label>
                <input type="number"  class="form-control" id="fadicional" name="adicional" value="1" >
                <label for="tipo">Tipo:</label>
                <select name="tipo_adicional" class="form-control">
                    <option value="Refrigerante 2L">Refrigerante 2L</option>
                    <option value="Refrigerante 3L">Refrigerante 3L</option>
                    <option value="Suco">Suco</option>
                </select>
                <label for="valor">Valor:</label>
                <input type="hidden" class="form-control" id="fvalorOriginal" name="valorOriginal" value="{{$restaurantDefault['adicional']}}">
                <input type="text" class="form-control" id="fvalor" name="valor" value="{{$restaurantDefault['adicional']}}" autocomplete="off" disabled>
                <label for="valor">Total (+ Frete):</label>
                <input type="hidden" class="form-control" id="ftotalOriginal" name="totalrOriginal" value="{{ number_format($total+$restaurantDefault['frete']+$restaurantDefault['adicional'], 2)}}" autocomplete="off">
                <input type="text" class="form-control" id="ftotal" name="total" value="{{ number_format($total+$restaurantDefault['frete']+$restaurantDefault['adicional'], 2)}}" autocomplete="off" disabled>
                <label for="valor">Troco:</label>
                <input type="text" class="form-control" id="ftroco" name="troco" value="0" autocomplete="off">
                <label for="valor">Observação:</label>
                <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase();" id="fobservacao" name="observacao" placeholder="Exemplo: Um refrigerante de brinde" value="">
                <input type="hidden" id="ffrete" name="frete" value="{{$restaurantDefault['frete']}}"/>   
                <input type="hidden" id="fcobra_frete" name="cobra_frete" value="{{$restaurantDefault['cobfr']}}"/>   
                <input type="hidden" id="fcobra_adicional" name="cobra_adicional" value="{{$restaurantDefault['cobad']}}"/>   
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Gerar Pedido</button>
            </div>
        </form>
    </div>
  </div>
</div>
    <script>
        $(document).ready(function(){
            $( "#fadicional").change(function(e) {
                var oldTotal = $("#ftotalOriginal").val();
                oldTotal = oldTotal.replace(",",".");
                oldTotal = parseFloat(oldTotal);
                var oldValue = $("#fvalorOriginal").val();
                oldValue = oldValue.replace(",",".");
                oldValue = parseFloat(oldValue);
                oldTotal -= oldValue;
                var newQuantity = parseInt($("#fadicional").val());
                var newTotal = oldTotal + (oldValue * newQuantity);
                var newValue = oldValue * newQuantity;

                newValue =newValue.toFixed(2);
                newValue = newValue.toString();
                newValue = newValue.replace(".",",");

                newTotal =newTotal.toFixed(2);
                newTotal = newTotal.toString();
                newTotal = newTotal.replace(".",",");

                $("#ftotal").val(newTotal); //input Total
                $("#fvalor").val(newValue); //input Valor Adicional
            });

            $('#generateOrder').submit(function(e) {
                //event.preventDefault();
                $("#fvalor").prop('disabled', false);
                $("#ftotal").prop('disabled', false);
                //generateOrder();
            });

            $('.delete_form').on('submit', function(){
                if(confirm("Confirma exclusão?")) {
                    return true;
                } else {
                    return false;
                }
            })

            // $('#btnEtiquetitas').click(function(){
            //     if(confirm("Confirma emissão de etiquetas?")) {
            //         generateTags();
            //     } else {
            //         return false;
            //     }
            // })
        })

        function generateOrder() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            var adicional = $("input[name=adicional]").val();
            var qtdAdicional = $("input[name=qtdAdicional]").val();
            var tipo_adicional = $("input[name=tipo_adicional]").val();
            var frete = $("input[name=frete]").val();
            var total = $("input[name=total]").val();
            var troco = $("input[name=troco]").val();
            var observacao = $("input[name=observacao]").val();

            $.ajax({
                url: "/app/pedido/gerar/",
                type:"POST",
                data:{
                    adicional:adicional, qtdAdicional:qtdAdicional, tipo_adicional:tipo_adicional,frete:frete, total:total, troco:troco, observacao:observacao, "_token": "{{ csrf_token() }}"
                },
                success:function(response){
                    if (response['wasGenerated'] == 1) {
                        orderGenerated();
                    } else {
                        orderNotGenerated();
                    }
                },
            });
        }

        function orderNotGenerated() {
            $.alert('<center>Desculpe, houve um problema ao gerar o pedido. Por favor, tente novamente. <br> Se o problema persistir, entre em contato em contato@ricardovidal.xyz</center>');
        }

        function generateTags() {
            $.ajax({
                url: "/app/pedido/etiquetas/",
                type:"GET",
                success:function(response){
                    if (response['wasGenerated'] == 1) {
                        orderGenerated();
                    } else {
                        orderNotGenerated();
                    }
                },
            });
        }
    </script>
@endsection