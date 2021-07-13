<?php

namespace rest\controller;

use rest\api\Feedbacks;
use rest\api\Coupons;
use rest\api\SMSClient;
use rest\validation\errors;
use rest\validation\ValidationException;
use rest\entity\Argo;

class rest_controller extends base_controller
{
	public function action_index() {
		$this->response->set([
			'message' => 'action main index'
		]);
	}

	public function action_feedback()
	{
		$feed = new Feedbacks();

		$feedback = new \stdClass;
		$feedback->name         = $this->request->post('name');
		//$feedback->email        = $this->request->get('email');
		$feedback->phone        = $this->request->post('phone');
		$feedback->message      = $this->request->post('message');
		$feedback->utm          = '';

		if (empty($feedback->phone)) {
			throw new ValidationException(errors::create(['phone' => 'Phone not be empty']));
		}

		if (empty($feedback->message)) {
			throw new ValidationException(errors::create(['message' => 'Message not be empty']));
		}

		if (isset($_COOKIE["utm_source"])) {
			$feedback->utm .= $_COOKIE["utm_source"];
		}

		if (isset($_COOKIE["utm_campaign"])) {
			$feedback->utm .= ':' .$_COOKIE["utm_campaign"];
		}

		$feedback->ip = $_SERVER['REMOTE_ADDR'];
		$feedback->lang_id = $feed->languages->lang_id();
		$feedback->url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$feedback_id = $feed->add_feedback($feedback);

		// Отправляем email
		$feed->notify->email_feedback_admin($feedback_id);

		$language = $feed->languages->get_language($feed->languages->lang_id());
		$lang = $feed->translations->get_translations(array('lang'=>$language->label));

		// Создаем лид в битрикс
		$feed->lead->add_lead_bitrix(
			[
				'title' => 'NEW FEEDBACK#' . $feedback_id,
				'name' => $feedback->name,
				'currency' => isset($data['currency']) ? $data['currency'] : 'UAH',
				'comment' => $feedback->message,
				'phone' => $feedback->phone,
				'source' => 'OPENLINE',
			],
			'Обратная связь на сайте'
		);

		return [
			'id' => $feedback_id,
			'message' => '<div class="message_success">
                <b>'. $feedback->name .',</b> <span data-language="feedback_message_sent">' . $lang->feedback_message_sent . '.</span>
            </div>',
		];
	}

	/**
	 * Generate new coupon and send sms
	 *
	 * @return array
	 * @throws \rest\api\SMSError_Exception
	 */
	public function action_coupon()
	{
		$phone = $this->request->post('phone');

		if (empty($phone)) {
			throw new ValidationException(errors::create(['phone' => 'Phone not be empty']));
		}

		$phone = preg_replace('~[^0-9]+~','',$phone);

		if (strlen($phone) == 10) {
			$phone = '38'.$phone;
		}

		$sms = new SMSClient();

		$coupon = new Coupons();

		$kupon = new \stdClass();
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$kupon->code = $coupon->generate_string($permitted_chars, 10);
		$kupon->type = 'percentage';

		$date_expire = new \DateTime('now + 7 days');
		$kupon->expire = $date_expire->format('Y-m-d');
		$kupon->value =  10;
		$kupon->single = 1;


		$coupon->add_coupon($kupon);
		// Создаем лид в битрикс
		$coupon->lead->add_lead_bitrix(
			[
				'title' => 'POPUP-WINDOW',
				'name' => 'Новый попап купон',
				'comment' => "Новый купон '{$kupon->code}' на тел. {$phone}",
				'phone' => $phone,
				'source' => 'OPENLINE',
			],
			'Новый попап купон'
		);

		$id = $sms->send($phone, 'Промокод: ' . $kupon->code);

		$status = $sms->getSMSState($id);

		if (isset($status['StateDescription'])) {
			$status = $status['StateDescription'];
		}

			$language = $coupon->languages->get_language($coupon->languages->lang_id());
			$lang = $coupon->translations->get_translations(array('lang'=>$language->label));

		$coupon->design->assign('lang', $lang);
		$coupon->design->assign('phone', $phone);

			return [
				'id' => $id,
				'status' => $status,
				'message' => $coupon->design->fetch('popap/coupon_result.tpl'),
		];
	}

	/**
	 * Save check to DB
	 *
	 * @return array
	 */
	public function action_argo()
	{
		try {
			$argo = new Argo();

			$id = $argo->create($this->request->get());
		} catch (\RuntimeException $e) {
			$this->response->set_code(400);
			return ['message' => $e->getMessage()];
		}

		return ['numberCheck' => $id];
	}

}