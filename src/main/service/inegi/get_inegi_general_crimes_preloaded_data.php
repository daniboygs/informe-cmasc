<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[cat].[Delito] d INNER JOIN [delitos].[INEGI] i ON d.DelitoID = i.DelitoID';

$recieved_id = $_POST['recieved_id'];
$agreement_id = $_POST['agreement_id'];

$data = (object) array(
	'id' => (object) array(
		'db_column' => "d.[DelitoID] AS 'id'",
		'search' => true
	),
	'name' => (object) array(
		'db_column' => "[Nombre]",
		'search' => true
	)
);

$sql_conditions = '';

if($agreement_id != ''){
	$sql_conditions = "[AcuerdoCelebradoID] = $agreement_id";
	$db_table = '[cat].[Delito] d INNER JOIN [delitos].[AcuerdosCelebrados] ac ON d.DelitoID = ac.DelitoID';
	//$data->id = "[AcuerdoCelebradoID] AS 'id'";
}
else{
	$sql_conditions = "[CarpetaRecibidaID] = $recieved_id";
	$db_table = '[cat].[Delito] d INNER JOIN [delitos].[CarpetasRecibidas] cr ON d.DelitoID = cr.DelitoID';
	//$data->id = "[CarpetaRecibidaID] AS 'id'";
}

/*$sql_conditions = (object) array(
	'recieved' => (object) array(
		'db_column' => 'CarpetaRecibidaID',
		'condition' => '=',
		'value' => "'$recieved_id'"
	),
	'agreement' => (object) array(
		'db_column' => 'AcuerdoCelebradoID',
		'condition' => '=',
		'value' => "'$agreement_id'"
	)
);*/

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
	//$conditions = formSearchConditions($attr->sql_conditions);
	$conditions = 'WHERE '.$attr->sql_conditions;

	$sql = "SELECT $columns FROM $attr->db_table $conditions";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			array_push($return, array(
				'id' => $row['id'],
				'name' => $row['Nombre']
			));
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

