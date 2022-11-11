<?php

namespace cron;

use rest\api\Database;
use XBase\Enum\FieldType;
use XBase\Enum\TableType;
use XBase\Header\Column;
use XBase\Header\HeaderFactory;
use XBase\TableCreator;
use XBase\TableEditor;
use XBase\TableReader;
use RuntimeException;
use Exception;


/**
 * Class cron
 * @package cron
 *
 * @property string fileName;
 * @property string dateFile;
 */
class cron extends Database
{
	public function __construct() {
		parent::__construct();
	}

	public function setFile($fileName)
	{
		if (!empty($fileName) && is_string($fileName) && file_exists($fileName)) {
			$this->fileName = $fileName;
			$this->dateFile = date('Y-m-d H:i:s', filemtime($this->fileName));
		} else {
			throw new RuntimeException('Error sat file: ' . $fileName);
		}
	}


	public function checkLastUpdateFile()
	{
		if (empty($this->fileName) || !is_string($this->fileName)) {
			throw new RuntimeException('File is empty');
		}

		$this->query("SELECT log_id FROM  `ok_dropbox_log` WHERE `date_file` = '{$this->dateFile}' LIMIT 1");

		if ($this->result('log_id')) {
			$this->printLog("File not update. Last update " . $this->dateFile);
			$this->logging("File not update. Last update " . $this->dateFile);
			exit;
		}
	}

	/**
	 */
	public function readFile(): TableReader
	{
		if (empty($this->fileName) || !is_string($this->fileName)) {
			throw new RuntimeException('File is empty');
		}

		try {
			$file = new TableReader($this->fileName, ['encoding' => 'CP1251']);
		} catch (Exception $e) {
			$this->logging('Error read file' . $this->fileName);

			throw new RuntimeException('Error read file' . $this->fileName);
		}

		$getRecordCount = $file->getRecordCount();

		if ($getRecordCount <= 0) {
			$this->logging('getRecordCount: ' . $getRecordCount);

			throw new RuntimeException('getRecordCount: ' . $getRecordCount);
		}

		return $file;
	}

