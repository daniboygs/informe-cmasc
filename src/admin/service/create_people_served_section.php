<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PersonasAtendidas]';

$acceius_date = $_POST['acceius_date'];

$people_served_date = $_POST['people_served_date'];
$people_served_crime = $_POST['people_served_crime'];
$people_served_nuc = $_POST['people_served_nuc'];
$people_served_number = $_POST['people_served_number'];
$people_served_unity = $_POST['people_served_unity'];





$data = (object) array(
	'acceius_date' => (object) array(
		'type' => 'date',
		'value' => $acceius_date,
		'null' => false,
		'db_column' => '[FechaInicioSigi]'
	),
	'people_served_date' => (object) array(
		'type' => 'date',
		'value' => $people_served_date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	'people_served_crime' => (object) array(
		'type' => 'text',
		'value' => $people_served_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),
	'people_served_nuc' => (object) array(
		'type' => 'text',
		'value' => $people_served_nuc,
		'null' => false,
		'db_column' => '[NUC]'
	),
	'people_served_number' => (object) array(
		'type' => 'text',
		'value' => $people_served_number,
		'null' => false,
		'db_column' => '[PersonasAtendidas]'
	),
	'people_served_unity' => (object) array(
		'type' => 'text',
		'value' => $people_served_unity,
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


function insertMultipleValues(){

	if(isset( $_POST['data'])){

		$data = $_POST['data'];

		foreach(json_decode($data, true) as $element){
		}

		return true;
	}
	else{
		return false;
	}
}


?>

