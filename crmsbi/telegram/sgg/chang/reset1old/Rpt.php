<?php
//PDF USING MULTIPLE PAGES
//CREATED BY: Carlos Vasquez S.
//E-MAIL: cvasquez@cvs.cl
//CVS TECNOLOGIA E INNOVACION
//SANTIAGO, CHILE

//require('fpdf.php');
require_once("../fpdf17/fpdf.php");

//Connect to your database
//include("conectmysql.php");

//Create new pdf file
$pdf=new FPDF();

//Disable automatic page break
$pdf->SetAutoPageBreak(false);

//Add first page
$pdf->AddPage();

//set initial y axis position per page
$y_axis_initial = 20;

//print column titles
$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','B',16);

$pdf->SetY($y_axis_initial);
$pdf->SetX(24);
$pdf->Cell(153,1,'LAPORAN PERUBAHAN PASSWORD USER',0,0,'L',0);
$y_axis_initial = 20;
$pdf->SetY($y_axis_initial);
$pdf->SetX(24);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(133,10,'TANGGAL : '.date('d-m-Y'),0,0,'L',0);

$pdf->SetFont('Arial','B',12);
$y_axis_initial = 35;
$pdf->SetY($y_axis_initial);
$pdf->SetX(25);
$pdf->Cell(10,10,'No.',1,0,'L',1);
$pdf->Cell(60,10,'NAMA USER',1,0,'L',1);
$pdf->Cell(30,10,'USER LOGIN',1,0,'L',1);
$pdf->Cell(40,10,'TGL. TRANSAKSI',1,0,'L',1);
$pdf->Cell(20,10,'JAM',1,0,'L',1);

$y_axis = $y_axis + $row_height;

//Select the Products you want to show in your PDF file
mysql_connect("localhost","sapsp","sapsp");
mysql_select_db("sapsp");
$cmd="select a.sapsp_user_nama, a.sapsp_user_login, b.sapsp_trans_tgl, b.sapsp_trans_jam from sapsp_user a,sapsp_trans b where a.sapsp_user_id = b.id_sapsp_user order by a.sapsp_user_nama, b.sapsp_trans_tgl, b.sapsp_trans_jam";
$exe=mysql_query($cmd);

//initialize counter
$i = 0;

//Set maximum rows per page
$max = 36;

//Set Row Height
$row_height = 6;
$codes = 1; //untuk halaman
$y_axis = 46; //untuk loop data pertama
$bdg = "pembanding"; //pembanding nilai nama
$hal = 1;
while($row = mysql_fetch_array($exe))
{
	//If the current row is the last one, create new page and print column title
	if ($i == $max)
	{
		//$y_axis_initial = $y_axis;
		$y_axis_initial = $hal * 260;
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(25);
		
		$halaman = "Hal. ".$hal;
		$pdf->Cell(160,30,$halaman,0,0,'R',0);
		
		$pdf->AddPage();
		//print column titles for the current page
		$y_axis_initial = 35;
		$y_axis= 36;
		$pdf->SetY($y_axis_initial);
		$pdf->SetX(25);
		
		$pdf->Cell(10,6,'No.',1,0,'L',1);
		$pdf->Cell(60,6,'NAMA USER',1,0,'L',1);
		$pdf->Cell(30,6,'USER LOGIN',1,0,'L',1);
		$pdf->Cell(40,6,'TGL. TRANSAKSI',1,0,'L',1);
		$pdf->Cell(20,6,'JAM',1,0,'L',1);
		//Go to next row
		$y_axis = $y_axis + $row_height;
		
		//Set $i variable to 0 (first row)
		$i = 0;
		
		//penambahan halaman
		$halaman+=1;
	}

	$code = $codes.'.';
	$name = $row['sapsp_user_nama'];
	$logi = $row['sapsp_user_login'];
	$tgla = $row['sapsp_trans_tgl'];
	$pchs = explode("-",$tgla);
	$tgls = $pchs[2]."-".$pchs[1]."-".$pchs[0];
	//$tgls = $row['sapsp_trans_tgl'];
	$jams = $row['sapsp_trans_jam'];
	
	$pdf->SetY($y_axis);
	$pdf->SetX(25);
	
	if ($bdg <> $name)
	{
		$pdf->Cell(10,6,$code,1,0,'L',1);
		$pdf->Cell(60,6,$name,1,0,'L',1);
		$pdf->Cell(30,6,$logi,1,0,'L',1);
		$bdg = $name;
		$codes+=1;
	}
	else	
	{
		$pdf->Cell(10,6,"",1,0,'L',1);
		$pdf->Cell(60,6,"",1,0,'L',1);
		$pdf->Cell(30,6,"",1,0,'L',1);
	}
	$pdf->Cell(40,6,$tgls,1,0,'R',1);
	$pdf->Cell(20,6,$jams,1,0,'R',1);
	
	//Go to next row
	$y_axis = $y_axis + $row_height;
	$i = $i + 1;
}

//mysql_close($link);
mysql_close();

$y_axis_initial = $hal * 260;
$pdf->SetY($y_axis_initial);
$pdf->SetX(25);
$hal+=1;		
$halaman = "Hal. ".$hal;
$pdf->Cell(160,30,$halaman,0,0,'R',0);

//Send file
$pdf->Output();
?>