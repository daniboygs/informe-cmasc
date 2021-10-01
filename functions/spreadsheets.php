<?php
header('Content-Type: text/html; charset=utf-8'); 

require '../../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

function newSheet($attr){

    if($attr->sheet_props == null){
        $spreadsheet = new Spreadsheet();
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $sheet = $spreadsheet->getActiveSheet()->setTitle($attr->title);

        $return = (object) array(
            'spreadsheet' => $spreadsheet,
            'sheet' => $sheet,
            'sheet_index' => 0,
            'drawing' => $drawing
        );
    }
    else{
        $attr->sheet_props->spreadsheet->createSheet();
        $attr->sheet_props->spreadsheet->setActiveSheetIndex($attr->sheet_props->sheet_index+1);
        $attr->sheet_props->sheet = $attr->sheet_props->spreadsheet->getActiveSheet()->setTitle($attr->title);

        $return = (object) array(
            'spreadsheet' => $attr->sheet_props->spreadsheet,
            'sheet' => $attr->sheet_props->sheet,
            'sheet_index' => $attr->sheet_props->sheet_index+1,
            'drawing' => $attr->sheet_props->drawing
        );
    }

    return $return;
}

function drawTableByConcept($attr){

    if($attr->header){
        $attr->current_row = drawTableHeaderByArrayKeys((object) array(
            'letters' => $attr->letters,
            'letter_index' => $attr->letter_index,
            'json_data' => $attr->json_data,
            'current_row' => $attr->current_row,
            'sheet_props' => $attr->sheet_props
        ))->current_row;
    }

    $initial_letter_index = $attr->letter_index;

    foreach($attr->json_data as $data){

        foreach(array_keys($data) as $metadata){

            if(isset($data[$metadata]['date'])){
                $attr->sheet_props->sheet->setCellValue($attr->letters[$attr->letter_index].''.$attr->current_row, explode(' ', $data[$metadata]['date'] )[0]);
            }
            else{
                $attr->sheet_props->sheet->setCellValue($attr->letters[$attr->letter_index].''.$attr->current_row, $data[$metadata]);
            }

            $attr->letter_index++;

        }

        $attr->letter_index = $initial_letter_index;
        $attr->current_row++;
    }

    return (object) array(
        'sheet' => $attr->sheet_props->sheet,
        'current_row' => $attr->current_row
    );
}

function drawTableHeaderByArrayKeys($attr){
    foreach($attr->json_data as $data){
        foreach(array_keys($data) as $metadata){
            $attr->sheet_props->sheet->setCellValue($attr->letters[$attr->letter_index].''.$attr->current_row, $metadata);
            $attr->letter_index++;
        }
        break;
    }

    return (object) array(
        'sheet' => $attr->sheet_props->sheet,
        'current_row' => $attr->current_row+1
    );
}

function getArrayLettersByArrayKeys($attr){

    $main_letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
    $count_keys = 0;
    $letters = array();
    $depurated_letters = array();
    $current_letter = '';

    foreach($attr->json_data as $data){
        foreach(array_keys($data) as $metadata){
            $count_keys++;
        }
        break;
    }

    $letters = $main_letters;

    if($count_keys < count($main_letters)){
        
        foreach($main_letters as $first_letter){

            foreach($main_letters as $second_letter){
                array_push($letters, $first_letter.''.$second_letter);
            }
        }
    }

    $i = 0;

    foreach($letters as $letter){
        if($i < $count_keys){
            array_push($depurated_letters, $letter);
        }
        else{
            break;
        }
        $i++;
    }

    return (object) array(
        'letters' => $depurated_letters
    );
}


?>