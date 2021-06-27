<?php

namespace rest\entity;

use rest\api\Okay;
use rest\api\Orders;


class Order extends Okay {

	public function __construct()
	{
		//parent::__construct();
	}


	public function create(array $data = [])
	{
		//print_r(['fgsdfg']);
		//$order = new stdClass;
		$or = new Orders();


		$order = $or->get_order(786);

		//$order_id = $this->orders->add_order($order);

		return $order;
	}

}
