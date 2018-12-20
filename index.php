<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once __DIR__ . '/sender/vendor/autoload.php';

include 'sender/Sender.php';

include_once ('sender/Render.php');


$message = array(
    'fromEmail' => 'john@doe.com',
    'fromName'=>'John Doe',
    'subject' => 'Wonderful Subject',
    'firstName' => 'Dear user',
    'email'=> 'vitaliasmaglenko@gmail.com'
);

$render = new Render();
$render->rendering('mailer', $message);

//$ob = new Sender();

//$ob->send();
unset($_POST);





