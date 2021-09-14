<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasRechazadas]';


$data = $_POST['data'];

$values = '';
$i = 1;


foreach(json_decode($data, true) as $element){

	//echo $element['folio'];

	$values.="('".$element['folio']."', ".$element['entered_folder_id'].")";

	if($i < count((array) json_decode($data, true))){
		$values.=",";
	}

	$i++;

}


$sql = "INSERT INTO $db_table
				( Folio, CarpetaIngresadaID )
				VALUES
				$values";


if($conn){
	$stmt = sqlsrv_query( $conn, $sql);

	sqlsrv_next_result($stmt); 
	sqlsrv_fetch($stmt); 

	echo json_encode(
		array(
			'state' => 'success',
			'data' => array(
				'id' => null
			)
		),
		JSON_FORCE_OBJECT
	);
}
else{
	echo json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}
	
/*
$folio = $_POST['rejected_folio'];
$entered_folder_id = $_POST['entered_folder_id'];

$data = (object) array(
	'folio' => (object) array(
		'type' => 'text',
		'value' => $folio,
		'null' => false,
		'db_column' => '[Folio]'
	),
	'entered_folder_id' => (object) array(
		'type' => 'number',
		'value' => $entered_folder_id,
		'null' => false,
		'db_column' => '[CarpetaIngresadaID]'
	),
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
		createSection(
			$data, 
			$db_table,
			$conn, 
			$params, 
			$options
		), 
		JSON_FORCE_OBJECT
	);
}*/

function createMultipleRecords2($id, $fields, $data, $db_table, $conn, $params, $options){

	$values = formInsertMultipleValues($data, $id);

	$sql = "INSERT INTO $db_table
				( $fields )
				VALUES
				$values";

	if($conn){
		$stmt = sqlsrv_query( $conn, $sql);

		sqlsrv_next_result($stmt); 
		sqlsrv_fetch($stmt); 

		return array(
            'state' => 'success',
            'data' => array(
                'id' => null
            )
        );
	}
	else{
		return array(
            'state' => 'fail',
            'data' => null
        );
	}

}


function formInsertMultipleValues2($data, $id){
	$values = "";
	$i = 1;

	foreach ($data as $element) {
		
		$values.="($element, $id)";

		if($i < count((array) $data)){
			$values.=",";
		}

		$i++;
	}
	return $values;
}

?>



