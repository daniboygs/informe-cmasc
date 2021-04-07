<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[delitos].[CarpetasRecibidas]';
$fields = '[DelitoID], [CarpetaRecibidaID]';

$id = $_POST['id'];
$data = $_POST['data'];

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
		createMultipleRecords(
			$id,
			$fields,
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

