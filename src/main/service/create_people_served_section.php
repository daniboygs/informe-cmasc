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
//$people_served_crime = $_POST['people_served_crime'];
$people_served_nuc = $_POST['people_served_nuc'];
$people_served_number = $_POST['people_served_number'];
//$people_served_unity = $_POST['people_served_unity'];
$served_people_array = $_POST['served_people_array'];

//$entered_folders_data = $_POST['entered_folders_data'];
//$recieved_folders_data = $_POST['recieved_folders_data'];

if(isset($_POST['entered_folders_data'])){
	$existant_folders_data = $_POST['entered_folders_data'];
	$existant_folders_column = '[CarpetaIngresadaID]';
}
else if(isset($_POST['recieved_folders_data'])){
	$existant_folders_data = $_POST['recieved_folders_data'];
	$existant_folders_column = '[CarpetaRecibidaID]';
}


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
		'type' => 'number',
		'value' => $existant_folders_data['unity'],
		'null' => false,
		'db_column' => '[UnidadID]'
	),
	'existant_folder_id' => (object) array(
		'type' => 'number',
		'value' => $existant_folders_data['id'],
		'null' => false,
		'db_column' => $existant_folders_column
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
	)
);

if(isset($_POST['agreement_id'])){

	$temp_data = (array) $data;

	$temp_data += ['agreement_id' => (object) array(
		'type' => 'number',
		'value' => $_POST['agreement_id'],
		'null' => false,
		'db_column' => '[AcuerdoCelebradoID]'
	)];

	$data = (object) $temp_data;
}

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

				$served_people_id = $response['data']['id'];
				
				foreach(json_decode($served_people_array, true) as $element){

					/*$sql = "INSERT INTO [personas_atendidas].Persona 
					([Edad] ,[Sexo], [PersonasAtendidasID]) VALUES
					(".$element['age'].", '".$element['gener']."', ".$served_people_id.")";*/

					$sql = "INSERT INTO [personas_atendidas].Persona 
					([Nombre], [ApellidoPaterno], [ApellidoMaterno], [Edad], [Sexo], [Calidad], [PersonasAtendidasID]) VALUES
					('".$element['name']."', '".$element['ap']."', '".$element['am']."', ".$element['age'].", '".$element['gener']."', '".$element['type']."', ".$served_people_id.")";


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

