<?php
namespace cron;

require_once('bootstrap.php');

use rest\api\Okay;

require_once('function_cron.php');
$okay = new Okay();

use XBase\TableReader;

$dbProductsPath = 'files/Saitv.dbf';

try
{
	$table = new TableReader($dbProductsPath, ['encoding' => 'CP1251']);

	echo 'Record count: '.$table->getRecordCount() . PHP_EOL;

    $shtr = [];

    while ($record = $table->nextRecord()) {
        $shtr[$record->shtr][] = [
            'shtr' => $record->shtr,
            'name_uk' => $record->name,
            'name_ru' => $record->namer,
            'name_en' => $record->namee,
            'kol' => $record->kol,
            'mas' => $record->mas,
        ];
    }

    $okay->db->query("TRUNCATE TABLE `ok_insertions_file`");

    $i = 0;
    $error = [];
    foreach ($shtr as $pr) {
		$values = [];

		foreach ($pr as $p) {
			if ($p['kol'] > 0 && $p['mas'] > 0) {
				$sh = !empty($p['shtr']) ? $p['shtr'] : '';
				$nu = !empty($p['name_uk']) ? $p['name_uk'] : '';
				$nr = !empty($p['name_ru']) ? $p['name_ru'] : '';
				$ne = !empty($p['name_en']) ? $p['name_en'] : '';
				$kol = !empty($p['kol']) ? $p['kol'] : 0;
				$mas = !empty($p['mas']) ? $p['mas'] : 0;

				$values[] = "({$sh}, '{$nu}', '{$nr}', '{$ne}', {$kol}, {$mas})";
				$i++;
			} else {
				$error[] = $p;
			}
		}

		if (count($values) > 0) {
		$sqlValues = implode(', ', $values);

		$sql = "INSERT INTO `ok_insertions_file`(`shtr`, `name_uk`, `name_ru`, `name_en`, `kol`, `mas`) VALUES " . $sqlValues;

		$okay->db->query($sql);
	}

    }
    echo '<br>' . $i;

    if (count($error) > 0) {
    	echo '<pre>';
    	print_r($error);
		echo '</pre>';
	}
} catch (Exception $e) {
    echo $e->getMessage();
}