<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PersonasAtendidas]';

$sigi_date = $_POST['sigi_date'];

$people_served_date = $_POST['people_served_date'];
//$people_served_crime = $_POST['people_served_crime'];
$people_served_nuc = $_POST['people_served_nuc'];
$people_served_number = $_POST['people_served_number'];
$people_served_unity = $_POST['people_served_unity'];
$served_people_array = $_POST['served_people_array'];



$data = (object) array(
	'sigi_date' => (object) array(
		'type' => 'date',
		'value' => $sigi_date,
		'null' => false,
		'db_column' => '[FechaInicioSigi]'
	),
	'people_served_date' => (object) array(
		'type' => 'date',
		'value' => $people_served_date,
		'null' => false,
		'db_column' => '[Fecha]'
	),
	/*'people_served_crime' => (object) array(
		'type' => 'text',
		'value' => $people_served_crime,
		'null' => false,
		'db_column' => '[Delito]'
	),*/
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

	$response = createSection(
		$data, 
		$db_table,
		$conn, 
		$params, 
		$options
	);


	if($response['state'] == 'success'){

		if(isset($response['data']['id'])){

			if($response['data']['id'] != '' && $response['data']['id'] != null){

				$server_people_id = $response['data']['id'];
				
				foreach(json_decode($served_people_array, true) as $element){

					$sql = "INSERT INTO [personas_atendidas].Persona 
					([Edad] ,[Sexo], [PersonasAtendidasID]) VALUES
					(".$element['age'].", '".$element['gener']."', ".$server_people_id.")";

					if($conn){
						$stmt = sqlsrv_query( $conn, $sql);

						sqlsrv_next_result($stmt); 
						sqlsrv_fetch($stmt);
					}
					else{
						$response = array(
							'state' => 'fail',
							'data' => null
						);
					}
				}
			}
		}
	}
	
	echo json_encode(
		$response, 
		JSON_FORCE_OBJECT
	);
	
	
}
?>

