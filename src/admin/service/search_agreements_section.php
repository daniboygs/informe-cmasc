<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados]';

$nuc = $_POST['nuc'];
/*$month = $_POST['month'];
$year = $_POST['year'];*/

$data = (object) array(
	'agreement_id' => (object) array(
		'db_column' => '[AcuerdoCelebradoID]',
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
	'agreement_crime' => (object) array(
		'db_column' => '[AcuerdoDelito]',
		'search' => true
	),
	'agreement_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'agreement_intervention' => (object) array(
		'db_column' => '[Intervenciones]',
		'search' => true
	),
	'agreement_mechanism' => (object) array(
		'db_column' => '[Mecanismo]',
		'search' => true
	),
	'agreement_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'agreement_total' => (object) array(
		'db_column' => '[TotalParcial]',
		'search' => true
	),
	'agreement_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = (object) array(
	'nuc' => (object) array(
		'db_column' => '[NUC]',
		'condition' => '=', 
		'value' => $nuc
	)/*,
	'month' => (object) array(
		'db_column' => 'MONTH(Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(Fecha)',
		'condition' => '=', 
		'value' => $year
	)*/
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
	//$conditions = formSearchConditions($attr->sql_conditions);

	$nuc = $attr->sql_conditions->nuc->value;

	$sql = "SELECT $columns FROM $attr->db_table WHERE [NUC] = '$nuc'";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$agreement_date = $row['Fecha'];

			if($agreement_date != null)
				$agreement_date = $agreement_date->format('Y/m/d');
	
			array_push($return, array(
				'agreement_id' => array(
					'name' => 'ID',
					'value' => $row['AcuerdoCelebradoID']
				),
				'agreement_date' => array(
					'name' => 'Fecha',
					'value' => $agreement_date
				),
				'agreement_crime' => array(
					'name' => 'Delito',
					'value' => $row['AcuerdoDelito']
				),
				'agreement_intervention' => array(
					'name' => 'Intervencion',
					'value' => $row['Intervenciones']
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
					'value' => $row['MontoRecuperado']
				),
				'agreement_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
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
