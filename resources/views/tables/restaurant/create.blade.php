@extends('layouts.index')

@section('content')
    <p><a href="javascript: history.go(-1)">Voltar para a página anterior</a></p>
    <h1 class="display-1">Inserir Restaurante</h1>
    @if (count($errors) > 0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(Session::has('success'))
        <div class="alert alert-success" role="success">
            <p>{{\Session::get('success')}}</p>
        </div>
    @endif
    <form action="{{route('restaurant.create')}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text"  class="form-control" id="fnome" name="nome" placeholder="Nome do Restaurante" >
            <label for="endereço">Endereço:</label>
            <input type="text"  class="form-control" id="fendereco" name="endereco" placeholder="Endereço" >
            <label for="bairro">Número:</label>
            <input type="text"  class="form-control" id="fnumero" name="numero" placeholder="Numero" >
            <label for="bairro">Bairro:</label>
            <input type="text"  class="form-control" id="fbairro" name="bairro" placeholder="Bairro" >
            <label for="cep">CEP:</label>
            <input type="text"  class="form-control" id="fcep" name="cep" placeholder="CEP" >
            <label for="telefone">Telefone:</label>
            <input type="text"  class="form-control" id="ftelefone" name="telefone" placeholder="Telefone">
            <label for="celular">Celular:</label>
            <input type="text"  class="form-control" id="fcelular" name="celular" placeholder="Celular" >
            <label for="valor">Valor Marmitex:</label>
            <input type="text"  class="form-control" id="fvalor" name="valor" placeholder="Valor" >
            <label for="frete">Frete:</label>
            <input type="frete" class="form-control" id="ffrete" name="frete" placeholder="Frete">
            <label for="responsavel">Responsável:</label>
            <input type="text"  class="form-control" id="ffresponsavel" name="responsavel" placeholder="Responsavel" >
            <input type="checkbox" id="chfrete" name="chfrete" value = 1>
            <label for="chfrete">Cobrar Frete</label>
            <input type="checkbox" id="chadicional" name="chadicional" value = 1>
            <label for="chadicional">Cobrar Adicional</label>
            <input type="checkbox" id="chpadrao" name="chpadrao" value = 1>
            <label for="chpadrao">Padrão</label><br/>
            <input type="submit" class="btn btn-primary" value="Inserir" value = 1>
        </div>
    </form>
@endsection
