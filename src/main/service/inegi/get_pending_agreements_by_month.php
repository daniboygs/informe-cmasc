<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados] a RIGHT JOIN [dbo].[CarpetasRecibidas] cr ON a.NUC = cr.NUC';

$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'recieved_id' => (object) array(
		'db_column' => '[CarpetaRecibidaID]',
		'search' => true
	),
	'agreement_id' => (object) array(
		'db_column' => '[AcuerdoCelebradoID]',
		'search' => true
	),
	'agreement_nuc' => (object) array(
		'db_column' => 'cr.[NUC]',
		'search' => true
	),
	'recieved_date' => (object) array(
		'db_column' => "cr.[Fecha] AS 'FechaRecibida'",
		'search' => true
	),
	'agreement_date' => (object) array(
		'db_column' => "a.[Fecha] AS 'FechaAcuerdo'",
		'search' => true
	),
	'agreement_crime' => (object) array(
		'db_column' => '[AcuerdoDelito]',
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
	'agreement_intervention' => (object) array(
		'db_column' => '[Intervinientes]',
		'search' => true
	),
	'agreement_mechanism' => (object) array(
		'db_column' => '[Mecanismo]',
		'search' => true
	),
	'agreement_total' => (object) array(
		'db_column' => "CASE [TotalParcial] WHEN 1 THEN 'Total' WHEN 2 THEN 'Parcial' ELSE NULL END AS 'TotalParcial'",
		'search' => true
	),
	'agreement_unity' => (object) array(
		'db_column' => "CASE ISNULL(a.[Unidad], 'NULL')  WHEN 'NULL' THEN cr.[Unidad] ELSE a.[Unidad] END AS 'Unidad'",
		'search' => true
	),
	'agreement_amount_in_kind' => (object) array(
		'db_column' => '[MontoEspecie]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'cr.[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = (object) array(
	'user' => (object) array(
		'db_column' => 'cr.[UsuarioID]',
		'condition' => '=', 
		'value' => '2'
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

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);

	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY cr.NUC, cr.Fecha, a.Fecha";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$recieved_date = $row['FechaRecibida'];

			if($recieved_date != null)
				$recieved_date = $recieved_date->format('d/m/Y');

			$agreement_date = $row['FechaAcuerdo'];

			if($agreement_date != null)
				$agreement_date = $agreement_date->format('d/m/Y');

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
				'recieved_date' => array(
					'name' => 'Fecha Recibida',
					'value' => $recieved_date
				),
				'agreement_date' => array(
					'name' => 'Fecha Acuerdo',
					'value' => $agreement_date
				),
				'agreement_crime' => array(
					'name' => 'Delito',
					'value' => $row['AcuerdoDelito']
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

