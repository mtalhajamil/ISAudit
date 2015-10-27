<?php 
require_once('../PHPMailerAutoload.php');

//include_once '../../../db_functions.php';
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loadeda


//$db = new DB_Functions();

$data = array();
$data[0] = array('name'=>'Raja Ali Ehsan', 'email' => 'ameerhamza810@gmail.com');
$data[1] = array('name'=>'Muhammad Shoaib Hasan', 'email' => 'ameer.hamza103@yahoo.com');

echo count($data);

/*$count = count($data);
//echo $data[0]["name"];
//var_dump($data);
$close=0;
$open=0;
for ($i=0;$i<$count;$i++)
{
 $var=  $data[$i]["name"];
 //echo $var;

 $q1 = "Select Status from report where ResponsiblePerson ".$var;
 
    if ( $query2 = $db->openCloseChartq2($q1))
    {
      while($obj1 = mysql_fetch_object($query2))
      {
        if ($obj1->Status == 'Close' )
        {
          $close++;
        }

        if ($obj1->Status == 'Open' || $obj1->Status == 'open')
        {
          $open++;
        }


      }
    }
    echo $close;
    echo $open;
}
*/

$mail             = new PHPMailer();

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host       = "inf01.iefl.com"; // SMTP server
//$mail->Host       = "mail.engrofoods.com"; // SMTP server
$mail->Host 	  = "192.168.202.85";

$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
$mail->SMTPOptions = array(
      'ssl' => array(
      		'verify_peer' => false,
      		'verify_peer_name' => false,
      		'allow_self_signed' => true
      	)

	);
	                                          // 2 = messages only
$mail->SMTPAuth   = false;                  // enable SMTP authentication
//$mail->Host       = "inf01.iefl.com"; // sets the SMTP server
//$mail->Host       = "mail.engrofoods.com"; // SMTP server
//$mail->Host       = "smtp.engrofoods.com"; // SMTP server

$mail->Port       = 25;                    // set the SMTP port for the GMAIL server
//$mail->Username   = "safarooqui@iefl.com"; // SMTP account username
//$mail->Password   = "Windows10@2015";        // SMTP account password

$mail->SetFrom('ameerhamza810@gmail.com', 'Ameer Hamza');

//$mail->AddReplyTo("abc@uve.com","abc xyz");

$mail->Subject    = "PHPMailer Test Subject via smtp, basic with authentication";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

//$address = "ameerhamza810@gmail.com";
//$mail->AddAddress($address, "Ameer Hamza");
$mail->AddAddress('ameerhamza810@gmail.com', "Ameer Hamza");

$mail->AddAttachment("images/phpmailer.png");      // attachment
$mail->AddAttachment("images/phpmailer_mini.png"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

//$count--;


?>    