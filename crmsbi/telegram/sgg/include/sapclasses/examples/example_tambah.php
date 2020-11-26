<html>
<head>
   <title>SAPFunction Class: Get List of Users in SAP-System</title>
</head>
<body>
<h1>SAPFunction Class: Get List of Users in SAP-System</h1>
<?
    include_once("../sap.php");
	
    $sap = new SAPConnection();
    $sap->Connect("logon_data.conf");
    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
    if ($sap->GetStatus() != SAPRFC_OK ) {
       $sap->PrintStatus();
       exit;
    }

    $fce = &$sap->NewFunction ("zfm_abap01_lat01");
    if ($fce == false ) {
       $sap->PrintStatus();
       exit;
    }

    $fce->FU_A = "1";
	$fce->FU_B = "2";
	
    $fce->Call();
    // $fce->Debug();

    if ($fce->GetStatus() == SAPRFC_OK) {
        echo "<table><tr><td>SAP-Name</td><td>User-Number</td></tr>";
        echo $fce->FU_A.'+'.$fce->FU_B.' = '.$fce->FC_HASIL;
    } else
        $fce->PrintStatus();

	$sap->Close();
?>
</body>
</html>
