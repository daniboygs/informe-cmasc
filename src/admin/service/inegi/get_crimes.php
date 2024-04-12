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
$crimes_by_general_id = isset($_POST['crimes_by_general_id']) ? $_POST['crimes_by_general_id'] : null;
$sql_conditions = array();
$return = array();

$db_table = '[inegi].[Delito] d INNER JOIN (
	SELECT g.[GeneralID]
		  ,g.[NUC]
		  ,g.[FechaInicioSigi]
		  ,g.[Fecha]
		  ,g.[Atendidos]
		  ,acu.[CarpetaRecibidaID] 
		  ,g.[UnidadID]
		  ,g.[FiscaliaID]
		  ,g.[UsuarioID] FROM [inegi].[General] g INNER JOIN AcuerdosCelebrados acu ON acu.AcuerdoCelebradoID = g.AcuerdoCelebradoID
	UNION
	SELECT [GeneralID]
		  ,[NUC]
		  ,[FechaInicioSigi]
		  ,[Fecha]
		  ,[Atendidos]
		  ,[CarpetaRecibidaID] 
		  ,[UnidadID]
		  ,[FiscaliaID]
		  ,[UsuarioID] FROM [inegi].[General] WHERE CarpetaRecibidaID is not null
	) g ON d.GeneralID = g.GeneralID INNER JOIN [cat].[Modalidad] m ON d.Modalidad = m.ModalidadID
INNER JOIN [cat].[Instrumento] i ON d.Instrumento = i.InstrumentoID INNER JOIN [cat].[Delito] cd ON d.DelitoID = cd.DelitoID INNER JOIN cat.Unidad uni on uni.UnidadID = g.UnidadID
LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = g.FiscaliaID
INNER JOIN CarpetasRecibidas cr ON cr.CarpetaRecibidaID = g.CarpetaRecibidaID
INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID
INNER JOIN dbo.Usuario u ON u.UsuarioID = g.UsuarioID';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "g.[GeneralID]",
		'search' => true
	),
	'nuc' => (object) array(
		'db_column' => 'g.[NUC]',
		'search' => true
	),
	'entered_date' => (object) array(
		'db_column' => 'ci.FechaIngreso',
		'search' => true
	),
	'date' => (object) array(
		'db_column' => 'g.[Fecha]',
		'search' => true
	),
	'crime_rate' => (object) array(
		'db_column' => '[Calificacion]',
		'search' => true
	),
	'crime_contest' => (object) array(
		'db_column' => '[Concurso]',
		'search' => true
	),
	'crime_action' => (object) array(
		'db_column' => '[FormaAccion]',
		'search' => true
	),
	'crime_commission' => (object) array(
		'db_column' => '[Comision]',
		'search' => true
	),
	'crime_violence' => (object) array(
		'db_column' => '[Violencia]',
		'search' => true
	),
	'crime_modality' => (object) array(
		'db_column' => "m.[Nombre] AS 'Modalidad'",
		'search' => true
	),
	'crime_instrument' => (object) array(
		'db_column' => "i.[Nombre] AS 'Instrumento'",
		'search' => true
	),
	'crime_alternative_justice' => (object) array(
		'db_column' => "CASE [JusticiaAlternativa] WHEN 1 THEN 'Si' WHEN 2 then 'No' END AS 'JusticiaAlternativa'",
		'search' => true
	),
	'crime_name' => (object) array(
		'db_column' => "cd.Nombre AS 'Delito'",
		'search' => true
	),
	'unity' => (object) array(
		'db_column' => "uni.Nombre AS 'Unidad'",
		'search' => true
	),
	'fiscalia' => (object) array(
		'db_column' => "f.Nombre AS 'Fiscalia'",
		'search' => true
	),
	'user_name' => (object) array(
		'db_column' => "u.[Nombre] AS 'NombreFcilitador'",
		'search' => true
	),
	'user_ap' => (object) array(
		'db_column' => 'u.[ApellidoPaterno]',
		'search' => true
	),
	'user_am' => (object) array(
		'db_column' => 'u.[ApellidoMaterno]',
		'search' => true
	)
);

if($nuc != null){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'g.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}

if($initial_date != null && $finish_date != null){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'g.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(!isset($_SESSION['user_data']) && count($sql_conditions) == 0 && $crimes_by_general_id == null){
	$return = json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}
else{
	$return = json_encode(
		array(
			'state' => 'success',
			'data' => getRecord(
				(object) array(
					'data' => $data,
					'sql_conditions' => $sql_conditions,
					'db_table' => $db_table,
					'conn' => $conn,
					'params' => $params,
					'options' => $options,
					'crimes_by_general_id' => $crimes_by_general_id
				)
			)
		),
		JSON_FORCE_OBJECT
	);
}

echo $return;

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY g.Fecha";
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options);
	$row_count = sqlsrv_num_rows($result);
	$return = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

			array_push($return, array(
				'general_id' => array(
					'name' => 'ID',
					'value' => $row['GeneralID']
				),
				'general_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'entered_date' => array(
					'name' => 'FechaIngreso',
					'value' => formatRowDate($row['FechaIngreso'])
				),
				'general_date' => array(
					'name' => 'FechaCapturaInegi',
					'value' => formatRowDate($row['Fecha'])
				),
				'crime_name' => array(
					'name' => 'Delito',
					'value' => $row['Delito']
				),
				'crime_rate' => array(
					'name' => 'Calificacion',
					'value' => $row['Calificacion']
				),
				'crime_contest' => array(
					'name' => 'Concurso',
					'value' => $row['Concurso']
				),
				'crime_action' => array(
					'name' => 'FormaAccion',
					'value' => $row['FormaAccion']
				),
				'crime_commission' => array(
					'name' => 'Comision',
					'value' => $row['Comision']
				),
				'crime_violence' => array(
					'name' => 'Violencia',
					'value' => $row['Violencia']
				),
				'crime_modality' => array(
					'name' => 'Modalidad',
					'value' => $row['Modalidad']
				),
				'crime_instrument' => array(
					'name' => 'Instrumento',
					'value' => $row['Instrumento']
				),
				'crime_alternative_justice' => array(
					'name' => 'JusticiaAlternativa',
					'value' => $row['JusticiaAlternativa']
				),
				'unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				),
				'user' => array(
					'name' => 'Facilitador',
					'value' => $row['NombreFcilitador'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				)
			));
		}
	}
	else{
		$return = null;
	}
	return $return;
}

function getHTMLListCrimesByGeneralId($attr){

    $listed_values = '';

    if(isset(json_decode($attr->crimes, true)[$attr->general_id])){

        foreach(json_decode($attr->crimes, true)[$attr->general_id] as $element){

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