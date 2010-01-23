<?php
    require_once "Mail.php";
    include("../includes/init.php");

    function Redirect($response){
        header("Location: ../sendmail.php?mail=".$response);
    }

    $from = "Troopr <mailer@troopr.co.uk>";
    $to = $_POST['to'];
    $subject = $_POST['sub'];
    $body = $_POST['msg'];

    $body .= "\r\n\r\n"."_________________"."\r\n";
    $body .= "This email was sent from the Troopr Scout Management System. http://www.troopr.co.uk";

    $host = "mail.troopr.co.uk";
    $username = "mailer@troopr.co.uk";
    $password = "minor101.";

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
        $response = $mail->getMessage();
        Redirect($response);
     } else {
        $response = "1";
        Redirect($response);
     }
?>
