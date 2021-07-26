<?php

namespace rest\controller;

use rest\api\Feedbacks;
use rest\api\Callbacks;
use rest\api\Comments;
use rest\api\Coupons;
use rest\api\SMSClient;
use rest\validation\errors;
use rest\validation\ValidationException;
use rest\entity\Argo;
use RuntimeException;
use Exception;

class rest_controller extends base_controller
{
	public function action_index() {
		$this->response->set([
			'message' => 'action main index'
		]);
	}

	/**
	 * FeedBack Form
	 *
	 * @return array
	 */
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
		$feedback->url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

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

	public function action_callback()
	{
		$call = new Callbacks();

		$callback = new \stdClass();
		$callback->phone        = $this->request->post('phone');
		$callback->name         = $this->request->post('name');
		$callback->url          = $this->request->post('url')?? 'https://'.$_SERVER['HTTP_HOST'].($_SERVER['REQUEST_URI']?? '');
		$callback->message      = $this->request->post('message');
		$callback->utm = '';

		/*Определяем язык*/
		$language = $call->languages->get_language($call->languages->lang_id());
		$lang = $call->translations->get_translations(['lang'=>$language->label]);
		$call->design->assign('lang', $lang);

		if (empty($callback->phone)) {
			throw new ValidationException(errors::create(['phone' => $lang->form_enter_phone]));
		}

		if (empty($callback->name)) {
			throw new ValidationException(errors::create(['name' => $lang->form_enter_name]));
		}

		if (empty($callback->message)) {
			throw new ValidationException(errors::create(['message' => $lang->form_enter_comment]));
		}

		if (isset($_COOKIE["utm_source"])) {
			$callback->utm .= $_COOKIE["utm_source"];
		}

		if (isset($_COOKIE["utm_campaign"])) {
			$callback->utm .= ':' .$_COOKIE["utm_campaign"];
		}
		try {
			$callback_id = $call->add_callback($callback);
		} catch (Exception $e) {
			throw new RuntimeException($e->getMessage());
		}

		if (false === $callback_id) {
			throw new RuntimeException('Error create callback!');
		}

		// Создаем лид в битрикс
		$call->lead->add_lead_bitrix(
			[
				'title' => 'NEW CALLBACK#' . $callback_id,
				'name' => $callback->name,
				'currency' => 'UAH',
				'comment' => $callback->message,
				'phone' => $callback->phone,
				'source' => 'OPENLINE',
			],
			'Обратный звонок на сайте'
		);

		return [
			'id' => $callback_id,
			'message' => $call->design->fetch('callback_page_result.tpl'),
		];
	}

	public function action_add_comment()
	{
		$comm = new Comments();

		$comment = new \stdClass;
		$comment->name = $this->request->post('name');
		$comment->email = $this->request->post('email');
		$comment->text = $this->request->post('text');
		$comment->type = $this->request->post('type');
		$comment->object_id = (int) $this->request->post('object');
		$comment->ip        = $_SERVER['REMOTE_ADDR'];
		$comment->lang_id   = $_SESSION['lang_id']?? 3;
		$comment->utm = '';
		$comment->approved = $comm->settings->auto_approved;

		if (empty($comment->email)) {
			throw new ValidationException(errors::create(['email' => 'Email not be empty']));
		}

		if (empty($comment->text)) {
			throw new ValidationException(errors::create(['text' => 'Comment not be empty']));
		}

		if (empty($comment->name)) {
			throw new ValidationException(errors::create(['name' => 'Name not be empty']));
		}

		if (isset($_COOKIE["utm_source"])) {
			$comment->utm .= $_COOKIE["utm_source"];
		}

		if (isset($_COOKIE["utm_campaign"])) {
			$comment->utm .= ':' .$_COOKIE["utm_campaign"];
		}

		$comment->lang_id = $comm->languages->lang_id();

		try {
			$comment_id = $comm->add_comment($comment);
		} catch (Exception $e) {
			throw new RuntimeException($e->getMessage());
		}

		if (false === $comment_id) {
			throw new RuntimeException('Error create comment!');
		}

		// Создаем лид в битрикс
		$comm->lead->add_lead_bitrix(
			[
				'title' => 'NEW COMMENT#' . $comment_id,
				'name' => $comment->name,
				'currency' => 'UAH',
				'comment' => $comment->text,
				'source' => 'OPENLINE',
			],
			'Новый коммент на сайте'
		);

		return [
			'id' => $comment_id,
			'message' => '',
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
		} catch (RuntimeException $e) {
			$this->response->set_code(400);
			return ['message' => $e->getMessage()];
		}

		return ['numberCheck' => $id];
	}

}