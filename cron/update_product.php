<?php
namespace cron;
use Exception;

require_once('bootstrap.php');

$cron = new cron();

$cron->setFile(__DIR__ . '/files/Sait.dbf');

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
	'Сертификат' => [
		'id' => 33,
		'translit' => 'sertifikat'
	],
];

$color = [
    'Белый' => 640,
    'Желтый' => 644,
    'Желто-белый' => 644,
    'Красный' => 643,
    'Красно-белый' => 643,
];

$collection = [
    'KIMBERLI PRIVE' => 339,
    'KIMBERLI Lite' => 332,
    'KIMBERLI Exclusive' => 351,
    'KIMBERLI Classic' => 348,
];

$data = ['update' => 0, 'add_options' => 0, 'add' => [], 'error' => []];

$i = 0;

$cron->checkLastUpdateFile();// проверяем последнее обновление файла

$table = $cron->readFile(); // читаем содержимое файла

try {

	$cron->updateStockVariant(); //обнуление остатка

	// Дальше переписать

    while ($record = $table->nextRecord()) {
    	$shtr = trim($record->shtr);

		$cron->query("SELECT `id`, `product_id` FROM  `ok_variants` WHERE `sku` LIKE '$shtr'  LIMIT 1"); //

        $variant =  $cron->result();

        $id = $variant->id ?? false;
        $p_id = $variant->product_id ?? false;

        $ru_name = $record->namer . ' - ' . $record->namecr . ' - ' . $record->shtr . ' - ' . $record->si;
        $en_name = $record->namei . ' - ' . $record->nameci . ' - ' . $record->shtr . ' - ' . $record->si;
        $ua_name = $record->name . ' - ' . $record->namec . ' - ' . $record->shtr . ' - ' . $record->si;

        $ua_name = str_replace("'", "\'", $ua_name);
        
        if ($id) {

        	$kol = $record->kol;
			$price = $record->cena;
			$oldPrice = $record->cenas;
			$mas = $record->mas;
        	$proc = $record->proc;
        	$size = $record->razm;

			$cron->query(
            	"UPDATE `ok_variants`
					SET `ok_variants`.`stock` = {$kol},
					    `ok_variants`.`price` = {$price},
					    `ok_variants`.`compare_price` = {$oldPrice},
					    `ok_variants`.`weight` = {$mas},
					    `ok_variants`.`size` = {$size},
					    `ok_variants`.`proc` = {$proc},
					    `ok_variants`.`cvet` = '{$record->cvet}',
					    `ok_variants`.`vstavka` = '{$record->namev}'
					WHERE `ok_variants`.`id` = {$id}"
			);

            $cron->query("SELECT `lang_id`, `variant_id` FROM `ok_lang_variants` WHERE `variant_id` = {$id} LIMIT 3");

            $lv = $cron->results();

            $langs = [
                1 => $ru_name,
                2 => $en_name,
                3 => $ua_name,
            ];

            if (count($lv) != 3) {
                $lang = array_column($lv, 'lang_id');
                foreach (array_diff(array_keys($langs), $lang) as $lang_id) {
                    $sql = "INSERT INTO `ok_lang_variants` (`lang_id`, `variant_id`, `name`) VALUES ({$lang_id}, {$id}, '{$langs[$lang_id]}')";

                    $cron->query($sql);
                }
            }

            if($p_id) {
				$cron->query("SELECT `product_id` as `ids` FROM `ok_products_features_values` WHERE `product_id` = {$p_id} LIMIT 1");
                
                if(!$cron->result('ids') && !empty($color[$record->namecr]) && !empty($collection[$record->gr])) {
                    $data['add_options'] += 1;
					$cron->query("INSERT INTO `ok_products_features_values` (`product_id`, `value_id`) VALUES ({$p_id}, {$color[$record->namecr]}), ({$p_id}, {$collection[$record->gr]})"); // добавление свойства: цвет золота и коллекция
                }

                $cron->query("SELECT `lang_id`, `product_id` FROM `ok_lang_products` WHERE `product_id` = {$p_id} LIMIT 3");

                $lp = $cron->results();

                if (count($lp) != 3) {
                    $lang = array_column($lp, 'lang_id');

                    foreach (array_diff(array_keys($langs), $lang) as $lang_id) {
                        $sql = "INSERT INTO `ok_lang_products` (`lang_id`, `product_id`, `name`) VALUES ({$lang_id}, {$p_id}, '{$langs[$lang_id]}')";

                        $cron->query($sql);
                    }
                }
            }
             
        $data['update'] = $data['update']+1;
        } else {

            $new_sku = $record->si . '-' . $record->cvet . '-' . $record->namev;

            if ('Сертификат' == $record->si) {
                $new_sku .= '-' . $record->shtr;
            }

            if (empty(trim($record->namer))) {

                $url = $categoriesMap[trim($record->namer)]['translit'] . '-' . $record->shtr;

                $cvet = $record->cvet;
                $namev = $record->namev;
                $mas = $record->mas;
                $proc = $record->proc > 0 ? $record->proc : 0;
                $size = $record->razm > 0 ? $record->razm : 0;

                $sql = "SELECT `id`, `product_id` FROM  `ok_variants` WHERE `new_sku` LIKE '{$new_sku}' LIMIT 1";

                $cron->query($sql);
                $res = $cron->result();

                if (!empty($res->product_id)) {

                    $var = "INSERT INTO `ok_variants` (`product_id`, `url`, `new_sku`, `cvet`, `vstavka`, `sku2`, `sku`, `shtr`, `name`, `weight`, `size`, `proc`, `price`, `compare_price`, `stock`, `currency_id`) VALUES ("
                        . "{$res->product_id},"
                        . "'{$url}',"
                        . "'{$new_sku}',"
                        . "'{$cvet}',"
                        . "'{$namev}',"
                        . "'{$record->si}', "
                        . "{$record->shtr}, "
                        . "{$record->shtr}, "
                        . " '{$ru_name}', "
                        . "{$mas}, "
                        . "{$size}, "
                        . "{$proc}, "
                        . "{$record->cena}, "
                        . "{$record->cenas}, "
                        . "{$record->kol}, "
                        . "4"
                        . ")";
                    $cron->query($var);
                    $id_var = $cron->insert_id();

				$cron->query("INSERT INTO `ok_lang_variants` (`lang_id`, `variant_id`, `name`) VALUES
                                                                        (1, {$id_var}, '{$ru_name}'),
                                                                        (2, {$id_var}, '{$en_name}'),
                                                                        (3, {$id_var}, '{$ua_name}')
                                                                        ");

                    $i++;
                    $data['add'][] = ['var' => $id_var];

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

                    $cron->query($sql);

                    $id = $cron->insert_id();

                    if (0 == $id) {
                        throw new \RuntimeException('Error insert ok_products');
                    }

				$cron->query("INSERT INTO `ok_lang_products` (`lang_id`, `product_id`, `name`) VALUES
                                                                        (1, {$id}, '{$ru_name}'),
                                                                        (2, {$id}, '{$en_name}'),
                                                                        (3, {$id}, '{$ua_name}')
                                                                        ");

                    $var = "INSERT INTO `ok_variants` (`product_id`, `url`, `new_sku`, `cvet`, `vstavka`, `sku2`, `sku`, `shtr`, `name`, `weight`, `proc`, `price`, `compare_price`, `stock`, `currency_id`) VALUES ("
                        . "{$id},"
                        . "'{$url}',"
                        . "'{$new_sku}',"
                        . "'{$cvet}',"
                        . "'{$namev}',"
                        . "'{$record->si}', "
                        . "{$record->shtr}, "
                        . "{$record->shtr}, "
                        . " '{$ru_name}', "
                        . "{$mas}, "
                        . "{$proc}, "
                        . "{$record->cena}, "
                        . "{$record->cenas}, "
                        . "{$record->kol}, "
                        . "4"
                        . ")";
                    $cron->query($var);

                    $id_var = $cron->insert_id();

				$cron->query("INSERT INTO `ok_lang_variants` (`lang_id`, `variant_id`, `name`) VALUES
                                                                        (1, {$id_var}, '{$ru_name}'),
                                                                        (2, {$id_var}, '{$en_name}'),
                                                                        (3, {$id_var}, '{$ua_name}')
                                                                        ");

                    if (!empty($color[$record->namecr])) {
                        $cron->query("INSERT INTO `ok_products_features_values` (`product_id`, `value_id`) 
								VALUES ({$id}, {$color[$record->namecr]})
       						"); // добавление свойства: цвет золота
                    } else {
                        $data['error'][] = ['product_id' => $id, 'color' => $record->namecr];
                    }

                    if (!empty($collection[$record->gr])) {
                        $cron->query("INSERT INTO `ok_products_features_values` (`product_id`, `value_id`) 
								VALUES ({$id}, {$collection[$record->gr]})
       						"); // добавление свойства: коллекция
                    } else {
                        $data['error'][] = ['product_id' => $id, 'collection' => $record->gr];
                    }

                    $cron->query("INSERT INTO `ok_products_categories` (`product_id`, `category_id`) VALUES ({$id}, {$categoriesMap[$record->namer]['id']})");

                    $i++;
                    $data['add'][] = ['prod' => $id, 'var' => $id_var];
                }
            }
        }
}

	$cron->query("UPDATE `ok_products` P SET
                           P.`stock` = (SELECT COALESCE( SUM(V.stock), 0) FROM ok_variants V WHERE V.product_id = P.id),
                           P.price = (SELECT MIN(V.price) FROM ok_variants V WHERE V.product_id = P.id and V.stock > 0),
                           P.compare_price = (SELECT MIN(V.compare_price) FROM ok_variants V WHERE V.product_id = P.id and V.stock > 0)
                           ");
	
	$cron->query("UPDATE `ok_products` P SET
                           P.price = (SELECT MIN(V.price) FROM ok_variants V WHERE V.product_id = P.id and V.stock = 0),
                           P.compare_price = (SELECT MIN(V.compare_price) FROM ok_variants V WHERE V.product_id = P.id and V.stock = 0)
							WHERE P.`stock` = 0

                           ");

		if (count($data['error']) > 0) {
			$cron->printLog($data['error']);
		}

	unset($data['error']);

	$data['date_file'] = $cron->dateFile;
	$data['add'] = count($data['add']);

	$cron->logging("products(update:{$data['update']}, add:{$data['add']}, add_options: {$data['add_options']})");

    $cron->logging($data, 'db');

} catch (Exception $e){
    echo $e->getMessage();
 }

