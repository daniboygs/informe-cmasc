<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[CarpetasIngresadas]';

$entered_folder_id = $_POST['entered_folder_id'];

$data = (object) array(
	'entered_folders_id' => (object) array(
		'db_column' => '[CarpetaIngresadaID]',
		'search' => true
	),
	'entered_folders_delegated_user_id' => (object) array(
		'db_column' => '[UsuarioDelegadoID]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'entered_folder_id' => (object) array(
		'db_column' => '[CarpetaIngresadaID]',
		'condition' => '=', 
		'value' => $entered_folder_id
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
		array(
			'state' => 'success',
			'data' => json_encode(
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
			)
		),
		JSON_FORCE_OBJECT
	);
}

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);

	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT $columns FROM $attr->db_table $conditions";

    $result = sqlsrv_query($attr->conn, $sql , $attr->params, $attr->options);

	$row_count = sqlsrv_num_rows($result);
	
	$return = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

			$return = array(
				'entered_folder_id' => array(
					'name' => 'CarpetaIngresadaID',
					'value' => $row['CarpetaIngresadaID']
				),
				'entered_folders_delegated_user_id' => array(
					'name' => 'UsuarioDelegadoID',
					'value' => $row['UsuarioDelegadoID']
				)
			);
		}
	}
	else{
		$return = null;
	}

	return $return;
}
?>

