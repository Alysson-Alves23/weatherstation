<?php

require_once("conexao.php");
//require_once("mais.php");

//var_dump($conexao);
$d_i = $_POST['data_i'];
$d_f = $_POST['data_f'];
//var_dump($d_i);
//var_dump($d_f);


if($d_i == NULL || $d_f == NULL){
	$query = "SELECT *FROM dados ORDER BY id DESC";	
}else{
	$query = "SELECT *FROM dados WHERE data >= '$d_i' AND data <= '$d_f'";		
}

$result = mysqli_query($conexao, $query) or die("database error:". mysqli_error($conexao));

$records = array();
while( $rows = mysqli_fetch_assoc($result) ) {
	$records[] = $rows;
}



preg_match_all('!\d+!',"2022-10-05",$ini);
preg_match_all('!\d+!',$d_f,$final);

for($i=0;$i<count($records);$i++){
	if(!strcmp($records[$i]['Data'],'2022-10-05')){
		
	}
}
print_r($ini);


if(isset($_POST["export_csv_data"])) {	
	$csv_file = "Estação_Dados_".date('Ymd') . ".csv";			
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=\"$csv_file\"");	
	$fh = fopen( 'php://output', 'w' );
	$is_coloumn = true;
	if(!empty($records)) {
	  foreach($records as $record) {
		if($is_coloumn) {		  	  
		  fputcsv($fh, array_keys($record));
		  $is_coloumn = false;
		}		
		fputcsv($fh, array_values($record));
	  }
	   fclose($fh);
	}
	exit;  
}

?>
