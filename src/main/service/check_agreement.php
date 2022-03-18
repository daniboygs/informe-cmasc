<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['cmasc']['conn'];
$db = $connections['cmasc']['db'];

$nuc = $_POST['nuc'];

if($conn){
    $sql = "SELECT TOP 1 
                [AcuerdoCelebradoID] AS 'id',
                [NUC], 
                UnidadID AS 'Unidad'
            FROM $db.[dbo].[AcuerdosCelebrados]
            WHERE NUC = '$nuc' 
            ORDER BY AcuerdoCelebradoID DESC";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $result = sqlsrv_query( $conn, $sql , $params, $options );

    $row_count = sqlsrv_num_rows( $result );

    $json = '';
    $return = array();

    if($row_count != 0){
        while( $row = sqlsrv_fetch_array( $result) ) {
            $json = json_encode($row);
        }
        
        $json = json_decode($json, true);
            
        $return = array(
            'state' => 'success',
            'data' => array(
                'id' => $json['id'],
                'nuc' => $json['NUC'],
                'unity' => $json['Unidad']
            )
        );
        
    }
    else{
        $return = array(
            'state' => 'not_found',
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