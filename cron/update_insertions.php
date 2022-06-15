<?php
namespace cron;

use Exception;

require_once('bootstrap.php');

$cron = new cron();

$insertionsLang = cron::getInsertionsLang();
$insertionsMap = cron::getInsertionsMap();

$limit = 500;

try {
	$cron->query("SELECT i.`shtr`
	FROM `ok_insertions_file` i
	INNER JOIN ok_variants v ON v.sku = i.shtr
	WHERE i.`sync` = 0
	GROUP BY i.`shtr`
	LIMIT {$limit}");

	if ($cron->num_rows() == 0) {
		exit();
	}

	$shtr = implode(',', $cron->results('shtr'));

	$cron->query("UPDATE `ok_insertions_file` SET `sync`= 1 WHERE shtr in ({$shtr})");

	$cron->query("DELETE FROM `ok_insertions` WHERE `shtr` in({$shtr})");

	$cron->query("SELECT i.*, v.sku FROM `ok_insertions_file` i INNER JOIN ok_variants v ON v.sku = i.shtr WHERE i.shtr in ({$shtr})");

	$inserts = $cron->results();

	$count_s = $count_p = 0;

	if (count($inserts)) {
		$group = [];

		foreach ($inserts as $ins) {
			$dop = [];
			foreach ($insertionsMap as $hayStack => $tr) {
				if (strpos($ins->name_ru, $hayStack) !== false) {
					 $dop['translate'] = $tr;
					 $dop['title_uk'] = $insertionsLang[3][$tr];
					 $dop['title_ru'] = $insertionsLang[1][$tr];
					 $dop['title_en'] = $insertionsLang[2][$tr];
				break;
				}
			}

			if (count($dop) != 4) {
				continue;
			}

			$group[$ins->shtr][] = array_merge((array) $ins, $dop);
		}

		$sql = "INSERT INTO `ok_insertions` (`shtr`, `name`, `translit`, `mass`, `count`,`title`, `lang_id`) VALUES ";

		foreach ($group as $g) {
			$values = [];
			foreach ($g as $p) {
				$pId = $p['shtr'];

				$translate = !empty($p['translate']) ? $p['translate'] : '';

				$nu = !empty($p['name_uk']) ? $p['name_uk'] : '';
				$nr = !empty($p['name_ru']) ? $p['name_ru'] : '';
				$ne = !empty($p['name_en']) ? $p['name_en'] : '';

				$tu = !empty($p['title_uk']) ? $p['title_uk'] : '';
				$tr = !empty($p['title_ru']) ? $p['title_ru'] : '';
				$te = !empty($p['title_en']) ? $p['title_en'] : '';

				$kol = !empty($p['kol']) ? $p['kol'] : 0;
				$mas = !empty($p['mas']) ? $p['mas'] : 0;

				$values[] = "({$pId}, '{$nu}', '{$translate}', '{$mas}', '{$kol}', '{$tu}', 3)";
				$values[] = "({$pId}, '{$nr}', '{$translate}', '{$mas}', '{$kol}', '{$tr}', 1)";
				$values[] = "({$pId}, '{$ne}', '{$translate}', '{$mas}', '{$kol}', '{$te}', 2)";

				$count_s ++;
			}

			$cron->query($sql . implode(', ', $values));
			$count_p ++;
		}

	}

$cron->logging("insertions(update:{$count_p})");
} catch (\Throwable $e){
    echo $e->getMessage();
 }