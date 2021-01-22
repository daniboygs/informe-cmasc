<?php
session_start();
include("../../../Conexiones/Conexion_SICAP.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

$amount = $_POST['agreement_amount'];
$compliance = $_POST['agreement_compliance'];
$crime = $_POST['agreement_crime'];
$date = $_POST['agreement_date'];
$intervention = $_POST['agreement_intervention'];
$mechanism = $_POST['agreement_mechanism'];
$nuc = $_POST['agreement_nuc'];
$total = $_POST['agreement_total'];
$unity = $_POST['agreement_unity'];


$data = (object) array(
	'imputed_process' => $imputed_process,
	'authority' => $authority,
	'flagrancy_released' => $flagrancy_released,
	'audience_date' => $audience_date,
	'legal_detention' => $legal_detention,
	'commandment_request_date' => $commandment_request_date,
	'commandment_type' => $commandment_type,
	'commandment_release_date' => $commandment_release_date,
	'commandment_status' => $commandment_status,
	'imputed_id' => $imputed_id,
	'folder_id' => $folder_id
);

json_encode(createSection($user_id, $data, $conn, $params, $options), JSON_FORCE_OBJECT);

function createImputed($user_id, $data, $conn, $params, $options){

	$sql = "INSERT INTO [dbo].[AcuerdoID]
				([NUC]
				,[Fecha]
				,[Delito]
				,[Intervension]
				,[Cumplimientos]
				,[TotalParcial]
				,[Mecanismo]
				,[Monto]
				,[Unidad]
				,[UsuarioID])
				VALUES
				(
					$data->imputed_process,
					$data->authority,
					$data->flagrancy_released,
					'$data->audience_date',
					$data->legal_detention,
					'$data->commandment_request_date',
					$data->commandment_type,
					'$data->commandment_release_date',
					$data->commandment_status,
					$data->user_id
				)
			SELECT SCOPE_IDENTITY()";
        
	$stmt = sqlsrv_query( $conn, $sql);

	sqlsrv_next_result($stmt); 
	sqlsrv_fetch($stmt); 

	$id = sqlsrv_get_field($stmt, 0);

	return true;

}
?>

