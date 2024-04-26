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
$sql_conditions = array();
$return = array();

$db_table = '[dbo].[CarpetasEnviadasInvestigacion] a 
				INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID
				LEFT JOIN [cat].[MotivoCanalizacionInvestigacion] m ON a.MotivoCanalizacionInvestID = m.MotivoCanalizacionID 
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
		'db_column' => 'a.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(isset($_SESSION['user_data']) && count($sql_conditions) > 0 && $crimes_by_record_id != null){

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

	$return = json_encode(
		getRecord(
			(object) array(
				'data' => $data,
				'sql_conditions' => $sql_conditions,
				'db_table' => $db_table,
				'crimes_by_record_id' => $crimes_by_record_id,
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
				'folders_to_investigation_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => formatRowDate($row['FechaInicioSigi'])
				),
				'folders_to_investigation_date' => array(
					'name' => 'Fecha',
					'value' => formatRowDate($row['Fecha'])
				),
				'folders_to_investigation_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListCrimesByRecordId(
						(object) array(
							'record_id' => $row['id'],
							'crimes' => $attr->crimes_by_record_id
						)
					)->listed_values
				),
				'folders_to_investigation_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'folders_to_investigation_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
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

function getHTMLListCrimesByRecordId($attr){

    $listed_values = '';

    if(isset(json_decode($attr->crimes, true)[$attr->record_id])){

        foreach(json_decode($attr->crimes, true)[$attr->record_id] as $element){

            $listed_values.='<li>'.$element['crime_name'].'</li>';
    
        }

        return (object) array(
            'listed_values' => $listed_values
        );
    }
    else{
        return (object) array(
            'listed_values' => '<li>No tiene delitos</li>'
        );
    }
}
?>

