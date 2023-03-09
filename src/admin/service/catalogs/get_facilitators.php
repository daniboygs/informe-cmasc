<?php
session_start();
include("../../../../service/connection.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[Usuario] u inner join cat.Fiscalia f on u.FiscaliaID = f.FiscaliaID';

$elements = array();
$facilitator_name = '';

$sql = "SELECT [UsuarioID] AS 'id'
			,u.[Nombre]
			,[ApellidoPaterno]
      		,[ApellidoMaterno]
			,f.Nombre as 'Fiscalia'
		FROM $db_table 
		WHERE [Tipo] != 1 ORDER BY [Nombre], [ApellidoPaterno], [ApellidoMaterno]";

$result = sqlsrv_query( $conn, $sql , $params, $options );

$row_count = sqlsrv_num_rows( $result );

if($row_count > 0){

	while( $row = sqlsrv_fetch_array( $result) ) {

		if($row['id'] == 21 || $row['id'] == 54){
			$facilitator_name = $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno'].' ('.$row['Fiscalia'].')';
		}
		else{
			$facilitator_name = $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno'];
		}

		array_push($elements, array(
			'id' => $row['id'],
			'name' => $facilitator_name
		));
		
	}

}
else{
	$elements = null;
}

echo json_encode($elements, JSON_FORCE_OBJECT);

sqlsrv_close($conn);

?>
