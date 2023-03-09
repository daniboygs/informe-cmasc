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
    $sql = "SELECT 
                    dbo.caso.cNumeroGeneralCaso AS 'nuc',
                    Expediente.dFechaCreacion AS 'fecha'					
                FROM  
                dbo.caso 
                left join dbo.Expediente ON Expediente.Caso_id = dbo.Caso.Caso_id		
                where dbo.caso.cNumeroGeneralCaso IN (
                    '1003202012279',
'1003202012279',
'1003202012279',
'1003202012279',
'1006202241821',
'1006202243018',
'1007202242542',
'1002202242985',
'1002202242746',
'1003202239294',
'1010202227872',
'1010202227872',
'1010202227872',
'1001202240913',
'1001202240509',
'1001202240509',
'1001202242492',
'1005202240867',
'1005202241403',
'1005202241131',
'1005202226449',
'1005202226449',
'1005202240531',
'1006202241816',
'1006202241816',
'1003202241066',
'1003202212954',
'1003202239671',
'1003202239671',
'1003202239349',
'1003202232922',
'1003202239349',
'1002202237620',
'1001202242416',
'1005202231982',
'1005202231982',
'1003202241284',
'1003202241284',
'1003202239389',
'1005202241139',
'1005202238459',
'1005202239598',
'1005202239710',
'1005202240801',
'1002202243013',
'1006202240753',
'1003202213476',
'1003202225936',
'1006202243178',
'1003202225936',
'1006202243212',
'1006202243212',
'1001202241281',
'1001202215831',
'1003202226114',
'1005202243223',
'1003202240629',
'1005202243223',
'1005202243223',
'1005202134232',
'1003202237461',
'1006202240507',
'1006202240604',
'1003202241362',
'1005202239316',
'1005202235970'
                )";

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