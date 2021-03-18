<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados]';

$nuc = $_POST['nuc'];

$data = (object) array(
	'mechanism' => (object) array(
		'db_column' => '[Mecanismo]',
		'search' => true
	),
	'compliance' => (object) array(
		'db_column' => '[Cumplimiento]',
		'search' => true
	),
	'agreement_total' => (object) array(
		'db_column' => '[TotalParcial]',
		'search' => true
	),
	'agreement_amount' => (object) array(
		'db_column' => '[MontoRecuperado]',
		'search' => true
	),
	'agreement_amount_in_kind' => (object) array(
		'db_column' => '[MontoEspecie]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'general_id' => (object) array(
		'db_column' => 'NUC',
		'condition' => '=',
		'value' => "'$nuc'"
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

	$sql = "SELECT $columns FROM $attr->db_table $conditions";
	
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			array_push($return, array(
				'masc_mechanism' => array(
					'name' => 'Mecanismo',
					'value' => $row['Mecanismo']
				),
				'masc_compliance' => array(
					'name' => 'Cumplimiento',
					'value' => $row['Cumplimiento']
				),
				'masc_total' => array(
					'name' => 'Total/Parcial',
					'value' => $row['TotalParcial']
				),
				'masc_recovered_amount' => array(
					'name' => 'Monto Recuperado',
					'value' => $row['MontoRecuperado']
				),
				'masc_amount_property' => array(
					'name' => 'MontoEspecie',
					'value' => $row['MontoEspecie']
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

