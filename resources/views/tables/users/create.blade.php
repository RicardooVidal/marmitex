@extends('layouts.index')

@section('content')
    <p><a href="/app/tabelas/usuarios/">Voltar para a página anterior</a></p>
    <h1 class="display-1">Inserir Usuário</h1>
    @if(!empty($exists))
        <div class="alert alert-danger" role="success">
            <p>{{ $exists }}</p>
        </div>
    @endif
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
    <form id="formUser"action="{{route('user.create')}}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
            <label for="nome">Usuario:</label>
            <input type="text"  class="form-control" id="fusuario" name="usuario" placeholder="Usuário (Até 8 caracteres)" value="{{old('usuario')}}" maxlength="8" >
            <label for="nome">Senha:</label>
            <input type="password"  class="form-control" id="fusuario" name="senha" placeholder="Senha (Até 10 caracteres)" value="{{old('senha')}}" maxlength="10"><br/>
            <input type="submit" class="btn btn-primary" value="Inserir" value = 1>
        </div>
    </form>
@endsection