<?php

include ('TransportInterface.php');
include_once ('Render.php');

class SwiftMailerTransport implements TransportInterface
{
    private $config;
    private $mailer;
    private $message;


    public function __construct()
    {
        $this->config = $this->fixConfig();

    }

    protected function fixConfig(){

        $config = include_once ('config.php');
        return $config;
    }

    protected function getConfig()
    {
        return $this->config;
    }



    public function createTransport(){

        $config = $this->getConfig();

        $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['username'])
            ->setPassword($config['password'])
            -> setEncryption($config['encryption']);
        ;

        return $transport;

    }


    public function getTransport()
    {
        $transport = $this->createTransport();
        return $transport;
    }


    protected function createMailer()

    {
        $transport = $this->getTransport();
        $mailer = new Swift_Mailer($transport);
        return $mailer;
    }


    public function getMailer()
    {
        if (null == $this->mailer) {
            $this->mailer = $this->createMailer();
        }

        return $this->mailer;
    }


    public function getMessage()
    {
        if (null == $this->message) {
            $this->message = $this->createMessage();
        }

        return $this->message;
    }


    public function createMessage(){
        $params = new Render();
        $params = $params->getParameters();

        $page = new Render();
        $page = $page->renderPhpFile();
        // var_dump($page);
        $message = (new Swift_Message($params['subject']))
            ->setFrom([$params['fromEmail'] => $params['fromName']])
            ->setTo([$params['email'], $params['email'] =>$params['firstName']])
            ->setBody($page, 'text/html')

        ;

        return $message;
    }

}