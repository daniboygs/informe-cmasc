<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];

$sql = "SELECT g.[GeneralID]
			,cd.Nombre AS 'Delito'
			FROM [EJERCICIOS].[inegi].[General] g INNER JOIN [inegi].[Delito] d ON d.GeneralID = g.GeneralID 
			INNER JOIN [cat].[Delito] cd ON cd.DelitoID = d.DelitoID
			WHERE Fecha between '$initial_date' AND '$finish_date' ORDER BY Fecha";

$result = sqlsrv_query( $conn, $sql , $params, $options );

$row_count = sqlsrv_num_rows( $result );

$return = array();

if($row_count > 0){

    while($row = sqlsrv_fetch_array($result)){

		if(isset($return[$row['GeneralID']])){

			array_push($return[$row['GeneralID']], array(
				'crime_name' => $row['Delito']
			));
		}
		else{

			$return += [$row['GeneralID'] => array(
				array('crime_name' => $row['Delito'])
			)];
		}
    }
}
else{
    $return = null;
}

echo json_encode(
    array(
        'state' => 'success',
        'data' => array(
			'crimes_by_general_record' => $return
		)
    ),
    JSON_FORCE_OBJECT
);
?>