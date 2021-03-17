<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados]';

$nuc = $_POST['nuc'];

$data = (object) array(
	'nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'crime' => (object) array(
		'db_column' => '[AcuerdoDelito]',
		'search' => true
	),
	'unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'nuc' => (object) array(
		'db_column' => 'NUC',
		'condition' => '=',
		'value' => "'$nuc'"
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
				'sql_conditions' => $sql_conditions,
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
	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT $columns FROM $attr->db_table $conditions";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			array_push($return, array(
				'general_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'general_crime' => array(
					'name' => 'Delito',
					'value' => $row['AcuerdoDelito']
				),
				'general_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				)
			));
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

