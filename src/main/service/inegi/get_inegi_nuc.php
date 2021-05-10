<?php
session_start();
include('../../../../service/connection.php');
$conn = $connections['cmasc']['conn'];
$db = $connections['cmasc']['db'];

$recieved_id = $_POST['recieved_id'];

$agreement_id = '';

$db_table = '[dbo].[CarpetasRecibidas]';
$sql_conditions = "[CarpetaRecibidaID] = $recieved_id";

if(isset($_POST['agreement_id'])){
	if($_POST['agreement_id'] != '')
		$agreement_id = $_POST['agreement_id'];
	else
		$agreement_id = '';
}
else{
	$agreement_id = '';
}

if($agreement_id != ''){
	$db_table = '[dbo].[AcuerdosCelebrados]';
	$sql_conditions = "[AcuerdoCelebradoID] = $agreement_id";
}
else{
	$db_table = '[dbo].[CarpetasRecibidas]';
	$sql_conditions = "[CarpetaRecibidaID] = $recieved_id";
}

if($conn){
    $sql = "SELECT NUC FROM $db_table WHERE $sql_conditions";

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
                'id' => null,
                'nuc' => $json['NUC']
            )
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