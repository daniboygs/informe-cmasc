<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasEnviadasInvestigacion] a INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID
LEFT JOIN [cat].[MotivoCanalizacionInvestigacion] m ON a.MotivoCanalizacionInvestID = m.MotivoCanalizacionID LEFT JOIN [cat].[Fiscalia] f ON a.FiscaliaID = f.FiscaliaID LEFT JOIN [cat].[Unidad] uni ON a.UnidadID = uni.UnidadID';

if(isset( $_POST['nuc']))
	$nuc = $_POST['nuc'];
else
	$nuc = '';

if(isset( $_POST['initial_date']))
	$initial_date = $_POST['initial_date'];
else
	$initial_date = '';

if(isset( $_POST['finish_date']))
	$finish_date = $_POST['finish_date'];
else
	$finish_date = '';

$data = (object) array(
	'folders_to_investigation_id' => (object) array(
		'db_column' => "[CarpetaEnviadaInvestigacionID] AS 'id'",
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => '[FechaInicioSigi]',
		'search' => true
	),
	'folders_to_investigation_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'folders_to_investigation_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'folders_to_investigation_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'folders_to_investigation_unity' => (object) array(
		'db_column' => 'uni.[Nombre] AS "Unidad"',
		'search' => true
	),
	/*'folders_to_investigation_channeling_reason' => (object) array(
		'db_column' => '[MotivoCancelacion]',
		'search' => true
	),*/
	'folders_to_investigation_channeling_reason' => (object) array(
		'db_column' => "CASE WHEN m.Nombre IS NULL THEN [MotivoCancelacion] ELSE m.Nombre END AS 'MotivoCanalizacion'",
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'a.[UsuarioID]',
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

$sql_conditions = array();

if($nuc != ''){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => '[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != '' && $finish_date != ''){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(!isset($_SESSION['user_data']) || count($sql_conditions) <= 0){
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha, Nombre";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$folders_to_investigation_date = $row['Fecha'];

			if($folders_to_investigation_date != null)
				$folders_to_investigation_date = $folders_to_investigation_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');
	
			array_push($return, array(
				'folders_to_investigation_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'folders_to_investigation_date' => array(
					'name' => 'Fecha',
					'value' => $folders_to_investigation_date
				),
				'folders_to_investigation_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => "[CarpetaEnviadaInvestigacionID] = '".$row['id']."' ORDER BY d.Nombre",
							'db_table' => '[delitos].[CarpetasEnviadasInvestigacion] ci inner join cat.Delito d on ci.DelitoID = d.DelitoID',
							'conn' => $attr->conn,
							'params' => $attr->params,
							'options' => $attr->options
						)
					)
				),
				'folders_to_investigation_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'folders_to_investigation_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				/*'folders_to_investigation_channeling_reason' => array(
					'name' => 'MotivoCancelacion',
					'value' => $row['MotivoCancelacion']
				),*/
				'folders_to_investigation_channeling_reason' => array(
					'name' => 'MotivoCanalizacion',
					'value' => $row['MotivoCanalizacion']
				),
				'folders_to_investigation_user' => array(
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

