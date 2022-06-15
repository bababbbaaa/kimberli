<?php

namespace rest\api;

use RuntimeException;
use Throwable;
use rest\providers\CRest;

class LeadBitrix extends Okay {

    public function add_lead_bitrix(array $data, $status = 'Новый заказ на сайте'): bool
	{
            try {

            	$files = [
					'TITLE' => $data['title']?? 'NEW LEAD',
					'NAME' =>$data['name']?? '',
					'SOURCE_ID' => $data['source']?? 'STORE',
					'STATUS_ID' => 'NEW',
					'STATUS_DESCRIPTION' => $status,
					'ADDRESS' => $data['address']?? '',
					'CURRENCY_ID' => $data['currency']?? 'UAH',
					'OPPORTUNITY' => $data['total_price']?? 0,
					'COMMENTS' => $data['comment']?? '',
					'EMAIL' => $data['email']?? '',
					//'WEB' => 'kimberli.ua',
					'ASSIGNED_BY_ID' => 32,
					'UF_CRM_1591106755997' => 32,
					'UF_CRM_5F183BB693BE2' => 188,
					'UTM_SOURCE' => $_COOKIE["utm_source"]?? '',
					'UTM_MEDIUM' => $_COOKIE["utm_medium"]?? '',
					'UTM_CAMPAIGN' => $_COOKIE["utm_campaign"]?? '',
					'UTM_CONTENT' => $_COOKIE["utm_content"]?? '',
					'UTM_TERM' => $_COOKIE["utm_term"]?? '',
				];

            	if (!empty($data['phone'])) {
            		$phone = (string) substr(preg_replace('~[^0-9]+~', '', $data['phone']), 2);
            		if (strlen($phone) == 10) {

						$files['PHONE'] = ['VALUE' => $phone, 'VALUE_TYPE' => 'MOBILE'];

						// add contact to lead
						/*$id = $this->getContactId($phone);

						if ($id) {
							$files['CONTACT_ID'] = $id;
						}*/
					}

				}

				$lead = CRest::call(
					'crm.lead.add',
					[
						'fields' => $files
					]
				);



				if (!empty($data['id']) && !empty($lead['result'])) {

					$leadId = (int) $lead['result'];

					$this->orders->update_order((int) $data['id'], ['lead_id' => $leadId]);

					$this->addProductToLead($leadId, (int) $data['id']);
				}

				if (empty($lead['result'])) {
					l($lead);
				}

            } catch (Throwable $e) {
				Bug::addException($e);
				return false;
            }

		return true;

    }

	/**
	 * @param int $leadId
	 * @param int $orderId
	 * @return array|mixed|string|string[]
	 */
    private function addProductToLead(int $leadId, int $orderId)
	{
		$purchases = $this->orders->get_purchases(array('order_id'=> $orderId) );

		if ($purchases) {
			$rows = [];

			$order = $this->orders->get_order($orderId);

			$coupon = $this->coupons->get_coupon($order->coupon_code);

			if ($coupon && $coupon->valid && $order->total_price >= $coupon->min_order_price) {


				if($coupon->type == 'percentage') {

					$skidka = (100 - $coupon->value) / 100;

					foreach ($purchases as $purchase) {

						$price = round($purchase->price * $skidka, 2);

						$rows[] = [
							'PRODUCT_ID' => $purchase->sku,
							'PRODUCT_NAME' =>  $purchase->product_name . ' SHTR:' . $purchase->sku,
							'PRICE' => $price,
							'DISCOUNT_TYPE_ID' => 2,
							'DISCOUNT_RATE' => $coupon->value,
							'DISCOUNT_SUM' => $purchase->price - $price,
							'QUANTITY' => $purchase->amount,
						];
					}

				} else {
					$skidka = $coupon->value / count($purchases);

					foreach ($purchases as $purchase) {

						$price = round($purchase->price - $skidka, 2);

						$rows[] = [
							'PRODUCT_ID' => $purchase->sku,
							'PRODUCT_NAME' =>  $purchase->product_name . ' SHTR:' . $purchase->sku,
							'PRICE' => $price,
							'DISCOUNT_TYPE_ID' => 1,
							//'DISCOUNT_RATE' => $coupon->value,
							'DISCOUNT_SUM' => $purchase->price - $price,
							'QUANTITY' => $purchase->amount,
						];
					}
				}
			} else {
				foreach ($purchases as $purchase) {
					$rows[] = [
						'PRODUCT_ID' => $purchase->sku,
						'PRODUCT_NAME' =>  $purchase->product_name . ' SHTR:' . $purchase->sku,
						'PRICE' => $purchase->price,
						'QUANTITY' => $purchase->amount,
					];
				}
			}

			return CRest::call(
				'crm.lead.productrows.set',
				[
					'id' => $leadId,
					'rows' => $rows,
				],
			);
		}
	}

