<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.js"></script>
    <style>
        .content {
            width: 50%;
            position: relative;
            left: 25%;
        }

        .form-group label {
            margin-top: 5px;
            padding: 10px;
        }

        .btn-primary#insert {
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
    <title>Ricardo Vial</title>
</head>
<body>

<div class="container-fluid">
    <div class="navbar-header">
      <p class="navbar-brand"><a href="/home">Marmitex</a></p>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Cardápio</a></li>
      <li class="active"><a href="#">Pedir</a></li>
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
          <li><a href="#">Sobre</a></li>
        </ul>
      </li>
      <li>
      </li>
    </ul>
  </div>
</nav>

<div class="content">
    @yield('content')
</div>

</body>
</html>
