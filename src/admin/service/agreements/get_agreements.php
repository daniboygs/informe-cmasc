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
$crimes_by_record_id = isset($_POST['crimes_by_record_id']) ? $_POST['crimes_by_record_id'] : null;
$sql_conditions = array();
$return = array();

$db_table = '[dbo].[AcuerdosCelebrados] a 
				INNER JOIN Usuario u ON a.UsuarioID = u.UsuarioID 
				LEFT JOIN [cat].[Fiscalia] f ON a.FiscaliaID = f.FiscaliaID 
				LEFT JOIN [cat].[Unidad] uni ON a.UnidadID = uni.UnidadID';

if($nuc != null){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'a.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != null && $finish_date != null){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'a.[Fecha]',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

if(isset($_SESSION['user_data']) && count($sql_conditions) > 0 && $crimes_by_record_id != null){

	$data = (object) array(
		'agreement_id' => (object) array(
			'db_column' => "[AcuerdoCelebradoID] AS 'id'",
			'search' => true
		),
		'sigi_initial_date' => (object) array(
			'db_column' => '[FechaInicioSigi]',
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
			'db_column' => 'uni.[Nombre] AS "Unidad"',
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
		'agreement_amount_in_kind' => (object) array(
			'db_column' => '[MontoEspecie]',
			'search' => true
		),
		'fiscalia' => (object) array(
			'db_column' => "f.[Nombre] AS 'Fiscalia'",
			'search' => true
		)
	);

	$return = json_encode(
		getRecord(
			(object) array(
				'data' => $data,
				'sql_conditions' => $sql_conditions,
				'db_table' => $db_table,
				'crimes_by_record_id' => $crimes_by_record_id,
				'conn' => $conn,
				'params' => $params,
				'options' => $options
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

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha, Nombre";
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );
	$row_count = sqlsrv_num_rows( $result );
	$return = array();
	$return_data = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array( $result)){
	
			array_push($return_data, array(
				'agreement_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => formatRowDate($row['FechaInicioSigi'])
				),
				'agreement_date' => array(
					'name' => 'Fecha',
					'value' => formatRowDate($row['Fecha'])
				),
				'agreement_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListElementsByRecordId(
						(object) array(
							'record_id' => $row['id'],
							'elements' => $attr->crimes_by_record_id
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
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				)
			));
		}

		$return = array(
			'state' => 'success',
			'data' => $return_data
		);
	}
	else{
		$return = array(
			'state' => 'success',
			'data' => null
		);
	}

	return $return;
}
?>

