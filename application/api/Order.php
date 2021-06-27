<?php

namespace rest\api;

use rest\validation\errors;
use rest\validation\ValidationException;

class Order extends Okay {

	public function __construct()
	{
		parent::__construct();
	}

	public function create(array $data = [])
	{
		$order = new \stdClass;
		$order->payment_method_id = isset($data['payment_method_id']) ? $data['payment_method_id'] : '';
		$order->delivery_id = isset($data['delivery_id']) ? $data['delivery_id'] : '';
		$order->name        = isset($data['name']) ? $data['name'] : '';
		$order->email       = isset($data['email']) ? $data['email'] : '';
		$order->address     = isset($data['address']) ? $data['address'] : '';
		$order->phone       = isset($data['phone']) ? $data['phone'] : '';
		$order->comment     = isset($data['comment']) ? $data['comment'] : '';
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

			// Создаем лид в битрикс
			$this->lead->add_lead_bitrix(
				[
					'title' => 'NEW ORDER#' . $order->id,
					'id' => $order->id,
					'name' => $order->name,
					'address' => $order->address,
					'currency' => isset($data['currency']) ? $data['currency'] : 'UAH',
					'total_price' => $order->total_price,
					'comment' => $order->comment,
					'phone' => $order->phone,
					'email' => $order->email,
					'source' => 'STORE',
				],
				'Новый заказ на сайте'
			);

			// Отправляем письмо пользователю
			$this->notify->email_order_user($order->id);

			// Отправляем письмо администратору
			$this->notify->email_order_admin($order->id);

			$language = $this->languages->get_language($this->languages->lang_id());
			$lang = $this->translations->get_translations(array('lang'=>$language->label));

			//sms
			try {
				$message = $lang->user_order_number . ' ' . $order->id . $lang->cart_deliveries_to_pay . ' ' . $order->total_price;

				$phone = $order->phone;

				if (strlen($order->phone) == 10) {
					$phone = '38'.$phone;
				}

				$this->sms->send($phone, $message);
			} catch (\Throwable $e) {

			}

			// Очищаем корзину (сессию)
			$this->cart->empty_cart();

			return [
				'orderId' => $order->id,
				'type' => 'order',
				'url' => '/'.$this->languages->get_lang_link . 'order/' . $order->url,
				'value' => $order->total_price,
				'currency' => isset($data['currency']) ? $data['currency'] : 'UAH',
			];

	}

	public function get($orderId)
	{
		return $this->orders->get_order($orderId);
	}

	public function quickOrder(array $data = [])
	{
		$order = new \stdClass;
		$order->payment_method_id = '';
		$order->delivery_id = '';
		$order->phone       = isset($data['phone']) ? $data['phone'] : '';
		$order->ip          = $_SERVER['REMOTE_ADDR'];
		$order->utm			= '';

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
		$this->lead->add_lead_bitrix(
			[
				'title' => 'NEW ORDER#' . $order->id,
				'id' => $order->id,
				'name' => $order->name,
				'address' => $order->address,
				'currency' => isset($data['currency']) ? $data['currency'] : 'UAH',
				'total_price' => $order->total_price,
				'comment' => $order->comment,
				'phone' => $order->phone,
				'email' => $order->email,
				'source' => 'STORE',
			],
			'Быстрый заказ на сайте'
		);

		// Отправляем письмо администратору
		$this->notify->email_order_admin($order->id);

		$language = $this->languages->get_language($this->languages->lang_id());
		$lang = $this->translations->get_translations(array('lang'=>$language->label));
		$this->design->assign('lang', $lang);
		//sms
		try {
			$message = $lang->user_order_number . ' ' . $order->id . $lang->cart_deliveries_to_pay . ' ' . $order->total_price;

			$phone = $order->phone;

			if (strlen($order->phone) == 10) {
				$phone = '38'.$phone;
			}

			$this->sms->send($phone, $message);
		} catch (\Throwable $e) {

		}

		$this->design->assign('phone', $order->phone);
		$this->design->assign('orderId', $order->id);

		$result = $this->design->fetch('product/quick_order_result.tpl');

		return [
			'orderId' => $order->id,
			'type' => 'quick',
			'value' => $order->total_price,
			'currency' => isset($data['currency']) ? $data['currency'] : 'UAH',
			'message' => $result,
		];

	}

}
