<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

use XBase\Table;
//use PHPMailer\PHPMailer\PHPMailer;
//use XBase\Table;
class Dropbox extends Okay{
    public function __construct() {
        parent::__construct();
    }

    public function get_open_file($dbProductsPath) {
//$dbProductsPath = dirname(__DIR__) . '/cron/dropbox/sait.dbf';

if (is_file($dbProductsPath)) {
try {
    $table =  new Table($dbProductsPath);
    
   // $records = new \Inok\Dbf\Records($table);
return $table;
	//return $records->nextRecord();
} catch (Exception $e ) {
    echo "Captured Throwable: " . $e->getMessage() . PHP_EOL;
}

}
        return false;
    }
}

