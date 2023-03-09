<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$agreement_id = $_POST['id'];


$sql = "SELECT TOP 1 GeneralID FROM [inegi].[General] WHERE AcuerdoCelebradoID = '$agreement_id'";
	
$result = sqlsrv_query( $conn, $sql , $params, $options );

$row_count = sqlsrv_num_rows( $result );

$return = array();

if($row_count > 0){

    $id = null;

    while( $row = sqlsrv_fetch_array( $result) ) {

        $id = $row['GeneralID'];

    }

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

}

echo true;

sqlsrv_close($conn);
?>

