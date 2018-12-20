<?php

/**
 * Created by PhpStorm.
 * User: Виталия
 * Date: 18.12.2018
 * Time: 21:29
 */
include ('TransportInterface.php');

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

        $message = (new Swift_Message('Wonderful Subject'))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo([$_POST['email'], $_POST['email'] => $_POST['name']])
            ->setBody($_POST['msg'])
        ;

        return $message;
    }

}