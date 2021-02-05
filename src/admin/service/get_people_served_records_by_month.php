<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PersonasAtendidas] a INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'people_served_id' => (object) array(
		'db_column' => '[PersonaID]',
		'search' => true
	),
	'people_served_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'people_served_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'people_served_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'people_served_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'people_served_number' => (object) array(
		'db_column' => '[PersonasAtendidas]',
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

			$people_served_date = $row['Fecha'];

			if($people_served_date != null)
				$people_served_date = $people_served_date->format('Y/m/d');
	
			array_push($return, array(
				'people_served_id' => array(
					'name' => 'ID',
					'value' => $row['PersonaID']
				),
				'people_served_date' => array(
					'name' => 'Fecha',
					'value' => $people_served_date
				),
				'people_served_crime' => array(
					'name' => 'Delito',
					'value' => $row['Delito']
				),
				'people_served_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'people_served_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'people_served_number' => array(
					'name' => 'PersonasAtendidas',
					'value' => $row['PersonasAtendidas']
				),
				'people_served_user' => array(
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

