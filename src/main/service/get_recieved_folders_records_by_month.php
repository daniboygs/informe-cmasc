<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = "[EJERCICIOS].[dbo].[CarpetasRecibidas] cr LEFT JOIN 
(
SELECT MAX([Fecha]) AS 'inves_max_date'
	,[NUC]
FROM [EJERCICIOS].[dbo].[CarpetasEnviadasInvestigacion]
GROUP BY NUC
) ci 
ON cr.NUC = ci.NUC 
LEFT JOIN 
(
SELECT MAX([Fecha]) AS 'val_max_date'
	,[NUC]
FROM [EJERCICIOS].[dbo].[CarpetasEnviadasValidacion]
GROUP BY NUC
) cv on cr.NUC = cv.NUC";

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'recieved_folders_id' => (object) array(
		'db_column' => "cr.[CarpetaRecibidaID] AS 'id'",
		'search' => true
	),
	/*'recieved_folders_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),*/
	'sigi_initial_date' => (object) array(
		'db_column' => 'cr.[FechaInicioSigi]',
		'search' => true
	),
	'recieved_folders_date' => (object) array(
		'db_column' => 'cr.[Fecha]',
		'search' => true
	),
	'recieved_folders_nuc' => (object) array(
		'db_column' => 'cr.[NUC]',
		'search' => true
	),
	'recieved_folders_unity' => (object) array(
		'db_column' => 'cr.[Unidad]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'cr.[UsuarioID]',
		'search' => false
	),
	'recieved_folders_investigation_date' => (object) array(
		'db_column' => "ci.inves_max_date AS 'FechaInvestigacion'",
		'search' => true
	),
	'recieved_folders_validation_date' => (object) array(
		'db_column' => "cv.val_max_date AS 'FechaValidacion'",
		'search' => true
	),
	'recieved_folders_status' => (object) array(
		'db_column' => "CASE WHEN ci.inves_max_date IS NOT NULL AND ci.inves_max_date >= cr.Fecha AND (cv.val_max_date IS NULL OR (cv.val_max_date IS NOT NULL AND cv.val_max_date < ci.inves_max_date)) THEN 'Investigación' 
		WHEN cv.val_max_date IS NOT NULL AND cv.val_max_date >= cr.Fecha AND (ci.inves_max_date IS NULL OR (ci.inves_max_date IS NOT NULL AND ci.inves_max_date < cv.val_max_date)) THEN 'Validación'
		WHEN ci.inves_max_date IS NOT NULL AND ci.inves_max_date >= cr.Fecha AND (cv.val_max_date IS NULL OR (cv.val_max_date IS NOT NULL AND cv.val_max_date = ci.inves_max_date)) THEN 'Investigación'
		WHEN cv.val_max_date IS NOT NULL AND cv.val_max_date >= cr.Fecha AND (ci.inves_max_date IS NULL OR (ci.inves_max_date IS NOT NULL AND ci.inves_max_date = cv.val_max_date)) THEN 'Investigación'  
		ELSE 'Tramite' END AS 'Estatus'",
		'search' => true
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => ''
	),
	'month' => (object) array(
		'db_column' => 'MONTH(Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(Fecha)',
		'condition' => '=', 
		'value' => $year
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

	$sql_conditions->user->value = $_SESSION['user_data']['id'];
	
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

			$recieved_folders_date = $row['Fecha'];

			if($recieved_folders_date != null)
				$recieved_folders_date = $recieved_folders_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');
	
			array_push($return, array(
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'recieved_folders_date' => array(
					'name' => 'Fecha',
					'value' => $recieved_folders_date
				),
				'recieved_folders_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => "[CarpetaRecibidaID] = '".$row['id']."' ORDER BY d.Nombre",
							'db_table' => '[delitos].[CarpetasRecibidas] cr inner join cat.Delito d on cr.DelitoID = d.DelitoID',
							'conn' => $attr->conn,
							'params' => $attr->params,
							'options' => $attr->options
						)
					)
				),
				'recieved_folders_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'recieved_folders_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'recieved_folders_status' => array(
					'name' => 'Estatus',
					'value' => $row['Estatus']
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

