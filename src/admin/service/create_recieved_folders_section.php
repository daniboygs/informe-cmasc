<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasRecibidas]';

$recieved_folders_date = $_POST['recieved_folders_date'];
$recieved_folders_crime = $_POST['recieved_folders_crime'];
$recieved_folders_nuc = $_POST['recieved_folders_nuc'];
$recieved_folders_unity = $_POST['recieved_folders_unity'];



$data = (object) array(
	'recieved_folders_date' => (object) array(
		'type' => 'date',
		'value' => $recieved_folders_date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	'recieved_folders_crime' => (object) array(
		'type' => 'text',
		'value' => $recieved_folders_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),
	'recieved_folders_nuc' => (object) array(
		'type' => 'text',
		'value' => $recieved_folders_nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'recieved_folders_unity' => (object) array(
		'type' => 'text',
		'value' => $recieved_folders_unity,
		'null' => false,
		'db_column' => '[Unidad]'
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

