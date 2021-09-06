<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasRechazadas]';

$folio = $_POST['rejected_folio'];
$entered_folder_id = $_POST['entered_folder_id'];

$data = (object) array(
	'folio' => (object) array(
		'type' => 'text',
		'value' => $folio,
		'null' => false,
		'db_column' => '[Folio]'
	),
	'entered_folder_id' => (object) array(
		'type' => 'number',
		'value' => $entered_folder_id,
		'null' => false,
		'db_column' => '[CarpetaIngresadaID]'
	),
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



