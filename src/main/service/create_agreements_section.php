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
$unity = $_POST['agreement_unity'];
$amount_in_kind = $_POST['agreement_amount_in_kind'];

$served_people_array = $_POST['served_people_array'];



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
		'type' => 'text',
		'value' => $unity,
		'null' => false,
		'db_column' => '[Unidad]'
	),
	'amount_in_kind' => (object) array(
		'type' => 'text',
		'value' => $amount_in_kind,
		'null' => false,
		'db_column' => '[MontoEspecie]'
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

