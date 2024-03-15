<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];

$db_table = '(
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
	) subq
	INNER JOIN cat.Unidad uni ON uni.UnidadID = subq.UnidadID 
	LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = subq.FiscaliaID 
	INNER JOIN CarpetasRecibidas cr ON cr.CarpetaRecibidaID = subq.CarpetaRecibidaID
	INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "subq.[GeneralID]",
		'search' => true
	),
	/*'general_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),*/
	'entered_date' => (object) array(
		'db_column' => 'ci.FechaIngreso',
		'search' => true
	),
	'general_date' => (object) array(
		'db_column' => 'subq.[Fecha]',
		'search' => true
	),
	'general_nuc' => (object) array(
		'db_column' => 'subq.[NUC]',
		'search' => true
	),
	'general_unity' => (object) array(
		'db_column' => "uni.Nombre AS 'Unidad'",
		'search' => true
	),
	'general_fiscalia' => (object) array(
		'db_column' => "f.Nombre AS 'Fiscalia'",
		'search' => true
	),
	'general_attended' => (object) array(
		'db_column' => '[Atendidos]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	),
	'crime_name' => (object) array(
		'db_column' => "cd.Nombre AS 'Delito'",
		'search' => true
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'subq.Fecha',
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY subq.Fecha";
	
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$general_date = $row['Fecha'];

			if($general_date != null)
				$general_date = $general_date->format('d/m/Y');

			$entered_date = $row['FechaIngreso'];

			if($entered_date != null)
				$entered_date = $entered_date->format('d/m/Y');
	
			array_push($return, array(
				'ID' => $row['GeneralID'],
				'NUC' => $row['NUC'],
				'FechaIngreso' => $entered_date,
				'FechaCapturaInegi' => $general_date,
				'Unidad' => $row['Unidad'],
				'Delito' => $row['Delito'],
				'Atendidos' => $row['Atendidos'],
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