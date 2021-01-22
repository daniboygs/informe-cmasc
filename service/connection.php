<?php
	$servername = "MO22P1R02F8E5\SQLEXPRESS";
	$username = "doko";
	$password = "A2544.19";
	$db = "sigep";
	$connectionInfo = array(
        'CharacterSet' => 'UTF-8', 
        'Database' => $db, 
        'UID' => $username, 
        'PWD' => $password
    );

	$conn = sqlsrv_connect( $servername, $connectionInfo);
?>
