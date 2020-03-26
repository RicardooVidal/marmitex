@extends('layouts.index')

@section('content')
    <p><a href="/app/tabelas/funcionarios/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Inserir Funcionário</h1>
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
    <form id="formEmployee"action="{{route('employee.create')}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text"  class="form-control" id="fnome" name="nome" placeholder="Nome do Funcionário" value="{{old('nome')}}" >
            <label for="nome">Sobrenome:</label>
            <input type="text"  class="form-control" id="fsobrenome" name="sobrenome" placeholder="Sobrenome" value="{{old('sobrenome')}}" >
            <label for="nome">Mensagem:</label>
            <input type="text"  class="form-control" id="fmensagem" name="mensagem" placeholder="Essa mensagem vai aparecer quando o usuário clicar neste nome" value="{{old('mensagem')}}" >
            <label for="nome">Bloqueado:</label>
            <input type="radio" id="sim" name="bloqueado" value="1">
            <label for="bloqueio-sim">Sim</label>
            <input type="radio" id="nao" name="bloqueado" value="2" checked>
            <label for="bloqueio-nao">Não</label><br/>
            <label for="nome">Pode preencher observação?:</label>
            <input type="radio" id="sim" name="observacao" value="1">
            <label for="observacao-sim">Sim</label>
            <input type="radio" id="nao" name="observacao" value="2" checked>
            <label for="observacao-nao">Não</label><br/>  
            <input type="submit" class="btn btn-primary" value="Inserir" value = 1>
        </div>
    </form>
@endsection