<?php

session_start();

/*checkVariables((object) array(
	
));*/
$return = array();

if(isset($_POST['nuc']) && isset($_POST['folio'])){


	$_SESSION['rejected_folders_pdf_data'] = (object) array(
		'nuc' => $_POST['nuc']['value'],
		'folio' => $_POST['folio']['value'],
		'mp_channeler' => $_POST['mp_channeler']['value'],
		'unity' => $_POST['unity']['value'],
		'sigi_initial_date' => $_POST['sigi_initial_date']['value'],
		'rejected_reason' => $_POST['rejected_reason']['value'],
		'rejected_reason_id' => $_POST['rejected_reason_id']['value'],
		'rejected_basis' => $_POST['rejected_basis']['value'],
		'nuc' => $_POST['nuc']['value']
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