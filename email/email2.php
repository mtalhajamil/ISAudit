<?php
    echo ini_set("SMTP", "mail.engrofoods.com");
    echo ini_set("sendmail_from", "abc@xyz.com");



    $message = "The mail message was sent with the following mail setting:\r\nSMTP = aspmx.l.google.com\r\nsmtp_port = 25\r\nsendmail_from = YourMail@address.com";

    $headers = "From: abc@xyz.com";


    mail("ameerhamza810@gmail.com", "Testing", $message, $headers);
    echo "Check your email now....<BR/>";
?>