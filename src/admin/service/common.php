<?php

function formInsertValuesByType($data){
	$values = "";
	$i = 1;

	foreach ($data as $element => $attr) {
		if($attr->value != 'null'){
			if($attr->type != 'number'){
				$values.="'$attr->value'";
			}
			else{
				$values.="$attr->value";
			}
		}
		else{
			$values.="$attr->value";
		}

		if($i < count((array) $data)){
			$values.=",";
		}

		$i++;
	}
	return $values;
}

function formUpdateValuesByType($data){
	$values = "";
	$i = 1;

	foreach ($data as $element => $attr) {
		if($attr->value != 'null'){
			if($attr->type != 'number'){
				$values.="$attr->db_column = '$attr->value'";
			}
			else{
				$values.="$attr->db_column = $attr->value";
			}
		}
		else{
			$values.="$attr->db_column = $attr->value";
		}

		if($i < count((array) $data)){
			$values.=",";
		}

		$i++;
	}
	return $values;
}

function formDBColumns($data){
	$columns = "";
	$i = 1;

	foreach ($data as $element => $attr) {
		if($attr->db_column != ''){
			$columns.="$attr->db_column";
		}

		if($i < count((array) $data)){
			$columns.=",";
		}

		$i++;
	}
	return $columns;
}

function createSection($data, $db_table, $conn, $params, $options){

	$columns = formDBColumns($data);
	$values = formInsertValuesByType($data);

	$sql = "INSERT INTO $db_table
				( $columns )
				VALUES
				( $values )
            SELECT SCOPE_IDENTITY()";

	if($conn){
		$stmt = sqlsrv_query( $conn, $sql);

		sqlsrv_next_result($stmt); 
		sqlsrv_fetch($stmt); 

		$id = sqlsrv_get_field($stmt, 0);

		return array(
            'state' => 'success',
            'data' => array(
                'id' => $id
            )
        );
	}
	else{
		return array(
            'state' => 'fail',
            'data' => null
        );
	}

}

function formSearchDBColumns($data){
	$columns = "";
    $i = 1;
    $search_data = array();
    
    foreach ($data as $element => $attr) {
        if($attr->search){
            array_push($search_data, $attr->db_column);
        }
    }

	foreach ($search_data as $element) {
        
        if($element != ''){
            $columns.="$element";
        }

        if($i < count((array) $search_data)){
            $columns.=",";
        }

		$i++;
	}
	return $columns;
}

function formSearchConditions($data){
    $conditions = "";
    $i = 1;

	foreach ($data as $element => $attr) {
        $conditions.=' '.$attr->db_column.' '.$attr->condition.' '.$attr->value;

        if($i < count((array) $data)){
            $conditions.=" AND ";
        }

        $i++;
    }
    
    if($conditions != ''){
        return 'WHERE'.$conditions;
    }
    else{
        return $conditions;
    }
}

function createMultipleRecords($id, $fields, $data, $db_table, $conn, $params, $options){

	$values = formInsertMultipleValues($data, $id);

	$sql = "INSERT INTO $db_table
				( $fields )
				VALUES
				$values";

	if($conn){
		$stmt = sqlsrv_query( $conn, $sql);

		sqlsrv_next_result($stmt); 
		sqlsrv_fetch($stmt); 

		return array(
            'state' => 'success',
            'data' => array(
                'id' => null
            )
        );
	}
	else{
		return array(
            'state' => 'fail',
            'data' => null
        );
	}

}


function formInsertMultipleValues($data, $id){
	$values = "";
	$i = 1;

	foreach ($data as $element) {
		
		$values.="($element, $id)";

		if($i < count((array) $data)){
			$values.=",";
		}

		$i++;
	}
	return $values;
}

function getRecordsByCondition($attr){

	$sql = "SELECT $attr->columns FROM $attr->db_table WHERE $attr->condition";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$crimes = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			array_push($crimes, $row['Nombre']);

			//$crimes = $crimes.'*'.$row['Nombre'].', ';
			
		}

		$listed_values = "";
		$counted_values = "";
		
		foreach ($crimes as $element) {
			$listed_values.="<li>$element</li>";
		}

		$i = 1;
		foreach ($crimes as $element) {
			if($i < count($crimes)){
				$counted_values.="$i.- $element, ";
			}
			else{
				$counted_values.="$i.- $element.";
			}
			$i++;
			
		}

		//$values = "<ul>$values</ul>";
	
	}
	else{
		$listed_values = null;
		$counted_values = null;
	}

	$return = (object) array(
		'listed_values' => $listed_values,
		'counted_values' => $counted_values
	);

	return $return;


}

function formSearchByMultipleValues($data){
	$values = "";
	$i = 1;

	foreach ($data as $element) {
		
		$values.="$element";

		if($i < count((array) $data)){
			$values.=",";
		}

		$i++;
	}

	return $values;
}

function getListedPeopleRecordsByCondition($attr){

	$sql = "SELECT $attr->columns FROM $attr->db_table WHERE $attr->condition";

    $result = sqlsrv_query( $attr->conn, $sql , $attr->params, $attr->options );

	$row_count = sqlsrv_num_rows( $result );
	
	$people = array();

	if($row_count > 0){

		while( $row = sqlsrv_fetch_array( $result) ) {

			array_push($people, (object) array(
				'name' => $row['Nombre'].' '.$row['ApellidoPaterno'].' '.$row['ApellidoMaterno'],
				'age' => $row['Edad'],
				'gener' => $row['Sexo'],
				'type' => $row['Calidad']
			));

			//$people = $people.'*'.$row['Nombre'].', ';
			
		}

		$listed_values = "";
		$counted_values = "";
		
		foreach ($people as $element) {
			$listed_values.="<li>$element->name "."$element->age años, "."Sexo $element->gener "."($element->type)</li>";
		}

		/*$i = 1;
		foreach ($people as $element) {
			if($i < count($people)){
				$counted_values.="$i.- $element, ";
			}
			else{
				$counted_values.="$i.- $element.";
			}
			$i++;
			
		}*/

		//$values = "<ul>$values</ul>";
	
	}
	else{
		$listed_values = null;
		$counted_values = null;
	}

	$return = (object) array(
		'listed_values' => $listed_values,
		'counted_values' => $counted_values
	);

	return $return;


}

function checkExpectedRequest($attr){

    $validated = true;

    foreach($attr->expected_request as $expected_field => $value){
        if(!isset($_POST[$attr->expected_request[$expected_field]])){
            $validated = false;
        }
    }

    return (object) array(
        'validated' => $validated
    );
}

function convierteFecha($fecha){
	$array_fecha=  explode('-', $fecha,3) ;
	$fechaConvertida=$array_fecha[2].'-'.$array_fecha[1].'-'.$array_fecha[0];
	return $fechaConvertida;
}

function formatRowDate($row_date){

	if($row_date != null)
		$row_date = $row_date->format('d/m/Y');

	return $row_date;	
}

?>