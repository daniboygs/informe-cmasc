<?php
session_start();

$data = json_decode($_POST['user_data'], true );

switch($data['type']){
    case 'user':
        $_SESSION['user_data'] = array(
            'uid' => $data['data']['uid'],
            'username' => $data['data']['username'],
            'name' => $data['data']['name'],
            'paternal_surename' => $data['data']['paternal_surename'],
            'maternal_surename' => $data['data']['maternal_surename']
        );
        echo true;
    break;

    default:
        echo false;
}

?>