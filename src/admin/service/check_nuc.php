<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['sigi']['conn'];
$db = $connections['sigi']['db'];

$nuc = $_POST['nuc'];

if($conn){
    $sql = "SELECT 
                    dbo.caso.cNumeroGeneralCaso AS 'nuc',
                    Expediente.dFechaCreacion AS 'fecha'					
                FROM  
                dbo.caso 
                left join dbo.Expediente ON Expediente.Caso_id = dbo.Caso.Caso_id		
                where dbo.caso.cNumeroGeneralCaso = '$nuc'";

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
                'nuc' => $json['nuc'],
                'date' => $json['fecha']
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