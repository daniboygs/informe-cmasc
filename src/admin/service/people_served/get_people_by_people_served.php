<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$nuc = isset($_POST['nuc']) ? $_POST['nuc'] : null;
$initial_date = isset($_POST['initial_date']) ? $_POST['initial_date'] : null;
$finish_date = isset($_POST['finish_date']) ? $_POST['finish_date'] : null;
$return = array();

$sql_conditions = ($initial_date != null && $finish_date != null) 
? ($nuc != null ? "Fecha between '$initial_date' AND '$finish_date' AND NUC = '$nuc'" : "Fecha between '$initial_date' AND '$finish_date'")
: ($nuc != null ? "NUC = '$nuc'" : null);

if($sql_conditions != null){

	$sql = "SELECT a.[PersonaID] AS 'id',
			pa.Nombre AS 'nombre',
			pa.ApellidoPaterno AS 'paterno',
			pa.ApellidoMaterno AS 'materno'
			FROM [EJERCICIOS].[dbo].[PersonasAtendidas] a 
			INNER JOIN [personas_atendidas].[Persona] pa ON pa.PersonasAtendidasID = a.PersonaID
			WHERE $sql_conditions ORDER BY Fecha";

	$result = sqlsrv_query($conn, $sql, $params, $options);
	$row_count = sqlsrv_num_rows($result);
	$people_by_record = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

			if(isset($people_by_record[$row['id']])){

				array_push($people_by_record[$row['id']], array(
					'name' => $row['nombre'].' '.$row['paterno'].' '.$row['materno']
				));
			}
			else{

				$people_by_record += [$row['id'] => array(
					array('name' => $row['nombre'].' '.$row['paterno'].' '.$row['materno'])
				)];
			}
		}
	}
	else{
		$people_by_record = null;
	}

	$return = json_encode(
		array(
			'state' => 'success',
			'data' => array(
				'people_by_record' => $people_by_record
			)
		),
		JSON_FORCE_OBJECT
	);

}
else{
	$return = json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}

echo $return;
?>