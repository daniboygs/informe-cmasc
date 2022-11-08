<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = "[dbo].[CarpetasRecibidas] cr INNER JOIN Usuario u ON cr.UsuarioID = u.UsuarioID INNER JOIN [cat].[Fiscalia] f ON  u.FiscaliaID = f.FiscaliaID 
LEFT JOIN 
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

/*$nuc = $_POST['nuc'];
$month = $_POST['month'];
$year = $_POST['year'];*/

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
	'recieved_folders_id' => (object) array(
		'db_column' => "[CarpetaRecibidaID] AS 'id'",
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => '[FechaInicioSigi]',
		'search' => true
	),
	'recieved_folders_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'recieved_folders_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'recieved_folders_nuc' => (object) array(
		'db_column' => 'cr.[NUC]',
		'search' => true
	),
	'recieved_folders_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'cr.[UsuarioID]',
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

$sql_conditions = array();

if($nuc != ''){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'cr.[NUC]',
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
		'db_column' => 'cr.[UsuarioID]',
		'condition' => '=', 
		'value' => $_SESSION['user_data']['id']
	)];

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

			$recieved_folders_date = $row['Fecha'];

			if($recieved_folders_date != null)
				$recieved_folders_date = $recieved_folders_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');
	
			array_push($return, array(
				'recieved_folders_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
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
				'recieved_folders_user' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				),			
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
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

