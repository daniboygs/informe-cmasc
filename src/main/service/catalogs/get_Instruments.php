<?php
session_start();
include("../../../../service/connection.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[cat].[Instrumento]';

$elements = array();

$sql = "SELECT [InstrumentoID] AS 'id'
			,[Nombre]
		FROM $db_table";

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
