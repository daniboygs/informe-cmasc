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
$return = array();

$sql_conditions = ($initial_date != null && $finish_date != null) 
? ($nuc != null ? "Fecha between '$initial_date' AND '$finish_date' AND NUC = '$nuc'" : "Fecha between '$initial_date' AND '$finish_date'")
: ($nuc != null ? "NUC = '$nuc'" : null);

if($sql_conditions != null){

	$sql = "SELECT a.[PersonaID] AS 'id',
			cd.Nombre AS 'Delito'
			FROM [EJERCICIOS].[dbo].[PersonasAtendidas] a 
			INNER JOIN [delitos].[PersonasAtendidas] d ON d.PersonaAtendidaID = a.PersonaID
			INNER JOIN [cat].[Delito] cd ON cd.DelitoID = d.DelitoID
			WHERE $sql_conditions ORDER BY Fecha";

	$result = sqlsrv_query($conn, $sql, $params, $options);
	$row_count = sqlsrv_num_rows($result);
	$crimes_by_record = array();

	if($row_count > 0){

		$crimes_by_record = sqlsrv_getElementsByRecordID((object) array(
			'result' => $result,
            'record_id' => 'id',
			'element_name' => 'Delito',
		));
	}
	else{
		$crimes_by_record = null;
	}

	$return = json_encode(
		array(
			'state' => 'success',
			'data' => array(
				'crimes_by_record' => $crimes_by_record
			)
		),
		JSON_FORCE_OBJECT
	);
}
else{
	$return = json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}

echo $return;
?>