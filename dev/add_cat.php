<?php

if(!empty($_SERVER['HTTP_USER_AGENT'])){
    session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();
chdir('..');
include_once('api/Okay.php');
$okay = new Okay();
use XBase\Table;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$dbProductsPath = 'cron/files/Sait.dbf';

if (!file_exists($dbProductsPath)) {
	echo 'error file_exists';
	exit();
}

try {
	$table = new Table($dbProductsPath, null, 'CP1251');
	echo 'Record count: '.$table->getRecordCount() . '<br>';
	echo date('Y-m-d H:i:s', filemtime($dbProductsPath));

} catch (Throwable $e) {
	print_r($e->getMessage());
}

/*

$sql = "SELECT t1.`id`
FROM `ok_products` t1
LEFT JOIN ok_products_categories t2 ON t1.`id` = t2.`product_id`
AND t2.category_id =114
WHERE t2.`product_id` IS NULL";

$results = $okay->db->query($sql);
$i = 0;
foreach ($okay->db->results() as $r) {
    $sql = "INSERT INTO `ok_products_categories` (`product_id`, `category_id`) VALUES ('{$r->id}', 114)";
    $okay->db->query($sql);
    $i++;
}

echo '#'.$i;
*/