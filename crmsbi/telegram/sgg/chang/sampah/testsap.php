<?php
	include_once('saprfc/sapclasses/sap.php');
    	$sap = new SAPConnection();
    	$sap->Connect("saprfc/sapclasses/logon_data.conf");
	
		if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
		if ($sap->GetStatus() != SAPRFC_OK ) {
		   $sap->PrintStatus();
		   exit;
		}	
		//$fce->Close();
		$sap->Close();	
?>