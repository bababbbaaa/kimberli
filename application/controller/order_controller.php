<?php
namespace rest\controller;

use rest\api\Order;
use rest\api\SMSClient;

class order_controller extends base_controller
{

	public function action_create()
	{
		$order = new Order();

		return $order->create($this->request->post());
	}

	public function action_quick()
	{
		$order = new Order();

		return $order->quickOrder($this->request->post());
	}

	public function action_get($orderId)
	{
		$order = new Order();
		$orderId = (int) $orderId;

		return (array) $order->get($orderId);
	}
	public function action_sms_balance()
	{
		$sms = new SMSClient();
		return $sms->getBalance();
	}

	public function action_sms_send()
	{
		$phone = $this->request->get('phone');

		if (strlen($phone) == 10) {
			$phone = '38'.$phone;
		}

		$sms = new SMSClient();
		$code  = mt_rand(1000,9999);

		$id = $sms->send($phone, $code);

		try {
			$status = $sms->getSMSState($id);

			if (isset($status['StateDescription'])) {
				$status = $status['StateDescription'];
			}
		} catch (\Exception $e) {
			$status = $e->getMessage();
		}

		return [
			'id' => $id,
			'status' => $status,
			'code' => $code,
		];

	}

	public function action_sms_status()
	{
		$id = $this->request->get('id');

		$sms = new SMSClient();

		$status = $sms->getSMSState($id);

		if ($status['StateDescription'] !== 'Доставлено') {
			return ['status' => true];
		}

		return ['status' => false];

	}
}