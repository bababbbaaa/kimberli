<?php

chdir ('../../');

session_start();

require_once("payment/PayParts/PayParts.php");

$pp = new PayParts($_SESSION['StoreId'], $_SESSION['Password']);
$getState = $pp->getState($_SESSION['OrderID'], false); //orderId, showRefund

/*можно ожидать результат платежа который пришёл в ResponseUrl*/
//var_dump($_SESSION['OrderID']);

if ($getState['paymentState'] === 'SUCCESS') {

	require_once('api/Okay.php');
	$okay = new Okay();
    //echo 'SUCCESS';

	$order = $okay->orders->get_order((int) $_SESSION['OrderID']);

	header('Location: https://kimberli.ua/order/'.$order->url. '/', 302);
    /*проводим проводки на магазине оплата прошла
    если был создан Отложенный платеж то делаем подтверждение
    $ConfirmHold=$pp->ConfirmHold($_SESSION['OrderID']);
    или отказываемся если нужно
    $CancelHold=$pp->CancelHold('ORDER-D3AE1082C5E2F81F2A904EAC3DB990E0A8F211B0'
    анализируем $ConfirmHold там будет результат операции*/
} else {
    echo $getState['paymentState'];
    /*есть ошибки в оплате или отказ*/
}