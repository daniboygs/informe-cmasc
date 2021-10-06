<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Delito] d INNER JOIN [inegi].[General] g ON d.GeneralID = g.GeneralID INNER JOIN [cat].[Modalidad] m ON d.Modalidad = m.ModalidadID
INNER JOIN [cat].[Instrumento] i ON d.Instrumento = i.InstrumentoID';

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];

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
		'db_column' => "m.[Nombre] AS 'Modalidad'",
		'search' => true
	),
	'crime_instrument' => (object) array(
		'db_column' => "i.[Nombre] AS 'Instrumento'",
		'search' => true
	),
	'crime_alternative_justice' => (object) array(
		'db_column' => "CASE [JusticiaAlternativa] WHEN 1 THEN 'Si' WHEN 2 then 'No' END AS 'JusticiaAlternativa'",
		'search' => true
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'g.Fecha',
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
				'NUC' => $row['NUC'],
				'Fécha' => $date,
				'Calificacion' => $row['Calificacion'],
				'Concurso' => $row['Concurso'],
				'Forma Accion' => $row['FormaAccion'],
				'Comision' => $row['Comision'],
				'Violencia' => $row['Violencia'],
				'Modalidad' => $row['Modalidad'],
				'Instrumento' => $row['Instrumento'],
				'Justicia Alternativa' => $row['JusticiaAlternativa']
			));
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

