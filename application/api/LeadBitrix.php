<?php

namespace rest\api;

use http\Exception\RuntimeException;

class LeadBitrix extends Okay {
    
    public function add_lead_bitrix(array $data, $status = 'Новый заказ на сайте') {

            try {
                $lead = file_get_contents("https://leads.devrise.com.ua/lead_add.php" .
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

                if(isset($lead->code)) {
					 switch ($lead->code) {
                    	case '200':
                    		if (!empty($data['id'])) {
								$this->orders->update_order($data['id'], ['lead_id' => (int) substr($lead->description, 11, -1)]);
							}
						break;
						//case '500': throw new RuntimeException($lead->code_text);
                   	 default: break;
                	}
            	}

            } catch (\Throwable $e) {
				//throw new RuntimeException($e->getMessage());
            }
    }
    
}
