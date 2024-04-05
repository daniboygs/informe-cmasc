<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
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
INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => 'g.[GeneralID]',
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
	'crime_fiscalia' => (object) array(
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
				'Calificacion' => $row['Calificacion'],
				'Concurso' => $row['Concurso'],
				'Forma Accion' => $row['FormaAccion'],
				'Comision' => $row['Comision'],
				'Violencia' => $row['Violencia'],
				'Modalidad' => $row['Modalidad'],
				'Instrumento' => $row['Instrumento'],
				'Justicia Alternativa' => $row['JusticiaAlternativa'],
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

