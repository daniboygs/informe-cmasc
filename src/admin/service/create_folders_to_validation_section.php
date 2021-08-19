<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasEnviadasValidacion]';

$sigi_date = $_POST['sigi_date'];

$folders_to_validation_date = $_POST['folders_to_validation_date'];
$folders_to_validation_crime = $_POST['folders_to_validation_crime'];
$folders_to_validation_nuc = $_POST['folders_to_validation_nuc'];
$folders_to_validation_unity = $_POST['folders_to_validation_unity'];



$data = (object) array(
	'sigi_date' => (object) array(
		'type' => 'date',
		'value' => $sigi_date,
		'null' => false,
		'db_column' => '[FechaInicioSigi]'
	),
	'folders_to_validation_date' => (object) array(
		'type' => 'date',
		'value' => $folders_to_validation_date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	'folders_to_validation_crime' => (object) array(
		'type' => 'text',
		'value' => $folders_to_validation_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),
	'folders_to_validation_nuc' => (object) array(
		'type' => 'text',
		'value' => $folders_to_validation_nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'folders_to_validation_unity' => (object) array(
		'type' => 'text',
		'value' => $folders_to_validation_unity,
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

