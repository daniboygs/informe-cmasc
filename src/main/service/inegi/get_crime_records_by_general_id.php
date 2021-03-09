<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Delito] d INNER JOIN [inegi].[General] g ON d.GeneralID = g.GeneralID';

$general_id = $_POST['general_id'];

$data = (object) array(
	'nuc' => (object) array(
		'db_column' => 'g.[NUC]',
		'search' => true
	),
	'date' => (object) array(
		'db_column' => 'g.[Fecha]',
		'search' => true
	),
	'crime_rate' => (object) array(
		'db_column' => '[Calificacion]',
		'search' => true
	),
	'crime_contest' => (object) array(
		'db_column' => '[Concurso]',
		'search' => true
	),
	'crime_action' => (object) array(
		'db_column' => '[FormaAccion]',
		'search' => true
	),
	'crime_commission' => (object) array(
		'db_column' => '[Comision]',
		'search' => true
	),
	'crime_violence' => (object) array(
		'db_column' => '[Violencia]',
		'search' => true
	),
	'crime_modality' => (object) array(
		'db_column' => '[Modalidad]',
		'search' => true
	),
	'crime_instrument' => (object) array(
		'db_column' => '[Instrumento]',
		'search' => true
	),
	'crime_alternative_justice' => (object) array(
		'db_column' => '[JusticiaAlternativa]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => ''
	),
	'general_id' => (object) array(
		'db_column' => 'd.GeneralID',
		'condition' => '=', 
		'value' => $general_id
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY g.Fecha, g.NUC";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$date = $row['Fecha'];

			if($date != null)
				$date = $date->format('d/m/Y');
	
			array_push($return, array(
				'nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'date' => array(
					'name' => 'Fecha',
					'value' => $date
				),
				'crime_rate' => array(
					'name' => 'Calificación',
					'value' => $row['Calificacion']
				),
				'crime_contest' => array(
					'name' => 'Concurso',
					'value' => $row['Concurso']
				),
				'crime_action' => array(
					'name' => 'Forma de acción',
					'value' => $row['FormaAccion']
				),
				'crime_commission' => array(
					'name' => 'Comisión',
					'value' => $row['Comision']
				),
				'crime_violence' => array(
					'name' => 'Violencia',
					'value' => $row['Violencia']
				),
				'crime_modality' => array(
					'name' => 'Modalidad',
					'value' => $row['Modalidad']
				),
				'crime_instrument' => array(
					'name' => 'Instrumento',
					'value' => $row['Instrumento']
				),
				'crime_alternative_justice' => array(
					'name' => 'Justicia Alternativa',
					'value' => $row['JusticiaAlternativa']
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

