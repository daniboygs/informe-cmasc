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

$db_table = '[inegi].[MASC] m INNER JOIN (
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
	) g ON m.GeneralID = g.GeneralID 
INNER JOIN [cat].[TipoReparacion] tr ON m.TipoReparacion = tr.TipoReparacionID
INNER JOIN [cat].[TipoConclusion] tc ON m.TipoConclusion = tc.TipoConclusionID
INNER JOIN [cat].[Turnado] t ON m.Turnado = t.TurnadoID
INNER JOIN cat.Unidad uni on uni.UnidadID = g.UnidadID
LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = g.FiscaliaID
INNER JOIN CarpetasRecibidas cr ON cr.CarpetaRecibidaID = g.CarpetaRecibidaID
INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID
INNER JOIN dbo.Usuario u ON u.UsuarioID = g.UsuarioID';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "g.[GeneralID]",
		'search' => true
	),
	'masc_id' => (object) array(
		'db_column' => 'm.[MASCID]',
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
	'masc_mechanism' => (object) array(
		'db_column' => '[Mecanismo]',
		'search' => true
	),
	'masc_result' => (object) array(
		'db_column' => '[Resultado]',
		'search' => true
	),
	'masc_compliance' => (object) array(
		'db_column' => '[Cumplimiento]',
		'search' => true
	),
	'masc_total' => (object) array(
		'db_column' => "CASE [Total] WHEN 1 THEN 'Total' ELSE 'Parcial' END AS 'Total'",
		'search' => true
	),
	'masc_repair' => (object) array(
		'db_column' => "tr.[Nombre] AS 'TipoReparacion'",
		'search' => true
	),
	'masc_conclusion' => (object) array(
		'db_column' => "tc.[Nombre] AS 'TipoConclusion'",
		'search' => true
	),
	'masc_recovered_amount' => (object) array(
		'db_column' => '[MontoRecuperado]',
		'search' => true
	),
	'masc_amount_property' => (object) array(
		'db_column' => '[MontoInmueble]',
		'search' => true
	),
	'masc_turned_to' => (object) array(
		'db_column' => "t.[Nombre] AS 'Turnado'",
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
				'general_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListElementsByRecordId(
						(object) array(
							'record_id' => $row['GeneralID'],
							'elements' => $attr->crimes_by_general_id
						)
					)
				),
				'masc_mechanism' => array(
					'name' => 'Mecanismo',
					'value' => $row['Mecanismo']
				),
				'masc_result' => array(
					'name' => 'Resultado',
					'value' => $row['Resultado']
				),
				'masc_compliance' => array(
					'name' => 'Cumplimiento',
					'value' => $row['Cumplimiento']
				),
				'masc_total' => array(
					'name' => 'Total',
					'value' => $row['Total']
				),
				'masc_repair' => array(
					'name' => 'TipoReparacion',
					'value' => $row['TipoReparacion']
				),
				'masc_conclusion' => array(
					'name' => 'TipoConclusion',
					'value' => $row['TipoConclusion']
				),
				'masc_amount_recovered' => array(
					'name' => 'MontoRecuperado',
					'value' => $row['MontoRecuperado']
				),
				'masc_amount_property' => array(
					'name' => 'MontoInmueble',
					'value' => $row['MontoInmueble']
				),
				'masc_turned_to' => array(
					'name' => 'Turnado',
					'value' => $row['Turnado']
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
?>