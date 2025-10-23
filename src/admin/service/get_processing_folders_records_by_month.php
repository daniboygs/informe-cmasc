<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasTramite] a INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID INNER JOIN [cat].[Fiscalia] f ON  u.FiscaliaID = f.FiscaliaID';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'processing_folders_id' => (object) array(
		'db_column' => "[CarpetaTramiteID] AS 'id'",
		'search' => true
	),
	/*'processing_folders_facilitator' => (object) array(
		'db_column' => '[NombreFacilitador]',
		'search' => true
	),*/
	'processing_folders_initial_date' => (object) array(
		'db_column' => '[FechaInicio]',
		'search' => true
	),
	'processing_folders_finish_date' => (object) array(
		'db_column' => '[FechaFin]',
		'search' => true
	),
	'processing_folders_folders' => (object) array(
		'db_column' => '[CarpetasInvestigacion]',
		'search' => true
	),
	'processing_folders_inmediate_attention' => (object) array(
		'db_column' => '[AtencionInmediata]',
		'search' => true
	),
	'processing_folders_cjim' => (object) array(
		'db_column' => '[CJIM]',
		'search' => true
	),
	'processing_folders_domestic_violence' => (object) array(
		'db_column' => '[ViolenciaFamiliar]',
		'search' => true
	),
	'processing_folders_cyber_crimes' => (object) array(
		'db_column' => '[DelitosCiberneticos]',
		'search' => true
	),
	'processing_folders_teenagers' => (object) array(
		'db_column' => '[Adolescentes]',
		'search' => true
	),
	'processing_folders_swealth_and_finantial_inteligence' => (object) array(
		'db_column' => '[InteligenciaPatrimonial]',
		'search' => true
	),
	'processing_folders_high_impact_and_vehicles' => (object) array(
		'db_column' => '[AltoImpacto]',
		'search' => true
	),
	'processing_folders_human_rights' => (object) array(
		'db_column' => '[DerechosHumanos]',
		'search' => true
	),
	'processing_folders_fight_corruption' => (object) array(
		'db_column' => '[CombateCorrupcion]',
		'search' => true
	),
	'processing_folders_special_matters' => (object) array(
		'db_column' => '[AsuntosEspeciales]',
		'search' => true
	),
	'processing_folders_internal_affairs' => (object) array(
		'db_column' => '[AsuntosInternos]',
		'search' => true
	),
	'processing_folders_litigation' => (object) array(
		'db_column' => '[Litigacion]',
		'search' => true
	),
	'processing_folders_environment' => (object) array(
		'db_column' => '[MedioAmbiente]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	),
	'user_name' => (object) array(
		'db_column' => 'u.[Nombre]',
		'search' => true
	),
	'user_ps' => (object) array(
		'db_column' => '[ApellidoPaterno]',
		'search' => true
	),
	'user_ms' => (object) array(
		'db_column' => '[ApellidoMaterno]',
		'search' => true
	),
	'fiscalia' => (object) array(
		'db_column' => "f.[Nombre] AS 'Fiscalia'",
		'search' => true
	)
);

$sql_conditions = (object) array(
	/*'month' => (object) array(
		'db_column' => 'MONTH(Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(Fecha)',
		'condition' => '=', 
		'value' => $year
	)*/
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
				'options' => $options,
				'month' => $month,
				'year' => $year
			)
		), 
		JSON_FORCE_OBJECT
	);
}

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT $columns FROM $attr->db_table WHERE MONTH(FechaInicio) = $attr->month AND YEAR(FechaInicio) = $attr->year  ORDER BY FechaInicio";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			//$people_served_date = $row['Fecha'];

			/*if($people_served_date != null)
				$people_served_date = $people_served_date->format('d/m/Y');*/

			$processing_folders_initial_date = $row['FechaInicio'];

			$processing_folders_finish_date = $row['FechaFin'];

			if($processing_folders_initial_date != null)
				$processing_folders_initial_date = $processing_folders_initial_date->format('d/m/Y');

			if($processing_folders_finish_date != null)
				$processing_folders_finish_date = $processing_folders_finish_date->format('d/m/Y');

	
			array_push($return, array(
				'processing_folders_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				/*'processing_folders_facilitator' => array(
					'name' => 'NombreFacilitador',
					'value' => $row['NombreFacilitador']
				),*/
				'processing_folders_initial_date' => array(
					'name' => 'FechaInicio',
					'value' => $processing_folders_initial_date
				),
				'processing_folders_finish_date' => array(
					'name' => 'FechaFin',
					'value' => $processing_folders_finish_date
				),
				'processing_folders_folders' => array(
					'name' => 'CarpetasInvestigacion',
					'value' => $row['CarpetasInvestigacion']
				),
				'processing_folders_inmediate_attention' => array(
					'name' => 'AtencionInmediata',
					'value' => $row['AtencionInmediata']
				),
				'processing_folders_cjim' => array(
					'name' => 'CJIM',
					'value' => $row['CJIM']
				),
				'processing_folders_domestic_violence' => array(
					'name' => 'ViolenciaFamiliar',
					'value' => $row['ViolenciaFamiliar']
				),
				'processing_folders_cyber_crimes' => array(
					'name' => 'DelitosCiberneticos',
					'value' => $row['DelitosCiberneticos']
				),
				'processing_folders_teenagers' => array(
					'name' => 'Adolescentes',
					'value' => $row['Adolescentes']
				),
				'processing_folders_swealth_and_finantial_inteligence' => array(
					'name' => 'InteligenciaPatrimonial',
					'value' => $row['InteligenciaPatrimonial']
				),
				'processing_folders_high_impact_and_vehicles' => array(
					'name' => 'AltoImpacto',
					'value' => $row['AltoImpacto']
				),
				'processing_folders_human_rights' => array(
					'name' => 'DerechosHumanos',
					'value' => $row['DerechosHumanos']
				),
				'processing_folders_fight_corruption' => array(
					'name' => 'CombateCorrupcion',
					'value' => $row['CombateCorrupcion']
				),
				'processing_folders_special_matters' => array(
					'name' => 'AsuntosEspeciales',
					'value' => $row['AsuntosEspeciales']
				),
				'processing_folders_internal_affairs' => array(
					'name' => 'AsuntosInternos',
					'value' => $row['AsuntosInternos']
				),
				'processing_folders_litigation' => array(
					'name' => 'Litigacion',
					'value' => $row['Litigacion']
				),
				'processing_folders_environment' => array(
					'name' => 'Medio Ambiente',
					'value' => $row['MedioAmbiente']
				),
				'processing_folders_user' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				)
			));
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

