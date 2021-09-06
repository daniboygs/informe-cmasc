<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasRechazadas]';

$folio = $_POST['rejected_folio'];
$rejected_folder_id = $_POST['rejected_folder_id'];

$data = (object) array(
	'folio' => (object) array(
		'type' => 'text',
		'value' => $folio,
		'null' => false,
		'db_column' => '[Folio]'
	)
);

$conditions = (object) array(
	'folio' => (object) array(
		'type' => 'text',
		'value' => $rejected_folder_id,
		'null' => false,
		'db_column' => '[CarpetaRechazadaID]'
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
			$options,
			$conditions
		), 
		JSON_FORCE_OBJECT
	);
}

function updatePeriod($data, $db_table, $conn, $params, $options, $conditions){

	//$columns = formDBColumns($data);
	//$values = formInsertValuesByType($data);

	$folio = $data->folio->value;

	$folio_column = $data->folio->db_column;

	$rejected_folder_id = $conditions->folio->value;
	
	$rejected_folder_id_column = $conditions->folio->db_column;

	$sql = "UPDATE $db_table
				SET $folio_column = '$folio'
				WHERE $rejected_folder_id_column = $rejected_folder_id";


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

