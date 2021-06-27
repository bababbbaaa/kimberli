<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
if(!empty($_SERVER['HTTP_USER_AGENT'])){
    session_name(md5($_SERVER['HTTP_USER_AGENT']));
}

session_start();
//chdir('..');
require_once('function_cron.php');
include_once('../api/Okay.php');
$okay = new Okay();

// LANGUAGE DATA MAP
define('RU', 1);
define('UA', 3);
define('EN', 2);

$insertionsLang = array(
	RU => [
		'ametist' => 'Аметист',
		'brilliant' => 'Бриллиант',
		'rubin' => 'Рубин',
		'sapfir' => 'Сапфир',
		'korall' => 'Коралл',
		'biryuza' => 'Бирюза',
		'goryachayaemal' => 'Горячая эмаль',
		'serebro' => 'Серебро',
		'izumrud' => 'Изумруд',
		'zhemchug' => 'Жемчуг',
		'tsitrin' => 'Цитрин',
		'limonnyjkvarts' => 'Лимонный кварц',
		'granat' => 'Гранат',
		'kvarts' => 'Кварц',
		'peridot' => 'Перидот',
		'topaz' => 'Топаз',
		'haltsedon' => 'Халцедон',
		'gornyjhrustal' => 'Горный хрусталь',
		'praziolit' => 'Празиолит',
		'turmalin' => 'Турмалин',
		'tsavorit' => 'Цаворит',
		'perlamutr' => 'Перламутр',
        'chrysoprase' => 'Хризопраз'
	],
	UA => [
		'ametist' => 'Аметист',
		'brilliant' => 'Діамант',
		'rubin' => 'Рубін',
		'sapfir' => 'Сапфір',
		'korall' => 'Корал',
		'biryuza' => 'Бірюза',
		'goryachayaemal' => 'Гаряча емаль',
		'serebro' => 'Срібло',
		'izumrud' => 'Смарагд',
		'zhemchug' => 'Перли',
		'tsitrin' => 'Цитрин',
		'limonnyjkvarts' => 'Лимонний кварц',
		'granat' => 'Гранат',
		'kvarts' => 'Кварц',
		'peridot' => 'Перідот',
		'topaz' => 'Топаз',
		'haltsedon' => 'Халцедон',
		'gornyjhrustal' => 'Горний кришталь',
		'praziolit' => 'Празиолит',
		'turmalin' => 'Турмалін',
		'tsavorit' => 'Цаворіт',
		'perlamutr' => 'Перламутр',
        'chrysoprase' => 'Хризопраз'
	],
	EN => [
		'ametist' => 'Amethyst',
		'brilliant' => 'Diamond',
		'rubin' => 'Ruby',
		'sapfir' => 'Sapphire',
		'korall' => 'Coral',
		'biryuza' => 'Turquoise',
		'goryachayaemal' => 'Hot enamel',
		'serebro' => 'Silver',
		'izumrud' => 'Emerald',
		'zhemchug' => 'Pearls',
		'tsitrin' => 'Citrine',
		'limonnyjkvarts' => 'Lemon Quartz',
		'granat' => 'Garnet',
		'kvarts' => 'Quartz',
		'peridot' => 'Peridot',
		'topaz' => 'Topaz',
		'haltsedon' => 'Chalcedony',
		'gornyjhrustal' => 'Rhinestone',
		'praziolit' => 'Prasiolite',
		'turmalin' => 'Tourmaline',
		'tsavorit' => 'Tsavorite',
		'perlamutr' => 'Nacre',
        'chrysoprase' => 'Chrysoprase'
	]

);
$insertionsMap = array(
	
	'Аметист' => 'ametist',
	'Изумруд' => 'izumrud',
	'Рубин' => 'rubin',
	'Сапфир' => 'sapfir',
	'Сапф' => 'sapfir',
	'Хризопраз' => 'chrysoprase',
	'Ов-57' => 'brilliant',
	'Корал' => 'korall',
	'Гар. емаль' => 'goryachayaemal',
	'Серебро' => 'serebro',
	'Жемчуг' => 'zhemchug',
	'Цитрин' => 'tsitrin',
	'Кварц лимон' => 'limonnyjkvarts',
	'Гранат' => 'granat',
	'Кварц' => 'kvarts',
	'Перидот' => 'peridot',
	'Топаз' => 'topaz',
	'Бирюза' => 'biryuza',
	'горн хрусталь' => 'gornyjhrustal',
	'Халцедон' => 'haltsedon',
	'Празиолiт' => 'praziolit',
	'Турмалин' => 'turmalin',
	'Цаворит' => 'tsavorit',
	'3/4 1.10' => 'brilliant',
	'Перламутр' => 'perlamutr',
	'рубін' => 'rubin',
    'Коньяч брил' => 'brilliant',
    'Жемч.золот' => 'zhemchug',
    'Кр-57' => 'brilliant',
    'Пр-57' => 'brilliant',
    'Гр-57' => 'brilliant',
    'Мр-57' => 'brilliant',
    'Кр-17' => 'brilliant',
    'бр-багет' => 'brilliant',
);

