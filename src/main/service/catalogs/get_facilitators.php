<?php
session_start();
include("../../../../service/connection.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[Usuario]';

$elements = array();

$sql = "SELECT [UsuarioID] AS 'id'
			,[Nombre]
			,[ApellidoPaterno]
      		,[ApellidoMaterno]
		FROM $db_table 
		WHERE [Tipo] != 1 ORDER BY [Nombre], [ApellidoPaterno], [ApellidoMaterno]";

$result = sqlsrv_query( $conn, $sql , $params, $options );

$row_count = sqlsrv_num_rows( $result );

if($row_count > 0){

	while( $row = sqlsrv_fetch_array( $result) ) {

		array_push($elements, array(
			'id' => $row['id'],
			'name' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
		));
		
	}

}
else{
	$elements = null;
}

echo json_encode($elements, JSON_FORCE_OBJECT);

sqlsrv_close($conn);

?>
