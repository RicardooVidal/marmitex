@extends('layouts.index')

@section('content')
    <p><a href="/app/tabelas/restaurantes/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Inserir Restaurante</h1>
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
    <form id="formRestaurant"action="{{route('restaurant.create')}}" method="POST">
        {{csrf_field()}}
        <li class="list-group-item"> 
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text"  class="form-control" id="fnome" name="nome" placeholder="Nome do Restaurante" value="{{old('nome')}}" >
                <label for="endereço">Endereço:</label>
                <input type="text"  class="form-control" id="fendereco" name="endereco" placeholder="Endereço" value="{{old('endereco')}}">
                <label for="bairro">Número:</label>
                <input type="text"  class="form-control" id="fnumero" name="numero" placeholder="Numero" value="{{old('numero')}}" >
                <label for="bairro">Bairro:</label>
                <input type="text"  class="form-control" id="fbairro" name="bairro" placeholder="Bairro" value="{{old('bairro')}}">
                <label for="cep">CEP:</label>
                <input type="text"  class="form-control" id="fcep" name="cep" placeholder="CEP" value="{{old('cep')}}">
                <label for="telefone">Telefone:</label>
                <input type="text"  class="form-control" id="ftelefone" name="telefone" placeholder="Telefone"´value="{{old('telefone')}}" >
                <label for="celular">Celular:</label>
                <input type="text"  class="form-control" id="fcelular" name="celular" placeholder="Celular" value="{{old('celular')}}" >
                <label for="valor">Valor Marmitex:</label>
                <input type="text"  class="form-control" id="fvalor" name="valor" placeholder="Valor" value="{{old('valor')}}" >
                <label for="frete">Frete:</label>
                <input type="frete" class="form-control" id="ffrete" name="frete" placeholder="Frete" value="{{old('frete')}}">
                <label for="responsavel">Responsável:</label>
                <input type="text"  class="form-control" id="ffresponsavel" name="responsavel" placeholder="Responsavel" value="{{old('responsavel')}}" >
                <input type="checkbox" id="chfrete" name="chfrete" value = 1>
                <label for="chfrete">Cobrar Frete</label>
                <input type="checkbox" id="chadicional" name="chadicional" value = 1>
                <label for="chadicional">Cobrar Adicional</label>
                <input type="checkbox" id="chpadrao" name="chpadrao" value = 1>
                <label for="chpadrao">Padrão</label><br/>
                <input type="submit" class="btn btn-primary" value="Inserir" value = 1>
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
                $("#ffresponsavel").unmask();
            });
        });
    </script>

@endsection