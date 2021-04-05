<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[delitos].[AcuerdosCelebrados]';
$id_field = '[AcuerdoCelebradoID]';

$id = $_POST['id'];
$data = json_decode($_POST['data'], true);

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
			$id_field,
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

