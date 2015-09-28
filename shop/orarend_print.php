<?php
ob_start();
//require_once('inc/boot.php');
require_once('inc/bwSettings.php');
require_once('inc/bwPostget.php');
require_once('inc/bwDatabase.php');

setlocale(LC_TIME, 'hu_HU');

require_once('inc/bwComponent.php');
require_once('inc/bwDataset.php');
require_once('inc/bwLog.php');
require_once('inc/bwStatus.php');
require_once('inc/bwMeta.php');
require_once('inc/bwStatLog.php');

require_once('inc/bwSchedule.php');
require_once('fpdf/fpdf.php');

error_reporting(E_ALL);

class PDF extends FPDF
{
//Load data
function LoadData($schedule, $room)
{
	$data = array();
	
	$min = ($room == 2) ? '15' : '00';
	
	for ($hour=6; $hour<=20; $hour++)
	{
		$row1 = array();
		$row2 = array();
		
		$row1[] = $hour . ':' . $min;
		$row2[] = '';
		
		for ($day=1; $day<=7; $day++)
		{ 
			$row1[] = $schedule->instructor[$schedule->GetClassInstructorId($room, $day, $hour)];
			$row2[] = $schedule->classtype[$schedule->GetClassClassTypeId($room, $day, $hour)];
			if ($room == 2)
			{
				$min = '30';
			}
		}
		
		$data[] = $row1;
		$data[] = $row2;
	}
	
	return $data;
}



//Simple table
function BasicTable($header,$data)
{
    //Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

//Better table
function ImprovedTable($header,$data)
{
    //Column widths
    $w=array(40,45,45,45,45,45,45,45);
    //Header
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Data
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}

//Colored table
function FancyTable($header,$data)
{
    //Colors, line width and bold font
    $this->SetFillColor(150,150,150);
    $this->SetTextColor(255);
    $this->SetDrawColor(0,0,0);
    $this->SetLineWidth(.2);
    $this->SetFont('','B');
    //Header
    $w=array(9,35,35,35,35,35,35,35);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',1);
    $this->Ln();
    //Color and font restoration
    $this->SetFillColor(215,215,215);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Data
    $fill=array(0,0,1,1);
		$rowNum = 0;
    foreach($data as $row)
    {
				foreach($row as $id => $cell)
				{
	        $this->Cell($w[$id],5,$cell,'LR',0,'L',$fill[$rowNum]);
				}
        $this->Ln();
        $rowNum = ($rowNum < 3) ? ($rowNum + 1) : 0;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf=new PDF('L', 'mm', 'A4');

$header = array(
'', 'Hétfõ', 'Kedd', 'Szerda', 'Csütörtök', 'Péntek', 'Szombat', 'Vasárnap');

$label1 = "Érvényes : " . $schedule->GetWeekName() . "-ig";

$disclaimer = 'Kedves Vendégeink! Az órarend és az óratartó oktató változtatásának jogát fenntartjuk! Az emiatt elõforduló esetleges kellemetlenségekért elnézésüket kérjük!
Legfrissebb órarendünkrõl a honlapon tájékozódhat: http://www.cbafitness.hu/orarend.php ';

$pdf->SetAuthor('CBA Fitness & Wellness Line');
$pdf->SetCreator('www.cbafitness.hu órarend PDF-generáló');
$pdf->SetSubject('Órarend');
$pdf->SetTitle('CBA Fitness órarend ' . $schedule->GetWeekName());

$pdf->SetLeftMargin(15);

$data=$pdf->LoadData($schedule, 1);

$pdf->AddPage('L');

$pdf->SetFont('Arial','', 9);

$pdf->Cell(100, 10, "CBA Fitness - Rexona Aerobic terem");
$pdf->Cell(100, 10, $label1);
$pdf->Ln();

$pdf->SetFont('Arial','', 8);

$pdf->FancyTable($header,$data);

$pdf->Ln(5);
$pdf->MultiCell(0, 3, $disclaimer);

$data=$pdf->LoadData($schedule, 2);

$pdf->AddPage('L');

$pdf->SetFont('Arial','', 9);

$pdf->Cell(100, 10, "CBA Fitness - Vitalade aerobic-spinning terem");
$pdf->Cell(100, 10, $label1);
$pdf->Ln();

$pdf->SetFont('Arial','', 8);

$pdf->FancyTable($header,$data);

$pdf->Ln(5);
$pdf->MultiCell(0, 3, $disclaimer);

//header();


$pdf->Output('cbafitness.pdf', 'D');




?>