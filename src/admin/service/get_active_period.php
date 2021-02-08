<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PeriodoCaptura]';

$data = (object) array(
	'capture_period_id' => (object) array(
		'db_column' => '[PeriodoID]',
		'search' => true
	),
	'capture_period_initial_date' => (object) array(
		'db_column' => '[FechaInicio]',
		'search' => true
	),
	'capture_period_finish_date' => (object) array(
		'db_column' => '[FechaFin]',
		'search' => true
	)
);

if(!isset($_SESSION['user_data'])){
	echo json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}
else{
	echo json_encode(
		getRecord(
			(object) array(
				'data' => $data,
				'db_table' => $db_table,
				'conn' => $conn,
				'params' => $params,
				'options' => $options
			)
		), 
		JSON_FORCE_OBJECT
	);
}

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);

	$sql = "SELECT TOP(1) $columns FROM $attr->db_table";

    $result = sqlsrv_query($attr->conn, $sql , $attr->params, $attr->options);

	$row_count = sqlsrv_num_rows($result);
	
	$return = (object) array(
		'initial_date' => null,
		'finish_date' => null,
		'initial_us_date' => null,
		'finish_us_date' => null
	);

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$initial_date = $row['FechaInicio'];

			if($initial_date != null)
				$initial_date = $initial_date->format('d/m/Y');

			$finish_date = $row['FechaFin'];

			if($finish_date != null)
				$finish_date = $finish_date->format('d/m/Y');

			$initial_us_date = $row['FechaInicio'];

			if($initial_us_date != null)
				$initial_us_date = $initial_us_date->format('Y/m/d');

			$finish_us_date = $row['FechaFin'];

			if($finish_us_date != null)
				$finish_us_date = $finish_us_date->format('Y/m/d');

			$return->initial_date = $initial_date;
			$return->finish_date = $finish_date;
			$return->initial_us_date = $initial_us_date;
			$return->finish_us_date = $finish_us_date;
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

