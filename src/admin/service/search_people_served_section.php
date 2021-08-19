<?php
session_start();
include("../../../service/connection.php");
include("common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];
$db_table = '[dbo].[PersonasAtendidas] a INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID INNER JOIN [cat].[Fiscalia] f ON  u.FiscaliaID = f.FiscaliaID';

$nuc = $_POST['nuc'];
$month = $_POST['month'];
$year = $_POST['year'];

$data = (object) array(
	'people_served_id' => (object) array(
		'db_column' => "[PersonaID] AS 'id'",
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => '[FechaInicioSigi]',
		'search' => true
	),
	'people_served_crime' => (object) array(
		'db_column' => '[Delito]',
		'search' => true
	),
	'people_served_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'people_served_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'people_served_unity' => (object) array(
		'db_column' => '[Unidad]',
		'search' => true
	),
	'people_served_number' => (object) array(
		'db_column' => '[PersonasAtendidas]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'a.[UsuarioID]',
		'search' => false
	),
	'user_name' => (object) array(
		'db_column' => 'u.[Nombre]',
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
	'fiscalia' => (object) array(
		'db_column' => "f.[Nombre] AS 'Fiscalia'",
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

	/*$nuc = $attr->sql_conditions->nuc->value;

	$sql = "SELECT $columns FROM $attr->db_table WHERE [NUC] = '$nuc'";*/

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

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$return = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			$people_served_date = $row['Fecha'];

			if($people_served_date != null)
				$people_served_date = $people_served_date->format('d/m/Y');

			$sigi_initial_date = $row['FechaInicioSigi'];

			if($sigi_initial_date != null)
				$sigi_initial_date = $sigi_initial_date->format('d/m/Y');
	
			array_push($return, array(
				'people_served_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => $sigi_initial_date
				),
				'people_served_date' => array(
					'name' => 'Fecha',
					'value' => $people_served_date
				),
				'people_served_crime' => array(
					'name' => 'Delito',
					'value' => getRecordsByCondition(
						(object) array(
							'columns' => 'd.Nombre',
							'condition' => "[PersonaAtendidaID] = '".$row['id']."' ORDER BY d.Nombre",
							'db_table' => '[delitos].[PersonasAtendidas] pa inner join cat.Delito d on pa.DelitoID = d.DelitoID',
							'conn' => $attr->conn,
							'params' => $attr->params,
							'options' => $attr->options
						)
					)
				),
				'people_served_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'people_served_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'people_served_number' => array(
					'name' => 'PersonasAtendidas',
					'value' => $row['PersonasAtendidas']
				),
				'people_served_user' => array(
					'name' => 'Facilitador',
					'value' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
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

