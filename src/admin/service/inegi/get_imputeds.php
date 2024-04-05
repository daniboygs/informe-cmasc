<?php
session_start();
include("../../../../service/connection.php");
include("../common.php");

$params = array();
$options = array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
$conn = $connections['cmasc']['conn'];

$nuc = isset($_POST['nuc']) ? $_POST['nuc'] : '';
$initial_date = isset($_POST['initial_date']) ? $_POST['initial_date'] : '';
$finish_date = isset($_POST['finish_date']) ? $_POST['finish_date'] : '';
$crimes_by_general_id = $_POST['crimes_by_general_id'];

$db_table = '[inegi].[Imputado] i INNER JOIN (
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
	) g ON i.GeneralID = g.GeneralID INNER JOIN [cat].[Escolaridad] e ON i.Escolaridad = e.EscolaridadID
INNER JOIN [cat].[Ocupacion] o ON i.Ocupacion = o.OcupacionID INNER JOIN [inegi].[Delito] d ON g.GeneralID = d.GeneralID 
INNER JOIN cat.Delito cd ON d.DelitoID = cd.DelitoID INNER JOIN cat.Unidad uni on uni.UnidadID = g.UnidadID LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = g.FiscaliaID
INNER JOIN CarpetasRecibidas cr ON cr.CarpetaRecibidaID = g.CarpetaRecibidaID
INNER JOIN CarpetasIngresadas ci ON ci.CarpetaIngresadaID = cr.CarpetaIngresadaID
INNER JOIN dbo.Usuario u ON u.UsuarioID = g.UsuarioID';

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "g.[GeneralID]",
		'search' => true
	),
	'nuc' => (object) array(
		'db_column' => 'g.[NUC]',
		'search' => true
	),
	'entered_date' => (object) array(
		'db_column' => 'ci.FechaIngreso',
		'search' => true
	),
	'date' => (object) array(
		'db_column' => 'g.[Fecha]',
		'search' => true
	),
	'imputed_gener' => (object) array(
		'db_column' => '[Sexo]',
		'search' => true
	),
	'imputed_age' => (object) array(
		'db_column' => '[Edad]',
		'search' => true
	),
	'imputed_scholarship' => (object) array(
		'db_column' => "e.[Nombre] AS 'Escolaridad'",
		'search' => true
	),
	'imputed_ocupation' => (object) array(
		'db_column' => "o.[Nombre] AS 'Ocupacion'",
		'search' => true
	),
	'imputed_applicant' => (object) array(
		'db_column' => '[Solicitante]',
		'search' => true
	),
	'imputed_type' => (object) array(
		'db_column' => 'i.[Tipo]',
		'search' => true
	),
	'unity' => (object) array(
		'db_column' => "uni.Nombre AS 'Unidad'",
		'search' => true
	),
	'fiscalia' => (object) array(
		'db_column' => "f.Nombre AS 'Fiscalia'",
		'search' => true
	),
	'user_name' => (object) array(
		'db_column' => "u.[Nombre] AS 'NombreFcilitador'",
		'search' => true
	),
	'user_ap' => (object) array(
		'db_column' => 'u.[ApellidoPaterno]',
		'search' => true
	),
	'user_am' => (object) array(
		'db_column' => 'u.[ApellidoMaterno]',
		'search' => true
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'g.Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)
);
if($nuc != ''){
	$sql_conditions += ['nuc' => (object) array(
		'db_column' => 'subq.[NUC]',
		'condition' => '=', 
		'value' => "'$nuc'"
	)];
}
if($initial_date != '' && $finish_date != ''){
	$sql_conditions += ['range' => (object) array(
		'db_column' => 'Fecha',
		'condition' => 'between', 
		'value' => "'$initial_date' AND '$finish_date'"
	)];
}

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
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY g.Fecha";
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
				'imputed_gener' => array(
					'name' => 'Sexo',
					'value' => $row['Sexo']
				),
				'imputed_age' => array(
					'name' => 'Edad',
					'value' => $row['Edad']
				),
				'imputed_scholarship' => array(
					'name' => 'Escolaridad',
					'value' => $row['Escolaridad']
				),
				'imputed_ocupation' => array(
					'name' => 'Ocupacion',
					'value' => $row['Ocupacion']
				),
				'imputed_applicant' => array(
					'name' => 'Solicitante',
					'value' => $row['Solicitante']
				),
				'imputed_type' => array(
					'name' => 'Tipo',
					'value' => $row['Tipo']
				),
				'unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'fiscalia' => array(
					'name' => 'Fiscalía',
					'value' => $row['Fiscalia']
				),
				'user' => array(
					'name' => 'Facilitador',
					'value' => $row['NombreFcilitador'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno']
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