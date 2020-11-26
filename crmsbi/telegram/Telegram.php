<?php
#@liyantanto
	//include_once('../pc/include/setting.php');
	$dayKemarin=date('Ymd',strtotime('-1 day'));
	$dayNow=date('Ymd',strtotime('0 day'));
	$noAdmin='087750987896';

	$thn = substr($dayKemarin,0,4);
	$bln = substr($dayKemarin,4,2);
	$tgl = sprintf("%02d", substr($dayKemarin,6,2));


	$com = '4000';
	//include 'shipment_penjualan_cek.php';
	if ($com=='7000') {
		$judul = "SEMEN INDONESIA";
		$co = "SG";
		
	} else if ($com=='3000') {
		$judul = "SEMEN PADANG";
		$co = "SP";
	}  else if ($com=='4000') {
		$judul = "SEMEN TONASA";
		$co = "ST";
	}
	
	$dayKemarinIndo = $tgl.'-'.$bln.'-'.$thn;
	# SAP Connection #
	//require_once("sgg/include/connect/SAPDataModule_Connection.php");
	//$sap_con = New SAPDataModule_Connection();
	//$sap = $sap_con->getConnSAP();//getConnSAP_Dev(); 
	#Koneksi###
	$tnsname = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.3.144)(PORT = 1521))
        (CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = pdbsi)))';
    $username 	= 'APPBISD';
	$password 	= 'gresik45smigone1';
	$ora_con 	= oci_connect($username, $password, $tnsname);
	$sap_con 	= $ora_con; 
	//$ora_con = $sap_con->koneksiSD_Dev();
	if(!$ora_con || !$sap_con) { echo "Koneksi oracle gagal";exit; } 
	
	
	#exit;	    
	$zakcode='121-301';
	$curcode='121-302';	
        
	//call fungtion bi
	require_once("fungsi_bi.php");
	$bi = New fungsibi();
	//realisasi kumulatif si
	$realsg = $bi->getRealisasiKumST($ora_con,$com,$dayKemarin);
	exit;
	unset($datatemp);unset($realzakn);unset($realton);$totreal=0;
	$count=0;unset($datatempregion);unset($totdatatemp);
	$datatemp=$realsg['REKAP_REGION'];        
	$totdatatemp=$realsg['REKAP_TOTREGION'];  
	$realzakn=$realsg['REKAP_BUDATZAK'];
	$realton=$realsg['REKAP_BUDATTO'];
	$datatempregion=$realsg['M_REGION'];
	$datatempprov=$realsg['M_PROV'];
	$drealtotprov=$realsg['REKAP_PROV'];
	$count=count($realsg['REKAP_REGION']);


	//target realisasi
	$targetreallsg = $bi->getTargetRealisasisgRKAP($ora_con,$com,$dayKemarin);
	unset($datatarget);unset($totdatatarget);
	$datatarget=$targetreallsg['DATA_TARGET'];        
	$totdatatarget=$targetreallsg['DATA_TOTTARGET']; 
	$totdatatargetprop=$targetreallsg['DATA_TOTTARGETPROP']; 
        $totdatatargetbud=$targetreallsg['DATA_TARGETPROPBUD'];

	//Laporan Per Plant  
	$laporanplant = $bi->getLaporanPlantST($ora_con,$com,$dayKemarin);
	unset($dataplant);unset($plantarr);
	$dataplant=$laporanplant['DATA_PLANT'];
	$plantarr=$laporanplant['NAMA_PLANT'];
	
	//target realisasi per plant
	$targetPlant = $bi->getTargetPlant($ora_con,$com,$dayKemarin);
	unset($dataTcurah);unset($datatargetplant);
	$datatargetplant=$targetPlant['DATA_TARGETPLANT'];
	$dataTcurah=$targetPlant['DATA_PERSNCURAHPLANT'];
	
	
	//echo "<pre>";
	//print_r($datatarget);
	//echo "</pre>";

	if($count>0){
	//realisasi
	$realzak=$realzakn[$dayKemarin];
	$realto=$realton[$dayKemarin];
	//target
	$targetzak=0;$targetcur=0;
	foreach($datatempprov as $km => $val){
		$targetzak +=$totdatatargetbud[$km.$zakcode.$dayKemarin];
		$targetcur +=$totdatatargetbud[$km.$curcode.$dayKemarin];
	}
	$totreal = $realzak + $realto;
	$tottargetharini = $targetzak + $targetcur;
	$persenzak=@($realzak/$targetzak)*100;
	$persencur=@($realto/$targetcur)*100;
	$totpersentkk=@($totreal/$tottargetharini)*100;
	$real = ".:: <b>SEMANGAT PAGI</b> ::. %0A";
	$real .= "<b>REPORT REALISASI ".$co." KEMARIN ".$dayKemarinIndo."</b> %0A %0A";
	$real .= "<b>TARGET = ".$sap_con->getNil2($tottargetharini,0)." TON</b> %0A";
	$real .= "REAL ZAK : ".$sap_con->getNil2($realzak,0)." TON (".$sap_con->getNil2($persenzak,0)."%) %0A";
	$real .= "REAL CURAH : ".$sap_con->getNil2($realto,0)." TON (".$sap_con->getNil2($persencur,0)."%) %0A";
	$real .= "REAL TOTAL = ".$sap_con->getNil2($totreal,0)." TON (".$sap_con->getNil2($totpersentkk,0)."%) %0A";
	$real .= "%0A";
	$real .= "<b>REALISASI PROPINSI (ZAK:CURAH)</b> %0A %0A";
	
		foreach($datatempprov as $km => $val){
			$zakval=$drealtotprov[$km][$zakcode];
			$targetzakval=$totdatatargetbud[$km.$zakcode.$dayKemarin];
			$curval=$drealtotprov[$km][$curcode];
			$targetcurval=$totdatatargetbud[$km.$curcode.$dayKemarin];
			$persentzak=@($zakval/$targetzakval)*100;
			$persentcur=@($curval/$targetcurval)*100;
			if($km==3){$val='JBR DKI BTN';}
			$real .= " <b>".strtoupper($val)."</b> = ".$sap_con->getNil2($zakval,0)." (".$sap_con->getNil2($persentzak,0)."%); ".$sap_con->getNil2($curval,0)."  (".$sap_con->getNil2($persentcur,0)."%) %0A";
		}
	
	if(count($datatargetplant)>0){
		foreach ($dataTcurah as $key => $value) {
			$datatargetplant[$key.'121-302'] = (@($value/100)*$targetcur);
		}
	}
	$real .= "%0A";
	$real .= "<b>REALISASI PLANT (ZAK:CURAH)</b> %0A %0A";
		foreach($plantarr as $km => $val){
			$zakvalplant=@$dataplant[$km][$zakcode];
			$targetzakvalplant=@$datatargetplant[$km.$zakcode];
			$curvalplant=@$dataplant[$km][$curcode];
			$targetcurvalplant=@$datatargetplant[$km.$curcode];
			$persentzakpln=@($zakvalplant/$targetzakvalplant)*100;
			$persentcurplnt=@($curvalplant/$targetcurvalplant)*100;
			if($km=='7608'){$val='GP PEL.GRESIK';}
			if($zakvalplant>0 || $curvalplant>0){
				//$real .= $val." = ".$sap_con->getNil2($zakvalplant,0)." TON (".$sap_con->getNil2($persentzakpln,0)."%); ".$sap_con->getNil2($curvalplant,0)." TON (".$sap_con->getNil2($persentcurplnt,0)."%) %0A";
				$real .= "<b>".strtoupper($val)."</b> = ".$sap_con->getNil2($zakvalplant,0)." TON ; ".$sap_con->getNil2($curvalplant,0)." TON %0A";
			}
		}
	
	$real .= "%0A";
    $real .= "<b>NOTE:</b> %0ALaporan diatas masih dalam tahap evaluasi, mohon masukan jika terdapat kesalahan %0A";
	$real .= "%0APlant yang tidak tampil belum ada rilis %0A";	
	
	//realisasi now
	$realzaknow=$realzakn[$dayNow];
	$realtonow=$realton[$dayNow];
	//target hari ini
	$targetzakni=0;$targetcurni=0;
	foreach($datatempregion as $km => $val){
		$targetzakni +=$datatarget[$dayNow.$km.$zakcode];
		$targetcurni +=$datatarget[$dayNow.$km.$curcode];
	}	
	$targetHariini=$targetzakni+$targetcurni;
	$pencpainnow=@(date("H")/24)*100;
	
	

	$real .= "%0A Demikian, terima kasih %0A SCM TEAM(Admin System)";
	
		
	}
	echo $real;
	
	//exit;
	
	$sap->Close();
	if($count>0){
	//send to telegram
	$wsdl="http://10.15.5.242/tele/Telegram.php?wsdl";
	$idsend=$_GET['id_send'];	
	if($idsend!=''){
		$param['To']=$idsend;
	}else{
		$param['To']='scmReport';
	}
	//$param['To']='Produksi';
	//$param['To']='dev';
	//$param['To']='comdir';
	//$param['To']='085649470988';
	//$param['To']='081335395642';
	$param['Message']=$real;	
	$resultsendtelem = $sap_con->sendTotelegram($wsdl,$param);
	}
	echo "<pre>";
	print_r($resultsendtelem);
	echo "</pre>";
	
	//exit(); 

?>
