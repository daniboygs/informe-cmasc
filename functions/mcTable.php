<?php
	
	//@session_start();
	//require('./libs/fpdf-1.82/fpdf.php');
	
	
	class PDF_MC_Table extends FPDF
	{
		var $widths;
		var $aligns;
		var $fillColors;
		
		function SetWidths($w)
		{
			//Set the array of column widths
			$this->widths=$w;
		}
		
		function SetAligns($a)
		{
			//Set the array of column alignments
			$this->aligns=$a;
		}

		function SetFillColors($fc)
		{
			//Set the array of column alignments
			$this->fillColors=$fc;
		}
		
		function Row($data, $sec){
			
			
			//Calculate the height of the row
			$nb=0;
			for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
			$h=5*$nb;
			//Issue a page break first if needed
			
			$this->CheckPageBreak($h);
			//Draw the cells of the row
			for($i=0;$i<count($data);$i++){

				$w=$this->widths[$i];
				$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
				$fc=isset($this->fillColors[$i]) ? $this->fillColors[$i] : array(255, 255 ,255);

				//Save the current position
				$x=$this->GetX();
				$y=$this->GetY();

				//Draw the border
				$this->Rect($x,$y,$w,$h);

				/*if($sec != 'c'){
					//Fill cell color
					$this->setFillColor($fc[0], $fc[1], $fc[2]);

					//Print the text
					$this->MultiCell($w,5,$data[$i],1,$a,1);
				}
				else{
					//Print the text
					$this->MultiCell($w,5,$data[$i],0,$a);
				}*/
				$this->setFillColor(255, 255, 255);
				//Print the text
				$this->MultiCell($w,5,$data[$i],0,$a);

				//Put the position to the right of the cell
				$this->SetXY($x+$w,$y);
			}
			//Go to the next line
			$this->Ln($h);
			
			
		}

		function Header()
		{
			// Logo
			//$this->Image('assets/img/segob.png', 10, 10, 70);

			//$this->Image('assets/img/lv2020.jpg', 85, 10, 40);

			$this->SetFont('Arial','B',8);

			$this->SetTextColor(182, 137, 82);

			$this->Cell(130, 5, "", "", "", 'C');

			$this->Cell(50, 5, iconv('UTF-8', 'windows-1252', 'UNIDAD DE APOYO AL SISTEMA DE JUSTICIA'), "", "", 'C');

			$this->Ln();

			$this->SetFont('Arial','I',8);

			$this->Cell(130, 5, "", "", "", 'C');

			$this->Cell(50, 5, iconv('UTF-8', 'windows-1252', 'EVALUACIÓN AL SISTEMA DE JUSTICIA'), "", "", 'C');

			$this->SetTextColor(0);

			// Arial bold 15
			$this->SetFont('Arial','B',15);
			// Move to the right
			$this->Cell(80);

			//$this->Cell(380,2, 'Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
			// Line break
			$this->Ln(20);
		}

		function Footer()
		{
			// Position at 1.5 cm from bottom
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			// Text color in gray
			$this->SetTextColor(128);
			// Page number
			$this->Cell(0,10,iconv('UTF-8', 'windows-1252', 'Página ').$this->PageNo(),0,0,'C');
		}
		
		function CheckPageBreak($h){
			//If the height h would cause an overflow, add a new page immediately
			// if($this->GetY()+$h>$this->PageBreakTrigger){
			if($this->GetY()+$h>270){	
				//$this->AddPage($this->CurOrientation,"letter");

				$this->AddPage();
				
				$pdf = new FPDF();
				$pdf->AddPage("letter");
				
				
				$start_x = $pdf->GetX();
				$start_y = $pdf->GetY();
				
				
				/*$this->Image('assets/img/segob.png', 10, 10, 80);
				$this->SetAligns("C");
				$this->SetFont('Arial','',8);
				$this->AliasNbPages();
				$this->Ln();*/
			}
		}
		
		function NbLines($w,$txt)
		{
			//Computes the number of lines a MultiCell of width w will take
			$cw=&$this->CurrentFont['cw'];
			if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
			$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
			$s=str_replace("\r",'',$txt);
			$nb=strlen($s);
			if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
			$sep=-1;
			$i=0;
			$j=0;
			$l=0;
			$nl=1;
			while($i<$nb)
			{
				$c=$s[$i];
				if($c=="\n")
				{
					$i++;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
					continue;
				}
				if($c==' ')
				$sep=$i;
				$l+=$cw[$c];
				if($l>$wmax)
				{
					if($sep==-1)
					{
						if($i==$j)
						$i++;
					}
					else
					$i=$sep+1;
					$sep=-1;
					$j=$i;
					$l=0;
					$nl++;
				}
				else
				$i++;
			}
			return $nl;
		}
	}
?>