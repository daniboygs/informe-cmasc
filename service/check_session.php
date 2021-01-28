<?php

	session_start(); 

	if(isset($_SESSION['user_data'])){
		echo json_encode(
			array(
				'state' => 'success',
				'data' => false
			),
			JSON_FORCE_OBJECT
		);
	}
	else{
		echo json_encode(
			array(
				'state' => 'failed',
				'data' => false
			),
			JSON_FORCE_OBJECT
		);
	}
?>