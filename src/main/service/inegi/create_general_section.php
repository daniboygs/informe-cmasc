<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[General]';

$general_nuc = $_POST['general_nuc'];
$general_date = $_POST['general_date'];
$general_crime = $_POST['general_crime'];
$general_unity = $_POST['general_unity'];
$general_attended = $_POST['general_attended'];

$data = (object) array(
	'general_nuc' => (object) array(
		'type' => 'number',
		'value' => $general_nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'general_date' => (object) array(
		'type' => 'date',
		'value' => $general_date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	'general_crime' => (object) array(
		'type' => 'text',
		'value' => $general_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),
	'general_unity' => (object) array(
		'type' => 'text',
		'value' => $general_unity,
		'null' => false,
		'db_column' => '[Unidad]'
	),
	'general_attended' => (object) array(
		'type' => 'number',
		'value' => $general_attended,
		'null' => false,
		'db_column' => '[Atendidos]'
	),
	'user' => (object) array(
		'type' => 'number',
		'value' => 'null',
		'null' => true,
		'db_column' => '[UsuarioID]'
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

	$data->user->value = $_SESSION['user_data']['id'];
	$data->user->null = false;
	
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

