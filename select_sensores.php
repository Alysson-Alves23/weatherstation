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


$query = "SELECT `Temperatura`,`Evapotranspiração`,`Data`,`Hora` FROM b633vz1opiwq7syycoru.dados WHERE data = '2022-10-05'";  
$records = array();

while( $rows = mysqli_fetch_assoc($result) ) {
	$records[] = $rows;
}

for($i=0;$i<sizeof($records);$i++){
    echo records[$i];
}

?>