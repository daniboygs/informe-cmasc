<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasEnviadasValidacion] cv LEFT JOIN [cat].[Fiscalia] f ON cv.FiscaliaID = f.FiscaliaID LEFT JOIN [cat].[Unidad] uni ON cv.UnidadID = uni.UnidadID
LEFT JOIN [dbo].[AcuerdosCelebrados] a ON a.AcuerdoCelebradoID = cv.AcuerdoCelebradoID
LEFT JOIN [dbo].[CarpetasRecibidas] cr ON cr.CarpetaRecibidaID = a.CarpetaRecibidaID
LEFT JOIN [dbo].[CarpetasIngresadas] ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

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
	'folders_to_validation_id' => (object) array(
		'db_column' => "[CarpetaEnviadaValidacionID] AS 'id'",
		'search' => true
	),
	/*'folders_to_validation_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),*/
	'sigi_initial_date' => (object) array(
		'db_column' => 'cv.[FechaInicioSigi]',
		'search' => true
	),
	'folders_to_validation_date' => (object) array(
		'db_column' => 'cv.[Fecha]',
		'search' => true
	),
	'folders_to_validation_nuc' => (object) array(
		'db_column' => 'cv.[NUC]',
		'search' => true
	),
	'folders_to_validation_unity' => (object) array(
		'db_column' => 'uni.[Nombre] AS "Unidad"',
		'search' => true
	),
	'folders_to_validation_fiscalia' => (object) array(
		'db_column' => 'f.[Nombre] AS "Fiscalia"',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'cv.[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = array();

if($nuc != ''){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'cv.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != '' && $finish_date != ''){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'cv.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

/*$sql_conditions = (object) array(
	'nuc' => (object) array(
		'db_column' => 'cr.[NUC]',
		'condition' => '=', 
		'value' => $nuc
	),
	'range' => (object) array(
		'db_column' => 'Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)
);*/

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
	$sql_conditions += ['user' => (object) array(
		'db_column' => "(cv.[UsuarioID] = ".$_SESSION['user_data']['id']." OR ci.UsuarioDelegadoID = ".$_SESSION['user_data']['id'].")",
		'condition' => '', 
		'value' => ''
	)];

	/*$sql_conditions += ['user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => $_SESSION['user_data']['id']
	)];*/

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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$folders_to_validation_date = $row['Fecha'];

			if($folders_to_validation_date != null)
				$folders_to_validation_date = $folders_to_validation_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');
	
			array_push($return, array(
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'folders_to_validation_date' => array(
					'name' => 'Fecha',
					'value' => $folders_to_validation_date
				),
				'folders_to_validation_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => "[CarpetaEnviadaValidacionID] = '".$row['id']."' ORDER BY d.Nombre",
							'db_table' => '[delitos].[CarpetasEnviadasValidacion] cv inner join cat.Delito d on cv.DelitoID = d.DelitoID',
							'conn' => $attr->conn,
							'params' => $attr->params,
							'options' => $attr->options
						)
					)
				),
				'folders_to_validation_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'folders_to_validation_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'folders_to_validation_fiscalia' => array(
					'name' => 'Fiscalia',
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

