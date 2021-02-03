<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados]';

$amount = $_POST['agreement_amount'];
$compliance = $_POST['agreement_compliance'];
$crime = $_POST['agreement_crime'];
$date = $_POST['agreement_date'];
$intervention = $_POST['agreement_intervention'];
$mechanism = $_POST['agreement_mechanism'];
$nuc = $_POST['agreement_nuc'];
$total = $_POST['agreement_total'];
$unity = $_POST['agreement_unity'];



$data = (object) array(
	'amount' => (object) array(
		'type' => 'number',
		'value' => $amount,
		'null' => false,
		'db_column' => '[MontoRecuperado]'
	),
	'compliance' => (object) array(
		'type' => 'text',
		'value' => $compliance,
		'null' => false,
		'db_column' => '[Cumplimiento]'
	),
	'crime' => (object) array(
		'type' => 'text',
		'value' => $crime,
		'null' => false,
		'db_column' => '[AcuerdoDelito]'
	),
	'date' => (object) array(
		'type' => 'date',
		'value' => $date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	'intervention' => (object) array(
		'type' => 'number',
		'value' => $intervention,
		'null' => false,
		'db_column' => '[Intervenciones]'
	),
	'mechanism' => (object) array(
		'type' => 'text',
		'value' => $mechanism,
		'null' => false,
		'db_column' => '[Mecanismo]'
	),
	'nuc' => (object) array(
		'type' => 'text',
		'value' => $nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'total' => (object) array(
		'type' => 'text',
		'value' => $total,
		'null' => false,
		'db_column' => '[TotalParcial]'
	),
	'unity' => (object) array(
		'type' => 'text',
		'value' => $unity,
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

