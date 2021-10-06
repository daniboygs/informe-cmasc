<?php

include('../../../../functions/spreadsheets.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
$json_data = json_decode($_POST['data'], true);

$sheet_props = null;

foreach($json_data as $data){

    foreach(array_keys($data) as $metadata){

        $sheet_props = newSheet((object) array(
            'title' => $metadata,
            'sheet_props' => $sheet_props
        ));
        
        
        $sheet_props->sheet = drawTableByConcept((object) array(
            'letters' => $letters,
            'letter_index' => 0,
            'json_data' => $data[$metadata],
            'current_row' => 1,
            'header' => true,
            'sheet_props' => $sheet_props
        ))->sheet;

    }
}



/*$sheet_props = newSheet((object) array(
    'title' => $metadata,
    'sheet_props' => null
));


$sheet_props->sheet = drawTableByConcept((object) array(
    'letters' => $letters,
    'letter_index' => 0,
    'json_data' => $data[$metadata],
    'current_row' => 1,
    'header' => true,
    'sheet_props' => $sheet_props
))->sheet;*/

/*$sheet_props = newSheet((object) array(
    'title' => 'Second page',
    'sheet_props' => $sheet_props
));*/

header('Content-Encoding: UTF-8');
header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=Customers_Export.csv');

$writer = new Xlsx($sheet_props->spreadsheet);
//$writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($sheet_props->sheet_props->spreadsheet);
ob_start();
$writer->save('php://output');
$xlsData = ob_get_contents();
ob_end_clean();

$response =  array(
    'op' => 'ok',
    'file' => "data:application/vnd.ms-excel;base64,".base64_encode($xlsData)
);

die(json_encode($response));


?>