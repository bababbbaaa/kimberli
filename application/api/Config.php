<?php

namespace rest\api;
use InvalidArgumentException;

/**
 * Класс-обертка для конфигурационного файла с настройками магазина
 * В отличие от класса Settings, Config оперирует низкоуровневыми настройками, например найстройками базы данных.
 * @property $db_server
 * @property $db_user
 * @property $db_password
 * @property $db_name
 * @property $db_charset
 * @property $db_sql_mode
 * @property $db_timezone
 */


class Config {

    /*Версия системы*/
    public string $version = '2.3.0';
    /*Тип системы*/
    public $version_type = 'pro';
    
    /*Файл для хранения настроек*/
    public string $config_file = __DIR__ . '/../../config/config.php';
    public string $config_develop_file = __DIR__  . '/../../config/config.local.php';

    private array $vars = [];

    /*
     * В конструкторе записываем настройки файла в переменные этого класса
     *  для удобного доступа к ним. Например: $okay->config->db_user
     * */
    public function __construct() {
        /*Читаем настройки из дефолтного файла*/

        $c_file = $this->config_file;

        if (file_exists($c_file)) {
			$ini = parse_ini_file($c_file);
			/*Записываем настройку как переменную класса*/
			foreach($ini as $var=>$value) {
				$this->vars[$var] = $value;
			}
		} else {
			throw new InvalidArgumentException('No file config');
		}

        /*Заменяем настройки, если есть локальный конфиг*/
        if (file_exists($this->config_develop_file)) {
            $ini = parse_ini_file( $this->config_develop_file);
            foreach ($ini as $var => $value) {
                $this->vars[$var] = $value;
            }
        }


        // Вычисляем DOCUMENT_ROOT вручную, так как иногда в нем находится что-то левое
        $localpath = (string) getenv("SCRIPT_NAME");
        $absolutepath = (string) getenv("SCRIPT_FILENAME");

        if (!empty($localpath) && !empty($absolutepath)) {
			$pos = (strpos($absolutepath, $localpath) == false) ? 1 : strpos($absolutepath, $localpath);

			$_SERVER['DOCUMENT_ROOT'] = substr($absolutepath,0, $pos);
		} else {
			$_SERVER['DOCUMENT_ROOT'] = '/';
		}

        
        // Адрес сайта - тоже одна из настроек, но вычисляем его автоматически, а не берем из файла
        $script_dir1 = realpath(dirname(dirname(dirname(__FILE__))));
        $script_dir2 = realpath($_SERVER['DOCUMENT_ROOT']);

        $subdir = trim(substr($script_dir1, strlen($script_dir2)), "/\\");
        
        // Протокол
        $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'? 'https' : 'http' : 'https';

        if(isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"] == 443) {
			$protocol = 'https';
		} else if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1')))
            $protocol = 'https';
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on')
            $protocol = 'https';


        $this->vars['protocol'] = $protocol;
        $this->vars['root_url'] = isset($_SERVER['HTTP_HOST']) ? $protocol.'://'.rtrim($_SERVER['HTTP_HOST']) : '';

        if(!empty($subdir)) {
            $this->vars['root_url'] .= '/'.$subdir;
        }
        
        // Подпапка в которую установлен OkayCMS относительно корня веб-сервера
        $this->vars['subfolder'] = $subdir.'/';
        
        // Определяем корневую директорию сайта
        $this->vars['root_dir'] =  dirname(dirname(dirname(__FILE__))).'/';
        
        // Максимальный размер загружаемых файлов
        $max_upload = (int)(ini_get('upload_max_filesize'));
        $max_post = (int)(ini_get('post_max_size'));
        $memory_limit = (int)(ini_get('memory_limit'));
        $this->vars['max_upload_filesize'] = min($max_upload, $max_post, $memory_limit)*1024*1024;
        
        // Соль (разная для каждой копии сайта, изменяющаяся при изменении config-файла)
        $s = stat($this->config_file);

       // print_r($s); exit;

        $this->vars['salt'] = md5(md5_file($this->config_file).$s['dev'].$s['ino'].$s['uid'].$s['mtime']);
        
        // Часовой пояс
        if(!empty($this->vars['php_timezone'])) {
            date_default_timezone_set($this->vars['php_timezone']);
        }
    }

    /*Выборка настройки*/
    public function __get($name) {
        if(isset($this->vars[$name])) {
            return $this->vars[$name];
        } else {
            return null;
        }
    }

    /*Запись данных в конфиг*/
    public function __set($name, $value) {
        if(isset($this->vars[$name])) {
            $conf = file_get_contents($this->config_file);
            $conf = preg_replace("/".$name."\s*=.*\n/i", $name.' = '.$value."\r\n", $conf);
            $cf = fopen($this->config_file, 'w');
            fwrite($cf, $conf);
            fclose($cf);
            $this->vars[$name] = $value;
        }
    }

    /*Формирование токена*/
    public function token($text) {
        return md5($text.$this->salt);
    }

    /*Проверка токена*/
    public function check_token($text, $token) {
        if(!empty($token) && $token === $this->token($text)) {
            return true;
        }
        return false;
    }
    
}
