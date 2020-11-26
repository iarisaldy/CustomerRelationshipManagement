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

    $fce = &$sap->NewFunction ("ZFM_ABAP01_LAT02");
    if ($fce == false ) {
       $sap->PrintStatus();
       exit;
    }
	
	//Import
    $fce->GV_MATKL = "";
	$fce->GV_MATNR = "";
	$fce->GV_MAX_ROW = "0";
	
	//Execute Function
    $fce->Call();
	
    if ($fce->GetStatus() == SAPRFC_OK) {
        //Tables
        echo "<table><tr><td>Mat. Group</td><td>Mat. Number</td></tr>";
        $fce->GI_HEADER->Reset();
		//Display Tables
        while ( $fce->GI_HEADER->Next() ){
            echo "<tr><td>".$fce->GI_HEADER->row["MATKL"]."</td><td>".$fce->GI_HEADER->row["MATNR"]."</td></tr>";
		}
        echo "</table>";				
    } else
        $fce->PrintStatus();

	$sap->Close();
?>
</body>
</html>
