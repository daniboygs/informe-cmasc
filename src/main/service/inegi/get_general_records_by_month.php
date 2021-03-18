<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[General] g
LEFT JOIN (
	select distinct 
		sg.GeneralID 
	from [inegi].[General] sg 
	INNER JOIN [inegi].[Victima] sv 
	on sg.GeneralID = sv.GeneralID 
	where sg.[UsuarioID] = 2 AND MONTH(sg.Fecha) = 3 AND YEAR(sg.Fecha) = 2021
) v 
ON g.GeneralID = v.GeneralID
LEFT JOIN (
	select distinct 
		sg.GeneralID 
	from [inegi].[General] sg 
	INNER JOIN [inegi].[Imputado] si 
	on sg.GeneralID = si.GeneralID 
	where sg.[UsuarioID] = 2 AND MONTH(sg.Fecha) = 3 AND YEAR(sg.Fecha) = 2021
) i
ON g.GeneralID = i.GeneralID
LEFT JOIN [inegi].[Delito] d
ON g.GeneralID = d.GeneralID
LEFT JOIN [inegi].[MASC] m
ON g.GeneralID = m.GeneralID';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'general_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'general_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'general_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'general_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'general_attended' => (object) array(
		'db_column' => '[Atendidos]',
		'search' => true
	),
	'victim' => (object) array(
		'db_column' => "v.GeneralID AS 'TVictima'",
		'search' => true
	),
	'imputed' => (object) array(
		'db_column' => "i.GeneralID AS 'TImputado'",
		'search' => true
	),
	'crime' => (object) array(
		'db_column' => "d.DelitoID AS 'TDelito'",
		'search' => true
	),
	'masc' => (object) array(
		'db_column' => "m.MASCID AS 'TMASC'",
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => ''
	),
	'month' => (object) array(
		'db_column' => 'MONTH(Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(Fecha)',
		'condition' => '=', 
		'value' => $year
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha";
	
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$general_date = $row['Fecha'];

			if($general_date != null)
				$general_date = $general_date->format('d/m/Y');
	
			array_push($return, array(
				'general_date' => array(
					'name' => 'Fecha',
					'value' => $general_date
				),
				'general_crime' => array(
					'name' => 'Delito',
					'value' => $row['Delito']
				),
				'general_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'general_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'general_attended' => array(
					'name' => 'Atendidos',
					'value' => $row['Atendidos']
				),
				'victim' => array(
					'name' => 'Víctima',
					'value' => $row['TVictima']
				),
				'imputed' => array(
					'name' => 'Imputado',
					'value' => $row['TImputado']
				),
				'crime' => array(
					'name' => 'Delito',
					'value' => $row['TDelito']
				),
				'masc' => array(
					'name' => 'MASC',
					'value' => $row['TMASC']
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

