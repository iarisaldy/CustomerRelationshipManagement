<?php
$user = "MSADMIN";
$pass = "nGUmBEsiwal4N";
$_ora_db_pm_dev ='(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.15.5.96)(PORT = 1521))) (CONNECT_DATA = (SID = PMT)(SERVER = DEDICATED)))';
        
$conn = oci_connect($user, $pass,$_ora_db_pm_dev);

 $queryOracle = oci_parse($conn,"select TBH.SORT,TBH.PNTIDC,TBH.PLANTC,TBH.TEXT,TBX.PNTTEXT,TBX.VALUEDEFAULT,TBX.ONRLT, SYSDATE AS NOW,
										HourTOCHAR((SYSDATE - TBX.ONRLT)*24) AS SEL
										 from
										(SELECT TB1.*,TB2.* FROM (select SORT,PNTID as PNTIDC,LOCATION as PLANTC,TEXT from TEXT_CONFIG WHERE FLAG=1 GROUP BY PNTID,SORT,LOCATION,TEXT) tb1
										left join 
										(select PNTID as PNTIDM,to_char(MAX(ONRLT),'YYYYMMDD HH24:MI:SS') as TIMESET, PLANT AS PLANTM from PLG_EVENT_NEW
											group by PNTID,PLANT) tb2
										ON (tb1.PNTIDC=tb2.PNTIDM and tb1.PLANTC =tb2.PLANTM)
										)TBH
										LEFT JOIN PLG_EVENT_NEW TBX
										ON TBH.PNTIDM = TBX.PNTID AND TBH.TIMESET = to_char(TBX.ONRLT,'YYYYMMDD HH24:MI:SS') AND TBH.PLANTM = TBX.PLANT");
	oci_execute($queryOracle);
	while ($rowID=oci_fetch_array($queryOracle)){
	if($rowID['VALUEDEFAULT'] == "Stop" || $rowID['VALUEDEFAULT'] == "Not Ready"){
	$valueData = "Stop";
	}else if ($rowID['VALUEDEFAULT'] == null || $rowID['VALUEDEFAULT'] == " "){
	$valueData = "null";
	}else{
	$valueData = $rowID['VALUEDEFAULT'];
	}
	$go[$rowID['PLANTC']][$rowID['SORT']]=array(
						$valueData,
						$rowID['SEL']);
						//$rowID['LINEDEFAULT']);
	}
$queryGresik = oci_parse($conn,"SELECT * FROM PLG_SG_SILO WHERE TGL=(Select max(TGL) From PLG_SG_SILO)");
oci_execute($queryGresik);
while ($rowID=oci_fetch_array($queryGresik)){
$go['GRESIK'][$rowID['LOGSIL']]=array($rowID['VALUE']);
}


?>