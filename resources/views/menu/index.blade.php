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
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp1" name="p1" placeholder="Prato 1" value="{{ $menu['p1'] }}" maxlength="60" required>
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp2" name="p2" placeholder="Prato 2" value="{{ $menu['p2'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp3" name="p3" placeholder="Prato 3" value="{{ $menu['p3'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp4" name="p4" placeholder="Prato 4" value="{{ $menu['p4'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp5" name="p5" placeholder="Prato 5" value="{{ $menu['p5'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp6" name="p6" placeholder="Prato 6" value="{{ $menu['p6'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp7" name="p7" placeholder="Prato 7" value="{{ $menu['p7'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp8" name="p8" placeholder="Prato 8" value="{{ $menu['p8'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp9" name="p9" placeholder="Prato 9" value="{{ $menu['p9'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp10" name="p10" placeholder="Prato 10" value="{{ $menu['p10'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp11" name="p11" placeholder="Prato 11" value="{{ $menu['p11'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp12" name="p12" placeholder="Prato 12" value="{{ $menu['p12'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp13" name="p13" placeholder="Prato 13" value="{{ $menu['p13'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp14" name="p14" placeholder="Prato 14" value="{{ $menu['p14'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp15" name="p15" placeholder="Prato 15" value="{{ $menu['p15'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp16" name="p16" placeholder="Prato 16" value="{{ $menu['p16'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp17" name="p17" placeholder="Prato 17" value="{{ $menu['p17'] }}" maxlength="60">
                            <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" id="fp18" name="p18" placeholder="Prato 18" value="{{ $menu['p18'] }}" maxlength="60">
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
                            <input type="text"  class="form-control" id="fpr9" name="pr9" placeholder="Preço Prato 9" value="{{ $menu['pr9'] }}" >
                            <input type="text"  class="form-control" id="fpr10" name="pr10" placeholder="Preço Prato 10" value="{{ $menu['pr10'] }}" >
                            <input type="text"  class="form-control" id="fpr11" name="pr11" placeholder="Preço Prato 11" value="{{ $menu['pr11'] }}" >
                            <input type="text"  class="form-control" id="fpr12" name="pr12" placeholder="Preço Prato 12" value="{{ $menu['pr12'] }}" >
                            <input type="text"  class="form-control" id="fpr13" name="pr13" placeholder="Preço Prato 13" value="{{ $menu['pr13'] }}" >
                            <input type="text"  class="form-control" id="fpr14" name="pr14" placeholder="Preço Prato 14" value="{{ $menu['pr14'] }}" >
                            <input type="text"  class="form-control" id="fpr15" name="pr15" placeholder="Preço Prato 15" value="{{ $menu['pr15'] }}" >
                            <input type="text"  class="form-control" id="fpr16" name="pr16" placeholder="Preço Prato 16" value="{{ $menu['pr16'] }}" >
                            <input type="text"  class="form-control" id="fpr17" name="pr17" placeholder="Preço Prato 17" value="{{ $menu['pr17'] }}" >
                            <input type="text"  class="form-control" id="fpr18" name="pr18" placeholder="Preço Prato 18" value="{{ $menu['pr18'] }}" >
                        </div>
                    </div>
                </li><br/>
                <input type="submit" class="btn btn-primary" value="Inserir" value = 1><br/>
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
            $('#fpr9').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr10').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr11').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr12').mask('000.000.000.000.000,00' , { reverse : true});
        });
    
        $(document).ready(function(){
            $('#fpr13').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr14').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr15').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr16').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr17').mask('000.000.000.000.000,00' , { reverse : true});
        });

        $(document).ready(function(){
            $('#fpr18').mask('000.000.000.000.000,00' , { reverse : true});
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
                $("#fp9").unmask();
                $("#fp10").unmask();
                $("#fp11").unmask();
                $("#fp12").unmask();
                $("#fp13").unmask();
                $("#fp14").unmask();
                $("#fp15").unmask();
                $("#fp16").unmask(); 
                $("#fp17").unmask();
                $("#fp18").unmask(); 
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