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
? ($nuc != null ? "FechaIngreso between '$initial_date' AND '$finish_date' AND NUC = '$nuc'" : "FechaIngreso between '$initial_date' AND '$finish_date'")
: ($nuc != null ? "NUC = '$nuc'" : null);

if($sql_conditions != null){

	$sql = "SELECT a.[CarpetaEnviadaInvestigacionID] AS 'id',
			cd.Nombre AS 'Delito'
			FROM [EJERCICIOS].[dbo].[CarpetasEnviadasInvestigacion] a INNER JOIN [delitos].[CarpetasEnviadasInvestigacion] d ON d.CarpetaEnviadaInvestigacionID = a.CarpetaEnviadaInvestigacionID
			INNER JOIN [cat].[Delito] cd ON cd.DelitoID = d.DelitoID
			WHERE Fecha between '2024-03-01' AND '2024-04-24' ORDER BY Fecha";

	$result = sqlsrv_query($conn, $sql, $params, $options);
	$row_count = sqlsrv_num_rows($result);
	$crimes_by_general = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

			if(isset($crimes_by_general[$row['id']])){

				array_push($crimes_by_general[$row['id']], array(
					'crime_name' => $row['Delito']
				));
			}
			else{

				$crimes_by_general += [$row['id'] => array(
					array('crime_name' => $row['Delito'])
				)];
			}
		}
	}
	else{
		$crimes_by_general = null;
	}

	$return = json_encode(
		array(
			'state' => 'success',
			'data' => array(
				'crimes_by_record' => $crimes_by_general
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