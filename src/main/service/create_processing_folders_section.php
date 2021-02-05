<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasTramite]';

//$processing_folders_facilitator = $_POST['processing_folders_facilitator'];
$processing_folders_initial_date = $_POST['processing_folders_initial_date'];
$processing_folders_finish_date = $_POST['processing_folders_finish_date'];
$processing_folders_folders = $_POST['processing_folders_folders'];
$processing_folders_inmediate_attention = $_POST['processing_folders_inmediate_attention'];
$processing_folders_cjim = $_POST['processing_folders_cjim'];
$processing_folders_domestic_violence = $_POST['processing_folders_domestic_violence'];
$processing_folders_cyber_crimes = $_POST['processing_folders_cyber_crimes'];
$processing_folders_teenagers = $_POST['processing_folders_teenagers'];
$processing_folders_swealth_and_finantial_inteligence = $_POST['processing_folders_swealth_and_finantial_inteligence'];
$processing_folders_high_impact_and_vehicles = $_POST['processing_folders_high_impact_and_vehicles'];
$processing_folders_human_rights = $_POST['processing_folders_human_rights'];
$processing_folders_fight_corruption = $_POST['processing_folders_fight_corruption'];
$processing_folders_special_matters = $_POST['processing_folders_special_matters'];
$processing_folders_internal_affairs = $_POST['processing_folders_internal_affairs'];
$processing_folders_litigation = $_POST['processing_folders_litigation'];

$data = (object) array(
	/*'processing_folders_facilitator' => (object) array(
		'type' => 'text',
		'value' => $processing_folders_facilitator,
		'null' => false,
		'db_column' => '[NombreFacilitador]'
	),*/
	'processing_folders_initial_date' => (object) array(
		'type' => 'text',
		'value' => $processing_folders_initial_date,
		'null' => false,
		'db_column' => '[FechaInicio]'
	),
	'processing_folders_finish_date' => (object) array(
		'type' => 'text',
		'value' => $processing_folders_finish_date,
		'null' => false,
		'db_column' => '[FechaFin]'
	),
	'processing_folders_folders' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_folders,
		'null' => false,
		'db_column' => '[CarpetasInvestigacion]'
	),
	'processing_folders_inmediate_attention' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_inmediate_attention,
		'null' => false,
		'db_column' => '[AtencionInmediata]'
	),
	'processing_folders_cjim' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_cjim,
		'null' => false,
		'db_column' => '[CJIM]'
	),
	'processing_folders_domestic_violence' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_domestic_violence,
		'null' => false,
		'db_column' => '[ViolenciaFamiliar]'
	),
	'processing_folders_cyber_crimes' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_cyber_crimes,
		'null' => false,
		'db_column' => '[DelitosCiberneticos]'
	),
	'processing_folders_teenagers' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_teenagers,
		'null' => false,
		'db_column' => '[Adolescentes]'
	),
	'processing_folders_swealth_and_finantial_inteligence' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_swealth_and_finantial_inteligence,
		'null' => false,
		'db_column' => '[InteligenciaPatrimonial]'
	),
	'processing_folders_high_impact_and_vehicles' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_high_impact_and_vehicles,
		'null' => false,
		'db_column' => '[AltoImpacto]'
	),
	'processing_folders_human_rights' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_human_rights,
		'null' => false,
		'db_column' => '[DerechosHumanos]'
	),
	'processing_folders_fight_corruption' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_fight_corruption,
		'null' => false,
		'db_column' => '[CombateCorrupcion]'
	),
	'processing_folders_special_matters' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_special_matters,
		'null' => false,
		'db_column' => '[AsuntosEspeciales]'
	),
	'processing_folders_internal_affairs' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_internal_affairs,
		'null' => false,
		'db_column' => '[AsuntosInternos]'
	),
	'processing_folders_litigation' => (object) array(
		'type' => 'number',
		'value' => $processing_folders_litigation,
		'null' => false,
		'db_column' => '[Litigacion]'
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
?>

