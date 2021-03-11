<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[MASC] m INNER JOIN [inegi].[General] g ON m.GeneralID = g.GeneralID INNER JOIN [cat].[TipoReparacion] tr ON m.TipoReparacion = tr.TipoReparacionID
INNER JOIN [cat].[TipoConclusion] tc ON m.TipoConclusion = tc.TipoConclusionID INNER JOIN [cat].[Turnado] t ON m.Turnado = t.TurnadoID';

$general_id = $_POST['general_id'];

$data = (object) array(
	'nuc' => (object) array(
		'db_column' => 'g.[NUC]',
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
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => ''
	),
	'general_id' => (object) array(
		'db_column' => 'm.GeneralID',
		'condition' => '=', 
		'value' => $general_id
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

	$sql_conditions->user->value = $_SESSION['user_data']['id'];
	
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
	
			array_push($return, array(
				'nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'date' => array(
					'name' => 'Fecha',
					'value' => $date
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
					'name' => 'Tipo Reparación',
					'value' => $row['TipoReparacion']
				),
				'masc_conclusion' => array(
					'name' => 'Tipo Conclusión',
					'value' => $row['TipoConclusion']
				),
				'masc_recovered_amount' => array(
					'name' => 'Monto Recuperado',
					'value' => $row['MontoRecuperado']
				),
				'masc_amount_property' => array(
					'name' => 'Monto Inmueble',
					'value' => $row['MontoInmueble']
				),
				'masc_turned_to' => array(
					'name' => 'Turnado a',
					'value' => $row['Turnado']
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

