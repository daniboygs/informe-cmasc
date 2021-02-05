<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasRecibidas] a INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'recieved_folders_id' => (object) array(
		'db_column' => '[CarpetaRecibidaID]',
		'search' => true
	),
	'recieved_folders_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'recieved_folders_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'recieved_folders_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'recieved_folders_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	),
	'user_name' => (object) array(
		'db_column' => '[Nombre]',
		'search' => true
	),
	'user_ps' => (object) array(
		'db_column' => '[ApellidoPaterno]',
		'search' => true
	),
	'user_ms' => (object) array(
		'db_column' => '[ApellidoMaterno]',
		'search' => true
	)
);

$sql_conditions = (object) array(
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha, Nombre";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$recieved_folders_date = $row['Fecha'];

			if($recieved_folders_date != null)
				$recieved_folders_date = $recieved_folders_date->format('Y/m/d');
	
			array_push($return, array(
				'recieved_folders_id' => array(
					'name' => 'ID',
					'value' => $row['CarpetaRecibidaID']
				),
				'recieved_folders_date' => array(
					'name' => 'Fecha',
					'value' => $recieved_folders_date
				),
				'recieved_folders_crime' => array(
					'name' => 'Delito',
					'value' => $row['Delito']
				),
				'recieved_folders_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'recieved_folders_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'recieved_folders_user' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
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

