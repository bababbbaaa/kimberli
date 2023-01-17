<?php

namespace rest\api;

use rest\providers\facebook;
use rest\validation\errors;
use rest\validation\ValidationException;
use Exception;
use stdClass;
use Throwable;

class Order extends Okay {

	private $order = null;

	public function __construct($id = null)
	{
		parent::__construct();

		if (null != $id) {
			$order = $this->orders->get_order($id);

			if ($order) {
				
				$order->purchases = $this->getOrderProducts($id);
				
				$this->order = $order;
			}
		}
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function create(array $data = []): array
	{
		$order = new stdClass;
		$order->payment_method_id = $data['payment_method_id']?? '';
		$order->delivery_id = $data['delivery_id']?? '';
		$order->name        = $data['name']?? '';
		$order->email       = $data['email']?? '';
		$order->address     = $data['address']?? '';
		$order->phone       = $data['phone']?? '';
		$order->comment     = $data['comment']?? '';
		$order->ip          = $_SERVER['REMOTE_ADDR']?? '';
		$order->utm			= '';

        if ($order->phone == '+38 (096) 817-13-30') {
            $order->comment     = 'test';
        }

		// Скидка
		$cart = $this->cart->get_cart();
		$order->discount = $cart->discount;

		if($cart->coupon) {
			$order->coupon_discount = $cart->coupon_discount;
			$order->coupon_code = $cart->coupon->code;
		}

		if(!empty($this->user->id)) {
			$order->user_id = $this->user->id;
		}

		/*Валидация данных клиента*/
		/*if(!$this->validate->is_name($order->name, true)) {
			throw new ValidationException(errors::create(['name' => 'Name not be empty']));
		}
		if(!$this->validate->is_email($order->email, true)) {
			throw new ValidationException(errors::create(['email' => 'Email not be empty']));
		}*/
		if (!$this->validate->is_phone($order->phone)) {
			throw new ValidationException(errors::create(['phone' => 'Phone not be empty']));
		}

		/*if (!$this->validate->is_address($order->address)) {
			throw new ValidationException(errors::create(['address' => 'Address not be empty']));
		}
		if (!$this->validate->is_comment($order->comment)) {
			throw new ValidationException(errors::create(['comment' => 'Comment not be empty']));
		}*/

		if (empty($data['amounts'])) {
			throw new ValidationException(errors::create(['amounts' => 'Variants not be empty']));
		}

		if ($order->phone == '+38 (096) 817-13-30') {
			$order->comment = 'test order';
		}

			// Добавляем заказ в базу
			$order->lang_id = $this->languages->lang_id();

			// Добавляем метку к заказу

			if (isset($_COOKIE["utm_source"])) {
				$order->utm .= $_COOKIE["utm_source"];
			}

			if (isset($_COOKIE["utm_campaign"])) {
				$order->utm .= ':' .$_COOKIE["utm_campaign"];
			}

			$order_id = $this->orders->add_order($order);
			$_SESSION['order_id'] = $order_id;

			if (!empty($order->utm)) {
				$this->orderlabels->add_order_labels($order_id, [4]);
			}

			// Добавляем товары к заказу
			foreach($data['amounts'] as $variant_id => $amount) {
				$this->orders->add_purchase(array('order_id'=>$order_id, 'variant_id'=> intval($variant_id), 'amount'=>intval($amount)));
			}

			$order = $this->orders->get_order($order_id);

			// Стоимость доставки
			$delivery = $this->delivery->get_delivery($order->delivery_id);

			if(!empty($delivery) && $delivery->free_from > $order->total_price) {
				$this->orders->update_order($order->id, array('delivery_price'=>$delivery->price, 'separate_delivery'=>$delivery->separate_payment));
			} elseif ($delivery->separate_payment) {
				$this->orders->update_order($order->id, array('separate_delivery'=>$delivery->separate_payment));
			}

			// Отправляем письмо пользователю
			//$this->notify->email_order_user($order->id);

			// Отправляем письмо администратору
			$this->notify->email_order_admin($order->id);

			//$language = $this->languages->get_language($this->languages->lang_id());
			//$lang = $this->translations->get_translations(array('lang'=>$language->label));

			//sms
			/*try {
				$message = $lang->user_order_number . ' ' . $order->id . $lang->cart_deliveries_to_pay . ' ' . $order->total_price;

				$phone = $order->phone;

				if (strlen($order->phone) == 10) {
					$phone = '38'.$phone;
				}

				//$this->sms->send($phone, $message);
			} catch (Throwable $e) {}
			*/

			// Очищаем корзину (сессию)
			$this->cart->empty_cart();

		try {
			(new LeadBitrix())
				->add_lead_bitrix(
					[
						'title' => 'NEW ORDER#' . $order->id,
						'id' => $order->id,
						'total_price' => $order->total_price,
						'comment' => $order->comment,
						'phone' => $order->phone,
					]
				);
		} catch (Exception $e) {}

		try {
			facebook::send(['event' => 'Purchase', 'orderId' => $order->id, 'currency' => ($data['currency'] ?? 'UAH'), 'url' => 'order']);
		} catch (Exception $e) {}
		
		if ($order) {
			$order->purchases = $this->getOrderProducts($order->id);
		}

			return [
				'type' => 'order',
				'url' => '/'.$this->languages->get_lang_link . 'order/' . $order->url,
				'value' => $order->total_price,
				'currency' => $data['currency']?? 'UAH',
				'order' => $order,
			];

	}

	/**
	 * @return array
	 */
	public function shopping()
	{
		$cart = $this->cart->get_cart();

		$this->design->assign('cart', $cart);

		/*Определяем валюту*/
		$currencies = $this->money->get_currencies(array('enabled'=>1));
		if(isset($_SESSION['currency_id'])) {
			$currency = $this->money->get_currency($_SESSION['currency_id']);
		} else {
			$currency = reset($currencies);
		}
		$this->design->assign('currency',	$currency);

		/*Определяем язык*/
		$language = $this->languages->get_language($this->languages->lang_id());
		//$this->design->assign('language', $language);
		//$this->design->assign('lang_link', $this->languages->get_lang_link());

		$this->design->assign('lang', $this->translations->get_translations(array('lang'=>$language->label)));

		return [
			//'products' => $cart,
			'message' => $this->design->fetch('cart/continue_shopping.tpl'),
		];
	}

	public function fitting($data): array
	{
		if (empty($data['phone'])) {
			throw new ValidationException(errors::create(['phone' => 'Phone not be empty']));
		}

		$order = new stdClass;
		$order->payment_method_id = '';
		$order->delivery_id = '';
		$order->name        = '';
		$order->email       = '';
		$order->address     = '';
		$order->phone       = $data['phone'];
		$order->comment     = isset($data['dop_variant']) ? 'Хочу подобрать больше украшений' : '';
		$order->ip          = $_SERVER['REMOTE_ADDR'];
		$order->utm			= '';

		// Скидка
		$cart = $this->cart->get_cart();
		$order->discount = $cart->discount;

		if($cart->coupon) {
			$order->coupon_discount = $cart->coupon_discount;
			$order->coupon_code = $cart->coupon->code;
		}

		if(!empty($this->user->id)) {
			$order->user_id = $this->user->id;
		}

		// Добавляем заказ в базу
		$order->lang_id = $this->languages->lang_id();

		// Добавляем метку к заказу

		if (isset($_COOKIE["utm_source"])) {
			$order->utm .= $_COOKIE["utm_source"];
		}

		if (isset($_COOKIE["utm_campaign"])) {
			$order->utm .= ':' .$_COOKIE["utm_campaign"];
		}

		$order_id = $this->orders->add_order($order);
		$_SESSION['order_id'] = $order_id;

		if (!empty($order->utm)) {
			$this->orderlabels->add_order_labels($order_id, [4]);
		}

		$this->orderlabels->add_order_labels($order_id, [5]);

		// Добавляем товары к заказу
		foreach($cart->purchases as $purchase) {
			$this->orders->add_purchase(array('order_id'=>$order_id, 'variant_id'=> intval($purchase->variant->id), 'amount'=>intval($purchase->amount)));
		}

		$order = $this->orders->get_order($order_id);

		// Создаем лид в битрикс
		(new LeadBitrix())
			->add_lead_bitrix(
			[
				'title' => 'NEW FITTING ORDER#' . $order->id,
				'id' => $order->id,
				'total_price' => $order->total_price,
				'comment' => $order->comment,
				'phone' => $order->phone,
			],
			'Новый заказ на примерку'
		);

		try {
			facebook::send(['event' => 'Fitting', 'orderId' => $order->id, 'currency' => ($data['currency'] ?? 'UAH'), 'url' => $_SERVER['HTTP_REFERER'] ?? '']);
		} catch (Exception $e) {}

		/*Определяем язык*/
		$language = $this->languages->get_language($this->languages->lang_id());
		$this->design->assign('lang', $this->translations->get_translations(array('lang'=>$language->label)));


		return [
			'message' => $this->design->fetch('cart/fitting_result.tpl'),
		];
	}

	public function get($orderId = null)
	{
		if (null != $orderId) {
			$order = $this->orders->get_order($orderId);

			if (!$order) {
				return null;
			}
			
			$order->purchases = $this->getOrderProducts($order->id);

			return $order;
		}

		return $this->order;
	}

	public function getOrderProducts($orderId = null)
	{
		if (null !== $orderId) {
			return $this->orders->get_purchases(['order_id' => $orderId]);
		} else if (null != $this->order) {
			return $this->orders->get_purchases(['order_id' => $this->order->id]);
		}

		return [];
	}

	public function quickOrder(array $data = [])
	{
		$order = new stdClass;
		$order->payment_method_id = '';
		$order->delivery_id = '';
		$order->phone       = $data['phone'] ?? '';
		$order->ip          = $_SERVER['REMOTE_ADDR'];
		$order->utm			= '';
		$order->url			= $_SERVER['HTTP_REFERER'] ?? '';

        if ($order->phone == '+38 (096) 817-13-30') {
            $order->comment     = 'test';
        }

		if(!empty($this->user->id)) {
			$order->user_id = $this->user->id;
		}

		if (empty($data['phone'])) {
			throw new ValidationException(errors::create(['phone' => 'Phone not be empty']));
		}

		if (empty($data['variant'])) {
			throw new ValidationException(errors::create(['variant' => 'Variant not be empty']));
		}

		// Добавляем заказ в базу
		$order->lang_id = $this->languages->lang_id();

		// Добавляем метку к заказу

		if (isset($_COOKIE["utm_source"])) {
			$order->utm .= $_COOKIE["utm_source"];
		}

		if (isset($_COOKIE["utm_campaign"])) {
			$order->utm .= ':' .$_COOKIE["utm_campaign"];
		}

		$order_id = $this->orders->add_order($order);

		$this->orderlabels->add_order_labels($order_id, [3]);

		if (!empty($order->utm)) {
			$this->orderlabels->add_order_labels($order_id, [4]);
		}

		// Добавляем товар к заказу
		$this->orders->add_purchase(
			[
				'order_id' => $order_id,
				'variant_id' => (int) $data['variant'],
				'amount' => 1
			]
		);

		$order = $this->orders->get_order($order_id);

		// Создаем лид в битрикс
		(new LeadBitrix())
			->add_lead_bitrix(
			[
				'title' => 'NEW ORDER#' . $order->id,
				'id' => $order->id,
				'total_price' => $order->total_price,
				'comment' => $order->comment,
				'phone' => $order->phone,
			],
			'Быстрый заказ на сайте'
		);

		// Отправляем письмо администратору
		$this->notify->email_order_admin($order->id);

		$language = $this->languages->get_language($this->languages->lang_id());
		$lang = $this->translations->get_translations(array('lang'=>$language->label));
		$this->design->assign('lang', $lang);
		//sms
		/*try {
			$message = $lang->user_order_number . ' ' . $order->id . $lang->cart_deliveries_to_pay . ' ' . $order->total_price;

			$phone = $order->phone;

			if (strlen($order->phone) == 10) {
				$phone = '38'.$phone;
			}

			$this->sms->send($phone, $message);
		} catch (Throwable $e) {

		}*/

		try {
			facebook::send(['event' => 'quickOrder', 'orderId' => $order->id, 'currency' => ($data['currency'] ?? 'UAH'), 'url' => $order->url]);
		} catch (Exception $e) {

		}

		$this->design->assign('phone', $order->phone);
		$this->design->assign('orderId', $order->id);

		$result = $this->design->fetch('product/quick_order_result.tpl');
		
		if ($order) {
			$order->purchases = $this->getOrderProducts($order->id);
		}

		return [
			'orderId' => $order->id,
			'type' => 'quick',
			'value' => $order->total_price,
			'currency' => $data['currency']?? 'UAH',
			'message' => $result,
			'order' => $order,
		];

	}

}
