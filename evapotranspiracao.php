<?php
  include('conexao.php');

  $data = $_POST['data'];

  $sql = "SELECT *FROM dados WHERE Data = '$data' ORDER BY Temperatura LIMIT 1";
  $dados_min_temp = mysqli_query($conexao, $sql);

  $sql2 = "SELECT *FROM dados WHERE Data = '$data' ORDER BY Temperatura DESC LIMIT 1";
  $dados_max_temp = mysqli_query($conexao, $sql2);

  $sql3 = "SELECT ROUND(AVG(Umidade),2) FROM dados WHERE Data = '$data'";
  $dados_evapotranspiracao3 = mysqli_query($conexao, $sql3);

?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Evapotranspiração</title>

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
            <a class="nav-link active" href="evapotranspiracao.php">
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
        <h1 class="h2">Evapotranspiração</h1>
        <div class="btn-toolbar mb-2 mb-md-0">


      <!----------------------------------------------------------------------------------------------------------------------------->
          <form action="evapotranspiracao.php" method="post">   <!--Linha modificada-->
          <!-- Selecionar Data ---------------------------------------------------------------------------------------------->
            <div class="btn-group me-2"> 
              <input type="date" id="data" class="btn btn-sm btn-outline-secondary" min="2022-10-05" value="data" name="data" required>
            </div>

          <!-- Enviar ------------------------------------------------------------------------------------------------------->
            <div class="btn-group me-2">  
              <button type="submit" id="enviar" name='enviar' value="enviar" class="btn btn-sm btn-outline-secondary">Enviar</button>
            </div>
          </form>
      <!------------------------------------------------------------------------------------------------------------------------------>

   

        </div>
      </div>

   <!-- <h4>Dados recentes</h4>-->
      <br>
    <h4>Valores Para Reposição D'Água (mm)</h4>
  <p class="fs-5">Selecione uma data acima para consulta dos dados desejados referentes a quantidade de água necessária para reposição no solo em  <b>mm²</b>.</p>

<?php

if(isset($data)){


  while ($min_temp = mysqli_fetch_assoc($dados_min_temp)) {
    $Tmin = $min_temp['Temperatura'];
    $min_temp_data = $min_temp['Data'];
    $min_temp_hora = $min_temp['Hora'];
  }

  while ($max_temp = mysqli_fetch_assoc($dados_max_temp)) {
    $Tmax = $max_temp['Temperatura'];
    $max_temp_data = $max_temp['Data'];
    $max_temp_hora = $max_temp['Hora'];
  }

  while ($evap = mysqli_fetch_assoc($dados_evapotranspiracao3)) {
    $Umid_relativa = $evap['ROUND(AVG(Umidade),2)'];
  }



  // Cálculo da Evapotranspiração de Referência (ETo)
  // https://ainfo.cnptia.embrapa.br/digital/bitstream/CNPUV/8815/1/cir065.pdf

  // Definição das variáveis
  $Rn = 15.42;   // Saldo de radiação em MJ/m2.dia
  $G = 0;     // Fluxo total diário de calor do solo em MJ/m2.dia
  $Temp = ($Tmin+$Tmax)/2; // Temperatura em graus Celsius
  $ur = $Umid_relativa;   // Umidade Relativa em porcentagem
  $vv = 2.6;    // Velocidade do vento à 2m de altura em m/s
  $z = 370;     // Altitude do local em m

  
  // Cálculo da declividade da curva de pressão de vapor em relação à
  // temperatura (kPa/oC)
  
  $delta = (4098 * (0.6108 * exp((17.27 * $Temp) / ($Temp + 237.3)))) / pow(($Temp + 237.3), 2);
      
  // Cálculo do coeficiente psicométrico (kPa/oC)
  $gama = 0.665 * pow(10, -3) * 101.3 * pow(((293 - 0.0065 * $z) / 293), 5.26);
  
  // Cálculo do déficit de saturação
  // (Diferença entre Pressão de saturação de vapor - es e Pressão atual de
  // vapor - ea) (kPa)
  $es = 0.6108 * exp((17.27 * $Temp) / ($Temp + 237.3));
  $ea = ($es * $ur) / 100;

  // Cálculo da Evapotranspiração de Referência em mm
  $EToPMF = (0.408 * $delta * ($Rn - $G) + (($gama * 900 * $vv * ($es - $ea)) / ($Temp + 273))) / ($delta + $gama * (1 + 0.34 * $vv));


  $calculo_evapo_diario = round($EToPMF,2);
  

}

?>


<?php
  if(isset($data)){
    echo "<table class='table'>";
    echo "<thead align='center'>";
      echo "<tr>";
        echo "<th>Min °C</th>";
        echo "<th>Data</th>";
        echo "<th>Hora</th>";
        echo "<th>Máx °C</th>";
        echo "<th>Data</th>";
        echo "<th>Hora</th>";
      echo "</tr>";
    echo "</thead>";
      
      echo "<tbody align='center'>";      
                echo "<tr>";
                echo "<td>".$Tmin."</td>";
                echo "<td>".$min_temp_data."</td>";
                echo "<td>".$min_temp_hora."</td>";
            
                echo "<td>".$Tmax."</td>";
                echo "<td>".$max_temp_data."</td>";
                echo "<td>".$max_temp_hora."</td>";
                echo "<tr>";
            
            
      echo "</tbody>";
    echo "</table>";
  echo "<br>";
  }
  ?>



      <div class="table-responsive">
        <table class="table table-striped table-sm" align="center">
          <thead>
            <tr>
              <th scope="col">Evapotranspiração (mm)</th>
              <th scope="col">Méd Umidade do ar (%)</th>
              <th scope="col">Data</th>
            </tr>
          </thead>
          <tbody>
          <tbody>
            <?php
                echo "<tr>";
                echo "<td>".$calculo_evapo_diario."</td>";
                echo "<td>".$Umid_relativa."</td>";
                echo "<td>".$data."</td>";
                echo "<tr>";
            ?>
          </tbody>
          </tbody>
        </table>
      </div>

      </div>
    </main>
  </div>
</div>


    <script src="style/js/bootstrap.bundle.min.js"></script>
      <script src="style/js/feather.min.js"></script>
      <script src="style/js/icon.js"></script>
      
  </body>
</html>
