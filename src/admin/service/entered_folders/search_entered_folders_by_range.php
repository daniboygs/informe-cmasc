<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasIngresadas] c INNER JOIN [cat].[Municipio] cm on c.Municipio = cm.MunicipioID 
LEFT JOIN dbo.Usuario u on c.Facilitador = u.UsuarioID INNER JOIN [cat].[Fiscalia] f ON  u.FiscaliaID = f.FiscaliaID 
LEFT JOIN cat.MotivoRechazo mr ON mr.MotivoID = c.MotivoRechazo';

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
	'entered_folders_id' => (object) array(
		'db_column' => "[CarpetaIngresadaID] AS 'id'",
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => '[FechaInicioSigi]',
		'search' => true
	),
	'entered_folders_rejection_reason' => (object) array(
		'db_column' => "mr.Nombre AS 'MotivoRechazo'",
		'search' => true
	),
	'entered_folders_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'entered_folders_date' => (object) array(
		'db_column' => '[FechaIngreso]',
		'search' => true
	),
	'entered_folders_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'entered_folders_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'entered_folders_mp_channeler' => (object) array(
		'db_column' => '[MPCanalizador]',
		'search' => true
	),
	'entered_folders_priority' => (object) array(
		'db_column' => "CASE c.[Prioridad] WHEN 1 THEN 'Si' ELSE 'No' END AS 'Prioridad'",
		'search' => true
	),
	'entered_folders_recieved_folder' => (object) array(
		'db_column' => "CASE [CarpetaRecibida] WHEN 1 THEN 'Si' ELSE 'No' END AS 'CarpetaRecibida'",
		'search' => true
	),
	'entered_folders_channeler' => (object) array(
		'db_column' => '[Canalizador]',
		'search' => true
	),
	'entered_folders_fiscalia' => (object) array(
		'db_column' => '[Fiscalia]',
		'search' => true
	),
	'entered_folders_municipality' => (object) array(
		'db_column' => 'cm.[Nombre] AS "Municipio"',
		'search' => true
	),
	'entered_folders_observations' => (object) array(
		'db_column' => '[Observaciones]',
		'search' => true
	),
	'entered_folders_folders_date' => (object) array(
		'db_column' => '[FechaCarpetas]',
		'search' => true
	),
	'entered_folders_facilitator' => (object) array(
		'db_column' => '[Facilitador]',
		'search' => true
	),
	/*'entered_folders_book_date' => (object) array(
		'db_column' => '[FechaLibro]',
		'search' => true
	),*/
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	),
	'user_name' => (object) array(
		'db_column' => 'u.[Nombre]',
		'search' => true
	),
	'user_ps' => (object) array(
		'db_column' => 'u.[ApellidoPaterno]',
		'search' => true
	),
	'user_ms' => (object) array(
		'db_column' => 'u.[ApellidoMaterno]',
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
		'db_column' => 'FechaIngreso',
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY FechaIngreso, Nombre";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$entered_folders_date = $row['FechaIngreso'];

			if($entered_folders_date != null)
				$entered_folders_date = $entered_folders_date->format('d/m/Y');

			$entered_folders_folders_date = $row['FechaCarpetas'];

			if($entered_folders_folders_date != null)
				$entered_folders_folders_date = $entered_folders_folders_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');

			/*$entered_folders_book_date = $row['FechaLibro'];

			if($entered_folders_book_date != null)
				$entered_folders_book_date = $entered_folders_book_date->format('d/m/Y');*/
	
			array_push($return, array(
				'entered_folders_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'entered_folders_rejection_reason' => array(
					'name' => 'MotivoRechazo',
					'value' => $row['MotivoRechazo']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'entered_folders_date' => array(
					'name' => 'Fecha',
					'value' => $entered_folders_date
				),
				'entered_folders_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => "[CarpetaIngresadaID] = '".$row['id']."' ORDER BY d.Nombre",
							'db_table' => '[delitos].[CarpetasIngresadas] ci inner join cat.Delito d on ci.DelitoID = d.DelitoID',
							'conn' => $attr->conn,
							'params' => $attr->params,
							'options' => $attr->options
						)
					)
				),
				'entered_folders_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'entered_folders_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'entered_folders_mp_channeler' => array(
					'name' => 'MP Canalizador',
					'value' => $row['MPCanalizador']
				),
				'entered_folders_priority' => array(
					'name' => 'Prioridad',
					'value' => $row['Prioridad']
				),
				'entered_folders_recieved_folder' => array(
					'name' => 'Carpeta Recibida',
					'value' => $row['CarpetaRecibida']
				),
				'entered_folders_channeler' => array(
					'name' => 'Canalizador',
					'value' => $row['Canalizador']
				),
				'entered_folders_fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				),
				'entered_folders_municipality' => array(
					'name' => 'Municipio',
					'value' => $row['Municipio']
				),
				'entered_folders_observations' => array(
					'name' => 'Observaciones',
					'value' => $row['Observaciones']
				),
				'entered_folders_folders_date' => array(
					'name' => 'Fecha Carpetas',
					'value' => $entered_folders_folders_date
				),
				'entered_folders_facilitator' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				)/*,
				'entered_folders_book_date' => array(
					'name' => 'Fecha Libro',
					'value' => $entered_folders_book_date
				)*/
			));
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

