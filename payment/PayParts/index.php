<?php

chdir ('../../');
require_once('api/Okay.php');

$okay = new Okay();

if ($okay->request->post('send_pay')) {
   
    $order = $okay->orders->get_order((int)$okay->request->post('orderId'));
    $settings = $okay->payment->get_payment_settings($order->payment_method_id);
$products = [];
foreach ($okay->request->post('products') as $pp){
   $products[] = $pp; 
}

    $host = 'https://kimberli.ua';
    $options = array(
        'StoreId' => $settings['store_id'],
        'Password' => $settings['password'],
        'ResponseUrl' => $host.'/payment/PayParts/callback.php',          //URL, на который Банк отправит результат сделки (НЕ ОБЯЗАТЕЛЬНО)
        'RedirectUrl' => $host.'/order/'.$order->url,          //URL, на который Банк сделает редирект клиента (НЕ ОБЯЗАТЕЛЬНО)
        'PartsCount' => $okay->request->post('partsCount'),  //Количество частей на которые делится сумма транзакции ( >1)
      //  'Prefix' => '',                                  //Параметр не обязательный если Prefix указан с пустотой или не указа вовсе префикс будет ORDER
        'orderId' => $okay->request->post('orderId'),                                 //Если OrderID задан с пустотой или не укан вовсе OrderID сгенерится автоматически
        'merchantType' => $okay->request->post('merchantType'),                          //II - Мгновенная рассрочка; PP - Оплата частями; PB - Оплата частями. Деньги в периоде. IA - Мгновенная рассрочка. Акционная.
        'Currency' => '980',                             //Валюта по умолчанию 980 – Украинская гривна; Значения в соответствии с ISO
        'ProductsList' => $products,                 //Список продуктов, каждый продукт содержит поля: name - Наименование товара price - Цена за еденицу товара (Пример: 100.00) count - Количество товаров данного вида
        'recipientId' => ''                              //Идентификатор получателя, по умолчанию берется основной получатель. Установка основного получателя происходит в профиле магазина.
        );
        require_once("payment/PayParts/PayParts.php");
         
    $pp = new PayParts();
    $pp->setOptions($options);
    
    $send = $pp->create('pay');//hold //pay
    if(isset($send['state']) && $send['state'] == 'SUCCESS'){
        header('Location: https://payparts2.privatbank.ua/ipp/v2/payment?token=' . $send['token']);
    }else{
        $_SESSION['error_payment'] =  $send;
       // echo $send;
         header('Location: '.$host.'/order/'.$order->url);
    }
}else{
    echo 'error';
}
 exit;