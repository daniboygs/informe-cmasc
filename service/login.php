<?php
session_start();
include('connection.php');
include("validate_injection_string.php");
$conn = $connections['cmasc']['conn'];
$db = $connections['cmasc']['db'];

$data = json_decode($_POST['auth'], true );

$user = cleanTextInjec($data['username']);
$pass = hash('sha256', cleanTextInjec($data['password']));

if($conn){
    $sql = "SELECT TOP (1)
            [UsuarioID]
            ,[Usuario]
            ,[Nombre]
            ,[ApellidoPaterno]
            ,[ApellidoMaterno]
            ,[Tipo]
            ,[FiscaliaID]
        FROM $db.[dbo].[Usuario] 
        WHERE [Usuario] = '$user'
        AND [Contrasena] = '$pass'
        AND [Estatus] = 1";

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
                'id' => $json['UsuarioID'],
                'username' => $json['Usuario'],
                'name' => $json['Nombre'],
                'paternal_surname' => $json['ApellidoPaterno'],
                'maternal_surname' => $json['ApellidoMaterno'],
                'type' => $json['Tipo'],
                'fiscalia' => $json['FiscaliaID']
            )
        );
        
    }
    else{
        $return = array(
            'state' => 'not_found',
            'data' => false
        );
    }

    echo json_encode($return, JSON_FORCE_OBJECT);

    sqlsrv_close($conn);
}
else{
    $return = array(
        'state' => 'fail',
        'data' => false
    );

    echo json_encode($return, JSON_FORCE_OBJECT);
}

?>