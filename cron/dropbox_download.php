<?php

/**
 * @deprecated 
 */
ini_set("display_errors", 1);
$start = microtime(true);
define('APP_PATH', dirname(__DIR__));
require_once(APP_PATH . '/vendor/autoload.php');
require_once('function_cron.php');

$db_file = APP_PATH.'/cron/dropbox/sait.dbf';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://content.dropboxapi.com/2/files/download");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$headers = array('Authorization: Bearer CgAObeZbWQAAAAAAAAAAHMh5_TO0wVSgedSXccDea9oxjD_CoMHfTaZcxUO7a6oq',
    'Content-Type: application/octet-stream',
    'Dropbox-API-Arg: ' . json_encode(["path" => '/Sync/kimberli/regular/sait.dbf'])
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);
if(!$err){ 
    if (is_file($db_file)) {
    unlink($db_file);
}
$file = fopen($db_file, 'w');
fwrite($file, $result);
fclose($file); 
set_log('download-sait-ok');
}else{
   set_log('download-sait-'.$err); 
}

$dbv_file = APP_PATH.'/cron/dropbox/saitv.dbf';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://content.dropboxapi.com/2/files/download");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$headers = array('Authorization: Bearer CgAObeZbWQAAAAAAAAAAHMh5_TO0wVSgedSXccDea9oxjD_CoMHfTaZcxUO7a6oq',
    'Content-Type: application/octet-stream',
    'Dropbox-API-Arg: ' . json_encode(["path" => '/Sync/kimberli/regular/saitv.dbf'])
);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);

$err = curl_error($ch);
curl_close($ch);
if(!$err){
    if (is_file($dbv_file)) {
    unlink($dbv_file);
}
$file = fopen($dbv_file, 'w');
fwrite($file, $result);
fclose($file);
set_log('download-saitv-ok');
}else{
   set_log('download-saitv-'.$err); 
}

//echo 'USED TIME: ' . (microtime(true) - $start);