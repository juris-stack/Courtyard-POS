<?php
require "fpdf.php";
$db = new PDO('mysql:host=localhost;dbname=pos','root','');

class myPDF extends FPDF{
	function header(){
		$this->Image('logo.png',10,10,-220);
		$this->SetFont('Arial','B',10);
		$this->Cell(75,5,'POINT OF SALE',0,0,'R');
		$this->Ln();
		$this->Cell(140,5,'MONTHLY SALES REPORT',0,0,'C');
		$this->Ln(5);
	}
	function displayTotal($db){
		$this->SetFont('Arial','B',10);
		$stmt = $db->query('SELECT SUM(total_amount) as result FROM transactions WHERE DATE(transaction_date) > CURDATE() - INTERVAL 7 DAY');
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){
			$this->Cell(58,5,'Total :',0,0,'R');
			$this->Cell(30,5,$data->result,0,0,'L');
			$this->Ln(15);

		}
	}
	function headerTable(){
		$this->SetFont('Arial','B',12);
		$this->Cell(25,10,'Invoice #',1,0,'C');
		$this->Cell(50,10,'Product',1,0,'C');
		$this->Cell(30,10,'Description',1,0,'C');
		$this->Cell(20,10,'Price',1,0,'C');
		$this->Cell(20,10,'Qty',1,0,'C');
		$this->Cell(40,10,'Total Amount',1,0,'C');
		$this->Cell(40,10,'Cashier',1,0,'C');
		$this->Cell(50,10,'Transaction Time',1,0,'C');
		$this->Ln();
	}
	function viewTable($db){
		$this->SetFont('Arial','',12);
		date_default_timezone_set('Asia/Manila');
		$date = date('y-m-d');
		$stmt = $db->query('SELECT * FROM sales WHERE DATE(transaction_time) > CURDATE() - INTERVAL 7 DAY'); 
		while($data = $stmt->fetch(PDO::FETCH_OBJ)){
			$this->Cell(25,10,$data->invoice_number,1,0,'C');
			$this->Cell(50,10,$data->purchase_name,1,0,'C');
			$this->Cell(30,10,$data->product_description,1,0,'C');
			$this->Cell(20,10,$data->product_price,1,0,'C');
			$this->Cell(20,10,$data->quantity,1,0,'C');
			$this->Cell(40,10,$data->total_amount,1,0,'C');
			$this->Cell(40,10,$data->cashier,1,0,'C');
			$this->Cell(50,10,$data->transaction_time,1,0,'C');
			$this->Ln();

		}
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('Arial','',8);
		$this->Cell(0,10,'Page'.$this->PageNo().'/{nb}',0,0,'C');
	}

}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->displayTotal($db);
$pdf->headerTable();
$pdf->viewTable($db);
$pdf->Output();

?>