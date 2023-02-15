<?php

namespace rest\controller;

use rest\api\Notify;
use rest\validation\errors;
use rest\validation\ValidationException;

class popup_controller extends base_controller
{
    public function action_send_email()
    {
        $phone = $this->request->post('phone');

        if (empty($phone)) {
            throw new ValidationException(errors::create(['phone' => 'Phone not be empty']));
        }

        $phone = preg_replace('~[^0-9]+~','',$phone);

        if (strlen($phone) == 10) {
            $phone = '38'.$phone;
        }

        $notify = new Notify();

        $language = $notify->languages->get_language($notify->languages->lang_id());
        $lang = $notify->translations->get_translations(array('lang'=>$language->label));

        $notify->design->assign('lang', $lang);

        try {
            $notify->email(
                'shopkimberli@gmail.com,kimberli.ocean@gmail.com,Humeniukev@gmail.com',
                'Звернення клієнта з поп-ап форми -40%',
                'Телефон: ' . $phone
            );
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }

        $this->response->set([
            'message' => $notify->design->fetch('popap/sale_result.tpl'),
        ]);
    }
}