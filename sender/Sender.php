<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 17.12.18
 * Time: 17:03
 */
//require_once '../transporter/vendor/autoload.php';

require_once ('SwiftMailerTransport.php');

class Sender
{

      public function send($view, $config)
      {
        $params = include($view);
        $config = include($config);
        $mailer = new SwiftMailerTransport();
        $mailer = $mailer->getMailer($config);
        $message = new SwiftMailerTransport();
        $message = $message->getMessage( $params);
        $result = $mailer->send($message);

    }

}