$log = [];
$insertions = [];
$products = [];
$limit = 1000;
try
{
    
$okay->db->query("SELECT i.`shtr`
FROM `ok_insertions_file` i
INNER JOIN ok_variants v ON v.sku = i.shtr
WHERE i.`sync` = 0
GROUP BY i.`shtr`
LIMIT {$limit}");

if ($okay->db->num_rows() == 0) {
    exit();
}

$shtr = $okay->db->results();
$shtrs = [];

foreach ($shtr as $v) {
    $shtrs[] = $v->shtr;
  //  $productIds[] = $v->product_id;
	//$varIds[] = $v->id;
}

$str_shtr = implode(',', $shtrs);

$okay->db->query("UPDATE `ok_insertions_file` SET `sync`= 1 WHERE shtr in ({$str_shtr})");
//$okay->db->query("DELETE FROM `ok_insertions` WHERE `product_id` in({$str_products_ids})");

$okay->db->query("DELETE FROM `ok_insertions` WHERE `shtr` in({$str_shtr})");


//$okay->db->query("SELECT i.*, v.product_id FROM `ok_insertions_file` i INNER JOIN ok_variants v ON v.sku = i.shtr WHERE i.shtr in ({$str_shtr})");
$okay->db->query("SELECT i.*, v.sku FROM `ok_insertions_file` i INNER JOIN ok_variants v ON v.sku = i.shtr WHERE i.shtr in ({$str_shtr})");

$inserts = $okay->db->results();
if (count($inserts)){
    $group = [];
    foreach ($inserts as $ins) {
        $dop = [];
        foreach ($insertionsMap as $hayStack => $translit) {
			if (strpos($ins->name_ru, $hayStack) !== false) {
				$dop['translit'] = $translit;
                                $dop['title_uk'] = $insertionsLang[3][$translit];
                                $dop['title_ru'] = $insertionsLang[1][$translit];
                                $dop['title_en'] = $insertionsLang[2][$translit];
				break;
                        }
		}
                
        if (count($dop) != 4) {
            continue;
        }
        
        $group[$ins->shtr][] = (object) array_merge((array)$ins, $dop);
    }
    $count_s = $count_p = 0;
    foreach ($group as $g) {
        $sql = "INSERT INTO `ok_insertions` (`shtr`, `name`, `translit`, `mass`, `count`,`title`, `lang_id`) VALUES ";
        $values = [];
        foreach ($g as $v) {
        	$p = (array) $v;
        	$pId = $p['shtr'];

			$translit = !empty($p['translit']) ? $p['translit'] : '';

			$nu = !empty($p['name_uk']) ? $p['name_uk'] : '';
			$nr = !empty($p['name_ru']) ? $p['name_ru'] : '';
			$ne = !empty($p['name_en']) ? $p['name_en'] : '';

			$tu = !empty($p['title_uk']) ? $p['title_uk'] : '';
			$tr = !empty($p['title_ru']) ? $p['title_ru'] : '';
			$te = !empty($p['title_en']) ? $p['title_en'] : '';

			$kol = !empty($p['kol']) ? $p['kol'] : 0;
			$mas = !empty($p['mas']) ? $p['mas'] : 0;

            $values[] = "({$pId}, '{$nu}', '{$translit}', '{$mas}', '{$kol}', '{$tu}',3)";
            $values[] = "({$pId},'{$nr}','{$translit}','{$mas}','{$kol}','{$tr}',1)";
            $values[] = "({$pId},'{$ne}','{$translit}','{$mas}','{$kol}','{$te}',2)";
            $count_s ++;
        }
        $sqlValues = implode(', ', $values);
        $sql .= $sqlValues;

        $okay->db->query($sql);
        $count_p ++;
    }
    
}

$log_messsage = "insertions(update:{$count_p})";
set_log($log_messsage);

print_r(['p' => $count_p, 's' => $count_s]);

} catch (\Exception $e){
    echo $e->getMessage();
    die();   
 }