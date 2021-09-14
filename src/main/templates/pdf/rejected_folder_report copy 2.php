<?php
require('../../../../libs/fpdf-1.82/fpdf.php');
require('../../../../functions/mcTable.php');
session_start();

//$records = json_decode($_POST['records'], true);

$rejected_folders_pdf_data = $_SESSION['rejected_folders_pdf_data'];

/*$day = 03;
$month = 'Septiembre';
$year = 2021;*/

$day = date("j");
$month = date("n");
$year = date("Y");

$hoy = date("j, n, Y"); 

$array_months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');


//$pdf2 = new FPDF();
$pdf2 = new PDF_MC_Table();
$pdf2->AddPage();

$pdf2->Image('../../../../assets/img/pdf_1.jpg', 15, -5, 183);

$pdf2->SetFont('Arial','',10);

/*$pdf2->SetFont('Arial','B',14);
$pdf2->Ln(6);
$pdf2->Cell(210, 7, iconv('UTF-8', 'windows-1252', '2021 AÑO DE LA INDEPENDENCIA'), "", "", 'C');
*/
$pdf2->Ln(-25);
$pdf2->SetFont('Arial','',5);
$pdf2->Cell(121, 5, "", "", "", 'C');
$pdf2->Cell(50, 5, iconv('UTF-8', 'windows-1252', 'Centro de Mecanismos Alternativos de Solución de Controversias'), "", "", 'L');

$pdf2->Ln(5);
$pdf2->SetFont('Arial','',8);
$pdf2->Cell(121, 5, "", "", "", 'C');
$pdf2->Cell(50, 5, iconv('UTF-8', 'windows-1252', 'Dirección de Acuerdos Reparatorios'), "", "", 'L');

$pdf2->Ln(5);
$pdf2->SetFont('Arial','',8);
$pdf2->Cell(121, 5, "", "", "", 'C');
$pdf2->Cell(50, 5, iconv('UTF-8', 'windows-1252', $rejected_folders_pdf_data->folio), "", "", 'L');

$pdf2->Ln(5);
$pdf2->SetFont('Arial','',8);
$pdf2->Cell(121, 5, "", "", "", 'C');
$pdf2->Cell(50, 5, iconv('UTF-8', 'windows-1252', ''), "", "", 'L');

$pdf2->Ln(5);
$pdf2->SetFont('Arial','',8);
$pdf2->Cell(121, 5, "", "", "", 'C');
$pdf2->Cell(50, 5, iconv('UTF-8', 'windows-1252', 'El que se indica'), "", "", 'L');

$pdf2->Ln(15);
$pdf2->SetFont('Arial','B',8);
$pdf2->Cell(120, 5, "", "", "", 'C');
$pdf2->Cell(45, 5, iconv('UTF-8', 'windows-1252', 'Morelia, Michoacán a '.strval($day).' de '.strval($array_months[$month-1]).' del '.strval($year).''), "", "", 'C');

// Arial bold 15
$pdf2->SetFont('Arial','B',12);


$pdf2->Ln(15);

$pdf2->SetFont('','B','');
$pdf2->Cell(10, 7, "", "", "", 'C');
$pdf2->Cell(20, 7, iconv('UTF-8', 'windows-1252', 'LIC. '.strtoupper($rejected_folders_pdf_data->mp_channeler)), "", "", 'L');

//$pdf2->SetFont('','','');
//$pdf2->MultiCell(150,7,iconv('UTF-8', 'windows-1252', 'Enero - Marzo del '.strval($year)), 'J');

$pdf2->Ln(5);
$pdf2->Cell(10, 7, "", "", "", 'C');
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'AGENTE DEL MINISTERIO PUBLICO:'), "", "", 'L');
$pdf2->Ln(5);
$pdf2->Cell(10, 7, "", "", "", 'C');
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'DE LA UNIDAD DE '.strtoupper($rejected_folders_pdf_data->unity)), "", "", 'L');
$pdf2->Ln(5);
$pdf2->Cell(10, 7, "", "", "", 'C');
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'DE LA FISCALIA DEL ESTADO:'), "", "", 'L');
$pdf2->Ln(5);
$pdf2->Cell(10, 7, "", "", "", 'C');
$pdf2->Cell(35, 7, iconv('UTF-8', 'windows-1252', 'PRESENTE.-'), "", "", 'L');


