<?php

session_start();

/*checkVariables((object) array(
	
));*/
$return = array();

if(isset($_POST['nuc']) && isset($_POST['folio'])){


	$_SESSION['rejected_folders_pdf_data'] = (object) array(
		'nuc' => $_POST['nuc']['value'],
		'folio' => $_POST['folio']['value'],
		'sigi_initial_date' => $_POST['sigi_initial_date']['value']
	);

	$return = array(
		'state' => 'success',
		'data' => null
	);
}
else{
	$return = array(
		'state' => 'fail',
		'data' => null
	);
}

echo json_encode($return, JSON_FORCE_OBJECT);
/*function checkVariables($data){

}*/

?>