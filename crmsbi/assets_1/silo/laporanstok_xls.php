<?
include ("inc_koneksi.php");
$reportexel = $_POST['reportexel'];                
if($reportexel=='report'){
    
    //echo 'tekan data';
    //================================ eksport data ================================
      include('Spreadsheet/Excel/Writer.php');
      $todate=date("Ymd"); 
      $xls =new Spreadsheet_Excel_Writer();
      $titt="LaporanStok_".$todate.".xls";
      $xls->send($titt);
    //======================================================================================================
} 
function showNilaiQTY($nilai){
	if($nilai>0) return number_format($nilai,2,",",".");
	else return '0';
}
$koneksi = new Inc_Koneksi();
$conn = $koneksi->koneksi2();
$cominn = trim($_POST['comin']);
$fromnn = trim($_POST['from']);
$tonn = trim($_POST['to']);
$plantnn = trim($_POST['plant']);
$tgl_fr = date("Y-m")."-01";
$tgl_to = date("Y-m-d");
if($cominn!=''){
	$org = $cominn;
}else{
	$org = "7000";
}
if($fromnn=='' && $tonn==''){
	$fromnn=$tgl_fr; 
	$tonn=$tgl_to;
}
if($plantnn!=''){
	$sqlfil .=" and NMPLAN='$plantnn' ";
}

	list($year,$month,$day)=split("-",$fromnn);
	$tglm=$year.$month.$day;
	list($year1,$month1,$day1)=split("-",$tonn);
	$tgls=$year1.$month1.$day1;

$q = "
select tb1.*,to_char(tb1.CREATE_DATE,'DD-MM-YYYY') as CREATE_DATEF,tb2.NAME as NAMEPLANT from
(
SELECT ORG,NMPLAN,CREATE_DATE,SUM(QTY_ENTRY) AS STOCK FROM ZREPORT_STOCK_SILO 
			WHERE ORG = '".$org."' AND
			CREATE_DATE BETWEEN TO_DATE('".$tglm."', 'YYYYMMDD') AND TO_DATE('".$tgls."', 'YYYYMMDD')
			$sqlfil
GROUP BY ORG,NMPLAN,CREATE_DATE
ORDER BY ORG,NMPLAN,CREATE_DATE
) tb1 left join (
                select KD_PLANT,NAME from ZREPORT_M_PLANT where ORG='".$org."'
                group by KD_PLANT,NAME 
)tb2 on (tb1.NMPLAN=tb2.KD_PLANT)
ORDER BY ORG,NMPLAN,CREATE_DATE ASC
";
$query = oci_parse($conn, $q);
oci_execute($query);$pp=0;
$arr_stock = array();unset($masterpalnt);
while ($dt = @oci_fetch_array($query)) {
	$lv_tgl = $dt['CREATE_DATEF'];
	$lv_plant = $dt['NMPLAN'];
	$masterpalnt[$dt['NMPLAN']]=$dt['NAMEPLANT'];
	$arr_stock[$pp] = $dt;
	$pp++;
}
$total=count($arr_stock);
if($total==0){
	$komen='Data tidak ditemukan';
}
//echo "<pre>";
//print_r($arr_stock);
//echo "</pre>";
//echo "<pre>";
//print_r($masterpalnt);
//echo "</pre>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>    
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Laporan Stok Plant</title>
<?
if($reportexel==''){
?>
	<script src="js/jquery-1.9.1.js"></script>
	<link href="js/datetime/jquery-ui.css" type="text/css" media="all" rel="stylesheet">
	<link href="js/datetime/jquery-ui-timepicker-addon.css" type="text/css" media="all" rel="stylesheet">
	<script src="js/datetime/jquery-ui.min.js" type="text/javascript"></script>
	<script src="js/datetime/jquery-ui-timepicker-addon.js" type="text/javascript"></script>
	<script src="js/datetime/jquery-ui-sliderAccess.js" type="text/javascript"></script>
	<script src="js/datetime/datetime.js" type="text/javascript"></script>
<link href="css/TableCSSCode.css" rel="stylesheet" type="text/css" />
<script>
	$(document).ready(function() {
		
		$( "#from" ).datepicker({
		   dateFormat:'yy-mm-dd'
		});
		$( "#to" ).datepicker({
		  dateFormat:'yy-mm-dd'
		});
		
		
		
		$("#comin").change(function(){ 
					var comin = $("#comin").val(); 
					$.ajax({ 
					url: "getplant.php", 
					data: "com="+comin, 
					cache: false, 
					success: function(msg){ 
					$("#plant").empty();
					$("#plant").html(msg); 
				} 
			})
		});
		$("#comin").change();
		
	});
	</script>
<?}?>
</head>

