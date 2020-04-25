@extends('layouts.index')

<style>
    #divMenu {
        width: 900px;
        margin: 0 auto;

    }

    #formMeals {
        display: inline-block;
        width: 75%;
    }

    #formMeals input {
        padding: 5px;
        margin-bottom: 10px;
    }


    #formPrices {
        position: absolute;
        right: 45px;
        bottom: 25px;
        width: 150px;
    }

    #formPrices input{
        padding: 5px;
        margin-bottom: 10px;
        right: 15px;
    }

    #restaurantContainer {
        position: relative;
        margin: 0 auto;
        width: 900px;
        padding: 10px;
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

</style>

@section('content')
    <p><a href="/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Cardápio do Dia - {{ date("d/m/Y")}}</h1>
    @if ($restaurantDefault['padrao'] != 1)
        <div class="alert alert-danger" role="alert">
            Restaurante deste cardápio não é padrão! <a href="/app/tabelas/restaurantes/">Clique para definir</a>
        </div>
    @endif
    @if ($restaurantDefault === null)
        <div class="alert alert-danger" role="alert">
            Restaurante padrão não definido! <a href="/app/tabelas/restaurantes/">Clique para definir</a>
        </div>
    @else
        <div id="restaurantContainer">
            <h4 id="restaurantTitle" class="display-1">Restaurante: {{ $restaurantDefault['nome'] }}</h4>
            <h4 id="restaurantResponsible" class="display-1">Responsável: {{ $restaurantDefault['responsavel'] }}</h4>
            <div id="restaurantTelephone" class="display-1"><h4>Telefone: {{ $restaurantDefault['telefone'] }}</h4></div>
            <div id="restaurantCellphone" class="display-1"><h4>Celular: {{ $restaurantDefault['celular'] }}</h4></div>
        </div>
        <div id ="divMenu">
            <form id="formMenu"action="/app/cardapio/editar/{{$menu['res_id']}}" method="POST">
                {{csrf_field()}}
                <li class="list-group-item">    
                    <div id="formMeals">
                        <div class="form-group">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();"  class="form-control" id="fp1" name="p1" placeholder="Prato 1" value="{{ $menu['p1'] }}" maxlength="60" required>
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp2" name="p2" placeholder="Prato 2" value="{{ $menu['p2'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp3" name="p3" placeholder="Prato 3" value="{{ $menu['p3'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp4" name="p4" placeholder="Prato 4" value="{{ $menu['p4'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp5" name="p5" placeholder="Prato 5" value="{{ $menu['p5'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp6" name="p6" placeholder="Prato 6" value="{{ $menu['p6'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp7" name="p7" placeholder="Prato 7" value="{{ $menu['p7'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp8" name="p8" placeholder="Prato 8" value="{{ $menu['p8'] }}" maxlength="60">
                        </div>
                    </div>
                    <div id="formPrices">
                        <div class="form-group">
                            <input type="text"  class="form-control" id="fpr1" name="pr1" placeholder="Preço Prato 1" value="{{ $menu['pr1'] }}" >
                            <input type="text"  class="form-control" id="fpr2" name="pr2" placeholder="Preço Prato 2" value="{{ $menu['pr2'] }}" >
                            <input type="text"  class="form-control" id="fpr3" name="pr3" placeholder="Preço Prato 3" value="{{ $menu['pr3'] }}" >
                            <input type="text"  class="form-control" id="fpr4" name="pr4" placeholder="Preço Prato 4" value="{{ $menu['pr4'] }}" >
                            <input type="text"  class="form-control" id="fpr5" name="pr5" placeholder="Preço Prato 5" value="{{ $menu['pr5'] }}" >
                            <input type="text"  class="form-control" id="fpr6" name="pr6" placeholder="Preço Prato 6" value="{{ $menu['pr6'] }}" >
                            <input type="text"  class="form-control" id="fpr7" name="pr7" placeholder="Preço Prato 7" value="{{ $menu['pr7'] }}" >
                            <input type="text"  class="form-control" id="fpr8" name="pr8" placeholder="Preço Prato 8" value="{{ $menu['pr8'] }}" >
                        </div>
                    </div>
                </li><br/>
                <input type="submit" class="btn btn-primary" value="Inserir" value = 1>
            </form>
        </div>
    @endif

    <script type="text/javascript">

        $(document).ready(function(){
            $('#fpr1').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr2').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr3').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr4').mask('000.000.000.000.000,00' , { reverse : true});
        });
    
        $(document).ready(function(){
            $('#fpr5').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr6').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr7').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr8').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $("#formMenu").submit(function() {
                $("#fp1").unmask();
                $("#fp2").unmask();
                $("#fp3").unmask();
                $("#fp4").unmask();
                $("#fp5").unmask();
                $("#fp6").unmask();
                $("#fp7").unmask();
                $("#fp8").unmask(); 
                // $("#fpr1").unmask();
                // $("#fpr2").unmask();
                // $("#fpr3").unmask();
                // $("#fpr4").unmask();
                // $("#fpr5").unmask();
                // $("#fpr6").unmask();
                // $("#fpr7").unmask();
                // $("#fpr8").unmask();
                //$("#fp1").val($(this).val().toUpperCase());
            });
        });
    </script>


@endsection