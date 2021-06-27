<?php
namespace rest\api;

use mysqli;

class db {

	private $mysqli;

	private $res;
	private $log_dir;

	private $config;

	public function __construct() {
		$this->config = new Config();

		$this->connect();
	}

	/**
	 * В деструкторе отсоединяемся от базы
	 */
	public function __destruct() {
		$this->disconnect();
	}

	public function connect() {
		// При повторном вызове возвращаем существующий линк
		if(!empty($this->mysqli)) {
			return $this->mysqli;
		} else { // Иначе устанавливаем соединение
			$this->mysqli = new mysqli($this->config->db_server, $this->config->db_user, $this->config->db_password, $this->config->db_name);
		}
		// Выводим сообщение, в случае ошибки
		if($this->mysqli->connect_error)
		{
			@file_get_contents('https://api.telegram.org/bot539849731:AAH9t4G2hWBv5tFpACwfFg3RqsPhK4NrvKI/sendMessage?chat_id=' . 404070580 . '&text=' . urlencode($this->mysqli->connect_error)).'&parse_mode=HTML';
			//trigger_error("Could not connect to the database: ".$this->mysqli->connect_error, E_USER_WARNING);
			echo file_get_contents('https://kimberli.ua/500.html');
			exit();
		}
		// Или настраиваем соединение
		else
		{
			if($this->config->db_charset)
				$this->mysqli->query('SET NAMES '.$this->config->db_charset);
			if($this->config->db_sql_mode)
				$this->mysqli->query('SET SESSION SQL_MODE = "'.$this->config->db_sql_mode.'"');
			if($this->config->db_timezone)
				$this->mysqli->query('SET time_zone = "'.$this->config->db_timezone.'"');
		}
		return $this->mysqli;
	}



}
