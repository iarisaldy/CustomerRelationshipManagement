<?php
/*
require('../fpdf17/mysql_table.php');
class PDF extends PDF_MySQL_Table
{
function Header()
{
    //Title
    $this->SetFont('Arial','',18);
    $this->Cell(0,6,'Report Change User',0,1,'C');
    $this->Ln(10);
    //Ensure table header is output
    parent::Header();
}
}

//Connect to database
mysql_connect("localhost","sapsp","sapsp");
mysql_select_db("sapsp");
//$cmd="select a.sapsp_user_nama, b.sapsp_trans_tgl, b.sapsp_trans_jam from sapsp_user a,sapsp_trans b where a.sapsp_user_id = b.id_sapsp_user;"

$pdf=new PDF();
$pdf->AddPage();
//First table: put all columns automatically

$pdf->Table('select a.sapsp_user_nama as "Nama User", b.sapsp_trans_tgl as "Tgl. Transaksi", b.sapsp_trans_jam as "Jam Transaksi" from sapsp_user a,sapsp_trans b where a.sapsp_user_id = b.id_sapsp_user');
$pdf->AddPage();
//Second table: specify 3 columns
//$pdf->AddCol('Nama',20,'','C');
//$pdf->AddCol('Tgl',40,'Country');
//$pdf->AddCol('Jam',40,'Pop (2001)','R');
//$prop=array('HeaderColor'=>array(255,150,100),
//            'color1'=>array(210,245,255),
//            'color2'=>array(255,255,210),
//            'padding'=>2);
//$pdf->Table('select sapsp_trans_tgl,sapsp_trans_jam from sapsp_trans',$prop);
$pdf->Output();
*/

/*
require('../fpdf17/fpdf.php');
//require_once("../fpdf17/fpdf.php");
//Connect to your database
//include("conectmysql.php");

//Select the Products you want to show in your PDF file
mysql_connect("localhost","sapsp","sapsp");
mysql_select_db("sapsp");
$cmd="select a.sapsp_user_nama, b.sapsp_trans_tgl, b.sapsp_trans_jam from sapsp_user a,sapsp_trans b where a.sapsp_user_id = b.id_sapsp_user;";
$exe=mysql_query($cmd);
//$i=1;
//while ($data=mysql_fetch_array($exe)){

//$result=mysql_query("select Code,Name,Price from Products ORDER BY Code",$link);
//$number_of_products = mysql_numrows($result);

//Initialize the 3 columns and the total
$column_code = "";
$column_name = "";
$column_price = "";
$total = 0;

//For each row, add the field to the corresponding column
while($row = mysql_fetch_array($exe))
{
    $code = $row["sapsp_user_nama"];
	$name =  $row["sapsp_trans_tgl"];
	$price_to_show =  $row["sapsp_trans_jam"];
	
    //$name = substr($row["Name"],0,20);
    //$real_price = $row["Price"];
    //$price_to_show = number_format($row["Price"],',','.','.');

    $column_code = $column_code.$code."\n";
    $column_name = $column_name.$name."\n";
    $column_price = $column_price.$price_to_show."\n";

    //Sum all the Prices (TOTAL)
    //$total = $total+$real_price;
}
mysql_close();

//Convert the Total Price to a number with (.) for thousands, and (,) for decimals.
$total = number_format($total,',','.','.');

//Create a new PDF file
$pdf=new FPDF();
$pdf->AddPage();

//Fields Name position
$Y_Fields_Name_position = 20;
//Table position, under Fields Name
$Y_Table_Position = 26;

//First create each Field Name
//Gray color filling each Field Name box
$pdf->SetFillColor(232,232,232);
//Bold Font for Field Name
$pdf->SetFont('Arial','B',12);
$pdf->SetY($Y_Fields_Name_position);
$pdf->SetX(45);
$pdf->Cell(20,6,'NAMA',1,0,'L',1);
$pdf->SetX(65);
$pdf->Cell(100,6,'TGL',1,0,'L',1);
$pdf->SetX(135);
$pdf->Cell(30,6,'JAM',1,0,'R',1);
$pdf->Ln();

//Now show the 3 columns
$pdf->SetFont('Arial','',12);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(45);
$pdf->MultiCell(20,6,$column_code,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(65);
$pdf->MultiCell(100,6,$column_name,1);
$pdf->SetY($Y_Table_Position);
$pdf->SetX(135);
$pdf->MultiCell(30,6,$columna_price,1,'R');
$pdf->SetX(135);
$pdf->MultiCell(30,6,'$ '.$total,1,'R');

//Create lines (boxes) for each ROW (Product)
//If you don't use the following code, you don't create the lines separating each row
$i = 0;
$pdf->SetY($Y_Table_Position);
while ($i < $number_of_products)
{
    $pdf->SetX(45);
    $pdf->MultiCell(120,6,'',1);
    $i = $i +1;
}

$pdf->Output();
*/

require_once("../fpdf17/fpdf.php");

//require_once("../fpdf17/html_table.php");

$pdf=new FPDF();
$pdf->AddPage();
$pdf->setFont("arial","b",10);
mysql_connect("localhost","sapsp","sapsp");
mysql_select_db("sapsp");
$cmd="select a.sapsp_user_nama, b.sapsp_trans_tgl, b.sapsp_trans_jam from sapsp_user a,sapsp_trans b where a.sapsp_user_id = b.id_sapsp_user;";
$exe=mysql_query($cmd);
$i=1;
$tst = "coba";
$pdf->SetXY(10,10); 
$pdf->Cell(60,06,"NAMA USER",0,0,'L'); 
$pdf->SetXY(70,10); 
$pdf->Cell(40,06,"TGL. TRANSAKSI",0,0,'L'); 
$pdf->SetXY(110,10); 
$pdf->Cell(40,06,"JAM TRANSAKSI",0,0,'L'); 
$pdf->ln(5);
while ($data=mysql_fetch_array($exe)){
$pdf->ln(5);
$pdf->setFont("arial","",10);
if ($tst <> $data["sapsp_user_nama"])
{
	$pdf->setFont("arial","b",10);
	$pdf->Cell(60,10,$data["sapsp_user_nama"],0);
	//$pdf->SetXY(10,20); 
	//$pdf->Cell(60,21,$data["sapsp_user_nama"],1,1,'L'); 
	
	//$pdf->write(10,$data["sapsp_user_nama"]);
	$tst=$data["sapsp_user_nama"];
}
else	
{
	$pdf->Cell(60,10,"",0);
}
$pdf->setFont("arial","",10);
$pdf->Cell(40,10,$data["sapsp_trans_tgl"],0);
$pdf->Cell(40,10,$data["sapsp_trans_jam"],0);
//$i+=1;
}

$pdf->Output();

/*

$htmlTable='
<TABLE>
<TR>
<TD>No.</TD>
<TD>User ID</TD>
<TD>Nama User</TD>
<TD>Tgl. Transaksi</TD>
<TD>Jam Transaksi</TD>
</TR>



</TABLE>'
;

$pdf=new PDF_HTML_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
$pdf->WriteHTML("Start of the HTML table.<BR>$htmlTable<BR>End of the table.");
$pdf->Output();
*/

?>
