<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Victima] v INNER JOIN [inegi].[General] g ON v.GeneralID = g.GeneralID INNER JOIN [cat].[Escolaridad] e ON v.Escolaridad = e.EscolaridadID
INNER JOIN [cat].[Ocupacion] o ON v.Ocupacion = o.OcupacionID INNER JOIN [inegi].[Delito] d ON g.GeneralID = d.GeneralID 
INNER JOIN cat.Delito cd ON d.DelitoID = cd.DelitoID INNER JOIN cat.Unidad uni on uni.UnidadID = g.UnidadID LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = g.FiscaliaID';

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
	'victim_gener' => (object) array(
		'db_column' => '[Sexo]',
		'search' => true
	),
	'victim_age' => (object) array(
		'db_column' => '[Edad]',
		'search' => true
	),
	'victim_scholarship' => (object) array(
		'db_column' => "e.[Nombre] AS 'Escolaridad'",
		'search' => true
	),
	'victim_ocupation' => (object) array(
		'db_column' => "o.[Nombre] AS 'Ocupacion'",
		'search' => true
	),
	'victim_applicant' => (object) array(
		'db_column' => '[Solicitante]',
		'search' => true
	),
	'victim_type' => (object) array(
		'db_column' => '[Tipo]',
		'search' => true
	),
	'crime_name' => (object) array(
		'db_column' => "cd.Nombre AS 'Delito'",
		'search' => true
	),
	'unity' => (object) array(
		'db_column' => "uni.Nombre AS 'Unidad'",
		'search' => true
	),
	'victim_fiscalia' => (object) array(
		'db_column' => "f.Nombre AS 'Fiscalia'",
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
				'Fecha' => $date,
				'Unidad' => $row['Unidad'],
				'Delito' => $row['Delito'],
				'Sexo' => $row['Sexo'],
				'Edad' => $row['Edad'],
				'Escolaridad' => $row['Escolaridad'],
				'Ocupación' => $row['Ocupacion'],
				'Solicitante' => $row['Solicitante'],
				'Tipo' => $row['Tipo'],
				'Fiscalía' => $row['Fiscalia']
			));
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

