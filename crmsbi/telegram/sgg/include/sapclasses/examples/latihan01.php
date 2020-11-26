<?
    include_once("../sap.php");
	
    $sap = new SAPConnection();
    $sap->Connect("logon_data.conf");
    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
    if ($sap->GetStatus() != SAPRFC_OK ) {
       $sap->PrintStatus();
       exit;
    }

    $fce = &$sap->NewFunction ("ZFM_TAMBAH_HK");
    if ($fce == false ) {
       $sap->PrintStatus();
       exit;
    }
	
	
	//Import
    $fce->A = "12";
	$fce->B = "50";
	
	//Execute Function
    $fce->Call();
	
    if ($fce->GetStatus() == SAPRFC_OK) {
        //Export
		echo "Hasil = ".$fce->C;
		
    } else
        $fce->PrintStatus();

	$sap->Close();
?>
<html>
<head>
   <title>SAPFunction Class: Get List of Users in SAP-System</title>
</head>
<body>
<h1>SAPFunction Class: Get List of Users in SAP-System</h1>

<form name="tambah">
<label>nilai a
<input type="text" name="a">
</label>
<br>
<label>nilai b
<input type="text" name="b">
</label>
<p>&nbsp;</p>

<label>
<input type="submit" name="Submit" value="Submit">
</label>
</form>

</body>
</html>
