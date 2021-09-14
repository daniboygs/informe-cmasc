<?php
require('../../../../libs/fpdf-1.82/fpdf.php');
require('../../../../functions/mcTable.php');
session_start();

//$records = json_decode($_POST['records'], true);

$rejected_folders_pdf_data = $_SESSION['rejected_folders_pdf_data'];

$day = 03;
$month = 'Septiembre';
$year = 2021;


//$pdf2 = new FPDF();
$pdf2 = new PDF_MC_Table();
$pdf2->AddPage();

$pdf2->Image('../../../../assets/img/pdf_1.jpg', 15, 0, 183);

$pdf2->SetFont('Arial','',10);

/*$pdf2->SetFont('Arial','B',14);
$pdf2->Ln(6);
$pdf2->Cell(210, 7, iconv('UTF-8', 'windows-1252', '2021 AÑO DE LA INDEPENDENCIA'), "", "", 'C');
*/
$pdf2->Ln();
$pdf2->SetFont('Arial','',10);

$pdf2->SetFont('Arial','B',8);

$pdf2->Cell(130, 10, "", "", "", 'C');

$pdf2->Ln(20);

$pdf2->Cell(120, 5, "", "", "", 'C');
$pdf2->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Morelia, Michoacán a '.strval($day).' de '.strval($month).' del '.strval($year).''), "", "", 'C');

// Arial bold 15
$pdf2->SetFont('Arial','B',12);


$pdf2->Ln(10);

$pdf2->SetFont('','B','');
$pdf2->Cell(20, 7, iconv('UTF-8', 'windows-1252', 'LIC._________________________________'), "", "", 'L');

//$pdf2->SetFont('','','');
//$pdf2->MultiCell(150,7,iconv('UTF-8', 'windows-1252', 'Enero - Marzo del '.strval($year)), 'J');

$pdf2->Ln(5);
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'AGENTE DEL MINISTERIO PUBLICO:'), "", "", 'L');
$pdf2->Ln(5);
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'DE LA UNIDAD DE_____________________'), "", "", 'L');
$pdf2->Ln(5);
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'DE LA FISCALIA DEL ESTADO:'), "", "", 'L');
$pdf2->Ln(5);
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'PRESENTE.-'), "", "", 'L');
$pdf2->Ln(20);


$pdf2->SetFont('', '', 12);

set_paragraph($pdf2, 1, $year);

//set_sign_field($pdf2, $user, $position, $involved_people);
    
$pdf2->Output();


function set_paragraph($pdf2, $section, $year){

    $pdf2->SetTextColor(0);
    $pdf2->SetFont('', '', 12);

    switch($section){
        case 1:
            $pdf2->SetFont('','');
            $pdf2->MultiCell(175,6,iconv('UTF-8', 'windows-1252', 'Por medio del presente y en atención a su oficio de canalización, se remite la carpeta original de investigación citada en rubro, misma que nos fue enviada para someterse a los medios alternos de solución de controversias. Informo a usted que una vez analizado el contenido de la presente carpeta, los presentes hechos  '.strval($year).'.'), 'J');
        break;
        case 2:
            $pdf2->SetFont('','B');
            $pdf2->Cell(10, 5, "2.", "", "", 'C');
            $pdf2->SetFont('','');
            $pdf2->MultiCell(180,6,iconv('UTF-8', 'windows-1252', 'Número de carpetas de investigación iniciadas durante el '.strval($year).' con motivó de las denuncias, querellas u otros requisitos equivalentes que se recibieron en su unidad en ese mismo año.'), 'J');

            $pdf2->Ln();

            $pdf2->Cell(10, 5, "", "", "", 'C');
            $pdf2->MultiCell(175,6,iconv('UTF-8', 'windows-1252', 'Carpetas de investigación se iniciaron en el '.strval($year).' correspondientes a denuncias, querellas u otros requisitos equivalentes recibidos en '.strval($year-1).'.'), 'J');

            $pdf2->Ln();
        break;
    }
}

