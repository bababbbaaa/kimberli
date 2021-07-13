<?php

require_once(__DIR__ . '/vendor/autoload.php');

//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);

if(!empty($_SERVER['HTTP_USER_AGENT'])){
	session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();

use KB\rest_server\application;

//application::set_time_zone('UTC');

// run api server
$application = application::init(__DIR__ . '/application/');

$response = $application->execute();

$response->send();
