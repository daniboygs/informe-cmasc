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
//$general_crime = $_POST['general_crime'];
$general_unity = $_POST['general_unity'];
$general_attended = $_POST['general_attended'];

$recieved_id = '';
if(isset($_POST['recieved_id'])){
	if($_POST['recieved_id'] != '')
		$recieved_id = $_POST['recieved_id'];
	else
		$recieved_id = 'NULL';
}
else{
	$recieved_id = 'NULL';
}

$agreement_id = '';
if(isset($_POST['agreement_id'])){
	if($_POST['agreement_id'] != '')
		$agreement_id = $_POST['agreement_id'];
	else
		$agreement_id = 'NULL';
}
else{
	$agreement_id = 'NULL';
}

$data = (object) array(
	'general_nuc' => (object) array(
		'type' => 'text',
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
	/*'general_crime' => (object) array(
		'type' => 'text',
		'value' => $general_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),*/
	/*'general_unity' => (object) array(
		'type' => 'text',
		'value' => $general_unity,
		'null' => false,
		'db_column' => '[Unidad]'
	),*/
	'general_unity_id' => (object) array(
		'type' => 'number',
		'value' => $general_unity,
		'null' => false,
		'db_column' => '[UnidadID]'
	),
	'general_attended' => (object) array(
		'type' => 'number',
		'value' => $general_attended,
		'null' => false,
		'db_column' => '[Atendidos]'
	),
	'fiscalia' => (object) array(
		'type' => 'number',
		'value' => 'null',
		'null' => true,
		'db_column' => '[FiscaliaID]'
	),
	'user' => (object) array(
		'type' => 'number',
		'value' => 'null',
		'null' => true,
		'db_column' => '[UsuarioID]'
	),
	'recieved_id' => (object) array(
		'type' => 'number',
		'value' => $recieved_id,
		'null' => false,
		'db_column' => '[CarpetaRecibidaID]'
	),
	'agreement_id' => (object) array(
		'type' => 'number',
		'value' => $agreement_id,
		'null' => true,
		'db_column' => '[AcuerdoCelebradoID]'
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

	$data->fiscalia->value = $_SESSION['user_data']['fiscalia'];
	$data->fiscalia->null = false;
	
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

