<?php
require_once "Mail.php";
 
$from = "Web Master <webmaster@example.com>";
$to = "Nobody <nobody@example.com>";
$subject = "Test email using PHP SMTP\r\n\r\n";
$body = "This is a test email message";
 
$host = "mail.engrofoods.com";
$username = "webmaster@example.com";
$password = "yourPassword";
 
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'username' => $username,
    'password' => $password));
 
$mail = $smtp->send($to, $headers, $body);
 
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
} else {
  echo("<p>Message successfully sent!</p>");
}
?>