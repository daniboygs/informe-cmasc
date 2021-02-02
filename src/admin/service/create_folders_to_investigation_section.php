<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasEnviadasInvestigacion]';

$folders_to_investigation_date = $_POST['folders_to_investigation_date'];
$folders_to_investigation_crime = $_POST['folders_to_investigation_crime'];
$folders_to_investigation_nuc = $_POST['folders_to_investigation_nuc'];
$folders_to_investigation_channeling_reason = $_POST['folders_to_investigation_channeling_reason'];
$folders_to_investigation_unity = $_POST['folders_to_investigation_unity'];



$data = (object) array(
	'folders_to_investigation_date' => (object) array(
		'type' => 'date',
		'value' => $folders_to_investigation_date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	'folders_to_investigation_crime' => (object) array(
		'type' => 'text',
		'value' => $folders_to_investigation_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),
	'folders_to_investigation_nuc' => (object) array(
		'type' => 'text',
		'value' => $folders_to_investigation_nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'folders_to_investigation_channeling_reason' => (object) array(
		'type' => 'text',
		'value' => $folders_to_investigation_channeling_reason,
		'null' => false,
		'db_column' => '[MotivoCancelacion]'
	),
	'folders_to_investigation_unity' => (object) array(
		'type' => 'text',
		'value' => $folders_to_investigation_unity,
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

