<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PersonasAtendidas]';

$id = $_POST['id'];


$sql = "DELETE FROM $db_table WHERE [PersonaID] = '$id'";


$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

echo true;

sqlsrv_close($conn);
?>

