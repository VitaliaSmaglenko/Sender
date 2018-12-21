<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once __DIR__ . '/sender/vendor/autoload.php';

include 'sender/Sender.php';

$ob = new Sender();
$ob->send('emailData.php', 'config.php');
echo 'start';





