<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['sicap']['conn'];
$db = $connections['sicap']['db'];

$nuc = $_POST['nuc'];

if($conn){
    $sql = "SELECT
                [NUC]
                ,cm.Nombre AS 'Delito'
            FROM $db.[dbo].[Carpeta] c 
            INNER JOIN Delito d 
            ON c.CarpetaID = d.CarpetaID 
            INNER JOIN CatModalidadesEstadisticas cm 
            ON d.CatModalidadesID = cm.CatModalidadesEstadisticasID 
            WHERE NUC = '$nuc'";

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
                'id' => null,
                'nuc' => $json['NUC'],
                'crime' => $json['Delito']
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