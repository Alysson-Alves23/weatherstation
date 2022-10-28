<?php

$MYSQL_ADDON_DB="b633vz1opiwq7syycoru";
$MYSQL_ADDON_HOST="b633vz1opiwq7syycoru-mysql.services.clever-cloud.com";
$MYSQL_ADDON_PASSWORD="ibBbuZFJrZAA7GyR5L44";
$MYSQL_ADDON_PORT="3306";
$MYSQL_ADDON_URI="mysql://us8beikwegk8lha0:ibBbuZFJrZAA7GyR5L44@b633vz1opiwq7syycoru-mysql.services.clever-cloud.com:3306/b633vz1opiwq7syycoru";
$MYSQL_ADDON_USER="us8beikwegk8lha0";
$MYSQL_ADDON_VERSION="8.0";
$conexao = mysqli_connect($MYSQL_ADDON_HOST,$MYSQL_ADDON_USER,$MYSQL_ADDON_PASSWORD,$MYSQL_ADDON_DB);

if($conexao->error){
	die("Error: " . mysqli.error);
	exit();
}

echo "Conexão com banco realizada com sucesso!"; 

$Temperatura = $_GET["Temperatura"];
$Pressão = $_GET["Pressão"]; 
$Umidade = $_GET["Umidade"]; 
$Altitude = $_GET["Altitude"]; 

$query = "INSERT INTO dados (Temperatura, Pressão, Umidade, Altitude) VALUES ('$Temperatura', '$Pressão', '$Umidade', '$Altitude')";
$result = mysqli_query($conexao,$query);

echo "Inserção feita com sucesso!";

?>