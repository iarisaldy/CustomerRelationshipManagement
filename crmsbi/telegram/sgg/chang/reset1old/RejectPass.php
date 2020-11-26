<?php
ob_start();
session_start();
ini_set("memory_limit","80M");
$ipmysql = "192.168.10.74";
?>
<!--
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
-->
<head>
<title>Reset Password : Process</title>
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

?>
<body topmargin="0" leftmargin="0" rightmargin="0" marginheight="100%" bgcolor="#b1b4bd">
<SCRIPT language="JavaScript"> 
function closeMe()
{
var win=window.open("","_self");
win.close();
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
                                                       
<?php 
                        
require("encr2.php");
$hsl = decode($_GET['id'],"This is a key 4");
list($nama, $passw, $ids) = split('[=]',$hsl);

//include "../class/DbC.class.php";
$base = "sapsp";$server=$ipmysql;$user="sapsp";$pass="sapsp";  
//$DBc = new DBc;

$DBc->DBcs($base,$server,$user,$pass);
$sqlss = "SELECT id_sapsp_user FROM sapsp_trans WHERE id_sapsp_user = ".$ids." and sapsp_trans_pass = '".$passw."' and sapsp_trans_stat=1";
$DBc->seek($sqlss,0);
if ($DBc->existornot==1){	
	$DBc->close();
	$base = "sapsp";$server=$ipmysql;$user="sapsp";$pass="sapsp";  
	$DBc = new DBc;
	$DBc->DBcs($base,$server,$user,$pass);
	$sqlss = "update sapsp_trans set sapsp_trans_stat=0 where id_sapsp_user = ".$ids." and sapsp_trans_stat=1";
	$DBc->execute($sqlss);  
	$DBc->close();
}
echo "Terima Kasih";      			
?>
            

   	
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
</body>
</html>