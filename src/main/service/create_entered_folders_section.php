<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasIngresadas]';

$sigi_date = $_POST['sigi_date'];

$entered_folders_date = $_POST['entered_folders_date'];
//$entered_folders_crime = $_POST['entered_folders_crime'];
$entered_folders_nuc = $_POST['entered_folders_nuc'];
$entered_folders_unity = $_POST['entered_folders_unity'];

if(isset($_POST['entered_folders_rejection_reason'])){
	if($_POST['entered_folders_rejection_reason'] != ''){
		$entered_folders_rejection_reason = $_POST['entered_folders_rejection_reason'];
	}
	else{
		$entered_folders_rejection_reason = 'null';
	}
}
else
	$entered_folders_rejection_reason = 'null';

if(isset($_POST['entered_folders_mp_channeler']))
	$entered_folders_mp_channeler = $_POST['entered_folders_mp_channeler'];
else
	$entered_folders_mp_channeler = 'null';

$entered_folders_priority = $_POST['entered_folders_priority'];
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

$cp_db_table = '[dbo].[CausaPenal]';

$entered_folders_ascription_place = $_POST['entered_folders_ascription_place'];
$entered_folders_type_file = $_POST['entered_folders_type_file'];


$data = (object) array(
	'sigi_date' => (object) array(
		'type' => 'date',
		'value' => $sigi_date,
		'null' => false,
		'db_column' => '[FechaInicioSigi]'
	),
	'entered_folders_rejection_reason' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_rejection_reason,
		'null' => false,
		'db_column' => '[MotivoRechazo]'
	),
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
	'entered_folders_priority' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_priority,
		'null' => false,
		'db_column' => '[Prioridad]'
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
		'null' => false,
		'db_column' => '[Facilitador]'
	),
	'entered_folders_ascription_place' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_ascription_place,
		'null' => false,
		'db_column' => '[LugarAdscripsionFiscaliaID]'
	),
	'entered_folders_type_file' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_type_file,
		'null' => true,
		'db_column' => '[TipoExpedienteID]'
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

$entered_folders_cause_number = $_POST['entered_folders_cause_number'];
$entered_folders_judge_name = $_POST['entered_folders_judge_name'];
$entered_folders_region = $_POST['entered_folders_region'];
$entered_folders_emission_date = $_POST['entered_folders_emission_date'];
$entered_folders_judicialized_before_cmasc = $_POST['entered_folders_judicialized_before_cmasc'];


$cp_data = (object) array(
	'entered_folders_cause_number' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_cause_number,
		'null' => false,
		'db_column' => '[NumeroCausaCuadernillo]'
	),
	'entered_folders_judge_name' => (object) array(
		'type' => 'text',
		'value' => $entered_folders_judge_name,
		'null' => false,
		'db_column' => '[NombreJuez]'
	),
	'entered_folders_region' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_region,
		'null' => false,
		'db_column' => '[RegionFiscaliaID]'
	),
	'entered_folders_emission_date' => (object) array(
		'type' => 'date',
		'value' => $entered_folders_emission_date,
		'null' => false,
		'db_column' => '[FechaEmision]'
	),
	'entered_folders_judicialized_before_cmasc' => (object) array(
		'type' => 'number',
		'value' => $entered_folders_judicialized_before_cmasc,
		'null' => true,
		'db_column' => '[JudicializadaAntesCMASC]'
	),
	'entered_folder_id' => (object) array(
		'type' => 'number',
		'value' => 'null',
		'null' => false,
		'db_column' => '[CarpetaIngresadaID]'
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

	if($data->entered_folders_facilitator->value == 'null')
		$data->entered_folders_facilitator->value = $_SESSION['user_data']['id'];

	$data->user->value = $_SESSION['user_data']['id'];
	$data->user->null = false;

	$create_entered_section_response = createSection(
		$data, 
		$db_table,
		$conn, 
		$params, 
		$options
	);

	if($create_entered_section_response['state'] == 'success' && $entered_folders_type_file != 3){

		if($cp_data->entered_folder_id->value == 'null')
			$cp_data->entered_folder_id->value = $create_entered_section_response['data']['id'];

		$criminal_cause_section_response = createSection(
			$cp_data, 
			$cp_db_table,
			$conn, 
			$params, 
			$options
		);

		if($criminal_cause_section_response['state'] == 'success'){
			echo json_encode(
				$create_entered_section_response, 
				JSON_FORCE_OBJECT
			);
		}
		else{
			echo json_encode(
				array(
					'state' => 'fail',
					'data' => null
				), 
				JSON_FORCE_OBJECT
			);
		}
	}
	else{
		echo json_encode(
			$create_entered_section_response, 
			JSON_FORCE_OBJECT
		);
	}
}
?>

