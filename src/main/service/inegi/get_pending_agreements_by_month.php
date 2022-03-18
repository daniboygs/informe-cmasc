<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = "(SELECT 
	res.[CarpetaRecibidaID],
	NULL AS AcuerdoCelebradoID,
	res.NUC, 
	res.Fecha
	,res.Unidad
	,res.UsuarioID
	,'[dbo].[CarpetasRecibidas]' AS 'RecordTable'
	,'[CarpetaRecibidaID]' AS 'RecordFieldID'
	,res.[CarpetaRecibidaID] AS 'RecordID'
	,'[delitos].[CarpetasRecibidas]' AS 'CrimeTable'
	,'[DelitoCarpetaRecibidaID]' AS 'CrimeFieldID'
	,res.[CarpetaRecibidaID] AS 'CrimeID'
	,NULL AS Intervinientes
	,NULL AS Cumplimiento
	,NULL AS TotalParcial
	,NULL AS Mecanismo
	,NULL AS MontoRecuperado
	,NULL AS MontoEspecie
FROM [CarpetasRecibidas] res WHERE res.CarpetaRecibidaID NOT IN (SELECT CarpetaRecibidaID FROM inegi.General WHERE CarpetaRecibidaID IS NOT NULL)
AND res.NUC NOT IN (SELECT DISTINCT [NUC] FROM dbo.AcuerdosCelebrados)
UNION  
SELECT
	NULL AS CarpetaRecibidaID,
	acu.AcuerdoCelebradoID,
	acu.nuc,
	acu.Fecha 
	,acu.[Unidad]
	,acu.[UsuarioID]
	,'[dbo].[AcuerdosCelebrados]' AS 'RecordTable'
	,'[AcuerdoCelebradoID]' AS 'RecordFieldID'
	,acu.[AcuerdoCelebradoID] AS 'RecordID'
	,'[delitos].[AcuerdosCelebrados]' AS 'CrimeTable'
	,'[DelitoAcuerdoID]' AS 'CrimeFieldID'
	,acu.[AcuerdoCelebradoID] AS 'CrimeID'
	,acu.[Intervinientes]
	,acu.[Cumplimiento]
	,CASE [TotalParcial] 
		WHEN 1 THEN 'Total' WHEN 2 THEN 'Parcial' ELSE NULL END AS 'TotalParcial'
	,acu.[Mecanismo]
	,acu.[MontoRecuperado]
	,acu.[MontoEspecie]
FROM [AcuerdosCelebrados] acu WHERE acu.AcuerdoCelebradoID NOT IN (SELECT AcuerdoCelebradoID FROM inegi.General WHERE AcuerdoCelebradoID IS NOT NULL)
UNION
SELECT 
	res.[CarpetaRecibidaID], 
	NULL AS AcuerdoCelebradoID, 
	res.NUC, 
	res.Fecha, 
	res.Unidad, 
	res.UsuarioID,
	'[dbo].[CarpetasRecibidas]' AS 'RecordTable',
	'[CarpetaRecibidaID]' AS 'RecordFieldID',
	res.[CarpetaRecibidaID] AS 'RecordID',
	'[delitos].[CarpetasRecibidas]' AS 'CrimeTable',
	'[DelitoCarpetaRecibidaID]' AS 'CrimeFieldID',
	res.[CarpetaRecibidaID] AS 'CrimeID',
	NULL AS Intervinientes,
	NULL AS Cumplimiento ,
	NULL AS TotalParcial ,
	NULL AS Mecanismo ,
	NULL AS MontoRecuperado ,
	NULL AS MontoEspecie 
FROM [CarpetasRecibidas] res INNER JOIN (SELECT [NUC], MAX(Fecha) AS 'FechaMAX'
  FROM [EJERCICIOS].[dbo].[AcuerdosCelebrados] group by NUC) a on res.NUC = a.NUC
WHERE res.CarpetaRecibidaID NOT IN 
(SELECT CarpetaRecibidaID FROM inegi.General WHERE CarpetaRecibidaID IS NOT NULL) 
AND res.Fecha > a.FechaMAX
) subq";

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array();

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => 'UsuarioID',
		'condition' => '=', 
		'value' => null
	)
);

if(!isset($_SESSION['user_data'])){
	echo json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}
else{

	$sql_conditions->user->value = $_SESSION['user_data']['id'];
	
	echo json_encode(
		getRecord(
			(object) array(
				'data' => $data,
				'sql_conditions' => $sql_conditions,
				'db_table' => $db_table,
				'conn' => $conn,
				'params' => $params,
				'options' => $options
			)
		), 
		JSON_FORCE_OBJECT
	);
}

function getRecord($attr){

	//$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT * FROM $attr->db_table $conditions ORDER BY subq.Fecha, subq.NUC DESC";
	
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$date = $row['Fecha'];

			if($date != null)
				$date = $date->format('d/m/Y');

			$agreement_amount = $row['MontoRecuperado'];

			if($agreement_amount != null)
				$agreement_amount = '$'.$agreement_amount;
	
			array_push($return, array(
				'recieved_id' => array(
					'name' => '',
					'value' => $row['CarpetaRecibidaID']
				),
				'agreement_id' => array(
					'name' => '',
					'value' => $row['AcuerdoCelebradoID']
				),
				'date' => array(
					'name' => 'Fecha',
					'value' => $date
				),
				'agreement_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => $row['RecordFieldID']." = '".$row['RecordID']."' ORDER BY d.Nombre",
							'db_table' => $row['CrimeTable']." ci inner join cat.Delito d on ci.DelitoID = d.DelitoID",
							'conn' => $attr->conn,
							'params' => $attr->params,
							'options' => $attr->options
						)
					)
				),
				'agreement_intervention' => array(
					'name' => 'Intervinientes',
					'value' => $row['Intervinientes']
				),
				'agreement_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'agreement_compliance' => array(
					'name' => 'Cumplimiento',
					'value' => $row['Cumplimiento']
				),
				'agreement_total' => array(
					'name' => 'Total/Parcial',
					'value' => $row['TotalParcial']
				),
				'agreement_mechanism' => array(
					'name' => 'Mecanismo',
					'value' => $row['Mecanismo']
				),
				'agreement_amount' => array(
					'name' => 'Monto Recuperado',
					'value' => $agreement_amount
				),
				'agreement_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'agreement_amount_in_kind' => array(
					'name' => 'MontoEspecie',
					'value' => $row['MontoEspecie']
				)
			));
			
		}
	
	}
	else{
		$return = null;
	}

	return $return;


}
?>

