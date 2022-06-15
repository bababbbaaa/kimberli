<?php

chdir ('../../');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	require_once('api/Okay.php');
	$okay = new Okay();

	$storeId = $_SESSION['StoreId'];   //Идентификатор магазина
	$password = $_SESSION['Password'];  //Пароль вашего магазина

	$data = file_get_contents('php://input');

	$file = dirname(__FILE__).'/callback.log';
	$myFile = fopen($file, 'a') or die('Unable to open file!');
	$date = date("Y-m-d H:i:s");
	fwrite($myFile, "\n$date-" . $data);
	fclose($myFile);

    /*  $current = file_get_contents($file);
        $current .= "$data\n";
        file_put_contents($file, $current);*/

    $order = $okay->orders->get_order((int) $data.orderId);

     if (empty($order)) {
     	die('Оплачиваемый заказ не найден');
     }

     $method = $okay->payment->get_payment_method(intval($order->payment_method_id));

     if(empty($method)) {
		 die("Неизвестный метод оплаты");
	 }
	
$settings = unserialize($method->settings);

require_once("payment/PayParts/PayParts.php");

    $pp = new PayParts();
    $options = array(
        'StoreId' => $settings['store_id'],
        'Password' => $settings['password'],
        );
    $pp->setOptions($options);
    $ar = $pp->checkCallBack($data);

 if (is_array($ar) && $order->id) {
 switch ($ar['paymentState']){
                case 'CREATED':
                    // Установим статус оплачен
                        $okay->orders->update_order(intval($order->id), array('paid'=>1));
                        // Спишем товары  
                        $okay->orders->close(intval($order->id));
                    break;//Платеж создан
                case 'CANCELED': break;//Платеж отменен (клиентом)
                case 'SUCCESS'://Платеж успешно совершен
                        // Установим статус оплачен
                        $okay->orders->update_order(intval($order->id), array('paid'=>1));
                        // Спишем товары  
                        $okay->orders->close(intval($order->id));

                    break;
                case 'FAIL':  break;//Ошибка при создании платежа
                case 'CLIENT_WAIT': break; //Ожидание оплаты клиента
                case 'OTP_WAITING': break;//Подтверждения клиентом ОТП пароля
                case 'PP_CREATION': break;//создание контракта для платежа
                case 'LOCKED': break;//Платеж подтвержден клиентом и ожидает подтверждение магазином.
            }
}

}