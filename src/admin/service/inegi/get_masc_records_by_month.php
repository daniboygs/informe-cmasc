<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
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
	) g ON m.GeneralID = g.GeneralID INNER JOIN [cat].[TipoReparacion] tr ON m.TipoReparacion = tr.TipoReparacionID
INNER JOIN [cat].[TipoConclusion] tc ON m.TipoConclusion = tc.TipoConclusionID INNER JOIN [cat].[Turnado] t ON m.Turnado = t.TurnadoID INNER JOIN [inegi].[Delito] d ON g.GeneralID = d.GeneralID 
INNER JOIN cat.Delito cd ON d.DelitoID = cd.DelitoID INNER JOIN cat.Unidad uni on uni.UnidadID = g.UnidadID LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = g.FiscaliaID
INNER JOIN CarpetasRecibidas cr ON cr.CarpetaRecibidaID = g.CarpetaRecibidaID
INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];

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
	'crime_name' => (object) array(
		'db_column' => "cd.Nombre AS 'Delito'",
		'search' => true
	),
	'unity' => (object) array(
		'db_column' => "uni.Nombre AS 'Unidad'",
		'search' => true
	),
	'masc_fiscalia' => (object) array(
		'db_column' => "f.Nombre AS 'Fiscalia'",
		'search' => true
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'g.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY g.Fecha, g.NUC";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$date = $row['Fecha'];

			if($date != null)
				$date = $date->format('d/m/Y');

			$entered_date = $row['FechaIngreso'];

			if($entered_date != null)
				$entered_date = $entered_date->format('d/m/Y');
	
			array_push($return, array(
				'ID' => $row['GeneralID'],
				'NUC' => $row['NUC'],
				'FechaIngreso' => $entered_date,
				'FechaCapturaInegi' => $date,
				'Unidad' => $row['Unidad'],
				'Delito' => $row['Delito'],
				'Mecanismo' => $row['Mecanismo'],
				'Resultado' => $row['Resultado'],
				'Cumplimiento' => $row['Cumplimiento'],
				'Total' => $row['Total'],
				'Tipo Reparación' => $row['TipoReparacion'],
				'Tipo Conclusión' => $row['TipoConclusion'],
				'Monto Recuperado' => $row['MontoRecuperado'],
				'Monto Inmueble' => $row['MontoInmueble'],
				'Turnado a' => $row['Turnado'],
				'Fiscalía' => $row['Fiscalia']
			));
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

