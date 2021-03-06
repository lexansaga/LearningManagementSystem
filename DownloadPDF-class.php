<?php
	require_once 'controllers/authController.php';
	require_once 'FPDF/fpdf.php';
	
	$sql = "SELECT * FROM classes";
	$data = mysqli_query($connection, $sql);
	
	//******************** DOWNLOAD PDF BUTTON *******************************
	class PDF extends FPDF
	{
		// Page header
		function Header()
		{
			// Logo
			$this->Image('styles/logo.png',15,10,20);
			// Font
			$this->SetFont('Arial','B',22);
			// Move to the right
			$this->Cell(30);
			// Title
			$this->Cell(30,10,'Educa Academy',0,0);
			// Font
			$this->SetFont('Arial','',10);
			// Move to the right
			$this->Cell(200);
			// SY
			$this->Cell(30,10,'SY : ' .  date("Y"),0,1);
				
			// Font
			$this->SetFont('Arial','',15);
			// Move to the right
			$this->Cell(30);
			// Sub Title
			$this->Cell(30,10,'Class List Record',0,0);
			// Font
			$this->SetFont('Arial','',10);
			// Move to the right
			$this->Cell(200);
			// Admin
			$this->Cell(30,10,'Admin : ' . $_SESSION['username'],0,1);
			// Font
			$this->SetFont('Arial','',10);
			// Move to the right
			$this->Cell(260);
			// Date
			$this->Cell(30,10,'Date : ' . date("F j\, Y"),0,0);
				
			// Line break
			$this->Ln(20);
		}
		// Page footer
		function Footer()
		{
				// Position at 1.5 cm from bottom
				$this->SetY(-15);
				// Arial italic 8
				$this->SetFont('Arial','I',8);
				// Page number
				$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
		}
	}
		
	$pdf = new PDF('L','mm','Legal');
	$pdf->SetFont('Arial','B',10);
	$pdf->AddPage();
	$pdf->Cell(50,10,'Program Code',1,0,'C');
	$pdf->Cell(220,10,'Program Name',1,0,'C');
	$pdf->Cell(0,10,'Reg. Date',1,1,'C');
		
	while($row = mysqli_fetch_assoc($data))
	{
		$pdf->SetFont('Arial','',10);
		$pdf->Cell(50,10,$row['program_code'],1,0,'C');
		$pdf->Cell(220,10,$row['program_name'],1,0,'C');
		$pdf->Cell(0,10,$row['date_created'],1,1,'C');

        $program = $row['program_name'];
        $res =  "SELECT * FROM sections WHERE program='$program'";
	    $result = mysqli_query($connection, $res);
        $classes = array();

        $pdf->Cell(50,10,$row['program_code'] . ' Classes : ',1,0,'C');
        while($row2 = mysqli_fetch_assoc($result))
	    {
            $pdf->Cell(50,10,$row2['class_name'],1,0,'C');
        }
        $pdf->Cell(0,10,'',1,1,'C');
		
	}
	$pdf->Output();
?>