<?php
session_start();

$data = json_decode($_POST['user_data'], true );

switch($data['type']){
    case 'user':
        $_SESSION['user_data'] = array(
            'id' => $data['data']['uid'],
            'username' => $data['data']['username'],
            'name' => $data['data']['name'],
            'paternal_surname' => $data['data']['paternal_surname'],
            'maternal_surname' => $data['data']['maternal_surname']
        );
        echo true;
    break;

    default:
        echo false;
}

?>