<?php
session_start();
include('connection.php');

$data = json_decode($_POST['auth'], true );

$user = $data['username'];
$pass = $data['password'];

if($conn){
    $sql = "SELECT TOP (1)
            [UsuarioID]
            ,[Usuario]
            ,[Nombre]
            ,[ApellidoPaterno]
            ,[ApellidoMaterno]
        FROM [informe_cmasc].[dbo].[Usuario] 
        WHERE [Usuario] = '$user'
        AND [Contrasena] = '$pass'";

    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $result = sqlsrv_query( $conn, $sql , $params, $options );

    $row_count = sqlsrv_num_rows( $result );

    $json = '';
    $return = array();

    if ($row_count != 0){
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
                'maternal_surname' => $json['ApellidoMaterno']
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