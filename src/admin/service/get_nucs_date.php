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
                    '1003202222500',
'1003202208151',
'1003202217183',
'1003202213098',
'1003202228723',
'1003202225798',
'1003202228928',
'1003202219692',
'1003202225313',
'1003202230262',
'1003202225547',
'1003202208959',
'1003202218583',
'1003202215184',
'1003202221079',
'1003202212297',
'1003202224382',
'1003202229782',
'1003202038425',
'1003202216601',
'1003202220837',
'1003202220867',
'1003202221895',
'1003202218173',
'1003202231054',
'1003202219044',
'1003202229428',
'1003202216250',
'1003202220043',
'1003202216907',
'1003202222595',
'1003202220042',
'1003202220982',
'1003202220386',
'1003202228979',
'1003202230552',
'1003202225377',
'1003202214682',
'1003202225008',
'1003202221911',
'1003202230793',
'1003202217543',
'1003202229338',
'1003202226388',
'1003202219750',
'1003202142341',
'1003202219253',
'1003202231258',
'1003202220432',
'1003202228839',
'1003202141832',
'1003202227191',
'1003202219234',
'1003202218778',
'1003202227484',
'1003202213013',
'1003202034249',
'1003202217499',
'1003202208213',
'1003202228570',
'1003202227968',
'1003202215744',
'1003202221542'
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