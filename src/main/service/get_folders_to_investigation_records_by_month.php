<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasEnviadasInvestigacion]';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'folders_to_investigation_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'folders_to_investigation_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'folders_to_investigation_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'folders_to_investigation_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'folders_to_investigation_channeling_reason' => (object) array(
		'db_column' => '[MotivoCancelacion]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => ''
	),
	'month' => (object) array(
		'db_column' => 'MONTH(Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(Fecha)',
		'condition' => '=', 
		'value' => $year
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

	$sql_conditions->user->value = $_SESSION['user_data']['id'];
	
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

			$folders_to_investigation_date = $row['Fecha'];

			if($folders_to_investigation_date != null)
				$folders_to_investigation_date = $folders_to_investigation_date->format('d/m/Y');
	
			array_push($return, array(
				'folders_to_investigation_date' => array(
					'name' => 'Fecha',
					'value' => $folders_to_investigation_date
				),
				'folders_to_investigation_crime' => array(
					'name' => 'Delito',
					'value' => $row['Delito']
				),
				'folders_to_investigation_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'folders_to_investigation_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'folders_to_investigation_channeling_reason' => array(
					'name' => 'MotivoCancelacion',
					'value' => $row['MotivoCancelacion']
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

