<?php
namespace rest\controller;

use rest\api\Bitrix24;

//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

//use Bitrix24\Bitrix24;
use rest\providers\CRest;


class bitrix_controller extends base_controller
{

	public function action_add_lead()
	{
		/* return CRest::call(
			'crm.lead.add',
			[
				'fields' =>[
					'TITLE' => 'Название лида',//Заголовок*[string]
					'NAME' => 'Имя',//Имя[string]
					'LAST_NAME' => 'Фамилия',//Фамилия[string],
					'CONTACT_ID'=> 19359,
				]

			]
		);*/
	/*	$phone = '0968171330';

		$contact = CRest::call(
			'crm.contact.list',
            [
                'filter' => [ 'PHONE' => $phone],
                'select' =>  [ 'ID'],
            ],
		);

		if ($contact['total']) {
			if (isset(current($contact['result'])['ID'])) {
				$id = (int) current($contact['result'])['ID'];

				return [$id];
			}


		}*/

		/*return CRest::call(
			'crm.contact.get',
			[
				'id' => 19359,
				]
		);*/

		return CRest::call(
			'crm.lead.get',
			[
				'id' => 29831,
			]
		);
		/*return CRest::call(
			'crm.lead.productrows.get',
			[
				'id' => 29863,
			]
		);*/





		/*return CRest::call(
			'crm.contact.add',
			[
				'fields' => [
					'NAME' => 'Yaroslav',
					'SECOND_NAME' => 'A',
					'LAST_NAME' => 'Romanchuk',
					'OPENED' => 'Y',
					'TYPE_ID' => 'CLIENT',
					'SOURCE_ID' => 'STORE',
					'PHONE' => ['VALUE' => '380968171331', 'VALUE_TYPE' => 'MOBILE'],
				],
				'params' =>  ['REGISTER_SONET_EVENT' => 'Y'],
			],
		);*/
	}

	/*public function action_profile()
	{
// init lib
		$obB24App = new \Bitrix24\Bitrix24(false);
		//$obB24App->setApplicationScope($arParams['B24_APPLICATION_SCOPE']);
		//$obB24App->setApplicationId($arParams['B24_APPLICATION_ID']);
		//$obB24App->setApplicationSecret($arParams['B24_APPLICATION_SECRET']);

		$obB24App->setDomain('kimberli.ua');
		//$obB24App->setAccessToken($arParams['AUTH_ID']);

		/*$profile = new Bitrix24(Bitrix24::TYPE_OAUTH, [
	       "client_id" => "app.5f32eee7cb8ab4.46841907", // ID приложения
	       "client_secret" => "VdK3IoIbtWxQyNc80o1HKlfMydRAW2oijX0F5daFhd5W6LTt7T", // Токен приложения
	  ]);*/
		//$obB24User = new \Bitrix24\User\User($obB24App);
	//	$arCurrentB24User = $obB24User->current();

		//return $arCurrentB24User;
	//}*/
}