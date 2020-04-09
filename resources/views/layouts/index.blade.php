<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <style>
        .content {
            width: 60%;
            position: relative;
            left: 20%;
        }

        .form-group label {
            margin-top: 5px;
            padding: 10px;
        }

        .btn-primary#insert {
            padding: 10px;
            margin-bottom: 10px;
        }

        .list-group-item {
          padding: 25px;
          margin: 10px 10px auto;
          position: relative;
        }

        .buttons-register {
          position:absolute;
          width: 200px;
          right: 25px;
          top: 20px;
        }

        #btnEdit {
          position:absolute;
          left: 35%;
        }

        #btnDelete {
          position:absolute;
          left: 70%;
        }

    </style>
    <title></title>
</head>
<body>

<div class="container-fluid">
    <div class="navbar-header">
      <p class="navbar-brand"><a href="/home">Marmitex</a></p>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/app/cardapio">Cardápio</a></li>
      <li class="active"><a href="/app/pedido">Pedir</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Fechamentos
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="#">Cobrança</a></li>
          <li><a href="#">Consultar Pedidos Anteriores</a></li>
          <li><a href="#">Etiquetas do Dia</a></li>
          <li><a href="#">Abrir Último pedido</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Outros
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/app/tabelas">Tabelas</a></li>
          <li><a href="/app/configuracoes">Configurações</a></li>
          <li><a href="#">Sobre</a></li>
        </ul>
      </li>
      <li>
        @if (Route::has('login'))
          @auth
          <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              {{ __('Sair') }}
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
          </form>
          @else
            <li><a href="{{ route('login') }}">Login</a></li>
          @endauth
        @endif
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>

<div class="content">
    @yield('content')
</div>

<script type="text/javascript">

  $(document).ready(function(){
        $('#pr1').mask('000.000.000.000.000,00' , { reverse : true});
  });

  $(document).ready(function(){
      $('#fhorario').mask('00:00');
  });

  $(document).ready(function(){
      $('#fcep').mask('00000-000');
  });

  $(document).ready(function(){
      $('#ftelefone').mask('(00) 0000-0000');
  });

  $(document).ready(function(){
      $('#fcelular').mask('(00) 00000-0000');
  });

  $(document).ready(function(){
      $('#fvalor').mask('000.000.000.000.000,00' , { reverse : true});
  });

  $(document).ready(function(){
      $('#ffrete').mask('000.000.000.000.000,00' , { reverse : true});
  });

  $(document).ready(function(){
      $('#fadicional').mask('000.000.000.000.000,00' , { reverse : true});
  });
</script>

</body>
</html>
