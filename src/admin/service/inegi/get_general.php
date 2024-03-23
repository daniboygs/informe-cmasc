<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$initial_date = $_POST['initial_date'];
$finish_date = $_POST['finish_date'];
$crimes_by_general_id = $_POST['crimes_by_general_id'];

$db_table = '(
	SELECT g.[GeneralID]
		  ,g.[NUC]
		  ,g.[FechaInicioSigi]
		  ,g.[Fecha]
		  ,g.[Atendidos]
		  ,acu.[CarpetaRecibidaID] 
		  ,g.[UnidadID]
		  ,g.[FiscaliaID]
		  ,g.[UsuarioID] FROM [inegi].[General] g INNER JOIN AcuerdosCelebrados acu ON acu.AcuerdoCelebradoID = g.AcuerdoCelebradoID
	UNION
	SELECT [GeneralID]
		  ,[NUC]
		  ,[FechaInicioSigi]
		  ,[Fecha]
		  ,[Atendidos]
		  ,[CarpetaRecibidaID] 
		  ,[UnidadID]
		  ,[FiscaliaID]
		  ,[UsuarioID] FROM [inegi].[General] WHERE CarpetaRecibidaID is not null
	) subq
	INNER JOIN cat.Unidad uni ON uni.UnidadID = subq.UnidadID 
	LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = subq.FiscaliaID 
	INNER JOIN CarpetasRecibidas cr ON cr.CarpetaRecibidaID = subq.CarpetaRecibidaID
	INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "subq.[GeneralID]",
		'search' => true
	),
	'entered_date' => (object) array(
		'db_column' => 'ci.FechaIngreso',
		'search' => true
	),
	'general_date' => (object) array(
		'db_column' => 'subq.[Fecha]',
		'search' => true
	),
	'general_nuc' => (object) array(
		'db_column' => 'subq.[NUC]',
		'search' => true
	),
	'general_unity' => (object) array(
		'db_column' => "uni.Nombre AS 'Unidad'",
		'search' => true
	),
	'general_fiscalia' => (object) array(
		'db_column' => "f.Nombre AS 'Fiscalia'",
		'search' => true
	),
	'general_attended' => (object) array(
		'db_column' => '[Atendidos]',
		'search' => true
	),
	'user' => (object) array(
		'db_column' => '[UsuarioID]',
		'search' => false
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'subq.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
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
				'options' => $options,
				'crimes_by_general_id' => $crimes_by_general_id
			)
		), 
		JSON_FORCE_OBJECT
	);
}

function getRecord($attr){

	$columns = formSearchDBColumns($attr->data);
	$conditions = formSearchConditions($attr->sql_conditions);
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY subq.Fecha";
    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options);
	$row_count = sqlsrv_num_rows($result);
	$return = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

			array_push($return, array(
				'general_id' => array(
					'name' => 'ID',
					'value' => $row['GeneralID']
				),
				'general_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'entered_date' => array(
					'name' => 'FechaIngreso',
					'value' => formatRowDate($row['FechaIngreso'])
				),
				'general_date' => array(
					'name' => 'FechaCapturaInegi',
					'value' => formatRowDate($row['Fecha'])
				),
				'general_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListCrimesByGeneralId(
						(object) array(
							'general_id' => $row['GeneralID'],
							'crimes' => $attr->crimes_by_general_id
						)
					)->listed_values
				),
				'general_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'general_attended' => array(
					'name' => 'Atendidos',
					'value' => $row['Atendidos']
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