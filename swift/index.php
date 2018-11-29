<?php
require_once 'lib/swift_required.php';

// Create the Transport
//$transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
//  ->setUsername('survey20@izkey.com')
//  ->setPassword('webarqcom')
//  ;
  
$transport = Swift_SmtpTransport::newInstance('smtp.mandrillapp.com', 587)
  ->setUsername('webarq@rajabot.com')
  ->setPassword('qKlozCb3pFDKmuXBNT7QoA')
  ;

/*
You could alternatively use a different transport such as Sendmail or Mail:

// Sendmail
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

// Mail
$transport = Swift_MailTransport::newInstance();
*/

// Create the Mailer using your created Transport
$mailer = Swift_Mailer::newInstance($transport);

// Create a message
$message = Swift_Message::newInstance('Wonderful Subject')
  ->setFrom(array('john@doe.com' => 'John Doe'))
  ->setTo(array('daniel@webarq.com', 'other@domain.org' => 'A name'))
  ->setBody('Here is the message itself')
  ;

// Send the message
$result = $mailer->send($message);
?> 