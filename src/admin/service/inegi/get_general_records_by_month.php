<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];

$db_table = '[inegi].[General]';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "[GeneralID] AS 'id'",
		'search' => true
	),
	/*'general_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),*/
	'general_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'general_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'general_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'general_attended' => (object) array(
		'db_column' => '[Atendidos]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha";
	
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$general_date = $row['Fecha'];

			if($general_date != null)
				$general_date = $general_date->format('d/m/Y');
	
			array_push($return, array(
				'NUC' => $row['NUC'],
				'Fecha' => $general_date,
				'Unidad' => $row['Unidad'],
				'Atendidos' => $row['Atendidos']
			));
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>