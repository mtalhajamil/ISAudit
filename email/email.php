<?php
// multiple recipients
$to  = 'ameerhamza810@gmail.com' ;
//$to=$_POST['email'];
// subject
$subject = 'Birthday Reminders for August';

// message
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
/head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: <ameerhamza810@gmail.com>' . "\r\n";
$headers .= 'From: Birthday Reminder <ameerhamza@aptitudor.base.pk>' . "\r\n";
$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Mail it

//mail($to, $subject, $message, $headers);
if (mail($to, $subject, $message, $headers))
{
     $data= array('status'=>'true');
}
else
{
  $data= array('status'=>'false');
}

echo json_encode($data);
?>

				