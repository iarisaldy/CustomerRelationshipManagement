 <?php
// require_once "Mail.php";
include "class/DbC.class.php"; 
$DBc = new DBc;
$base = "sapsp";$server="192.168.10.74";$user="sapsp";$pass="sapsp";  
$DBc->DBcs($base,$server,$user,$pass);
 
 /*
 $from = "Password Recovery <pswreco@semenpadang.co.id>";
 $to = "Nurdin <john.fitzgerald.nurdin@semenpadang.co.id>";
 $subject = "Hi Dari turunan!";
 $body = "Hi John,\n\nHow are you?";

 //$host = "gmail.com";
 //$username = "jfnurdin@gmail.com";
 //$password = "";

 $host = "spocs.semenpadang.co.id";
 $username = "pswreco";
 $password = "passreco1";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
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
  
 */
 /* 
 require_once "Mail.php";
 
 $from = "john Sender <john.fitzgerald.nurdin@semenpadang.co.id>";
 $to = "nurdin Recipient <john.fitzgerald.nurdin@semenpadang.co.id>";
 $subject = "Hi!";
 $body = "Hi,\n\nHow are you?";
 
 //$host = "ssl://smtp.gmail.com";
 //$port = "465";
 //$username = "jfnurdin";
 //$password = "force123";
 
 $host = "ssl://spocs.semenpadang.co.id";
 $port = "25";
 $username = "john.fitzgerald.nurdin";
 $password = "";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);
 
 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
  }
 */
 ?>