<?php

//error_reporting(E_ALL^E_NOTICE);

require_once(dirname(__DIR__).'/vendor/autoload.php');

/**
 * Class Okay
 */

class Okay {
	private $debug = false;
	public string $country = '';

	/*public $config = null;
	public $request = null;
	public $db = null;
	public $settings = null;
	public $design = null;
	public $products = null;
	public $variants = null;
	public $categories = null;
	public $brands = null;
	public $features = null;
	public $money = null;
	public $pages = null;
	public $blog = null;
	public $cart = null;
	public $image = null;
	public $delivery = null;
	public $payment = null;
	public $orders = null;
	public $users = null;
	public $coupons = null;
	public $comments = null;
	public $feedbacks = null;
	public $notify = null;
	public $managers = null;
	public $languages = null;
	public $translations = null;
	public $comparison = null;
	public $subscribes = null;
	public $banners = null;
	public $callbacks = null;
	public $reportstat = null;
	public $validate = null;
	public $orderlabels = null;
	public $orderstatus = null;
	public $supportinfo = null;
	public $support = null;
	public $import = null;
	public $menu = null;
	public $backend_translations = null;
	public $front_translations = null;
	public $seo_filter_patterns = null;
	public $features_aliases = null;
	public $features_values = null;
	public $insertions = null;
	public $dropbox = null;
	public $bug = null;
	public $lead = null;
	public $compilation = null;
	public $sms = null;
	public $vacancy = null;*/

    
    private $classes = array(
        'config'        => 'Config',
        'request'       => 'Request',
        'db'            => 'Database',
        'settings'      => 'Settings',
        'design'        => 'Design',
        'products'      => 'Products',
        'variants'      => 'Variants',
        'categories'    => 'Categories',
        'brands'        => 'Brands',
        'features'      => 'Features',
        'money'         => 'Money',
        'pages'         => 'Pages',
        'blog'          => 'Blog',
        'cart'          => 'Cart',
        'image'         => 'Image',
        'delivery'      => 'Delivery',
        'payment'       => 'Payment',
        'orders'        => 'Orders',
        'users'         => 'Users',
        'coupons'       => 'Coupons',
        'comments'      => 'Comments',
        'feedbacks'     => 'Feedbacks',
        'notify'        => 'Notify',
        'managers'      => 'Managers',
        'languages'     => 'Languages',
        'translations'  => 'Translations',
        'comparison'    => 'Comparison',
        'subscribes'    => 'Subscribes',
        'banners'       => 'Banners',
        'callbacks'     => 'Callbacks',
        'reportstat'    => 'ReportStat',
        'validate'      => 'Validate',
        'orderlabels'   => 'OrderLabels',
        'orderstatus'   => 'OrderStatus',
        'supportinfo'   => 'SupportInfo',
        'support'       => 'Support',
        'import'        => 'Import',
        'menu'          => 'Menu',
        'backend_translations' => 'BackendTranslations',
        'front_translations'   => 'FrontTranslations',
        'seo_filter_patterns'  => 'SEOFilterPatterns',
        'features_aliases'     => 'FeaturesAliases',
        'features_values'      => 'FeaturesValues',
        'insertions'           => 'Insertions',
        'dropbox'              => 'Dropbox',
        'bug'                  => 'Bug',
        'lead'                 => 'LeadBitrix',
        'compilation'          => 'Compilations',
		'sms'				   => 'SMSClient',
		'vacancy'			   => 'Vacancy',
    );
    
    private static $objects = array();

    public $translit_pairs = array(
        // русский
        array(
            'from'  => "А-а-Б-б-В-в-Ґ-ґ-Г-г-Д-д-Е-е-Ё-ё-Є-є-Ж-ж-З-з-И-и-І-і-Ї-ї-Й-й-К-к-Л-л-М-м-Н-н-О-о-П-п-Р-р-С-с-Т-т-У-у-Ф-ф-Х-х-Ц-ц-Ч-ч-Ш-ш-Щ-щ-Ъ-ъ-Ы-ы-Ь-ь-Э-э-Ю-ю-Я-я",
            'to'    => "A-a-B-b-V-v-G-g-G-g-D-d-E-e-E-e-E-e-ZH-zh-Z-z-I-i-I-i-I-i-J-j-K-k-L-l-M-m-N-n-O-o-P-p-R-r-S-s-T-t-U-u-F-f-H-h-TS-ts-CH-ch-SH-sh-SCH-sch---Y-y---E-e-YU-yu-YA-ya"
        ),
        // грузинский
        array(
            'from'  => "ა-ბ-გ-დ-ე-ვ-ზ-თ-ი-კ-ლ-მ-ნ-ო-პ-ჟ-რ-ს-ტ-უ-ფ-ქ-ღ-ყ-შ-ჩ-ც-ძ-წ-ჭ-ხ-ჯ-ჰ",
            'to'    => "a-b-g-d-e-v-z-th-i-k-l-m-n-o-p-zh-r-s-t-u-ph-q-gh-qh-sh-ch-ts-dz-ts-tch-kh-j-h"
        ),

    );

