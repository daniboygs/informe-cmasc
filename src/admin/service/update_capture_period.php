<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PeriodoCaptura]';

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];
$daily = $_POST['daily'];



$data = (object) array(
	'initial_date' => (object) array(
		'type' => 'date',
		'value' => $initial_date,
		'null' => false,
		'db_column' => '[FechaInicio]'
	),
	'finish_date' => (object) array(
		'type' => 'date',
		'value' => $finish_date,
		'null' => false,
		'db_column' => '[FechaFin]'
	),
	'daily' => (object) array(
		'type' => 'date',
		'value' => $daily,
		'null' => false,
		'db_column' => '[CapturaDiaria]'
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
		updatePeriod(
			$data, 
			$db_table,
			$conn, 
			$params, 
			$options
		), 
		JSON_FORCE_OBJECT
	);
}

function updatePeriod($data, $db_table, $conn, $params, $options){

	//$columns = formDBColumns($data);
	//$values = formInsertValuesByType($data);

	$initial_date = $data->initial_date->value;
	$finish_date = $data->finish_date->value;
	$daily = $data->daily->value;

	$initial_date_column = $data->initial_date->db_column;
	$finish_date_column = $data->finish_date->db_column;
	$daily_column = $data->daily->db_column;

	$sql = "UPDATE $db_table
				SET $initial_date_column = '$initial_date',
					$finish_date_column = '$finish_date',
					$daily_column = '$daily'";


	if($conn){
		$stmt = sqlsrv_query( $conn, $sql);

		sqlsrv_next_result($stmt); 
		sqlsrv_fetch($stmt); 

		return array(
            'state' => 'success',
            'data' => null
        );
	}
	else{
		return array(
            'state' => 'fail',
            'data' => null
        );
	}

}

?>

