<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados] a LEFT JOIN [cat].[Fiscalia] f ON a.FiscaliaID = f.FiscaliaID LEFT JOIN [cat].[Unidad] uni ON a.UnidadID = uni.UnidadID
LEFT JOIN [dbo].[CarpetasRecibidas] cr ON cr.CarpetaRecibidaID = a.CarpetaRecibidaID
LEFT JOIN [dbo].[CarpetasIngresadas] ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

if(isset( $_POST['nuc']))
	$nuc = $_POST['nuc'];
else
	$nuc = '';

if(isset( $_POST['initial_date']))
	$initial_date = $_POST['initial_date'];
else
	$initial_date = '';

if(isset( $_POST['finish_date']))
	$finish_date = $_POST['finish_date'];
else
	$finish_date = '';

$data = (object) array(
	'agreement_id' => (object) array(
		'db_column' => "[AcuerdoCelebradoID] AS 'id'",
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => 'a.[FechaInicioSigi]',
		'search' => true
	),
	'agreement_amount' => (object) array(
		'db_column' => '[MontoRecuperado]',
		'search' => true
	),
	'agreement_compliance' => (object) array(
		'db_column' => '[Cumplimiento]',
		'search' => true
	),
	/*'agreement_crime' => (object) array(
		'db_column' => '[AcuerdoDelito]',
		'search' => true
	),*/
	'agreement_date' => (object) array(
		'db_column' => 'a.[Fecha]',
		'search' => true
	),
	'agreement_intervention' => (object) array(
		'db_column' => '[Intervinientes]',
		'search' => true
	),
	'agreement_mechanism' => (object) array(
		'db_column' => '[Mecanismo]',
		'search' => true
	),
	'agreement_nuc' => (object) array(
		'db_column' => 'a.[NUC]',
		'search' => true
	),
	'agreement_total' => (object) array(
		'db_column' => "CASE [TotalParcial] WHEN 1 THEN 'Total' ELSE 'Parcial' END AS 'TotalParcial'",
		'search' => true
	),
	'agreement_unity' => (object) array(
		'db_column' => 'uni.[Nombre] AS "Unidad"',
		'search' => true
	),
	'agreement_fiscalia' => (object) array(
		'db_column' => 'f.[Nombre] AS "Fiscalia"',
		'search' => true
	),
	'agreement_amount_in_kind' => (object) array(
		'db_column' => '[MontoEspecie]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = array();

if($nuc != ''){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => '[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != '' && $finish_date != ''){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'a.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

/*$sql_conditions = (object) array(
	'nuc' => (object) array(
		'db_column' => 'cr.[NUC]',
		'condition' => '=', 
		'value' => $nuc
	),
	'range' => (object) array(
		'db_column' => 'Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)
);*/

if(!isset($_SESSION['user_data']) || count($sql_conditions) <= 0){
	echo json_encode(
		array(
			'state' => 'fail',
			'data' => null
		),
		JSON_FORCE_OBJECT
	);
}
else{
	$sql_conditions += ['user' => (object) array(
		'db_column' => "(a.[UsuarioID] = ".$_SESSION['user_data']['id']." OR ci.UsuarioDelegadoID = ".$_SESSION['user_data']['id'].")",
		'condition' => '', 
		'value' => ''
	)];

	/*$sql_conditions += ['user' => (object) array(
		'db_column' => '[UsuarioID]',
		'condition' => '=', 
		'value' => $_SESSION['user_data']['id']
	)];*/

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

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY a.Fecha";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$agreement_date = $row['Fecha'];

			if($agreement_date != null)
				$agreement_date = $agreement_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');
	
			array_push($return, array(
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'agreement_date' => array(
					'name' => 'Fecha',
					'value' => $agreement_date
				),
				'agreement_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => "[AcuerdoCelebradoID] = '".$row['id']."' ORDER BY d.Nombre",
							'db_table' => '[delitos].[AcuerdosCelebrados] ac inner join cat.Delito d on ac.DelitoID = d.DelitoID',
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
					'value' => '$'.$row['MontoRecuperado']
				),
				'agreement_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'agreement_fiscalia' => array(
					'name' => 'Fiscalia',
					'value' => $row['Fiscalia']
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

