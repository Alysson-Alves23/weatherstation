<?php
include('conexao.php');
include('exportarCSV.php');


  $sql = "SELECT *FROM dados WHERE Data = '$data' ORDER BY Temperatura LIMIT 1";
  $dados_min_temp = mysqli_query($conexao, $sql);

  $sql2 = "SELECT *FROM dados WHERE Data = '$data' ORDER BY Temperatura DESC LIMIT 1";
  $dados_max_temp = mysqli_query($conexao, $sql2);

  $sql3 = "SELECT ROUND(AVG(Umidade),2) FROM dados WHERE Data = '$data'";
  $dados_evapotranspiracao3 = mysqli_query($conexao, $sql3);


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