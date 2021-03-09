<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Imputado] i INNER JOIN [inegi].[General] g ON i.GeneralID = g.GeneralID';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'nuc' => (object) array(
		'db_column' => 'g.[NUC]',
		'search' => true
	),
	'date' => (object) array(
		'db_column' => 'g.[Fecha]',
		'search' => true
	),
	'imputed_gener' => (object) array(
		'db_column' => '[Sexo]',
		'search' => true
	),
	'imputed_age' => (object) array(
		'db_column' => '[Edad]',
		'search' => true
	),
	'imputed_scholarship' => (object) array(
		'db_column' => '[Escolaridad]',
		'search' => true
	),
	'imputed_ocupation' => (object) array(
		'db_column' => '[Ocupacion]',
		'search' => true
	),
	'imputed_applicant' => (object) array(
		'db_column' => '[Solicitante]',
		'search' => true
	),
	'imputed_required' => (object) array(
		'db_column' => '[Requerido]',
		'search' => true
	),
	'imputed_type' => (object) array(
		'db_column' => '[Tipo]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => ''
	),
	'month' => (object) array(
		'db_column' => 'MONTH(g.Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(g.Fecha)',
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
				'imputed_gener' => array(
					'name' => 'Sexo',
					'value' => $row['Sexo']
				),
				'imputed_age' => array(
					'name' => 'Edad',
					'value' => $row['Edad']
				),
				'imputed_scholarship' => array(
					'name' => 'Escolaridad',
					'value' => $row['Escolaridad']
				),
				'imputed_ocupation' => array(
					'name' => 'Ocupación',
					'value' => $row['Ocupacion']
				),
				'imputed_applicant' => array(
					'name' => 'Solicitante',
					'value' => $row['Solicitante']
				),
				'imputed_required' => array(
					'name' => 'Requerido',
					'value' => $row['Requerido']
				),
				'imputed_type' => array(
					'name' => 'Tipo',
					'value' => $row['Tipo']
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

