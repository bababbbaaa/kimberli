<?php

require_once __DIR__ . '/../vendor/autoload.php';

if(!empty($_SERVER['HTTP_USER_AGENT'])){
	session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();