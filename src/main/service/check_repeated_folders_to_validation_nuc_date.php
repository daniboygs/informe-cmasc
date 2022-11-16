<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['cmasc']['conn'];
$db = $connections['cmasc']['db'];

$nuc = $_POST['nuc'];
$date = $_POST['date'];

if($conn){
    $sql = "SELECT TOP 1 
                CarpetaEnviadaValidacionID AS 'id',
                [NUC]
            FROM [dbo].[CarpetasEnviadasValidacion]
            WHERE NUC = '$nuc' AND Fecha = '$date'
            ORDER BY CarpetaEnviadaValidacionID DESC";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $result = sqlsrv_query( $conn, $sql , $params, $options );

    $row_count = sqlsrv_num_rows( $result );

    $json = '';
    $return = array();

    if($row_count != 0){

        $return = array(
            'state' => 'founded',
            'data' => null
        );
    }
    else{
        $return = array(
            'state' => 'success',
            'data' => null
        );
    }

    echo json_encode($return, JSON_FORCE_OBJECT);

    sqlsrv_close($conn);
}
else{
    $return = array(
        'state' => 'fail',
        'data' => null
    );

    echo json_encode($return, JSON_FORCE_OBJECT);
}

?>