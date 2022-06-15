<?php

chdir ('../../');
require_once('api/Okay.php');

$okay = new Okay();

if ($okay->request->post('send_pay')) {

	$order = $okay->orders->get_order( (int) $okay->request->post('orderId'));

    $settings = $okay->payment->get_payment_settings($order->payment_method_id);

	$products = $okay->request->post('products');

	$ProductsList = [];

	$_SESSION['StoreId'] =  $settings['store_id'];   //Идентификатор магазина
	$_SESSION['Password'] = $settings['password'];  //Пароль вашего магазина


	$coupon = $okay->coupons->get_coupon($order->coupon_code);


	if ($coupon && $coupon->valid && $order->total_price >= $coupon->min_order_price) {


			if($coupon->type == 'percentage') {

				$skidka = (100 - $coupon->value) / 100;

				foreach ($products as $pp) {
					$pp['price'] = round($pp['price'] * $skidka, 2);


					$ProductsList[] = $pp;
				}

			} else {
				$skidka = $coupon->value / count($products);

				foreach ($products as $pp) {
					$pp['price'] = round($pp['price'] - $skidka, 2);

					$ProductsList[] = $pp;
				}
			}
	} else {
		foreach ($products as $pp) {
			$ProductsList[] = $pp;
		}
}

	$total = 0;

	foreach ($ProductsList as $p) {
		$total += $p['price'];
	}

	//print_r($total); exit;


    $host = 'https://kimberli.ua';
    $options = array(
        'StoreId' => $settings['store_id'],
        'Password' => $settings['password'],
		'amount' => $order->total_price,
        'ResponseUrl' => $host.'/payment/PayParts/callback.php',          //URL, на который Банк отправит результат сделки (НЕ ОБЯЗАТЕЛЬНО)
        'RedirectUrl' => $host.'/payment/PayParts/redirect.php', //'/order/'.$order->url,          //URL, на который Банк сделает редирект клиента (НЕ ОБЯЗАТЕЛЬНО)
        'PartsCount' => $okay->request->post('partsCount'),  //Количество частей на которые делится сумма транзакции ( >1)
      //  'Prefix' => '',                                  //Параметр не обязательный если Prefix указан с пустотой или не указа вовсе префикс будет ORDER
        'orderId' => (int) $okay->request->post('orderId'), //Если OrderID задан с пустотой или не укан вовсе OrderID сгенерится автоматически
        'merchantType' => $okay->request->post('merchantType'), //II - Мгновенная рассрочка; PP - Оплата частями; PB - Оплата частями. Деньги в периоде. IA - Мгновенная рассрочка. Акционная.
        'Currency' => '980',                             //Валюта по умолчанию 980 – Украинская гривна; Значения в соответствии с ISO
        'ProductsList' => $ProductsList,                 //Список продуктов, каждый продукт содержит поля: name - Наименование товара price - Цена за еденицу товара (Пример: 100.00) count - Количество товаров данного вида
        'recipientId' => ''                              //Идентификатор получателя, по умолчанию берется основной получатель. Установка основного получателя происходит в профиле магазина.
        );

require_once("payment/PayParts/PayParts.php");
         
    $pp = new PayParts();

    $pp->setOptions($options);

    $error = '';

	try {
		$send = $pp->create(); //hold //pay
		$token = $send['token'];

		$okay->orders->update_order($order->id, ['pay_token' => $token]);
	} catch (\Throwable $e) {

		if ($e->getMessage() === 'bad value: Payment with sent orderId already exists') {
			$getState = $pp->getState($order->id, false);

			if ($getState['state'] === 'SUCCESS') {
				switch ($getState['paymentState']) {
					case 'SUCCESS': break;
					case 'CREATED':
						$token = $order->pay_token;
					break;
					default: break;
				}

			}
		} else {
			$okay->bug->add_exception($e);
		}

		header('Location: '. $host.'/order/'.$order->url. '/?error=' . $e->getMessage(), 302);

		exit;
	}

	$_SESSION['OrderID'] = $order->id;

	header('Location: https://payparts2.privatbank.ua/ipp/v2/payment?token=' .$token);

} else {
    echo 'error';
}
exit;