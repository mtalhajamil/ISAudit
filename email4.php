<?php 

if(isset($_POST["email"])){
  $emailaddress = $_POST['email'];
  $respname = $_POST['username'];

  require_once('email/PHPMailer/PHPMailerAutoload.php');
  
  include_once 'db_functions.php';

  $db = new DB_Functions();


  $body = "Status Of Your Reports <br /><br />";
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loadeda


  //var_dump($emailadress);

//$xyz = array('aname' => $emailadress[0]["email"] );
//echo json_encode($xyz);




  // $data1 = array();
  // $data1[0] = array('name'=>'Raja Ali Ehsan', 'email' => 'mtalhajamil93@gmail.com');
  // $data1[1] = array('name'=>'Muhammad Shoaib Hasan', 'email' => 'mtalhajamil93@gmail.com');

//echo count($data1);

 // $count = count($emailadress);
//echo $data[0]["name"];
//var_dump($data);

  // for ($i=0;$i<$count;$i++)
  // {
  //echo $i;
    //$respname=  $emailadress[$i]['username'];
 //echo $respname;

  $query1 = $db->openCloseChartUser($respname);

  $close = 0;
  $open = 0;
  $count = 0;
  $var = array();
  $data = array();




  if ($query1)
  {
    while ($obj = mysql_fetch_object($query1))
    {
      $var[$count]= $obj;

      $q2 = "select Status from report where ReportName = '".$var[$count]->ReportName."' AND (ResponsiblePerson = '".$respname."' OR ResponsiblePerson2 = '".$respname."' OR ResponsiblePerson3 = '".$respname."' OR ResponsiblePerson4 = '".$respname."' OR ResponsiblePerson5 = '".$respname."') ";




      if ( $query2 = $db->openCloseChartq2($q2))
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

      $data[$count] = array('name' => $obj->ReportName, 'closed'=> $close, 'opened' => $open);

      $body = $body . $obj->ReportName . " Open:" . $open . " Closed:" . $close . "  <a href='192.168.202.119/audit/report.php?RN=" . urlencode($obj->ReportName) . "&FU=All'>Go To Report</a>"  ."<br />";

      $count++;
      $close=0;
      $open=0;

      

    }
    //$body = json_encode($data);
  //echo $abc;

    ///////////////////////////////////////

    $mail = new PHPMailer();


$mail->IsSMTP(); // telling the class to use SMTP
//$mail->Host       = "inf01.iefl.com"; // SMTP server
//$mail->Host       = "mail.engrofoods.com"; // SMTP server
$mail->Host     = "192.168.202.85";

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

$mail->SetFrom('safarooqi@engrofoods.com', 'Engro IS Audit Tracker');

//$mail->AddReplyTo("abc@uve.com","abc xyz");

$mail->Subject    = "Report Status";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

//$address = "ameerhamza810@gmail.com";
//$mail->AddAddress($address, "Ameer Hamza");

$mail->AddAddress($emailaddress, $respname);

//$mail->AddAttachment("images/phpmailer.png");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.png"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo $emailaddress ;
}



}

//}

}
/*
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

$count--;
*/

?>    