<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados]';

$sigi_date = $_POST['sigi_date'];

$amount = $_POST['agreement_amount'];
$compliance = $_POST['agreement_compliance'];
//$crime = $_POST['agreement_crime'];
$date = $_POST['agreement_date'];
$intervention = $_POST['agreement_intervention'];
$mechanism = $_POST['agreement_mechanism'];
$nuc = $_POST['agreement_nuc'];
$total = $_POST['agreement_total'];
//$unity = $_POST['agreement_unity'];
$amount_in_kind = $_POST['agreement_amount_in_kind'];

$served_people_array = $_POST['served_people_array'];

$recieved_folders_data = $_POST['recieved_folders_data'];

$data = (object) array(
	'sigi_date' => (object) array(
		'type' => 'date',
		'value' => $sigi_date,
		'null' => false,
		'db_column' => '[FechaInicioSigi]'
	),
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
	/*'crime' => (object) array(
		'type' => 'text',
		'value' => $crime,
		'null' => false,
		'db_column' => '[AcuerdoDelito]'
	),*/
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
		'db_column' => '[Intervinientes]'
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
		'type' => 'number',
		'value' => $recieved_folders_data['unity'],
		'null' => false,
		'db_column' => '[UnidadID]'
	),
	'amount_in_kind' => (object) array(
		'type' => 'text',
		'value' => $amount_in_kind,
		'null' => false,
		'db_column' => '[MontoEspecie]'
	),
	'recieved_folder_id' => (object) array(
		'type' => 'number',
		'value' => $recieved_folders_data['id'],
		'null' => false,
		'db_column' => '[CarpetaRecibidaID]'
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

				/*$served_people_id = $response['data']['id'];
				
				foreach(json_decode($served_people_array, true) as $element){

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
				}*/
			}
		}
	}
	
	echo json_encode(
		$response, 
		JSON_FORCE_OBJECT
	);
}
?>

