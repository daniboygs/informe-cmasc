<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[EJERCICIOS].[dbo].[CarpetasIngresadas] ci LEFT JOIN [EJERCICIOS].[dbo].[CarpetasRechazadas] cr
ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

$rejected_folders_id = $_POST['rejected_folders_id'];

$data = (object) array(
	'entered_folders_id' => (object) array(
		'db_column' => 'ci.[CarpetaIngresadaID]',
		'search' => true
	),
	'rejected_folders_id' => (object) array(
		'db_column' => 'cr.[CarpetaRechazadaID]',
		'search' => true
	),
	'entered_folders_nuc' => (object) array(
		'db_column' => 'ci.[NUC]',
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => 'ci.[FechaInicioSigi]',
		'search' => true
	),
	'folio' => (object) array(
		'db_column' => 'cr.[Folio]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'rejected_folder' => (object) array(
		'db_column' => 'cr.[CarpetaRechazadaID]',
		'condition' => '=', 
		'value' => $rejected_folders_id
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

	
	echo json_encode(
		getRecord(
			(object) array(
				'data' => $data,
				'sql_conditions' => $sql_conditions,
				'db_table' => $db_table,
				'conn' => $conn,
				'params' => $params,
				'options' => $options
			)
		), 
		JSON_FORCE_OBJECT
	);
}

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY ci.FechaInicioSigi";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');

	
			$return = array(
				'entered_folder_id' => array(
					'name' => 'CarpetaIngresadaID',
					'value' => $row['CarpetaIngresadaID']
				),
				'rejected_folder_id' => array(
					'name' => 'CarpetaRechazadaID',
					'value' => $row['CarpetaRechazadaID']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'folio' => array(
					'name' => 'Folio',
					'value' => $row['Folio']
				)
			);
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

