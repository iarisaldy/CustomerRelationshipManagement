<?php
ob_start();
session_start();
ini_set("memory_limit","80M");
?>
<title>Reset Password : Entry ID</title>
</head>
<?php
include "../class/DbC.class.php";
$DBc = new DBc;
$DBc->browser();
$nil=$DBc->nil;

if ($nil == 3){
	$sise=34;
}
elseif ($nil == 4){
	$sise=37;
}
elseif ($nil == 1){
	$sise=38;
}

$wrn = "#ffffff" ;$wrn1 = "#ffffff" ;$wrn3 = "#ffffff";

if (!empty($_GET['rtn']))
{
if ( $_GET['rtn'] == 3 )
	{
	$cpt = "CAPTCHA SALAH !!!"; 
	$wrn1 = "#FF0000";
	$vKirim = $_SESSION['vKirim'];
	unset($_SESSION['vKirim']);
	}

if ( $_GET['rtn'] == 1 )
	{
	$cpt = "CAPTCHA KOSONG !!!"; 
	$wrn1 = "#FF0000";
	$vKirim = $_SESSION['vKirim'];
	unset($_SESSION['vKirim']);
	}	
if ( $_GET['rtn'] == 2 )
	{
	$cpt = "USER ID KOSONG !!!";
	$wrn = "#FF0000"; 
	}		
if ( $_GET['rtn'] == 4 )
	{
	$cpt = "INCORECT USER ID !!!"; 
	$wrn = "#FF0000";
	}			
}

?>
<body topmargin="0" leftmargin="0" rightmargin="0" marginheight="100%" bgcolor="#b1b4bd">
<SCRIPT language="JavaScript"> 
function closeMe()
{
var win=window.open("","_self");
win.close();
}

function loadSubmit() {
var ProgressImage = document.getElementById('progress');
document.getElementById("progress").style.visibility = "visible";
setTimeout(function(){ProgressImage.src = ProgressImage.src},500);
document.getElementById("vKirim").style.visibility="hidden";
document.getElementById("vServer").style.visibility="hidden";
document.getElementById("pin").style.visibility="hidden";
document.getElementById("Cptc").style.visibility="hidden";
document.getElementById("cmdOK").style.visibility="hidden";
document.getElementById("cmdCl").style.visibility="hidden";
document.getElementById('usrid').style.color = '#8c8d91';
document.getElementById("appsvr").style.color = '#8c8d91';
document.getElementById("cptcha").style.color = '#8c8d91';
document.getElementById("grs1").style.visibility="hidden";
document.getElementById("grs2").style.visibility="hidden";
return true;
}

