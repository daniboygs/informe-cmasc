<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[MASC]';

$masc_mechanism = $_POST['masc_mechanism'];
$masc_result = $_POST['masc_result'];
$masc_compliance = $_POST['masc_compliance'];
$masc_total = $_POST['masc_total'];
$masc_repair = $_POST['masc_repair'];
$masc_conclusion = $_POST['masc_conclusion'];
$masc_recovered_amount = $_POST['masc_recovered_amount'];
$masc_amount_property = $_POST['masc_amount_property'];
$masc_turned_to = $_POST['masc_turned_to'];
$general_id = $_POST['general_id'];

$data = (object) array(
	'masc_mechanism' => (object) array(
		'type' => 'text',
		'value' => $masc_mechanism,
		'null' => false,
		'db_column' => '[Mecanismo]'
	),
	'masc_result' => (object) array(
		'type' => 'text',
		'value' => $masc_result,
		'null' => false,
		'db_column' => '[Resultado]'
	),
	'masc_compliance' => (object) array(
		'type' => 'text',
		'value' => $masc_compliance,
		'null' => false,
		'db_column' => '[Cumplimiento]'
	),
	'masc_total' => (object) array(
		'type' => 'text',
		'value' => $masc_total,
		'null' => false,
		'db_column' => '[Total]'
	),
	'masc_repair' => (object) array(
		'type' => 'text',
		'value' => $masc_repair,
		'null' => false,
		'db_column' => '[TipoReparacion]'
	),
	'masc_conclusion' => (object) array(
		'type' => 'number',
		'value' => $masc_conclusion,
		'null' => false,
		'db_column' => '[TipoConclusion]'
	),
	'masc_recovered_amount' => (object) array(
		'type' => 'number',
		'value' => $masc_recovered_amount,
		'null' => false,
		'db_column' => '[MontoRecuperado]'
	),
	'masc_amount_property' => (object) array(
		'type' => 'number',
		'value' => $masc_amount_property,
		'null' => false,
		'db_column' => '[MontoInmueble]'
	),
	'masc_turned_to' => (object) array(
		'type' => 'number',
		'value' => $masc_turned_to,
		'null' => false,
		'db_column' => '[Turnado]'
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

