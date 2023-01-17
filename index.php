<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', false);
//ini_set('display_startup_errors', 1);
 const BASE_DIR = __DIR__;

require_once('function.php');
set_exception_handler('exception_handler');
set_error_handler('error_handler');

$time_start = microtime(true);

if(!empty($_SERVER['HTTP_USER_AGENT'])){
    session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();

try {
    require_once('view/IndexView.php');

    $view = new IndexView();

//header("X-Powered-CMS: OkayCMS ".$view->config->version." ".$view->config->version_type);

if(isset($_GET['logout'])) {
    unset($_SESSION['admin']);
    header('location: '.$view->config->root_url);
    exit();
}

 $res= $view->fetch();
if($res !== false) {
    header("Content-type: text/html; charset=UTF-8");
    print $res;
    
    // Сохраняем последнюю просмотренную страницу в переменной $_SESSION['last_visited_page']
    if (empty($_SESSION['last_visited_page']) || empty($_SESSION['current_page']) || $_SERVER['REQUEST_URI'] !== $_SESSION['current_page']) {
        if(!empty($_SESSION['current_page']) && $_SESSION['last_visited_page'] !== $_SESSION['current_page']) {
            $_SESSION['last_visited_page'] = $_SESSION['current_page'];
        }
        $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    }
} else {
    // Иначе страница об ошибке
  //  header("http/1.0 404 not found");
    
    // Подменим переменную GET, чтобы вывести страницу 404
    $_GET['page_url'] = '404';
    $_GET['module'] = 'PageView';
    print $view->fetch();   
}

} catch (\Throwable $e) {

	$view->bug->add_exception($e);

	if ($view->config->debug_mode) {
		l($e);
		exit;
	}

	header('location: '.$view->config->root_url);
}

function l($var)
  {
	  if ($_SERVER['REMOTE_ADDR'] == '195.38.8.37') {
	  if (is_array($var)) {
		  echo '<pre>';
		  print_r($var);
		  echo '</pre>';
	  } elseif (is_object($var)) {
		  echo '<pre>';
		  print_r($var);
		  echo '</pre>';
	  } else {
		  echo '<br>' . $var . '<br>';
	  }
  }
}

// Отладочная информация
print "<!--\r\n";
$time_end = microtime(true);
$exec_time = $time_end-$time_start;

if(function_exists('memory_get_peak_usage')) {
    print "memory peak usage: ".memory_get_peak_usage()." bytes\r\n";
}
print "page generation time: ".$exec_time." seconds\r\n";
print "-->";