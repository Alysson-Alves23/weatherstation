<?php
  include('conexao.php');
   
  $sensor = $_GET['sensor'];
  $data = $_GET['data'];

?>

<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Painel</title>
    <script src="style/js/chart.min.js"></script>
    <script src="style/js/chart.esm.min.js"></script>
    <script src="style/js/chart.js"></script>

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

  
<!--
  <input class="form-control form-control-dark w-100 rounded-0 border-0" type="text" list="historico" placeholder="Search" aria-label="Search">
  <datalist id="historico">
    <option value="Ajuda"></option>
    <option value="Evapotranspiração"></option>
    <option value="mais.php">Exportar dados</option>
  </datalist>
  



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
            <a class="nav-link active" aria-current="page" href="painel.php">
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
            <a class="nav-link" href="mais.php">
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
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">



        <form action="painel.php" method="get">   <!--Linha modificada-->
          <!-- Selecionar Data ---------------------------------------------------------------------------------------------->
          <div class="btn-group me-2"> 
              <input type="date" id="data" class="btn btn-sm btn-outline-secondary" min="2022-10-05" value="data" name="data" required>
          </div>
          <!----------------------------------------------------------------------------------------------------------------->
          


        <!--<form action="painel.php" method="post">-->
          <!-- Selecionar Sensor -------------------------------------------------------------------------------------------->
          <div class="btn-group me-2">
            <select class="btn btn-sm btn-outline-secondary" name="sensor" id="" required>
              <option value="" disabled selected>Dados</option>
              <option value="Temperatura" name="Temperatura">Temperatura</option>
              <option value="Pressão" name="Pressão">Pressão</option>
              <option value="Umidade" name="Umidade">Umidade</option>
              <option value="Altitude" name="Altitude">Altitude</option>
            </select>
          </div>
          <!----------------------------------------------------------------------------------------------------------------->






          <!-- Enviar ------------------------------------------------------------------------------------------------------->
          <div class="btn-group me-2">  
              <button type="submit" id="enviar" name='enviar' value="enviar" class="btn btn-sm btn-outline-secondary">Enviar</button>
          </div>
          </form>
          <!----------------------------------------------------------------------------------------------------------------->



        </div>
      </div>


<?php  
  
  if(isset($data) && isset($sensor)){
    echo '<h6 align="right">Sensor: '; 
    echo $sensor;
    echo '<br>';
    echo 'Data: ';
    echo $data_brasileira = date("d/m/Y", strtotime($data));
    echo '</h6>';

    $consulta = "SELECT *FROM dados WHERE Data = '$data'";
    $resultado = mysqli_query($conexao, $consulta);
  }    
    ?>

     <canvas id="myChart" width="900" height="380">
      <script>
        var labels = [
            <?php 
              foreach($resultado as $v){
                echo "'".$v['hora']."',";
              }
            ?>
        ];

        var data = [
            <?php 
              foreach($resultado as $v){
                echo "'".$v[$sensor]."',";
              }
            ?>
        ];

        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    lineTension: 0,
                    backgroundColor: 'transparent',
                    borderColor: '#007bff',
                    borderWidth: 4,
                    pointBackgroundColor: '#007bff',
                }]
            },
            options: {
                plugins:{
                  legend:{
                    display: false
                  }
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
            
        });
</script>
  </canvas>

      
    </main>
  </div>
</div>
    <script src="style/js/bootstrap.bundle.min.js"></script>
      <script src="style/js/feather.min.js"></script>
      <script src="style/js/icon.js"></script>
  </body>
</html>
