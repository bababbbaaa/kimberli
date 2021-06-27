<?php

require_once('Okay.php');

class LeadBitrix extends Okay { 
    
    public function add_lead_bitrix($id, $quick = '') {
        if(!empty($id) && $order = $this->orders->get_order((int)$id)) {
            // Способ оплаты
            $payment_method = $this->payment->get_payment_method($order->payment_method_id);
            
            if(!empty($payment_method)) {
                // Валюта оплаты
                $currency = $this->money->get_currency(intval($payment_method->currency_id))->code;
            }
            try {
                $param = [
                    "TITLE" => "NEW ORDER#".$order->id ,
                    "NAME" => $order->name,
                    "SOURCE_ID" => "STORE",
                    "STATUS_ID" => "NEW",
                    "STATUS_DESCRIPTION" => "Создан новый заказ на сайте",
                    "ADDRESS" => $order->address,
                    "CURRENCY_ID" => !empty($currency) ? $currency : 'UAH',
                    "OPPORTUNITY" => $order->total_price,
                    "COMMENTS" => $quick . $order->comment,
                    "PHONE" => $order->phone,
                    "EMAIL" => $order->email,
                    //"CONTACT_ID" => $order->user_id,
                    "WEB" => "kimberli.ua",
                    "UF_CRM_1591106755997" => 168
                ];
                
                $lead = file_get_contents("https://leads.devrise.com.ua/lead_add.php?token=adc76c792dde5305f95adf91d17d9a&".http_build_query($param));
                if(isset($lead->code)) {
                switch ($lead->code) {
                    case '200':  $this->orders->update_order($order->id, ['lead_id'=>(int)substr($lead->description, 11, -1)]);  break;
                    default: break;
                }
            }
            } catch (Exception $e) {
                $this->bug->add_exception($e);
            } 
        }
    }
    
}