    public $spec_pairs = array(
        '+'  => 'p',
        '-'  => 'm',
        '—'  => 'ha',
        '–'  => 'hb',
        '−'  => 'hc',
        '‐'  => 'hd',
        '/'  => 'f',
        '°'  => 'deg',
        '±'  => 'pm',
        '_'  => 'u',
        '.'  => 'd',
        ','  => 'c',
        '@'  => 'at',
        '('  => 'lb',
        ')'  => 'rb',
        '{'  => 'lf',
        '}'  => 'rf',
        '['  => 'ls',
        ']'  => 'rs',
        ';'  => 'sem',
        ':'  => 'col',
        '%'  => 'pe',
        '$'  => 'do',
        ' '  => 'sp',
        '?'  => 'w',
        '&'  => 'a',
        '*'  => 's',
        '®'  => 'r',
        '©'  => 'co',
        '\'' => 'ap',
        '"'  => 'qu',
        '`'  => 'bt',
        '<'  => 'le',
        '>'  => 'mo',
        '#'  => 'sh',
        '№'  => 'n',
        '!'  => 'em',
        '~'  => 't',
        '^'  => 'h',
        '='  => 'eq',
        '|'  => 'vs',
        
    );
    
    public function __construct() {
        $this->debug = $this->config->debug_mode;

        if ($this->debug == true && isset($_SESSION['admin'])) {
            ini_set('display_errors', 'on');
            error_reporting(E_ALL);
        } else {
            ini_set('display_errors', 'off');
        }
        
      /*  if (empty($this->country) && isset($_SESSION['country']['ip']) && $_SESSION['country']['ip'] == $_SERVER['REMOTE_ADDR']) {
        	$this->country = $_SESSION['country']['iso'];
		} else if (!empty($this->country) && isset($_SESSION['country']['ip']) && $_SESSION['country']['ip'] != $_SERVER['REMOTE_ADDR']) {
        	$this->getCountry();
		} else {
			$this->getCountry();
		}*/
    }
    
    private function getCountry()
	{
		$is_bot = preg_match(
			"~(Google|Yahoo|Rambler|Bot|Yandex|Spider|Snoopy|Crawler|Finder|Mail|curl)~i",
			$_SERVER['HTTP_USER_AGENT']
		);
		
		try {
			$geo = !$is_bot ? json_decode(file_get_contents('http://api.sypexgeo.net/json/' . $_SERVER['REMOTE_ADDR']), true) : [];
			
			$this->country = isset($geo['country']['iso']) ? $geo['country']['iso'] : '';
			
			if (!empty($this->country)) {
				$_SESSION['country'] = [
					'iso' => $this->country,
					'ip' => $_SERVER['REMOTE_ADDR'],
				];
			}
		} catch (Throwable $e) {
		
		}
		
	}
    
    public function __get($name) {
        // Если такой объект уже существует, возвращаем его
        if(isset(self::$objects[$name])) {
            return(self::$objects[$name]);
        }

        // Если запрошенного API не существует - ошибка
        if(!array_key_exists($name, $this->classes)) {
            return null;
        }

        // Определяем имя нужного класса
        $class = $this->classes[$name];

        // Подключаем его
		require_once(dirname(__FILE__).'/'.$class.'.php');

        // Сохраняем для будущих обращений к нему
        self::$objects[$name] = new $class();

        // Возвращаем созданный объект
        return self::$objects[$name];
    }

    public function recaptcha() {
        $g_recaptcha_response = $this->request->post('g-recaptcha-response');
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.google.com/recaptcha/api/siteverify',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(array('secret'=>$this->settings->secret_recaptcha,
                'response'=>$g_recaptcha_response,
                'remoteip'=>$_SERVER['REMOTE_ADDR']))
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        if (strpos($response, 'invalid-input-secret')){
            return true;
        } else {
            return !strpos($response, 'false');
        }
    }

    public function translit($text) {
        $res = $text;
        foreach ($this->translit_pairs as $pair) {
            $from = explode('-', $pair['from']);
            $to = explode('-', $pair['to']);
            $res = str_replace($from, $to, $res);
        }

        $res = preg_replace("/[\s]+/ui", '-', $res);
        $res = preg_replace("/[^a-zA-Z0-9\.\-\_]+/ui", '', $res);
        $res = strtolower($res);
        return $res;
    }
    
    public function translit_alpha($text) {
        $res = $text;
        foreach ($this->translit_pairs as $pair) {
            $pair['from'] = explode('-', $pair['from']);
            $pair['to'] = explode('-', $pair['to']);

            $pair = $this->spec_pairs($pair);

            $res = str_replace($pair['from'], $pair['to'], $res);
        }

        $res = preg_replace("/[\s]+/ui", '', $res);
        $res = preg_replace("/[^a-zA-Z0-9]+/ui", '', $res);
        $res = strtolower($res);
        return $res;
    }

    //Добавляет к массиву пар для транслита, пары для замены спецсимволов на буквенные обозначения
    private function spec_pairs($pair) {
        foreach ($this->spec_pairs as $symbol => $alias) {
            $pair['from'][] = $symbol;
            $pair['to'][]   = $alias;
        }

        return $pair;
    }

    public function d($var)
	{
		if ($this->debug) {
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


	}
    
}
