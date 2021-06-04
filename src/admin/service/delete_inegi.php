<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$id = $_POST['id'];

$db_table = '[inegi].[General]';

$sql = "DELETE FROM $db_table WHERE GeneralID = '$id'";

$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$db_table = '[inegi].[Delito]';

$sql = "DELETE FROM $db_table WHERE GeneralID = '$id'";

$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$db_table = '[inegi].[Imputado]';

$sql = "DELETE FROM $db_table WHERE GeneralID = '$id'";

$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$db_table = '[inegi].[MASC]';

$sql = "DELETE FROM $db_table WHERE GeneralID = '$id'";

$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$db_table = '[inegi].[Victima]';

$sql = "DELETE FROM $db_table WHERE GeneralID = '$id'";

$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

$db_table = '[delitos].[INEGI]';

$sql = "DELETE FROM $db_table WHERE GeneralID = '$id'";

$stmt = sqlsrv_query( $conn, $sql);
if( $stmt === false ) {
    die( print_r( sqlsrv_errors(), true));
}

echo true;

sqlsrv_close($conn);
?>

