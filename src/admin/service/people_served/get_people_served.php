<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$nuc = isset($_POST['nuc']) ? $_POST['nuc'] : null;
$initial_date = isset($_POST['initial_date']) ? $_POST['initial_date'] : null;
$finish_date = isset($_POST['finish_date']) ? $_POST['finish_date'] : null;
$crimes_by_record_id = isset($_POST['crimes_by_record_id']) ? $_POST['crimes_by_record_id'] : null;
$people_by_record_id = isset($_POST['people_by_record_id']) ? $_POST['people_by_record_id'] : null;
$sql_conditions = array();
$return = array();

$db_table = '[dbo].[PersonasAtendidas] a 
				INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID 
				LEFT JOIN [cat].[Fiscalia] f ON a.FiscaliaID = f.FiscaliaID 
				LEFT JOIN [cat].[Unidad] uni ON a.UnidadID = uni.UnidadID';

if($nuc != null){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'a.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != null && $finish_date != null){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'a.[Fecha]',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(isset($_SESSION['user_data']) && count($sql_conditions) > 0 && $crimes_by_record_id != null){

	$data = (object) array(
		'people_served_id' => (object) array(
			'db_column' => "[PersonaID] AS 'id'",
			'search' => true
		),
		'sigi_initial_date' => (object) array(
			'db_column' => '[FechaInicioSigi]',
			'search' => true
		),
		'people_served_crime' => (object) array(
			'db_column' => '[Delito]',
			'search' => true
		),
		'people_served_date' => (object) array(
			'db_column' => '[Fecha]',
			'search' => true
		),
		'people_served_nuc' => (object) array(
			'db_column' => '[NUC]',
			'search' => true
		),
		'people_served_unity' => (object) array(
			'db_column' => 'uni.[Nombre] AS "Unidad"',
			'search' => true
		),
		'people_served_number' => (object) array(
			'db_column' => '[PersonasAtendidas]',
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

	$return = json_encode(
		getRecord(
			(object) array(
				'data' => $data,
				'sql_conditions' => $sql_conditions,
				'db_table' => $db_table,
				'crimes_by_record_id' => $crimes_by_record_id,
				'people_by_record_id' => $people_by_record_id,
				'conn' => $conn,
				'params' => $params,
				'options' => $options
			)
		), 
		JSON_FORCE_OBJECT
	);
}
else{
	$return = json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}

echo $return;

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha, Nombre";
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );
	$row_count = sqlsrv_num_rows( $result );
	$return = array();
	$return_data = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array( $result)){
	
			array_push($return_data, array(
				'people_served_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => formatRowDate($row['FechaInicioSigi'])
				),
				'people_served_date' => array(
					'name' => 'Fecha',
					'value' => formatRowDate($row['Fecha'])
				),
				'people_served_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListElementsByRecordId(
						(object) array(
							'record_id' => $row['id'],
							'elements' => $attr->crimes_by_record_id
						)
					)
				),
				'people_served_people' => array(
					'name' => 'Personas',
					'value' => getHTMLListElementsByRecordId(
						(object) array(
							'record_id' => $row['id'],
							'elements' => $attr->people_by_record_id
						)
					)
				),
				'people_served_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'people_served_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'people_served_number' => array(
					'name' => 'PersonasAtendidas',
					'value' => $row['PersonasAtendidas']
				),
				'people_served_user' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				)
			));
		}

		$return = array(
			'state' => 'success',
			'data' => $return_data
		);
	}
	else{
		$return = array(
			'state' => 'success',
			'data' => null
		);
	}

	return $return;
}
?>

