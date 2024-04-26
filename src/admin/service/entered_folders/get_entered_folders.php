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

$db_table = '[dbo].[CarpetasIngresadas] c INNER JOIN [cat].[Municipio] cm on c.Municipio = cm.MunicipioID 
				LEFT JOIN dbo.Usuario u on c.Facilitador = u.UsuarioID INNER JOIN [cat].[Fiscalia] f ON  c.FiscaliaID = f.FiscaliaID 
				LEFT JOIN cat.Unidad uni ON c.UnidadID = uni.UnidadID
				LEFT JOIN cat.MotivoRechazo mr ON mr.MotivoID = c.MotivoRechazo
				LEFT JOIN dbo.CausaPenal cp on cp.CarpetaIngresadaID = c.CarpetaIngresadaID
				LEFT JOIN [cat].[Fiscalia] cpf ON cp.RegionFiscaliaID = cpf.FiscaliaID
				LEFT JOIN [cat].[Fiscalia] cf ON c.LugarAdscripsionFiscaliaID = cf.FiscaliaID
				LEFT JOIN [cat].TipoExpediente te ON c.TipoExpedienteID = te.TipoExpedienteID';

if($nuc != null){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => '[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != null && $finish_date != null){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'FechaIngreso',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(isset($_SESSION['user_data']) && count($sql_conditions) > 0 && $crimes_by_record_id != null){

	$data = (object) array(
		'entered_folders_id' => (object) array(
			'db_column' => "c.[CarpetaIngresadaID] AS 'id'",
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
			'db_column' => 'uni.[Nombre] AS "Unidad"',
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
		'entered_folders_ascription_place' => (object) array(
			'db_column' => "cf.Nombre AS 'LugarAdscripcion'",
			'search' => true
		),
		'entered_folders_type_file' => (object) array(
			'db_column' => "te.Nombre AS 'TipoExpediente'",
			'search' => true
		),
		'entered_folders_cause_number' => (object) array(
			'db_column' => '[NumeroCausaCuadernillo]',
			'search' => true
		),
		'entered_folders_judge_name' => (object) array(
			'db_column' => '[NombreJuez]',
			'search' => true
		),
		'entered_folders_region' => (object) array(
			'db_column' => "cpf.Nombre AS 'Region'",
			'search' => true
		),
		'entered_folders_emission_date' => (object) array(
			'db_column' => '[FechaEmision]',
			'search' => true
		),
		'entered_folders_judicialized_before_cmasc' => (object) array(
			'db_column' => "CASE [JudicializadaAntesCMASC] WHEN 1 THEN 'Si' WHEN 0 THEN 'No' ELSE '' END AS 'JudicializadaAntesCMASC'",
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
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY FechaIngreso, Nombre";
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );
	$row_count = sqlsrv_num_rows( $result );
	$return = array();
	$return_data = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array( $result)){
	
			array_push($return_data, array(
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
					'value' => formatRowDate($row['FechaInicioSigi'])
				),
				'entered_folders_date' => array(
					'name' => 'Fecha',
					'value' => formatRowDate($row['FechaIngreso'])
				),
				'entered_folders_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListCrimesByRecordId(
						(object) array(
							'record_id' => $row['id'],
							'crimes' => $attr->crimes_by_record_id
						)
					)->listed_values
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
					'value' => formatRowDate($row['FechaCarpetas'])
				),
				'entered_folders_facilitator' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				),
				'entered_folders_ascription_place' => array(
					'name' => 'Lugar de adscripción',
					'value' => $row['LugarAdscripcion']
				),
				'entered_folders_type_file' => array(
					'name' => 'Tipo de Expediente',
					'value' => $row['TipoExpediente']
				),
				'entered_folders_cause_number' => array(
					'name' => 'Número de Causa Cuadernillo',
					'value' => $row['NumeroCausaCuadernillo']
				),
				'entered_folders_judge_name' => array(
					'name' => 'Nombre de Juez',
					'value' => $row['NombreJuez']
				),
				'entered_folders_region' => array(
					'name' => 'Región',
					'value' => $row['Region']
				),
				'entered_folders_emission_date' => array(
					'name' => 'Fecha de Emisión',
					'value' => formatRowDate($row['FechaEmision'])
				),
				'entered_folders_judicialized_before_cmasc' => array(
					'name' => 'Judicializada antes de CMASC',
					'value' => $row['JudicializadaAntesCMASC']
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

