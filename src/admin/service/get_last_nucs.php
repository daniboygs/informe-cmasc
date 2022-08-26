<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['sigi']['conn'];
$db = $connections['sigi']['db'];

/*if(isset( $_POST['nucs']))
    $array_nucs = $_POST['nucs'];
else
    $array_nucs = $_POST['nucs'];


$array_nucs_string = json_encode($array_nucs);

$banned = array('"', '[', ']');
$in_sql_nucs = str_replace($banned, "", $array_nucs_string);*/

if($conn){
    $sql = "SELECT TOP 20
                    dbo.caso.cNumeroGeneralCaso AS 'nuc',
                    Expediente.dFechaCreacion AS 'fecha'					
                FROM  
                dbo.caso 
                left join dbo.Expediente ON Expediente.Caso_id = dbo.Caso.Caso_id ORDER BY caso.cNumeroGeneralCaso DESC";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $result = sqlsrv_query( $conn, $sql , $params, $options );

    $row_count = sqlsrv_num_rows( $result );

    $json = '';
    $dates_by_nuc = array();

    if($row_count != 0){
        while( $row = sqlsrv_fetch_array( $result) ) {

            $initial_date = $row['fecha'];

            if($initial_date != null)
                $initial_date = $initial_date->format('d/m/Y');

            $dates_by_nuc += [$row["nuc"] => $initial_date];
        }

        $json = json_decode($json, true);
            
        $return = array(
            'state' => 'success',
            'data' => $dates_by_nuc
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