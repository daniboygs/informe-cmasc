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
$crimes_by_general_id = isset($_POST['crimes_by_general_id']) ? $_POST['crimes_by_general_id'] : null;
$sql_conditions = array();
$return = array();

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
	,u.Nombre
	,u.ApellidoPaterno
	,u.ApellidoMaterno
FROM [CarpetasRecibidas] res INNER JOIN Usuario u ON res.UsuarioID = u.UsuarioID WHERE res.CarpetaRecibidaID NOT IN (SELECT CarpetaRecibidaID FROM inegi.General WHERE CarpetaRecibidaID IS NOT NULL)
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
	,u.Nombre
	,u.ApellidoPaterno
	,u.ApellidoMaterno
FROM [AcuerdosCelebrados] acu INNER JOIN Usuario u ON acu.UsuarioID = u.UsuarioID WHERE acu.AcuerdoCelebradoID NOT IN (SELECT AcuerdoCelebradoID FROM inegi.General WHERE AcuerdoCelebradoID IS NOT NULL)
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
	NULL AS MontoEspecie ,
	u.Nombre ,
	u.ApellidoPaterno ,
	u.ApellidoMaterno 
FROM [CarpetasRecibidas] res INNER JOIN Usuario u ON res.UsuarioID = u.UsuarioID INNER JOIN (SELECT [NUC], MAX(Fecha) AS 'FechaMAX'
  FROM [EJERCICIOS].[dbo].[AcuerdosCelebrados] group by NUC) a on res.NUC = a.NUC
WHERE res.CarpetaRecibidaID NOT IN 
(SELECT CarpetaRecibidaID FROM inegi.General WHERE CarpetaRecibidaID IS NOT NULL) 
AND res.Fecha > a.FechaMAX
) subq";

if($nuc != null){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'subq.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}

if($initial_date != null && $finish_date != null){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(!isset($_SESSION['user_data']) || count($sql_conditions) <= 0){
	$return = json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}
else{
	$return = json_encode(
		array(
			'state' => 'success',
			'data' => getRecord(
				(object) array(
					'data' => $data,
					'sql_conditions' => $sql_conditions,
					'db_table' => $db_table,
					'conn' => $conn,
					'params' => $params,
					'options' => $options,
					'crimes_by_general_id' => $crimes_by_general_id
				)
			)
		),
		JSON_FORCE_OBJECT
	);
}

echo $return;

function getRecord($attr){

	$conditions = formSearchConditions($attr->sql_conditions);
	$sql = "SELECT * FROM $attr->db_table $conditions ORDER BY subq.Fecha, subq.NUC DESC";
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options);
	$row_count = sqlsrv_num_rows($result);
	$return = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

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
					'value' => formatRowDate($row['Fecha'])
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
				),
				'user_name' => array(
					'name' => 'Nombre',
					'value' => $row['Nombre']
				),
				'user_last_name' => array(
					'name' => 'ApellidoPaterno',
					'value' => $row['ApellidoPaterno']
				),
				'user_mothers_last_name' => array(
					'name' => 'ApellidoMaterno',
					'value' => $row['ApellidoMaterno']
				)
			));
		}
	}
	else{
		$return = null;
	}
	return $return;
}

function getHTMLListCrimesByGeneralId($attr){

    $listed_values = '';

    if(isset(json_decode($attr->crimes, true)[$attr->general_id])){

        foreach(json_decode($attr->crimes, true)[$attr->general_id] as $element){

            $listed_values.='<li>'.$element['crime_name'].'</li>';
    
        }

        return (object) array(
            'listed_values' => $listed_values
        );
    }
    else{
        return (object) array(
            'listed_values' => '<li>No tiene delitos</li>'
        );
    }
}
?>