<?php
session_start();
include('../../../service/connection.php');
$conn = $connections['acceius'];

$nuc = $_POST['nuc'];

if($nuc != null){

    $data = '';
    $return = array();

    $ch = curl_init($conn->url.$nuc);

    curl_setopt($ch, CURLOPT_USERPWD, $conn->user . ":" . $conn->pass);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if(curl_errno($ch)){

        $return = array(
            'state' => 'fail',
            'data' => null
        );
    }
    else{

        $data = json_decode($response, true);

        if($data['code'] != "200"){

            $return = array(
                'state' => 'not_found',
                'data' => null
            );
        }
        else{

            $clean_date = substr($data['fecha_inicio'], 0, 19);

            $date = new DateTime($clean_date);

            $return = array(
                'state' => 'success',
                'data' => array(
                    'id' => null,
                    'nuc' => $data['caso'],
                    'date' => $date->format('Y-m-d')
                )
            );
        }
    }

    curl_close($ch);

    echo json_encode($return, JSON_FORCE_OBJECT);

}
?>