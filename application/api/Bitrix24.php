<?php

namespace rest\api;
/**
 * Class Bitrix24
 */
class Bitrix24 {

	/**
	 * @var array Массив с данными авторизации
	 */
	public $auth = [];

	/**
	 * Тип авторизации: по умолчанию - для приложений с UI
	 */
	const TYPE_DEFAULT = 'default';

	/**
	 * Тип авторизации: Событие - для приложений с UI
	 */
	const TYPE_EVENT = 'event';

	/**
	 * Тип авторизации: Web хук
	 */
	const TYPE_HOOK = 'hook';

	/**
	 * Тип авторизации: oAuth
	 */
	const TYPE_OAUTH = 'oauth';

	/**
	 * Bitrix24 constructor.
	 * @param string $type Тип авторизвции (TYPE_DEFAULT, TYPE_EVENT, TYPE_HOOK, TYPE_OAUTH)
	 * @param array $params Массив параметров
	 * Для типа авторидации TYPE_HOOK:
	 * '''php
	 * $bitrix24 = new Bitrix24(Bitrix24::TYPE_HOOK, [
	 *      "endpoint" => "https://organization.bitrix24.ru", // Домен организации
	 *      "user_id" => 1, // ID пользователя к которому привязан хук
	 *      "token" => "xxxxxxxxxxxxxxxxxxxxxx", // Токен хука
	 * ]);
	 * '''
	 * Для типа авторидации TYPE_OAUTH:
	 * '''php
	 * $bitrix24 = new Bitrix24(Bitrix24::TYPE_OAUTH, [
	 *      "client_id" => "local.xxxxxxxxxxxxxxxxxxxx", // ID приложения
	 *      "client_secret" => "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx", // Токен приложения
	 * ]);
	 * '''
	 */
	public function __construct($type, $params = []) {
		return $this->auth($type, $params);
	}

	/**
	 * Инициалиция компоненты в FrameWork Yii2
	 */
	//public function init() {
		//parent::init();
	//}

	/**
	 * Авторизация
	 * @param string $type Тип авторизвции (TYPE_DEFAULT, TYPE_EVENT, TYPE_HOOK, TYPE_OAUTH)
	 * @param array $params Массив параметров, для типа авторидации TYPE_HOOK и TYPE_OAUTH
	 * @return $this
	 */
	public function auth($type, $params = []) {
		switch ($type) {
			case self::TYPE_DEFAULT:
				$this->auth = [
					'access_token' => htmlspecialchars($_REQUEST['AUTH_ID']),
					'expires_in' => htmlspecialchars($_REQUEST['AUTH_EXPIRES']),
					'application_token' => htmlspecialchars($_REQUEST['APP_SID']),
					'refresh_token' => htmlspecialchars($_REQUEST['REFRESH_ID']),
					'domain' => htmlspecialchars($_REQUEST['DOMAIN']),
					'client_endpoint' => ($_REQUEST['PROTOCOL'] == '0' ? 'http' : 'https') . '://' . htmlspecialchars($_REQUEST['DOMAIN']) . '/rest/',
				];
				break;
			case self::TYPE_EVENT:
				$this->auth = $_REQUEST['auth'];
				break;
			case self::TYPE_HOOK:
				$this->auth = [
					'client_endpoint' => $params['endpoint'] . '/rest/' . $params['user_id'] . '/' . $params['token'],
				];
				break;
			case self::TYPE_OAUTH:
				$oauth = file_get_contents("https://oauth.bitrix.info/oauth/token/?grant_type=authorization_code&client_id=" . $params['client_id'] . "&client_secret=" . $params['client_secret']);// . "&code=" . $_REQUEST['code']);
				$response = json_decode($oauth);
				$this->auth = [
					'client_endpoint' => $response->client_endpoint,
					'access_token' => $response->access_token,
				];
				break;
		}

		return $this;
	}

	/**
	 * Вызов метода REST API Bitrix24
	 * @param string $method Метод
	 * @param array $params Параметры передаваемые в метод
	 * @return mixed Возвращается JSON объект с результатом
	 * ```php
	 * $bitrix24 = new Bitrix24(Bitrix24::TYPE_...);
	 * // or
	 * $bitrix24 = Yii::$app->bitrix->auth(Bitrix24::TYPE_...);
	 * var_dump($bitrix24->call("profile"));
	 * ```
	 */
	public function call($method, $params = []) {
		$queryUrl = $this->auth['client_endpoint'] . '/' . $method . '.json';

		if (isset($this->auth['access_token'])) {
			$params['auth'] = $this->auth['access_token'];
		}

		$obCurl = curl_init();
		curl_setopt($obCurl, CURLOPT_URL, $queryUrl);
		curl_setopt($obCurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($obCurl, CURLOPT_POST, true);
		curl_setopt($obCurl, CURLOPT_POSTFIELDS, http_build_query($params));
		curl_setopt($obCurl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($obCurl, CURLOPT_SSL_VERIFYHOST, false);
		$out = curl_exec($obCurl);
		$result = json_decode($out, true);
		curl_close($obCurl);

		return $result;
	}

}