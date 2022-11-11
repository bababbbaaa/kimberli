<?php

namespace rest\controller;

use rest\api\Okay;
use rest\providers\facebook;
use rest\validation\errors;
use rest\validation\ValidationException;

class cart_controller extends base_controller
{
	/**
	 * Add to Cart
	 *
	 * @return array
	 */
	public function action_add(): array
	{
		$variant = $this->request->get('variant', null);

		if (empty($variant)) {
			throw new ValidationException(errors::create(['variant' => 'Variant not be empty']));
		}

		$amount = $this->request->get('amount', 1);

		$object = new Okay();

		$object->cart->add_item((int) $variant, (int) $amount);
		
		$result['variant'] = '';

		$cart = $object->cart->get_cart();

		$object->design->assign('cart', $cart);

		/*Определяем валюту*/
		$currencies = $object->money->get_currencies(array('enabled'=>1));
		if(isset($_SESSION['currency_id'])) {
			$currency = $object->money->get_currency($_SESSION['currency_id']);
		} else {
			$currency = reset($currencies);
		}

		$object->design->assign('currency',	$currency);

		/*Определяем язык*/
		$language = $object->languages->get_language($object->languages->lang_id());
		$object->design->assign('language', $language);
		$object->design->assign('lang_link', $object->languages->get_lang_link());
		$object->translations->debug = (bool) $object->config->debug_translation;
		$object->design->assign('lang', $object->translations->get_translations(array('lang'=>$language->label)));

		try {
			$result[] = facebook::send(['event' => 'AddToCart', 'cart' => $cart, 'currency' => ($data['currency'] ?? 'UAH'), 'url' => $_SERVER['HTTP_REFERER'] ?? '']);
		} catch (\Exception $e) {}

		$result['cart_informer'] = $cart->total_products;

		$result['cart_popap'] = $object->design->fetch('cart/cart_popap.tpl');

		return $result;
	}

	public function action_remove()
	{

	}

	public function action_clear()
	{

	}
}