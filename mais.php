<?php  
  include('conexao.php');
  include("exportarCSV.php");

  $data_i = $_POST['data_i'];
  $data_f = $_POST['data_f'];

  $sql = "SELECT *FROM dados ORDER BY id DESC LIMIT 10";
  $dados_recentes = mysqli_query($conexao, $sql);
  //print_r($dados);
?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Mais detalhes</title>

<link href="style/css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="style/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Painel</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!--<input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="index.php">Sair</a>
    </div>
  </div>-->

</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="painel.php">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="evapotranspiracao.php">
              <span data-feather="droplet" class="align-text-bottom"></span>
              Evapotranspiração
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="mais.php">
              <span data-feather="file" class="align-text-bottom"></span>
              Mais detalhes
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <span data-feather="arrow-right" class="align-text-bottom"></span>
              Sair
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Mais detalhes</h1>
        <div class="btn-toolbar mb-2 mb-md-0">





        

        </div>
      </div>

    <h4>Exportar dados em CSV</h4>
       <p class="fs-5 col-md-5">Selecione um período abaixo para consulta dos dados desejados ou se preferir, pressione a opção <b>Exportar(csv)</b> para baixar a base de dados completa.</p>

      <form action="mais.php" method="post">   <!--Linha modificada-->
           <!-- Selecionar Data Início ------------------------------------------------------------------------------------------->
            <div class="btn-group me-2"> 
              <input type="date" id="data_i" class="btn btn-sm btn-outline-secondary" min="2022-10-01" value="data_i" name="data_i">
            </div>
          <!----------------------------------------------------------------------------------------------------------------->

           <!-- Selecionar Data Fim----------------------------------------------------------------------------------------------->
            <div class="btn-group me-2"> 
              <input type="date" id="data_f" class="btn btn-sm btn-outline-secondary" min="2022-10-01" value="data_f" name="data_f">
            </div>
          <!----------------------------------------------------------------------------------------------------------------->



          <!-- Botão Exportar CSV ------------------------------------------------------------------------------------------->
          <div class="btn-group me-2">
              <button type="submit" id="export_csv_data" name='export_csv_data' value="Export to CSV" class="btn btn-sm btn-outline-secondary">Exportar(CSV)</button>
          </div>
          <!----------------------------------------------------------------------------------------------------------------->
      </form>

  <br><br><br><br>
    <h4>Dados recentes</h4>
      <div class="table-responsive">
        <table class="table table-striped table-sm" align="center">
          <thead>
            <tr>
          <!--<th scope="col">id</th>-->
              <th scope="col">Temperatura (°C)</th>
              <th scope="col">Pressão (Pha)</th>
              <th scope="col">Umidade</th>
              <th scope="col">Altitude</th>
              <th scope="col">Data</th>
              <th scope="col">Hora</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
            <?php
              while ($user_data = mysqli_fetch_assoc($dados_recentes)) {
                echo "<tr>";
                //echo "<td>".$user_data['id']."</td>";
                echo "<td>".$user_data['Temperatura']."</td>";
                echo "<td>".$user_data['Pressão']."</td>";
                echo "<td>".$user_data['Umidade']."</td>";
                echo "<td>".$user_data['Altitude']."</td>";
                echo "<td>".$user_data['Data']."</td>";
                echo "<td>".$user_data['Hora']."</td>";
                echo "<tr>";
            }
            ?>
          </tbody>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


    <script src="style/js/bootstrap.bundle.min.js"></script>
      <script src="style/js/feather.min.js"></script>
      <script src="style/js/icon.js"></script>
  </body>
</html>
