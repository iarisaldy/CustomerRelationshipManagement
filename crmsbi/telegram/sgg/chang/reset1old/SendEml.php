<?php
session_start();
ini_set("memory_limit","80M");
$iptarget="192.168.80.67";
?>
<title>Reset Password : Send E-Mail</title>
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

$pin = $_REQUEST["pin"];

if (empty($_REQUEST["vKirim"]))
{
	echo "<script>
		window.location=\"ResetPsw.php?rtn=2\"
	</script> ";
	exit();
}
if (empty($pin))
{
	$_SESSION['vKirim'] = $_REQUEST["vKirim"];
	echo "<script>
		window.location=\"ResetPsw.php?rtn=1\"
	</script> ";
	exit();
}
if ( $pin <> $_SESSION['key'] ){
	$_SESSION['vKirim'] = $_REQUEST["vKirim"];
	echo "<script>
		window.location=\"ResetPsw.php?rtn=3\"
	</script> ";	
	exit();
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
                            <td align="center" width="30" background="pict/top_right.jpg">&nbsp;</td>
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
		     
		$hslr=date('YmdHis');
		$RandomStrs = md5($hslr);// md5 to generate the random string 
		$ResultStrs = substr($RandomStrs,0,8);//trim 8 digit 
		$new_password = $ResultStrs;
		$username = $_REQUEST["vKirim"];
		
 		//include "../class/DbC.class.php";
		$base = "sapsp";$server="localhost";$user="sapsp";$pass="sapsp";  
		//$DBc = new DBc;
		$DBc->DBcs($base,$server,$user,$pass);
		
		$sqlss = 'SELECT sapsp_user_email,sapsp_user_nama, sapsp_user_id FROM sapsp_user WHERE sapsp_user_login="'.$username.'"';
		$DBc->seek($sqlss,1);
		if ($DBc->existornot==1)
		{	
			
			require("../PHPMailer/class.phpmailer.php");
			require("encr2.php");					
			$enc = $username."=".$new_password."=".$DBc->arry3;
			$links = encode($enc,"This is a key 4");
			$mail = new PHPMailer(); 
			$mail->IsSMTP(); // send via SMTP
			//IsSMTP(); // send via SMTP
			$mail->Priority = 1;
			$mail->SMTPAuth = true; // turn on SMTP authentication
			$mail->Username = "sgg.pass.recover@gmail.com"; // SMTP username
			$mail->Password = "passrecoversgg"; // SMTP password
			$webmaster_email = "john.fitzgerald.nurdin@semenpadang.co.id"; //Reply to this email ID
			$email=$DBc->arry1; // Recipients email ID
			$name=$DBc->arry2; // Recipient's name
			$mail->From = $webmaster_email;
			$mail->FromName = "Admin Password Recovery";
			$mail->AddAddress($email,$name);
			$mail->AddReplyTo($webmaster_email,"PassRecovery");
			$mail->WordWrap = 50; // set word wrap
			//$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
			//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment
			$mail->IsHTML(true); // send as HTML
			$mail->Subject = "Application Password Recovery";
			$mail->Body = "Setuju dengan reset password baru ".$new_password.", <a href='http://".$iptarget."/reset/UbhPswd.php?id=".$links."'>Ya</a> , <a href='http://192.168.80.67/reset.php'>Tidak</a>"; //HTML Body
			$mail->AltBody = "Reset Password"; //Text Body
			if(!$mail->Send())
			{
			echo "Mailer Error: " . $mail->ErrorInfo;
			}
			else
			{	
			//$DBc->close();
			
			
			echo "<font style='font-family: Arial; font-size: 10pt; font-weight: bold; color:#c5c5c6'><b>Pesan Telah Terkirim, Check E-Mail Anda</b></font>";
			}
		
		}
			else
		{	
   				//die('Incorrect User Name.');
				echo "<script>
					window.location=\"ResetPsw.php?rtn=4\"
					</script> ";	
				exit();
				//echo "Incorect User Name";
		}		
		// close database
		
		//$DBc->close();
		//$DBc->DBcs($base,$server,$user,$pass);
		$sqlss = "update sapsp_trans set sapsp_trans_stat=0 where id_sapsp_user = ".$DBc->arry3." and sapsp_trans_stat=1";
		$DBc->execute($sqlss);		
		//$DBc->close();
		//$DBc->DBcs($base,$server,$user,$pass);	
		$sqlss = "insert into sapsp_trans (id_sapsp_user, sapsp_trans_tgl, sapsp_trans_jam, sapsp_trans_pass, sapsp_trans_stat) values (".$DBc->arry3.",CURDATE(),CURTIME(),'".$new_password."',1)";
		$DBc->execute($sqlss);  
		$DBc->close();
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