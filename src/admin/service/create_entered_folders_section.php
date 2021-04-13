<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasIngresadas]';

$entered_folders_date = $_POST['entered_folders_date'];
//$entered_folders_crime = $_POST['entered_folders_crime'];
$entered_folders_nuc = $_POST['entered_folders_nuc'];
$entered_folders_unity = $_POST['entered_folders_unity'];

if(isset($_POST['entered_folders_mp_channeler']))
	$entered_folders_mp_channeler = $_POST['entered_folders_mp_channeler'];
else
	$entered_folders_mp_channeler = 'null';


$entered_folders_recieved_folder = $_POST['entered_folders_recieved_folder'];

if(isset($_POST['entered_folders_channeler']))
	$entered_folders_channeler = $_POST['entered_folders_channeler'];
else
	$entered_folders_channeler = 'null';


$entered_folders_fiscalia = $_POST['entered_folders_fiscalia'];
$entered_folders_municipality = $_POST['entered_folders_municipality'];
$entered_folders_observations = $_POST['entered_folders_observations'];


if(isset($_POST['entered_folders_folders_date']))
	$entered_folders_folders_date = $_POST['entered_folders_folders_date'];
else
	$entered_folders_folders_date = 'null';

if(isset($_POST['entered_folders_facilitator']))
	$entered_folders_facilitator = $_POST['entered_folders_facilitator'];
else
	$entered_folders_facilitator = 'null';


//$entered_folders_book_date = $_POST['entered_folders_book_date'];




$data = (object) array(
	'entered_folders_date' => (object) array(
		'type' => 'date',
		'value' => $entered_folders_date,
		'null' => false,
		'db_column' => '[FechaIngreso]'
	),
	/*'entered_folders_crime' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),*/
	'entered_folders_nuc' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'entered_folders_unity' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_unity,
		'null' => false,
		'db_column' => '[Unidad]'
	),
	'entered_folders_mp_channeler' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_mp_channeler,
		'null' => true,
		'db_column' => '[MPCanalizador]'
	),
	'entered_folders_recieved_folder' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_recieved_folder,
		'null' => false,
		'db_column' => '[CarpetaRecibida]'
	),
	'entered_folders_channeler' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_channeler,
		'null' => false,
		'db_column' => '[Canalizador]'
	),
	'entered_folders_fiscalia' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_fiscalia,
		'null' => true,
		'db_column' => '[Fiscalia]'
	),
	'entered_folders_municipality' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_municipality,
		'null' => false,
		'db_column' => '[Municipio]'
	),
	'entered_folders_observations' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_observations,
		'null' => false,
		'db_column' => '[Observaciones]'
	),
	'entered_folders_folders_date' => (object) array(
		'type' => 'date',
		'value' => $entered_folders_folders_date,
		'null' => true,
		'db_column' => '[FechaCarpetas]'
	),
	'entered_folders_facilitator' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_facilitator,
		'null' => true,
		'db_column' => '[Facilitador]'
	),
	/*'entered_folders_book_date' => (object) array(
		'type' => 'date',
		'value' => $entered_folders_book_date,
		'null' => false,
		'db_column' => '[FechaLibro]'
	),*/
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

