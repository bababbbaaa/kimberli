<?php

require_once('View.php');

class CartView extends View {

    public function __construct() {
        parent::__construct();

        // Если передан id варианта, добавим его в корзину
        if($variant_id = $this->request->get('variant', 'integer')) {
            $this->cart->add_item($variant_id, $this->request->get('amount', 'integer'));
            header('location: '.$this->config->root_url.'/'.$this->lang_link.'cart/');
        }

        // Удаление товара из корзины
        if($delete_variant_id = intval($this->request->get('delete_variant'))) {
            $this->cart->delete_item($delete_variant_id);
            if(!isset($_POST['submit_order']) || $_POST['submit_order']!=1) {
                header('location: '.$this->config->root_url.'/'.$this->lang_link.'cart/');
            }
        }
            // Если нам запостили amounts, обновляем их
            if($amounts = $this->request->post('amounts')) {
                foreach($amounts as $variant_id=>$amount) {
                    $this->cart->update_item($variant_id, $amount);
                }

                $coupon_code = trim($this->request->post('coupon_code', 'string'));
                if(empty($coupon_code)) {
                    $this->cart->apply_coupon('');
                    header('location: '.$this->config->root_url.'/'.$this->lang_link.'cart/');
                } else {
                    $coupon = $this->coupons->get_coupon((string)$coupon_code);
                    if(empty($coupon) || !$coupon->valid) {
                        $this->cart->apply_coupon($coupon_code);
                        $this->design->assign('coupon_error', 'invalid');
                    } else {
                        $this->cart->apply_coupon($coupon_code);
                        header('location: '.$this->config->root_url.'/'.$this->lang_link.'cart/');
                    }
                }
            }
    }

    /*Отображение заказа*/
    public function fetch() {
        // Способы доставки
        $deliveries = $this->delivery->get_deliveries(array('enabled'=>1));
        foreach($deliveries as $delivery) {
            $delivery->payment_methods = $this->payment->get_payment_methods(array('delivery_id'=>$delivery->id, 'enabled'=>1));
        }
        $this->design->assign('all_currencies', $this->money->get_currencies());
        $this->design->assign('deliveries', $deliveries);
        
        // Данные пользователя
        if($this->user) {
            $last_order = $this->orders->get_orders(array('user_id'=>$this->user->id, 'limit'=>1));
            $last_order = reset($last_order);
            if($last_order) {
                $this->design->assign('name', $last_order->name);
                $this->design->assign('email', $last_order->email);
                $this->design->assign('phone', $last_order->phone);
                $this->design->assign('address', $last_order->address);
            } else {
                $this->design->assign('name', $this->user->name);
                $this->design->assign('email', $this->user->email);
                $this->design->assign('phone', $this->user->phone);
                $this->design->assign('address', $this->user->address);
            }
        }
        
        // Если существуют валидные купоны, нужно вывести инпут для купона
        if($this->coupons->count_coupons(array('valid'=>1))>0) {
            $this->design->assign('coupon_request', true);
        }

        // Выводим корзину
        return $this->design->fetch('cart.tpl');
    }
    
}
