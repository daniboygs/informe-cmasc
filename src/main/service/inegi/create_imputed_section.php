<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Imputado]';

$imputed_gener = $_POST['imputed_gener'];
$imputed_age = $_POST['imputed_age'];
$imputed_scholarship = $_POST['imputed_scholarship'];
$imputed_ocupation = $_POST['imputed_ocupation'];
$imputed_applicant = $_POST['imputed_applicant'];
$imputed_required = $_POST['imputed_required'];
$imputed_type = $_POST['imputed_type'];
$general_id = $_POST['general_id'];

$data = (object) array(
	'imputed_gener' => (object) array(
		'type' => 'text',
		'value' => $imputed_gener,
		'null' => false,
		'db_column' => '[Sexo]'
	),
	'imputed_age' => (object) array(
		'type' => 'number',
		'value' => $imputed_age,
		'null' => false,
		'db_column' => '[Edad]'
	),
	'imputed_scholarship' => (object) array(
		'type' => 'number',
		'value' => $imputed_scholarship,
		'null' => false,
		'db_column' => '[Escolaridad]'
	),
	'imputed_ocupation' => (object) array(
		'type' => 'number',
		'value' => $imputed_ocupation,
		'null' => false,
		'db_column' => '[Ocupacion]'
	),
	'imputed_applicant' => (object) array(
		'type' => 'text',
		'value' => $imputed_applicant,
		'null' => false,
		'db_column' => '[Solicitante]'
	),
	'imputed_required' => (object) array(
		'type' => 'text',
		'value' => $imputed_required,
		'null' => false,
		'db_column' => '[Requerido]'
	),
	'imputed_type' => (object) array(
		'type' => 'text',
		'value' => $imputed_type,
		'null' => false,
		'db_column' => '[Tipo]'
	),
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

