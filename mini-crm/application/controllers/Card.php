<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {

	function __construct(){
		parent::__construct();
        require_once(APPPATH.'libraries/Fpdf/FPDF.php');
    }

    public function create($number, $name){
        $text = $number.';'.$name.';';
        $pdf = new FPDF('P','mm',array(50,73));
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',8);
        $pdf->Image(base_url().'assets/barcode.jpg', 0, 0,50, 73);
        $pdf->SetXY(5, 11);
        $pdf->Cell(9.5,7,str_replace("%20", " ", $name),0,4,'L');
        $pdf->SetXY(5, 19);
        $pdf->Cell(9.5,7,$number,0,4,'L');
        $pdf->Image('http://chart.apis.google.com/chart?cht=qr&chs=500x500&chma=50&chld=H|0&chl='.$text.'&choe=UTF-8.png', 6, 29, 38, 40);
        // $pdf->Image(base_url().'assets/qr/qrcode.png', 6, 29, 38, 40);
        $pdf->Output();
    }
}
