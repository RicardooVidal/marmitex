@extends('layouts.index')

<style>
    #imgDefault img {
        position: absolute;
        top: 3px;
        width: 25px;
        height: 25px;
    }
</style>


@section('content')
    <p><a href="/app/tabelas">Voltar para a página anterior</a></p>
    <h1 class="display-1">Configurações</h1>
    <h3 class="display-1">Definições gerais</h3>
    @if(!empty($success))
        <div class="alert alert-success" role="success">
            <p>{{ $success }}</p>
        </div>
    @endif
    <ul class="list-group">
        <li class="list-group-item"> 
            <form id="formConfig"action="{{route('config.update')}}" method="POST">
            {{ csrf_field() }}
                <div class="form-group">
                    <label for="horario">Horário:</label>
                    <input type="text"  class="form-control" id="fhorario" name="horario" placeholder="Horário limite para pedidos" value="{{old('horario', $config->horario)}}">
                    <label for="mensagem">Mensagem:</label>
                    <input type="text"  class="form-control" id="fmensagem" name="mensagem" placeholder="Se preencher este campo, uma mensagem vai aparecer quando o usuário abrir o sistema" value="{{old('mensagem', $config->mensagem)}}"><br/>
                    <label for="mensagem">Zebra Tag API (Windows):</label>
                    <input type="text"  class="form-control" id="fzebra" name="zebra" value="{{old('mensagem', $config->zebra)}}"><br/>
                    <p>Licença: </p>
                    <input type="submit" class="btn btn-primary" value="Salvar">
                </div>
            </form>
        </li>
    </ul>

@endsection