$pdf2->Ln(20);





$pdf2->SetFont('', '', 12);

switch($rejected_folders_pdf_data->rejected_reason_id){
    case 9:
        set_paragraph($pdf2, 2, $rejected_folders_pdf_data);
        break;
    default:
        set_paragraph($pdf2, 1, $rejected_folders_pdf_data);
}

$pdf2->Ln(10);

set_paragraph($pdf2, 3, $rejected_folders_pdf_data);



$pdf2->SetY(-60);
$pdf2->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'ATENTAMENTE'), 0, 0, 'C');
$pdf2->SetY(-55);
$pdf2->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'LIC. NOE MARTINEZ PONCE'), 0, 0, 'C');
$pdf2->SetY(-50);
$pdf2->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'AGENTE DEL MINISTERIO PUBLICO ADSCRITO'), 0, 0, 'C');
$pdf2->SetY(-45);
$pdf2->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'A LA DIRRECCION DE ACUERDOS REPARATORIOS DEL CENTRO'), 0, 0, 'C');
$pdf2->SetY(-40);
$pdf2->Cell(0, 10, iconv('UTF-8', 'windows-1252', 'DE MECANISMOS ALTERNATIVOS DE SOLUCIÓN DE CONTROVERSÍAS'), 0, 0, 'C');


$pdf2->Output();


function set_paragraph($pdf2, $section, $rejected_folders_pdf_data){

    $pdf2->SetTextColor(0);
    $pdf2->SetFont('', '', 12);

    switch($section){
        case 1:
            $pdf2->SetFont('','');
            $pdf2->Cell(10, 6, "", "", "", 'C');
            $pdf2->MultiCell(170,6,iconv('UTF-8', 'windows-1252', 'Por medio del presente y en atención a su oficio de canalización, se remite la carpeta original de investigación citada en rubro, misma que nos fue enviada para someterse a los medios alternos de solución de controversias. Informo a usted que, una vez analizado el contenido de la presente carpeta, esta no puede ser admitida debido a que '.strval($rejected_folders_pdf_data->rejected_reason).', lo cual no cumple con los requisitos de admisibilidad, lo anterior con fundamento en lo establecido en los artículos 9, 10,11 y 12 de la ley Nacional de Mecanismos Alternativos de Solución de Controversias en materia Penal. Es por eso que este órgano, estima que no es procedente realizar el mecanismo. Lo anterior para los efectos legales que haya lugar.'), 'J');
        break;
        case 2:
            $pdf2->SetFont('','');
            $pdf2->Cell(10, 6, "", "", "", 'C');
            $pdf2->MultiCell(170,6,iconv('UTF-8', 'windows-1252', 'Por medio del presente y en atención a su oficio de canalización, se remite la carpeta original de investigación citada en rubro, misma que nos fue enviada para someterse a los medios alternos de solución de controversias. Informo a usted que, una vez analizado el contenido de la presente carpeta, esta no puede ser admitida debido a que, los presentes hechos NO son susceptibles de resolverse a través de un mecanismo alternativo, ya que no entra en los supuestos por lo establecido en los artículos 186 y 187 del Código Nacional de Procedimientos Penales;. Es por eso que este órgano, estima que no es procedente realizar el mecanismo. Lo anterior para los efectos legales que haya lugar.'), 'J');
        break;
        case 3:
            $pdf2->SetFont('','');
            $pdf2->Cell(10, 6, "", "", "", 'C');
            $pdf2->MultiCell(170,6,iconv('UTF-8', 'windows-1252', 'Sin otro particular, reciba un cordial Saludo, reiterando mi más distinguida consideración.'), 'J');
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