    private function getContactId(string $phone): int
	{
		$contact = CRest::call(
			'crm.contact.list',
			[
				'filter' => ['PHONE' => $phone],
				'select' => ['ID'],
			],
		);

		if ($contact['total']) {
			if (isset(current($contact['result'])['ID'])) {
				$id = (int) current($contact['result'])['ID'];
			} else {
				$result = CRest::call(
					'crm.contact.add',
					[
						'fields' => [
							'PHONE' => ['VALUE' => $phone, 'VALUE_TYPE' => 'MOBILE'],
							'ASSIGNED_BY_ID' => 32,
                    		'TYPE_ID' => 'CLIENT',
							'UF_CRM_5F183BB693BE2' => 188,
						],
						'params' => ['REGISTER_SONET_EVENT' => 'Y'],
					],
				);

				$id = $result['result'];
			}
		} else {
			$result = CRest::call(
				'crm.contact.add',
				[
					'fields' => [
						'PHONE' => ['VALUE' => $phone, 'VALUE_TYPE' => 'MOBILE'],
						'ASSIGNED_BY_ID' => 32,
						'TYPE_ID' => 'CLIENT',
						'UF_CRM_5F183BB693BE2' => 188,
					],
					'params' => ['REGISTER_SONET_EVENT' => 'Y'],
				],
			);

			$id = $result['result'];
		}

		return $id;
	}
    
}

/*   $lead = file_get_contents("https://leads.devrise.com.ua/lead_add.php" .
	   "?token=adc76c792dde5305f95adf91d17d9a" .
	   "&TITLE=" . urlencode(isset($data['title']) ? $data['title'] : 'NEW LEAD') .
	   "&NAME=" . urlencode(isset($data['name']) ? $data['name'] : '') .
	   "&SOURCE_ID=" . urlencode(isset($data['source']) ? $data['source'] : 'STORE') .
	   "&STATUS_ID=" . urlencode("NEW") .
	   "&STATUS_DESCRIPTION=" . urlencode($status) .
	   "&ADDRESS=" . urlencode(isset($data['address']) ? $data['address'] : '') .
	   "&CURRENCY_ID=" . urlencode(isset($data['currency']) ? $data['currency'] : 'UAH') .
	   "&OPPORTUNITY=" . urlencode(isset($data['total_price']) ? $data['total_price'] : 0) .
	   "&COMMENTS=" . urlencode(isset($data['comment']) ? $data['comment'] : '') .
	   "&PHONE=" . urlencode(isset($data['phone']) ? $data['phone'] : '') .
	   "&EMAIL=" . urlencode(isset($data['email']) ? $data['email'] : '') .
	   "&WEB=" . urlencode("kimberli.ua") .
	   "&UF_CRM_1591106755997=" . urlencode(168) .
	   "&UTM_SOURCE=" . urlencode(isset($_COOKIE["utm_source"]) ? $_COOKIE["utm_source"] : '') .
	   "&UTM_MEDIUM=" . urlencode(isset($_COOKIE["utm_medium"]) ? $_COOKIE["utm_medium"] : '') .
	   "&UTM_CAMPAIGN=" . urlencode(isset($_COOKIE["utm_campaign"]) ? $_COOKIE["utm_campaign"] : '') .
	   "&UTM_CONTENT=" . urlencode(isset($_COOKIE["utm_content"]) ? $_COOKIE["utm_content"] : '')
   );

   $lead = json_decode($lead);

   if(isset($lead->code)) {
		switch ($lead->code) {
		   case '200':
			   if (!empty($data['id'])) {
				   $this->orders->update_order($data['id'], ['lead_id' => (int) substr($lead->description, 11, -1)]);
			   }
			   break;
		   case '500': $e = new RuntimeException($lead->description, $lead->code); Bug::addException($e); return false;
		   default: break;
	   }
   }*/
