<?php
/**
 * @deprecated
 */

    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Okay.php');
    define('IS_CLIENT', true);
    $okay = new Okay();
    $errors = [];
    $result = '';
    
     /*Определяем язык*/
    $language = $okay->languages->get_language($okay->languages->lang_id());
    $lang = $okay->translations->get_translations(array('lang'=>$language->label));
    $okay->design->assign('lang', $lang);
    
    $order = new stdClass;
            $order->payment_method_id = '';
            $order->delivery_id = '';
            //$order->name        = $okay->request->post('name');
            $order->email       = '';
            $order->address     = '';
            $order->phone       = $okay->request->post('phone');
            $order->comment     = $lang->quick_order_header;
            $order->ip          = $_SERVER['REMOTE_ADDR'];
            $captcha_code =  $okay->request->post('captcha_code', 'string');
            $order->utm = '';

           // $okay->design->assign('name', $order->name);
            $okay->design->assign('phone', $order->phone);

            if(!empty($okay->user->id)) {
                $order->user_id = $okay->user->id;
            }

            /*Валидация данных клиента*/
           /* if(!$okay->validate->is_name($order->name, true)) {
                $errors[] = "name";
            } else
                */

            if(!$okay->validate->is_phone($order->phone, true)) { 
                 $errors[] = "phone";
            } elseif($okay->settings->captcha_quick_order && !$okay->validate->verify_captcha('captcha_quick_order', $captcha_code)) {
                $errors[] = "captcha";
            } else {
                
                if(!empty($okay->user->id)) {
                    $order->user_id = $okay->user->id;
                }

				// Добавляем метку к заказу
				if (isset($_COOKIE["utm_source"])) {
					$order->utm .= $_COOKIE["utm_source"];
				}

				if (isset($_COOKIE["utm_campaign"])) {
					$order->utm .= ':' .$_COOKIE["utm_campaign"];
				}

                // Добавляем заказ в базу
                $order->lang_id = $okay->languages->lang_id();
                $order_id = $okay->orders->add_order($order);
                //$_SESSION['order_id'] = $order_id;

				if (!empty($order->utm)) {
					$this->orderlabels->add_order_labels($order_id, [4]);
				}

                // Добавляем товар к заказу
                $okay->orders->add_purchase(array('order_id'=>$order_id, 'variant_id'=>intval($okay->request->post('variant')), 'amount'=>1));

                $order = $okay->orders->get_order($order_id);

                $okay->orderlabels->add_order_labels($order_id, [3]);

                // Отправляем письмо администратору
                $okay->notify->email_order_admin($order->id);
                
                $okay->design->assign('orderId', $order->id);
                
                // Создаем лид в битрикс
                $okay->lead->add_lead_bitrix($order_id, $quick = 'Быстрый заказ!');
               
                $result = $okay->design->fetch('product/quick_order_result.tpl');
            }
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    die(json_encode(['errors' => $errors, 'text' => $result]));
