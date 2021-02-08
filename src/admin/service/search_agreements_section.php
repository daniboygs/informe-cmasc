<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[AcuerdosCelebrados] a INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID';

$nuc = $_POST['nuc'];
$month = $_POST['month'];
$year = $_POST['year'];
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
		'db_column' => '[Intervinientes]',
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
		'db_column' => "CASE [TotalParcial] WHEN 1 THEN 'Total' ELSE 'Parcial' END AS 'TotalParcial'",
		'search' => true
	),
	'agreement_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'a.[UsuarioID]',
		'search' => false
	),
	'user_name' => (object) array(
		'db_column' => '[Nombre]',
		'search' => true
	),
	'user_ps' => (object) array(
		'db_column' => '[ApellidoPaterno]',
		'search' => true
	),
	'user_ms' => (object) array(
		'db_column' => '[ApellidoMaterno]',
		'search' => true
	),
	'agreement_amount_in_kind' => (object) array(
		'db_column' => '[MontoEspecie]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'nuc' => (object) array(
		'db_column' => '[NUC]',
		'condition' => '=', 
		'value' => $nuc
	),
	'month' => (object) array(
		'db_column' => 'MONTH(Fecha)',
		'condition' => '=', 
		'value' => $month
	),
	'year' => (object) array(
		'db_column' => 'YEAR(Fecha)',
		'condition' => '=', 
		'value' => $year
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
	$month = $attr->sql_conditions->month->value;
	$year = $attr->sql_conditions->year->value;

	$sql = "";

	if($nuc != '' && $month != ''){
		$sql = "SELECT $columns FROM $attr->db_table WHERE [NUC] = '$nuc' AND MONTH(Fecha) = '$month' AND YEAR(Fecha) = '$year' ORDER BY Fecha, Nombre";
	}
	else if($nuc != ''){
		$sql = "SELECT $columns FROM $attr->db_table WHERE [NUC] = '$nuc' ORDER BY Fecha, Nombre";
	}
	else{
		$sql = "SELECT $columns FROM $attr->db_table WHERE MONTH(Fecha) = '$month' AND YEAR(Fecha) = '$year' ORDER BY Fecha, Nombre";
	}

	//$month = date('m', $month.'-01');

	//$sql = "SELECT $columns FROM $attr->db_table WHERE [NUC] = '$nuc' AND MONTH(Fecha) = '$month' AND YEAR(Fecha) = '$year'";

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
					'value' => $row['MontoRecuperado']
				),
				'agreement_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'agreement_amount_in_kind' => array(
					'name' => 'MontoEspecie',
					'value' => $row['MontoEspecie']
				),
				'agreement_user' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
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

