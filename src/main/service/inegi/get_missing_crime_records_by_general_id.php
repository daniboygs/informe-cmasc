<?php
session_start();
include("../../../../service/connection.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[inegi].[Delito] id RIGHT JOIN [inegi].[General] g ON id.GeneralID = g.GeneralID 
INNER JOIN [delitos].[INEGI] di ON g.GeneralID = di.GeneralID INNER JOIN [cat].[Delito] d ON d.DelitoID = di.DelitoID';

$general_id = $_POST['general_id'];

$elements = array();

$sql = "SELECT DISTINCT d.[DelitoID] AS 'id'
			,d.[Nombre]
		FROM $db_table WHERE g.GeneralID = $general_id AND d.DelitoID NOT IN (SELECT DelitoID FROM inegi.Delito WHERE GeneralID = $general_id )";

$result = sqlsrv_query( $conn, $sql , $params, $options );

$row_count = sqlsrv_num_rows( $result );

if($row_count > 0){

	while( $row = sqlsrv_fetch_array( $result) ) {

		array_push($elements, array(
			'id' => $row['id'],
			'name' => $row['Nombre']
		));
		
	}

}
else{
	$elements = null;
}

echo json_encode($elements, JSON_FORCE_OBJECT);

sqlsrv_close($conn);

?>