</script>
<table width="100%" border="0" height="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle">
    	<table width="795" border="0" cellpadding="0" cellspacing="0" height="400">
			<tr valign="middle">
				<td width="795" align="center">
                	<table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" height="100%">
						<tr height="30">
							<td align="center" width="30" background="Pict/top_left.jpg">&nbsp;</td>
                            <td align="center" background="Pict/top_mid.jpg">&nbsp;</td>
                            <td align="center" width="30" background="Pict/top_right.jpg">&nbsp;</td>
						</tr>
						<tr>							
							<td align="center" background="Pict/mid_left.jpg">&nbsp;</td>
                            <td align="center" bgcolor="#8c8d91">
                            <img src="Pict/t_img_.jpg" alt="Tittle">
                      		</td>
                            <td align="center" background="Pict/mid_right.jpg">&nbsp;</td>
                         </tr>   
                         <tr>
                         	<td align="center" background="Pict/mid_left.jpg">&nbsp;</td>
                         	<td align="center" bgcolor="#8c8d91" style="font-family: Arial; font-size: 10pt; font-weight: bold; color:#fff" valign="middle">
                            <!-- Processing -->                    
                            
                            
                            <!-- FORM PENGIRIMAN -->
								<form name='form2' method='POST' action='SendEml1.php' onSubmit="return loadSubmit()">
                                <!-- =============== -->
                                <br><br><br>                                
   	  							<table border="0" width="600">
                                	<!--
                                	<tr>
                                    	<td colspan="2" height="2" style="font-family: Arial; font-size: 10pt; font-weight: bold; color:#fff" align="right"><i>&nbsp;<?php /* echo $cpt; */?></i></td>
                                    </tr>
                                    -->
                                	<tr>
                                    	<td colspan="2" height="1" bgcolor="#919296" bordercolor="#919296" id="grs1"></td>
                                    </tr>
                                    <tr>
                                    	<td colspan="2" align="center"><img border="0" src="Pict/processing_1.gif" width="150" height="40" name='progress' style="visibility:hidden"></td>
                                    </tr>
                                	<tr>
                                    	<td width="190" style="font-family: Arial; font-size: 10pt; font-weight: bold; color:<?php echo $wrn; ?>"><div id="usrid">USER ID</div></td>
                                        <td><input type='text' name='vKirim' size='<?php echo $sise ?>' style="background-image:url(Picture/ChPass/shad_white.jpg); border:hidden; font-weight: bold" value="<?php echo $vKirim; ?>">                                         
                                        </td>
                                     </tr>   
                                     <tr>
                                    	<td width="190" style="font-family: Arial; font-size: 10pt; font-weight: bold; color:<?php echo $wrn3; ?>"><div id="appsvr">APLICATION SERVER</div></td>
                                        <td><select size="1" name="vServer">
                                            <option selected value="1">Production Client 210</option>
                                            <option value="2" disabled='disabled'>Booking Online</option>
                                            <option value="3" disabled='disabled'>EIS ( Executive Information System )</option>
                                            <option value="4" disabled='disabled'>STM ( Sales Transportasi Management</option>
                                            <option value="5" disabled='disabled'>SISDIPEN ( Sistim Distribusi dan Penjualan )</option>
                                            <option value="6" disabled='disabled'>E-Mail SGG</option>
                                            <option value="7" disabled='disabled'>E-Mail SP</option>
                                            <option value="8" disabled='disabled'>Sunfish</option>
                                            <option value="9" disabled='disabled'>Servicedesk</option>
                                            <option value="10" disabled='disabled'>Qlikview/BI</option>
                                            </select>
                                         </td>
                                     </tr>   
                                     <tr>
                                    	<td width="190" style="font-family: Arial; font-size: 10pt; font-weight: bold; color:<?php echo $wrn1; ?>"><div id="cptcha">CAPTCHA</div></td>
                                        <td valign="bottom">                                         
                                        <input type="text" name="pin" size='5' maxlength="5" style="height: 30; vertical-align:middle; font-size:16px;background-image:url(Picture/ChPass/shad_white.jpg); border:hidden; font-weight: bold">
                                        <img src="cap1.php?date=<?php echo date('YmdHis');?>" alt="security image" align="middle" name="Cptc">                                  		</td>
                                     </tr>   
                                     <tr>
                                    	<td colspan="2" height="25">&nbsp;</td>
                                     </tr>   
                                     <tr>
                                    	<td colspan="2" height="1" bgcolor="#919296" bordercolor="#dbd8d8" id="grs2"></td>
                                    </tr>
                                     <tr>
                                    	<td colspan="2" height="20">&nbsp;</td>
                                     </tr>   
                                     <tr>
                                    	<td colspan="2" align="right">
                                        <input type='submit' value='Submit' name='cmdOK'>
                                        <input type="button" value='Cancel' name='cmdCl' onClick="closeMe()">
                                        <!--
                                        <input type='reset' value='Reset' name='B2'>
                                        -->
                                        </td>
                                     </tr>   
                                </table>
                                </form>
                            
                            
                                   	
                            <!-- End Process -->
                            </td>
                            <td align="center" background="Pict/mid_right.jpg">&nbsp;</td>
						</tr>
                        <tr>
                         	<td align="center" background="Pict/mid_left.jpg">&nbsp;</td>
                         	<td align="center" bgcolor="#8c8d91">
                            <table width="100%" border="0" bgcolor="#8c8d91">
                            	<tr>
                                	<td width="60" align="left">                                    
                                    </td>
                                    <td align="center">
                                    <font style="font-family: Arial; font-size: 10pt; font-weight: bold; color:#b4b4b5">
                                    E-Mail Akan Dikirimkan Pada Alamat E-Mail yang Terdaftar<br>
                                    </font>
                            		<font style="font-family: Arial; font-size: 10pt; font-weight: bold; color:#c5c5c6">
                            		SISFO SGG
                            		</font>
                                    </td>
                                    <td width="60"></td>
                                </tr>
                            </table>
                            </td>
                            <td align="center" background="Pict/mid_right.jpg">&nbsp;</td>
						</tr>
						<tr height="30">							
							<td align="center" background="Pict/bot_left.jpg">&nbsp;</td>
                            <td align="center" background="Pict/bot_mid.jpg">&nbsp;</td>
                            <td align="center" background="Pict/bot_right.jpg">&nbsp;</td>
						</tr>
					</table> 
                </td>
            </tr>
         </table>       
	</td>
  </tr>
</table>
<?php
if (!empty($cpt))
{
	echo "<script type='text/javascript'>alert('$cpt')</script>";
}
?>
</body>
</html>