<body>
<div align="center">
    <table width="999" align="center" class="adminlist">
	<tr>
          <th align="left" colspan="16">
                <span class="style5">&nbsp;Laporan Stok Plant</span>  
           </th>    
      </tr>
  </table>
</div> 
<?
if($reportexel==''){
?>    
<div align="center" style="width:50%;">
<form id="fsimpan" name="fsimpan" method="post" action="<?=$targetVolume;?>">
<table border="0" class="CSSTableGenerator" align="center">  
  <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
        <td ><strong>Organisasi</strong></td>
        <td width="10"><strong>:</strong></td>
        <td width="153" colspan="2">
                    <select name="comin" id="comin">
                        <?
                        $sqlPlant= "select ORG,NAMA_ORG from ZREPORT_M_ORG where delete_mark='0' and org<>'6000'
                                    order by URUTAN ASC";

                        //echo $sqlPlant;
                        $query2= oci_parse($conn, $sqlPlant);
                        oci_execute($query2);
                 
                        while($rowD=oci_fetch_array($query2)){ 
                            $ORGnn=$rowD['ORG'];
                            $NAMA_ORGnn=$rowD['NAMA_ORG'];
							if($org==$ORGnn){
                        ?>
                             <option value='<?=$ORGnn;?>' selected><?=$ORGnn;?>&nbsp;&nbsp;<?=$NAMA_ORGnn;?></option>
                        <?
							}else{
						?>
							<option value='<?=$ORGnn;?>'><?=$ORGnn;?>&nbsp;&nbsp;<?=$NAMA_ORGnn;?></option>
						<?	
							}
                        }
                        ?>
                    </select>&nbsp;*
        </td>
    </tr>   
	<tr>
      <td class="puso"><strong>Plant</strong></td>
      <td class="puso">:</td>
      <td >

				<select name="plant" id="plant">					
				</select>
     </td>
     </tr>
    <tr>
      <td class="puso"><strong>Date</strong></td>
      <td class="puso">:</td>
      <td >
         <input type="text" id="from" name="from" readonly="true" value="<?=$fromnn?>"><label for="to">&nbsp;to&nbsp;</label><input type="text" id="to" name="to" readonly="true" value="<?=$tonn?>">&nbsp;* 
     </td>
     </tr>
     <tr>
                  <td  class="puso">&nbsp;</td>
                  <td  class="puso">&nbsp;</td>
                  <td>
                      <input type="checkbox" name="reportexel" value="report">Report ke Excel 
                  </td>
    </tr>
    <tr>
      <td class="ThemeOfficeMenu">&nbsp;</td>
      <td class="ThemeOfficeMenu">&nbsp;</td>
      <td class="ThemeOfficeMenu" colspan="2">
          <input name="Cari" type="submit" class="button" id="Cari" value="Cari"/>
          <a href="index.php"><input name="back" type="button" class="button" id="back" value="Back"/></a>
      </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
		<td>&nbsp;</td>
        <td colspan="2">&nbsp;</td>
    </tr>
</table>
</form>  
</div>
<br>  
<?}?>
<div align="center" style="width:50%;">
	<table id="test1" align="center" class="CSSTableGenerator" <? if($reportexel!=''){ echo ' border="1" ';} ?> >
	<tbody >
         <tr>
           <td width="34"><div align="center">No.</div></td>
           <td width="107" align="center">Plant</td>
           <td width="107" align="center">Nama Plant</td>
           <td width="107" align="center">Date</td>
           <td width="107" align="center">Stok</td>         	   
		</tr>
<?
if($total>0){
		for($i=0; $i<$total;$i++) {
            $no=$i+1;
            $kei=$i;
            $urutke="urutke".$i;            
        ?>
	<tr>	
        <td align="center"><? echo $no.".";?></td>
        <td align="center"><? echo $arr_stock[$i]['NMPLAN']; ?></td>
        <td align="center"><? echo $arr_stock[$i]['NAMEPLANT']; ?></td>
        <td align="center"><? echo $arr_stock[$i]['CREATE_DATEF']; ?></td>
        <td align="right"><? echo showNilaiQTY($arr_stock[$i]['STOCK']); ?></td>
    </tr>
      <?
      }
	
}else {
?>
        <tr class="row1"><td align="center" colspan="5"><? echo $komen;?></td></tr>
<?
}
?>        
	  </tbody>
  </table>


</body>
</html>
