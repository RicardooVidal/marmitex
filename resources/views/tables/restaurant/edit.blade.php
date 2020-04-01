@extends('layouts.index')

@section('content')
    <p><a href="/app/tabelas/restaurantes/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Editar Restaurante</h1>
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
    <form id="formRestaurant"action="/app/tabelas/restaurantes/editar/{{$restaurant->id}}" method="POST">
        {{csrf_field()}}
        <li class="list-group-item"> 
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text"  class="form-control" id="fnome" name="nome" placeholder="Nome do Restaurante" value="{{old('nome', $restaurant->nome)}}" >
                <label for="endereço">Endereço:</label>
                <input type="text"  class="form-control" id="fendereco" name="endereco" placeholder="Endereço" value="{{old('endereco', $restaurant->endereco)}}">
                <label for="bairro">Número:</label>
                <input type="text"  class="form-control" id="fnumero" name="numero" placeholder="Numero" value="{{old('numero', $restaurant->numero)}}" >
                <label for="bairro">Bairro:</label>
                <input type="text"  class="form-control" id="fbairro" name="bairro" placeholder="Bairro" value="{{old('bairro', $restaurant->bairro)}}">
                <label for="cep">CEP:</label>
                <input type="text"  class="form-control" id="fcep" name="cep" placeholder="CEP" value="{{old('cep', str_pad($restaurant->cep, 8, '0', STR_PAD_LEFT))}}">
                <label for="telefone">Telefone:</label>
                <input type="text"  class="form-control" id="ftelefone" name="telefone" placeholder="Telefone"´value="{{old('telefone', $restaurant->telefone)}}" >
                <label for="celular">Celular:</label>
                <input type="text"  class="form-control" id="fcelular" name="celular" placeholder="Celular" value="{{old('celular', $restaurant->celular)}}" >
                <label for="valor">Valor Marmitex:</label>
                <input type="text"  class="form-control" id="fvalor" name="valor" placeholder="Valor" value="{{old('valor', $restaurant->vlr_m)}}" >
                <label for="frete">Frete:</label>
                <input type="frete" class="form-control" id="ffrete" name="frete" placeholder="Frete" value="{{old('frete', $restaurant->frete)}}">
                <label for="frete">Adicional:</label>
                <input type="adicional" class="form-control" id="fadicional" name="adicional" placeholder="Adicional" value="{{old('adicional', $restaurant->adicional)}}">
                <label for="responsavel">Responsável:</label>
                <input type="text"  class="form-control" id="ffresponsavel" name="responsavel" placeholder="Responsável" value="{{old('responsavel', $restaurant->responsavel)}}" >
                <input type="checkbox" id="chfrete" name="chfrete" value = 1 {{$restaurant->cobfr === 1 ? 'checked' : '' }}>
                <label for="chfrete">Cobrar Frete</label>
                <input type="checkbox" id="chadicional" name="chadicional" value = 1 {{$restaurant->cobad === 1 ? 'checked' : '' }}>
                <label for="chadicional">Cobrar Adicional</label>
                <input type="checkbox" id="chpadrao" name="chpadrao" value = 1 {{$restaurant->padrao === 1 ? 'checked' : '' }}>
                <label for="chpadrao">Padrão</label><br/>
                <input type="submit" class="btn btn-primary" value="Alterar" >
            </div>
        </li>
    </form>

    <script>
        $(document).ready(function(){
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
        });
    </script>

@endsection