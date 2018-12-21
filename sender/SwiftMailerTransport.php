<?php

include ('TransportInterface.php');
include_once ('Render.php');

class SwiftMailerTransport implements TransportInterface
{
    private $mailer;
    private $message;



    public function createTransport($config){


        $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['username'])
            ->setPassword($config['password'])
            -> setEncryption($config['encryption']);
        ;

        return $transport;

    }


    public function getTransport($config)
    {
        $transport = $this->createTransport($config);
        return $transport;
    }


    protected function createMailer($config)

    {
        $transport = $this->getTransport($config);
        $mailer = new Swift_Mailer($transport);
        return $mailer;
    }


    public function getMailer($config)
    {
        if (null == $this->mailer) {
            $this->mailer = $this->createMailer($config);
        }

        return $this->mailer;
    }


    public function getMessage($params)
    {
        if (null == $this->message) {
            $this->message = $this->createMessage( $params);
        }

        return $this->message;
    }


    public function createMessage($params){

        $page = new Render();
        $page = $page->renderPhpFile($params);
        $message = (new Swift_Message($params['subject']))
            ->setFrom([$params['fromEmail'] => $params['fromName']])
            ->setTo([$params['email'], $params['email'] =>$params['firstName']])
            ->setBody($page, 'text/html')

        ;

        return $message;
    }

}