function set_counted_paragraph($pdf2, $section, $year){

    $pdf2->SetTextColor(0);
    $pdf2->SetFont('', '', 12);

    switch($section){
        case 1:
            $pdf2->SetFont('','B');
            $pdf2->Cell(10, 5, "1.", "", "", 'C');
            $pdf2->SetFont('','');
            $pdf2->MultiCell(175,6,iconv('UTF-8', 'windows-1252', 'Por medio del presente y en atención a su oficio de canalización, se remite la carpeta original de investigación citada en rubro, misma que nos fue enviada para someterse a los medios alternos de solución de controversias. Informo a usted que una vez analizado el contenido de la presente carpeta, los presentes hechos  '.strval($year).'.'), 'J');
        break;
        case 2:
            $pdf2->SetFont('','B');
            $pdf2->Cell(10, 5, "2.", "", "", 'C');
            $pdf2->SetFont('','');
            $pdf2->MultiCell(175,6,iconv('UTF-8', 'windows-1252', 'Número de carpetas de investigación iniciadas durante el '.strval($year).' con motivó de las denuncias, querellas u otros requisitos equivalentes que se recibieron en su unidad en ese mismo año.'), 'J');

            $pdf2->Ln();

            $pdf2->Cell(10, 5, "", "", "", 'C');
            $pdf2->MultiCell(175,6,iconv('UTF-8', 'windows-1252', 'Carpetas de investigación se iniciaron en el '.strval($year).' correspondientes a denuncias, querellas u otros requisitos equivalentes recibidos en '.strval($year-1).'.'), 'J');

            $pdf2->Ln();
        break;
    }
}

function set_sign_field($pdf2, $user, $position, $involved_people){

    if(isset($involved_people['third_person'])){
        $pdf2->Ln(-30);
    }
    
    $pdf2->Ln(5);

    $pdf2->Cell(70, 70, iconv('UTF-8', 'windows-1252', 'Elaboró'), "", "", 'C');
    $pdf2->Cell(170, 70, iconv('UTF-8', 'windows-1252', 'Validó'), "", "", 'C');
    $pdf2->Ln(15);
    $pdf2->Cell(70, 70, iconv('UTF-8', 'windows-1252', $involved_people['elaborated_by']['name']), "", "", 'C');
    $pdf2->Cell(170, 70, iconv('UTF-8', 'windows-1252',  $involved_people['validated_by']['name']), "", "", 'C');
    $pdf2->Ln(1);
    //$pdf2->Cell(70, 80, iconv('UTF-8', 'windows-1252', $involved_people['elaborated_by']['position']), "", "", 'C');
    //$pdf2->Cell(170, 80, iconv('UTF-8', 'windows-1252', $involved_people['validated_by']['position']), "", "", 'C');

    if(strlen($involved_people['validated_by']['position']) > 51){

        $pdf2->Ln(40);
        $pdf2->Cell(80, 6, iconv('UTF-8', 'windows-1252', $involved_people['elaborated_by']['position']), "", "", 'C');
        $pdf2->Cell(25, 6, '', "", "", 'C');
        $pdf2->MultiCell(95,6,iconv('UTF-8', 'windows-1252', $involved_people['validated_by']['position']), 0, 'C');

    }
    else{
        $pdf2->Cell(70, 80, iconv('UTF-8', 'windows-1252', $involved_people['elaborated_by']['position']), "", "", 'C');
        $pdf2->Cell(170, 80, iconv('UTF-8', 'windows-1252', $involved_people['validated_by']['position']), "", "", 'C');
    }

    if(isset($involved_people['third_person'])){
        $pdf2->Ln(-20);

        $pdf2->Cell(180, 80, iconv('UTF-8', 'windows-1252', $involved_people['third_person']['function']), "", "", 'C');

        $pdf2->Ln(8);

        $pdf2->Cell(180, 80, iconv('UTF-8', 'windows-1252', $involved_people['third_person']['name']), "", "", 'C');
        $pdf2->Ln(5);
        $pdf2->Cell(180, 80, iconv('UTF-8', 'windows-1252', $involved_people['third_person']['position']), "", "", 'C');
    }

}


function footer($pdf2)
{
    // Go to 1.5 cm from bottom
    $pdf2->SetY(-15);
    // Select Arial italic 8
    $pdf2->SetFont('Arial','I',8);
    // Print current and total page numbers
    $pdf2->Cell(0,10,'Page '.$pdf2->PageNo().'/{nb}',0,0,'C');
}

?>