	/**
	 * @param $message
	 * @param string $type
	 * @return bool
	 */
	public function logging($message, string $type = 'file'): bool
	{
		if (empty($message)) {
			return false;
		}

		switch ($type) {
			case 'db':
				if (is_array($message)) {
					$this->query("INSERT INTO `ok_dropbox_log` (`update_product`, `add_product`, `add_options`, `date_file`)
								VALUES ({$message['update']}, {$message['add']}, {$message['add_options']}, '{$message['date_file']}')");
				}

				break;
			case 'file':
			default:
				$file = file_get_contents(__DIR__ . '/dropbox.log');

			$file .= date('Y-m-d H:i:s').': ' . get_current_user() . ': '.$message."\n";

			file_put_contents(__DIR__ . '/dropbox.log', $file);
		}

		return true;
	}

	/**
	 * @return mixed
	 */
	public function updateStockVariant()
	{
		return $this->query("UPDATE `ok_variants` SET `stock` = '0' WHERE `ok_variants`.`stock` > 0;");
	}

	public function updateCurs()
	{
		try {


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.privatbank.ua/p24api/pubinfo?json=&exchange=&coursid=5",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_POSTFIELDS => "",
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$this->printLog($err);
			new RuntimeException('Error curl');
		} else {
			$result = json_decode($response);
			$up_curs = [];

			if (!empty($result) && is_array($result)) {
				foreach ($result as $c) {
					switch ($c->ccy) {
						case 'USD': $up_curs[1]['rate_to'] = round($c->sale, 2);  break;
						case 'EUR': $up_curs[5]['rate_to'] = round($c->sale, 2);  break;
						case 'RUR': $up_curs[2]['rate_to'] = round($c->sale, 2);  break;
						default : break;
					}
				}

				if (!empty($up_curs)) {
					$log = '';
					foreach ($up_curs as $k => $c) {
						if($c['rate_to'] > 0) {
							$this->query("UPDATE ok_currencies SET rate_to = {$c['rate_to']}  WHERE id = $k");
							$log.= $k.': '.$c['rate_to'].', ';
						}
					}

					$this->logging('update curs('.$log.')');
				} else {
					$this->logging('update curs error. New curs empty');
				}
			} else {
				$this->logging('update curs error. New curs empty');
			}
		}
		} catch (Exception $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	public function printLog($var)
	{
		if(is_array($var)){
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}elseif(is_object($var)){
			echo '<pre>';
			print_r($var);
			echo '</pre>';
		}else{
			echo '<br>' . $var . '<br>';
		}
	}

	public static function getInsertionsMap(): array
	{
		return [
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
			'Гр-56' => 'brilliant',
		];
	}
	public static function getInsertionsLang(): array
	{
		return [
			1 => [
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
			3 => [
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
			2 => [
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
		];
	}

	public function getClients()
	{
		try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://joinposter.com/api/clients.getClients?token=640195:9676065de9eef516cc50e8d95b2666f0",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				//CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				//CURLOPT_POSTFIELDS => "",
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				$this->printLog($err);
				throw new RuntimeException('Error curl');
			} else {
				return json_decode($response)->response;
			}
		} catch (Exception $e) {
			throw new RuntimeException($e->getMessage());
		}
	}

	public function setContacts($data)
	{
		//$this->createFile();

		$this->clearFile();

		$this->writeFile($data);

	}
	protected function clearFile($fileName = 'poster.dbf')
	{
		$table = new TableEditor(__DIR__ . '/files/' . $fileName);

		while ($record = $table->nextRecord()) {
			$table->deleteRecord(); //mark record deleted
		}

		$table
			->pack() //remove deleted rows
			->save() //save changes
			->close();
	}

	protected function writeFile($data, $fileName = 'poster.dbf')
	{
		$table = new TableEditor(__DIR__ . '/files/' . $fileName, ['encoding' => 'CP1251']);

		foreach ($data as $contact) {
			try {
			$record = $table->appendRecord();
			$fio = [
				preg_replace('/\PL/u', '', $contact->lastname),
				preg_replace('/\PL/u', '', $contact->firstname),
				preg_replace('/\PL/u', '', $contact->patronymic)
			];

			$record->client_id = $contact->client_id;

			$lastName = implode(' ', $fio);

			if (mb_strlen($lastName,'utf-8') > 40) {
				$lastName = mb_substr($lastName, 0, 40,'utf-8');
			} else {
				$lastName = mb_substr($lastName, 0, mb_strlen($lastName,'utf-8'),'utf-8');
			}

			$record->lastname = $lastName;

			$record->bonus = number_format(($contact->bonus/100), 2, '.', '');
			$record->date_activ = $contact->date_activale;
			$record->phone = $contact->phone;
			$record->email = $contact->email;
			$record->birthday = $contact->birthday;
			$table->writeRecord();
			} catch (\Throwable $e) {
			//	$this->printLog($e);
			}
		}

		$table
			->save()
			->close();
	}

	protected function createFile($fileName = 'poster.dbf')
	{
// you can specify any other database version from TableType
		$header = HeaderFactory::create(TableType::DBASE_III_PLUS_MEMO);
		$filepath = __DIR__ . '/files/' . $fileName;

		$tableCreator = new TableCreator($filepath, $header);

		$tableCreator
			->addColumn(new Column([
				'name'   => 'name',
				'type'   => FieldType::CHAR,
				'length' => 20,
			]))
			->addColumn(new Column([
				'name'   => 'birthday',
				'type'   => FieldType::DATE,
			]))
			->addColumn(new Column([
				'name'   => 'is_man',
				'type'   => FieldType::LOGICAL,
			]))
			->addColumn(new Column([
				'name'   => 'bio',
				'type'   => FieldType::MEMO,
			]))
			->addColumn(new Column([
				'name'         => 'money',
				'type'         => FieldType::NUMERIC,
				'length'       => 20,
				'decimalCount' => 4,
			]))
			->addColumn(new Column([
				'name'   => 'image',
				'type'   => FieldType::MEMO,
			]))
			->save(); //creates file
	}
}