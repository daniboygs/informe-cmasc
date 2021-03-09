<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Victima]';

$victim_gener = $_POST['victim_gener'];
$victim_age = $_POST['victim_age'];
$victim_scholarship = $_POST['victim_scholarship'];
$victim_ocupation = $_POST['victim_ocupation'];
$victim_applicant = $_POST['victim_applicant'];
$victim_required = $_POST['victim_required'];
$victim_type = $_POST['victim_type'];
$general_id = $_POST['general_id'];

$data = (object) array(
	'victim_gener' => (object) array(
		'type' => 'text',
		'value' => $victim_gener,
		'null' => false,
		'db_column' => '[Sexo]'
	),
	'victim_age' => (object) array(
		'type' => 'number',
		'value' => $victim_age,
		'null' => false,
		'db_column' => '[Edad]'
	),
	'victim_scholarship' => (object) array(
		'type' => 'number',
		'value' => $victim_scholarship,
		'null' => false,
		'db_column' => '[Escolaridad]'
	),
	'victim_ocupation' => (object) array(
		'type' => 'number',
		'value' => $victim_ocupation,
		'null' => false,
		'db_column' => '[Ocupacion]'
	),
	'victim_applicant' => (object) array(
		'type' => 'text',
		'value' => $victim_applicant,
		'null' => false,
		'db_column' => '[Solicitante]'
	),
	'victim_required' => (object) array(
		'type' => 'text',
		'value' => $victim_required,
		'null' => false,
		'db_column' => '[Requerido]'
	),
	'victim_type' => (object) array(
		'type' => 'number',
		'value' => $victim_type,
		'null' => false,
		'db_column' => '[Tipo]'
	),
	'general_id' => (object) array(
		'type' => 'number',
		'value' => $general_id,
		'null' => false,
		'db_column' => '[Tipo]'
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

