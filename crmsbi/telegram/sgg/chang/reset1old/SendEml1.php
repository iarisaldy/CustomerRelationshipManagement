<?php
ob_start();
session_start();
ini_set("memory_limit","80M");
$iptarget="10.15.5.150/sgg/chang/reset1/";
$ipmysql = "192.168.10.74";
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
		window.location=\"resetpsw.php?rtn=2\"
	</script> ";
	exit();
}
if (empty($pin))
{
	$_SESSION['vKirim'] = $_REQUEST["vKirim"];
	echo "<script>
		window.location=\"resetpsw.php?rtn=1\"
	</script> ";
	exit();
}
if ( $pin <> $_SESSION['key'] ){
	$_SESSION['vKirim'] = $_REQUEST["vKirim"];
	echo "<script>
		window.location=\"resetpsw.php?rtn=3\"
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
		     
		$hslr=date('YmdHis');
		$RandomStrs = md5($hslr);// md5 to generate the random string 
		$ResultStrs = substr($RandomStrs,0,8);//trim 8 digit 
		$new_password = $ResultStrs;
		$username = $_REQUEST["vKirim"];
		
 		//include "../class/DbC.class.php";
		$base = "sapsp";$server=$ipmysql;$user="sapsp";$pass="sapsp";  
		//$DBc = new DBc;
		$DBc->DBcs($base,$server,$user,$pass);
		
		$sqlss = 'SELECT sapsp_user_email,sapsp_user_nama, sapsp_user_id FROM sapsp_user WHERE sapsp_user_login="'.$username.'"';
		$DBc->seek($sqlss,1);
		if ($DBc->existornot==1)
		{	
			
			
			require_once "Mail.php";
			require("encr2.php");
			
			
			//require("../PHPMailer/class.phpmailer.php");
			//require("encr2.php");					
			$enc = $username."=".$new_password."=".$DBc->arry3;			
			$links = encode($enc,"This is a key 4");
			
			$from = "Password Recovery <pswreco@semenpadang.co.id>";
			//$to1 = $DBc->arry2;
			//$to2 = $DBc->arry1;
			$to = $DBc->arry1;
 			$subject = "Password Recovery";
			$body = "Setuju dengan reset password baru ".$new_password.", <a href='http://".$iptarget."UbhPswd.php?id=".$links."'>Ya</a> , <a href='http://".$iptarget."RejectPass.php?id=".$links."'>Tidak</a>";
 			//$body = "Hi John,\n\nHow are you?";
			
 			$host = "spocs.semenpadang.co.id";
 			$username = "pswreco";
 			$password = "passreco1";
 			
			
 			//$headers = array ('From' => $from,
   			//			'To' => $to,
   			//			'Subject' => $subject);
						
			$headers = array("MIME-Version"=> '1.0',  
                 "Content-type" => "text/html; charset=iso-8859-1", 
                 "From" => $from, 
                 "To" => $to,  
                 "Subject" => $subject);
									
 			$smtp = Mail::factory('smtp',
   						array ('host' => $host,
     							'auth' => false,
     							'username' => $username,
     							'password' => $password));
 
 			$mail = $smtp->send($to, $headers, $body);
 
 			if (PEAR::isError($mail)) {
   				echo("<p>" . $mail->getMessage() . "</p>");
  			} else {
   				echo("<p>Message successfully sent!</p>");
  			}
			
						
		}
			else
		{	
   				//die('Incorrect User Name.');
				echo "<script>
					window.location=\"resetpsw.php?rtn=4\"
					</script> ";	
				exit();
				//echo "Incorect User Name";
		}		
		
		$sqlss = "update sapsp_trans set sapsp_trans_stat=0 where id_sapsp_user = ".$DBc->arry3." and sapsp_trans_stat=1";
		$DBc->execute($sqlss);		
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