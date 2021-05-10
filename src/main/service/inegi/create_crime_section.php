<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Delito]';

$general_crime = $_POST['crime_crime'];
$crime_rate = $_POST['crime_rate'];
$crime_contest = $_POST['crime_contest'];
$crime_action = $_POST['crime_action'];
$crime_commission = $_POST['crime_commission'];
$crime_violence = $_POST['crime_violence'];
$crime_modality = $_POST['crime_modality'];
$crime_instrument = $_POST['crime_instrument'];
//$crime_alternative_justice = $_POST['crime_alternative_justice'];
$general_id = $_POST['general_id'];

$data = (object) array(
	'general_crime' => (object) array(
		'type' => 'text',
		'value' => $general_crime,
		'null' => false,
		'db_column' => '[DelitoID]'
	),
	'crime_rate' => (object) array(
		'type' => 'text',
		'value' => $crime_rate,
		'null' => false,
		'db_column' => '[Calificacion]'
	),
	'crime_contest' => (object) array(
		'type' => 'text',
		'value' => $crime_contest,
		'null' => false,
		'db_column' => '[Concurso]'
	),
	'crime_action' => (object) array(
		'type' => 'text',
		'value' => $crime_action,
		'null' => false,
		'db_column' => '[FormaAccion]'
	),
	'crime_commission' => (object) array(
		'type' => 'text',
		'value' => $crime_commission,
		'null' => false,
		'db_column' => '[Comision]'
	),
	'crime_violence' => (object) array(
		'type' => 'text',
		'value' => $crime_violence,
		'null' => false,
		'db_column' => '[Violencia]'
	),
	'crime_modality' => (object) array(
		'type' => 'number',
		'value' => $crime_modality,
		'null' => false,
		'db_column' => '[Modalidad]'
	),
	'crime_instrument' => (object) array(
		'type' => 'number',
		'value' => $crime_instrument,
		'null' => false,
		'db_column' => '[Instrumento]'
	),
	/*'crime_alternative_justice' => (object) array(
		'type' => 'number',
		'value' => $crime_alternative_justice,
		'null' => false,
		'db_column' => '[JusticiaAlternativa]'
	),*/
	'general_id' => (object) array(
		'type' => 'number',
		'value' => $general_id,
		'null' => false,
		'db_column' => '[GeneralID]'
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
		createSection(
			$data, 
			$db_table,
			$conn, 
			$params, 
			$options
		), 
		JSON_FORCE_OBJECT
	);
}
?>

