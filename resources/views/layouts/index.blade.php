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
    <script type="text/javascript" src="{{ asset('assets/js/FileSaver.js') }}"></script>
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
      
        #orderNotification img {
          width: 75px;
          height: 75px;
        }

        .navbar-brand img {
          width: 90px;
          height: 35px;
        }

        .footer {
          position: fixed;
          left: 0;
          bottom: 0;
          width: 100%;
          background-color: grey;
          text-align: center;
        }

        .footer p{
          color: white;
          text-align: center;
        }

        .container-fluid {
          width: 1024px;
        }

        /* Minimum resolution */
        @media (max-width: 1024px) {
          .container-fluid {
            width: 1024px;
          }
  
          .content {
            width: 500px;
            position: relative;
            left: 20%;
          }
        }



    </style>
    <title></title>
</head>
<body>
@if(!empty($orderOpened))
<script>
      console.log('Pedido aberto com sucesso!');
      $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/confirmed_1.png') }}"></img></div><h3>Pedido aberto com sucesso!</h3></center>');
  </script>
@endif

@if(!empty($orderClosed))
<script>
      console.log('Pedido fechado!');
      $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/exclamation.png') }}"></img></div><h3>Pedido fechado!</h3></center>');
  </script>
@endif

@if(!empty($orderNotOpened))
<script>
      console.log('Pedido do dia não encontrado!');
      $.alert('<center><div id="orderNotification"><img src="{{ asset('assets/images/exclamation.png') }}"></img></div><h3>'+employeeName+' já pediu!<br/></h3>Pedido do dia não encontrado!.</center>');
  </script>
@endif

<div class="container-fluid">
    <div class="navbar-header">
      <p class="navbar-brand"><a href="/home"><img src="{{ asset('assets/images/kota_sample.png')}}"></a></p>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="/app/cardapio">Inserir</a></li>
      <li class="active"><a href="/app/pedido">Pedir</a></li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Fechamentos
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/app/cobranca">Cobrança</a></li>
          <li><a href="/app/consulta_pedido">Consultar Pedidos Anteriores</a></li>
          <li><a href="/app/pedido/etiquetas">Etiquetas do Dia</a></li>
          <li><a href="/app/pedido/abrir">Abrir Pedido do Dia</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Outros
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="/app/tabelas">Tabelas</a></li>
          <li><a href="/app/configuracoes">Configurações</a></li>
          <li><a data-toggle="modal" href="#modalAbout">Sobre</a></li>
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

<!-- Modal -->
<div class="modal fade" id="modalAbout" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h2 class="modal-title">Ver. 20200821-1608</h2>
        <p>Desenvolvido para uso interno. Esta aplicação não pode ser vendida, copiada ou distribuída.</p>
        <p>E-mail: contato@ricardovidal.xyz</p>
      </div>

    </div>
  </div>
</div>


<div class="content">
    @yield('content')
</div>

<script type="text/javascript">

  $(document).ready(function(){
    $('#ftotal').mask('000.000.000.000.000,00' , { reverse : true});
  });

  $(document).ready(function(){
    $('#ftroco').mask('000.000.000.000.000,00' , { reverse : true});
  });

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

  function pad(n, width, z) {
    z = z || '0';
    n = n + '';
    return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
  }
</script>
<footer class="footer">
  <p>Kota Kota | contato@ricardovidal.xyz</p>
</footer>
</body>
</html>
