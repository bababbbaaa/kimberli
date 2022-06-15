<?php
namespace cron;

require_once('bootstrap.php');

$cron = new cron();
$cron->setFile(__DIR__ . '/files/Saitv.dbf');

try {
	$table = $cron->readFile();

	//echo 'Record count: '.$table->getRecordCount() . PHP_EOL;

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

	$cron->query("TRUNCATE TABLE `ok_insertions_file`");

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

		$cron->query("INSERT INTO `ok_insertions_file`(`shtr`, `name_uk`, `name_ru`, `name_en`, `kol`, `mas`) VALUES " . $sqlValues);
	}

    }


    if (count($error) > 0) {
    	$cron->printLog($i);
    	$cron->printLog($error);
	}
} catch (\Exception $e) {
    echo $e->getMessage();
}