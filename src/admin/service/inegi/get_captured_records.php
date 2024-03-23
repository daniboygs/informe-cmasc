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

$db_table = "[inegi].[General] g

				LEFT JOIN (
					select distinct 
						sg.GeneralID 
					from [inegi].[General] sg 
					INNER JOIN [inegi].[Victima] sv 
					on sg.GeneralID = sv.GeneralID 
					where sg.Fecha between '$initial_date' AND '$finish_date'
				) v

				ON g.GeneralID = v.GeneralID

				LEFT JOIN (
					select distinct 
						sg.GeneralID 
					from [inegi].[General] sg 
					INNER JOIN [inegi].[Imputado] si 
					on sg.GeneralID = si.GeneralID 
					where sg.Fecha between '$initial_date' AND '$finish_date'
				) i

				ON g.GeneralID = i.GeneralID
				LEFT JOIN [inegi].[MASC] m
				ON g.GeneralID = m.GeneralID

				LEFT JOIN (
					select sg.GeneralID , COUNT(sg.GeneralID) as 'CNT'
					from [inegi].[General] sg 
					INNER JOIN [inegi].[Delito] di on sg.GeneralID = di.GeneralID 
					where sg.Fecha between '$initial_date' AND '$finish_date' GROUP BY sg.GeneralID
				) d

				ON g.GeneralID = d.GeneralID

				LEFT JOIN (
					select sg.GeneralID , COUNT(sg.GeneralID) as 'DICNT'
					from [inegi].[General] sg 
					INNER JOIN [delitos].[INEGI] di on sg.GeneralID = di.GeneralID 
					where sg.Fecha between '$initial_date' AND '$finish_date' GROUP BY sg.GeneralID
				) di

				ON g.GeneralID = di.GeneralID

				INNER JOIN Usuario u ON g.UsuarioID = u.UsuarioID
				LEFT JOIN cat.Fiscalia f ON f.FiscaliaID = g.FiscaliaID
				LEFT JOIN cat.Unidad uni ON uni.UnidadID = g.UnidadID";

$data = (object) array(
	'general_id' => (object) array(
		'db_column' => "g.[GeneralID] AS 'id'",
		'search' => true
	),
	'sigi_initial_date' => (object) array(
		'db_column' => 'g.[FechaInicioSigi]',
		'search' => true
	),
	'general_date' => (object) array(
		'db_column' => '[Fecha]',
		'search' => true
	),
	'general_nuc' => (object) array(
		'db_column' => '[NUC]',
		'search' => true
	),
	'general_unity' => (object) array(
		'db_column' => "uni.[Nombre] AS 'Unidad'",
		'search' => true
	),
	'general_attended' => (object) array(
		'db_column' => '[Atendidos]',
		'search' => true
	),
	'victim' => (object) array(
		'db_column' => "v.GeneralID AS 'TVictima'",
		'search' => true
	),
	'imputed' => (object) array(
		'db_column' => "i.GeneralID AS 'TImputado'",
		'search' => true
	),
	'crime' => (object) array(
		'db_column' => "d.CNT AS 'CDelito'",
		'search' => true
	),
	'crime_inegi' => (object) array(
		'db_column' => "di.DICNT AS 'CDelitoInegi'",
		'search' => true
	),
	'masc' => (object) array(
		'db_column' => "m.MASCID AS 'TMASC'",
		'search' => true
	),
	'general_recieved_id' => (object) array(
		'db_column' => "g.[CarpetaRecibidaID] AS 'CR_ID'",
		'search' => true
	),
	'general_agreement_id' => (object) array(
		'db_column' => "g.[AcuerdoCelebradoID] AS 'AC_ID'",
		'search' => true
	),
	'user' => (object) array(
		'db_column' => 'u.[UsuarioID]',
		'search' => false
	),
	'user_name' => (object) array(
		'db_column' => 'u.[Nombre]',
		'search' => true
	),
	'user_ps' => (object) array(
		'db_column' => 'u.[ApellidoPaterno]',
		'search' => true
	),
	'user_ms' => (object) array(
		'db_column' => 'u.[ApellidoMaterno]',
		'search' => true
	),
	'fiscalia' => (object) array(
		'db_column' => "f.[Nombre] AS 'Fiscalia'",
		'search' => true
	)
);

$sql_conditions = (object) array(
	'range' => (object) array(
		'db_column' => 'Fecha',
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
	$sql = "SELECT $columns FROM $attr->db_table $conditions ORDER BY Fecha";
    $result = sqlsrv_query($attr->conn, $sql , $attr->params, $attr->options);
	$row_count = sqlsrv_num_rows($result);
	$return = array();

	if($row_count > 0){

		while($row = sqlsrv_fetch_array($result)){

			array_push($return, array(
				'general_id' => array(
					'name' => 'ID',
					'value' => $row['id']
				),
				'sigi_initial_date' => array(
					'name' => 'FechaSigi',
					'value' => formatRowDate($row['FechaInicioSigi'])
				),
				'general_date' => array(
					'name' => 'Fecha',
					'value' => formatRowDate($row['Fecha'])
				),
				'general_crime' => array(
					'name' => 'Delito',
					'value' => getHTMLListCrimesByGeneralId(
						(object) array(
							'general_id' => $row['id'],
							'crimes' => $attr->crimes_by_general_id
						)
					)->listed_values
				),
				'general_nuc' => array(
					'name' => 'NUC',
					'value' => $row['NUC']
				),
				'general_unity' => array(
					'name' => 'Unidad',
					'value' => $row['Unidad']
				),
				'general_attended' => array(
					'name' => 'Atendidos',
					'value' => $row['Atendidos']
				),
				'victim' => array(
					'name' => 'Víctima',
					'value' => $row['TVictima']
				),
				'imputed' => array(
					'name' => 'Imputado',
					'value' => $row['TImputado']
				),
				'crime' => array(
					'name' => 'Delito',
					'value' => $row['CDelito']
				),
				'masc' => array(
					'name' => 'MASC',
					'value' => $row['TMASC']
				),
				'crime_inegi' => array(
					'name' => 'Delito Inegi',
					'value' => $row['CDelitoInegi']
				),
				'general_recieved_id' => array(
					'name' => 'Recibida',
					'value' => $row['CR_ID']
				),
				'general_agreement_id' => array(
					'name' => 'Acuerdo',
					'value' => $row['AC_ID']
				),
				'user' => array(
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