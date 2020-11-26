<html>
<head>
   <title>SAPFunction Class: Get List of Users in SAP-System</title>
</head>
<body>
<h1>SAPFunction Class: Get List of Users in SAP-System</h1>

<form name="form1" method="post" action="">
  <label>Item No from
  <input type="text" name="item1">
  </label>
  <p>
    <label>Item No to
    <input type="text" name="item2">
    </label>
  </p>
  <p>
    <label>
    <input type="submit" name="Submit" value="Submit">
    </label>
</p>
</form>
<p>&nbsp;</p>
<?
    include_once("../sap.php");
	
    $sap = new SAPConnection();
    $sap->Connect("logon_data.conf");
    if ($sap->GetStatus() == SAPRFC_OK ) $sap->Open ();
    if ($sap->GetStatus() != SAPRFC_OK ) {
       $sap->PrintStatus();
       exit;
    }

    $fce = &$sap->NewFunction ("ZFM_HK_MATERIAL_LIST_02");
    if ($fce == false ) {
       $sap->PrintStatus();
       exit;
    }
	
	//Table Add
	$fce->GR_MATERIAL_LIST->row["SIGN"] = "I";
	$fce->GR_MATERIAL_LIST->row["OPTION"] = "BT";
	$fce->GR_MATERIAL_LIST->row["LOW"] = $_POST['item1'];
	$fce->GR_MATERIAL_LIST->row["HIGH"] = $_POST['item2'];;
	$fce->GR_MATERIAL_LIST->Append($fce->GR_MATERIAL_LIST->row);

	//Execute Function
    $fce->Call();
	
    if ($fce->GetStatus() == SAPRFC_OK) {
        //Tables
        echo "<table><tr><td>Kolom1</td><td>Kolom2</td></tr>";
        $fce->GI_MATERIAL_LIST->Reset();
		//Display Tables
        while ( $fce->GI_MATERIAL_LIST->Next() ){
            echo "<tr><td>".$fce->GI_MATERIAL_LIST->row["MATNR"]."</td><td>".$fce->GI_MATERIAL_LIST->row["MAKTX"]."</td></tr>";
		}
        echo "</table>";							
    } else
        $fce->PrintStatus();

	$sap->Close();
?>

</body>
</html>
