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
	INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID
	INNER JOIN dbo.Usuario u ON u.UsuarioID = subq.UsuarioID';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "subq.[GeneralID]",
		'search' => true
	),
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
	'general_attended' => (object) array(
		'db_column' => '[Atendidos]',
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
		'db_column' => 'subq.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}

if($initial_date != null && $finish_date != null){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'subq.Fecha',
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
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY subq.Fecha";
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
				'general_attended' => array(
					'name' => 'Atendidos',
					'value' => $row['Atendidos']
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