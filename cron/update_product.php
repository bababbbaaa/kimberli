<?php
namespace cron;

if(!empty($_SERVER['HTTP_USER_AGENT'])){
    session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();
require_once('function_cron.php');
include_once('../api/Okay.php');
$okay = new Okay();

use XBase\Table;

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
$categoriesMap = [
	'' => 0,
	'Серьги' => [
		'id' => 22,
		'translit' => 'sergi'
	],
	'Браслет' => [
		'id' => 30,
		'translit' => 'braslet'
	],
	'Подвеска' => [
		'id' => 29,
		'translit' => 'podveska'
	],
	'Колье' => [
		'id' => 31,
		'translit' => 'kole'
	],
	'Запонки' => [
		'id' => 23,
		'translit' => 'zaponki'
	],
	'Кольцо' => [
		'id' => 17,
		'translit' => 'koltso'
	],
	'Цепочка' => [
		'id' => 25,
		'translit' => 'tsepochka'
	],
	'Брошка' => [
		'id' => 32,
		'translit' => 'broshka'
	],
];

$color = [
    'Белый' => 640,
    'Желтый' =>644,
    'Желто-белый' => 644,
    'Красный' =>643,
    'Красно-белый' => 643,
];

$collection = [
    'KIMBERLI PRIVE' => 339,
    'KIMBERLI Lite' => 332,
    'KIMBERLI Exclusive' => 351,
    'KIMBERLI Classic' => 348,
];

$data = ['update' => 0, 'add_options' => 0, 'add' => 0];
$i=0;
$dbProductsPath = 'files/Sait.dbf';

if (!file_exists($dbProductsPath)) {
  echo 'no file';
exit;
}

$date_file = date('Y-m-d H:i:s', filemtime($dbProductsPath));

$sql = "SELECT log_id FROM  `ok_dropbox_log` WHERE `date_file` = '{$date_file}' LIMIT 1";
$okay->db->query($sql);

if ($okay->db->result('log_id')) {
	$log_messsage = "File not update. Last update " . $date_file;
	set_log($log_messsage);
	echo $log_messsage;
	exit();
}

try
{
    $table = new Table($dbProductsPath, null, 'CP1251');
echo 'dfsg'; exit;
    if ($table->getRecordCount() <= 0) {
    	exit();
	}

$okay->db->query("UPDATE `ok_variants` SET `kimb`.`ok_variants`.`stock` = 0"); //обнуление остатка

    while ($record = $table->nextRecord()) {
    
   // $sql = "UPDATE `kimb`.`ok_variants` SET `kimb`.`ok_variants`.`stock` = {$record->kol}, `kimb`.`ok_variants`.`price` = {$record->cena}, `kimb`.`ok_variants`.`compare_price` = {$record->cenas}, `kimb`.`ok_variants`.`weight` = {$record->mas} WHERE `kimb`.`ok_variants`.`sku` = {$record->shtr} ";
     $sql = "SELECT `id`, `product_id` FROM  `ok_variants` WHERE `sku` LIKE '%{$record->shtr}%'  LIMIT 1";
     
        $okay->db->query($sql);
        $res = $okay->db->results()[0];
        $id = $res->id;
        $p_id = $res->product_id;
        
        if($id){
        	$kol = $record->kol;
			$price = $record->cena;
			$oldPrice = $record->cenas;
			$mas = $record->mas;
        	$proc = !empty($record->proc) ? $record->proc : 0;
            $okay->db->query("UPDATE `ok_variants` SET `ok_variants`.`stock` = {$kol}, `ok_variants`.`price` = {$price}, `ok_variants`.`compare_price` = {$oldPrice}, `ok_variants`.`weight` = {$mas}, `ok_variants`.`proc` = {$proc}, `ok_variants`.`cvet` = '{$record->cvet}', `ok_variants`.`vstavka` = '{$record->namev}' WHERE `ok_variants`.`id` = {$id}");
            
            if($p_id) {
                $okay->db->query("SELECT `product_id` as `ids` FROM `ok_products_features_values` WHERE `product_id` = {$p_id} LIMIT 1");
                
                if(!$okay->db->result('ids') && !empty($color[$record->namecr]) && !empty($collection[$record->gr])) {
                    $data['add_options'] += 1;
                    $okay->db->query("INSERT INTO `ok_products_features_values` (`product_id`, `value_id`) VALUES ({$p_id}, {$color[$record->namecr]}), ({$p_id}, {$collection[$record->gr]})"); // добавление свойства: цвет золота и коллекция
                }  
            }
             
        $data['update'] = $data['update']+1;
        } else {

			$new_sku = $record->si .'-' . $record->cvet . '-' . $record->namev;
			$proc =  proc($record->cena, $record->cenas);

			$url = $categoriesMap[$record->namer]['translit'] . '-' . $record->shtr;

			$ru_name =  $record->namer . ' - ' . $record->namecr . ' - ' . $record->shtr . ' - ' . $record->si;
			$en_name = $record->namei . ' - ' . $record->nameci . ' - ' . $record->shtr . ' - ' . $record->si;
			$ua_name = $record->name . ' - ' . $record->namec . ' - ' . $record->shtr . ' - ' . $record->si;

			$cvet = $record->cvet;
			$vstavka = $record->namev;
			$sku2 = $record->si;

			$sql = "SELECT `id`, `product_id` FROM  `ok_variants` WHERE `new_sku` LIKE '{$new_sku}' LIMIT 1";

			$okay->db->query($sql);
			$res = $okay->db->result();

			if($res->product_id) {
				$var = "INSERT INTO `ok_variants` (`product_id`, `url`, `new_sku`, `cvet`, `vstavka`, `sku2`, `sku`, `shtr`, `name`, `weight`, `proc`, `price`, `compare_price`, `stock`, `currency_id`) VALUES ("
					. "{$res->product_id},"
					. "'{$url}',"
					. "'{$new_sku}',"
					. "'{$record->cvet}',"
					. "'{$record->namev}',"
					. "'{$record->si}', "
					. "{$record->shtr}, "
					. "{$record->shtr}, "
					. " '{$ru_name}', "
					. "{$record->mas}, "
					. "{$record->proc}, "
					. "{$record->cena}, "
					. "{$record->cenas}, "
					. "{$record->kol}, "
					. "4"
					. ")";
				$okay->db->query($var);
				$id_var = $okay->db->insert_id();

				$okay->db->query("INSERT INTO `ok_lang_variants` (`lang_id`, `variant_id`, `name`) VALUES
                                                                        (1, {$id_var}, '{$ru_name}'),
                                                                        (2, {$id_var}, '{$en_name}'),
                                                                        (3, {$id_var}, '{$ua_name}')
                                                                        ");

				$data[$i] = ['var' => $id_var];

				$i++;
				$data['add'] = $data['add']+1;

			} else {
				$sql = "INSERT INTO `ok_products`("
					. "`url`,"
					. "`name`,"
					. " `sku`,"
					. " `stock`,"
					. " `price`,"
					. " `compare_price`,"
					. " `shtr`,"
					. " `from_sync`,"
					. " `visible`,"
					. " `collections`"
					. ")"
					. " VALUES "
					. "('{$url}',"
					. " '{$ru_name}',"
					. " '{$record->si}',"
					. " '{$record->kol}',"
					. " '{$record->cena}',"
					. " '{$record->cenas}',"
					. " '{$record->shtr}', "
					. "1,"
					. " 0,"
					. " '{$record->gr}'"
					. ")";
				$okay->db->query($sql);
				$id = $okay->db->insert_id();

				$okay->db->query("INSERT INTO `ok_lang_products` (`lang_id`, `product_id`, `name`) VALUES
                                                                        (1, {$id}, '{$ru_name}'),
                                                                        (2, {$id}, '{$en_name}'),
                                                                        (3, {$id}, '{$ua_name}')
                                                                        ");

				$var = "INSERT INTO `ok_variants` (`product_id`, `url`, `new_sku`, `cvet`, `vstavka`, `sku2`, `sku`, `shtr`, `name`, `weight`, `proc`, `price`, `compare_price`, `stock`, `currency_id`) VALUES ("
					. "{$id},"
					. "'{$url}',"
					. "'{$new_sku}',"
					. "'{$record->cvet}',"
					. "'{$record->namev}',"
					. "'{$record->si}', "
					. "{$record->shtr}, "
					. "{$record->shtr}, "
					. " '{$ru_name}', "
					. "{$record->mas}, "
					. "{$record->proc}, "
					. "{$record->cena}, "
					. "{$record->cenas}, "
					. "{$record->kol}, "
					. "4"
					. ")";
				$okay->db->query($var);

				$id_var = $okay->db->insert_id();

				$okay->db->query("INSERT INTO `ok_lang_variants` (`lang_id`, `variant_id`, `name`) VALUES
                                                                        (1, {$id_var}, '{$ru_name}'),
                                                                        (2, {$id_var}, '{$en_name}'),
                                                                        (3, {$id_var}, '{$ua_name}')
                                                                        ");

				$okay->db->query("INSERT INTO `ok_products_features_values` (`product_id`, `value_id`) VALUES ({$id}, {$color[$record->namecr]}), ({$id}, {$collection[$record->gr]})"); // добавление свойства: цвет золота и коллекция

				$okay->db->query("INSERT INTO `ok_products_categories` (`product_id`, `category_id`) VALUES ({$id}, {$categoriesMap[$record->namer]['id']})");

				$data[$i] = ['prod' => $id, 'var' => $id_var];

				$i++;
				$data['add'] = $data['add']+1;
			}

        }   
}

$okay->db->query("INSERT INTO `ok_dropbox_log` (`update_product`, `add_product`, `add_options`, `date_file`)
VALUES ({$data['update']}, {$data['add']}, {$data['add_options']}, '{$date_file}')");

$log_messsage = "products(update:{$data['update']}, add:{$data['add']}, add_options: {$data['add_options']})";
set_log($log_messsage);
//l($data);	
} catch (\Exception $e){
    echo $e->getMessage();
 }
echo '<pre>';
 print_r($data);
echo '</pre>';

