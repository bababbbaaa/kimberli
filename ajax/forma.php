<?php
    if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Okay.php');
    define('IS_CLIENT', true);
    $okay = new Okay();
    
    $errors = '';
    $message = '';
    
     /*Определяем язык*/
    $language = $okay->languages->get_language($okay->languages->lang_id());
    $lang = $okay->translations->get_translations(array('lang'=>$language->label));
    $okay->design->assign('lang', $lang);
    
    $callback = new stdClass();
            $callback->phone        = $okay->request->post('phone');
            $callback->name         = $okay->request->post('name');
            $callback->url          = $okay->request->post('url');
            $callback->message      = $okay->request->post('message');
            

            /*Валидация данных клиента*/
            if (!$okay->validate->is_name($callback->name, true)) {
                $errors = "<span data-language='form_enter_name'>{$lang->form_enter_name}</span>";
            } elseif(!$okay->validate->is_phone($callback->phone, true)) {
                $okay->design->assign('call_page_error', 'empty_phone');
                 $errors = "<span data-language='form_enter_phone'>{$lang->form_enter_phone}</span>";
            } elseif(!$okay->validate->is_comment($callback->message, true)) {
                 $errors = "<span data-language='form_enter_comment'>{$lang->form_enter_comment}</span>";
            } elseif($callback_id = $okay->callbacks->add_callback($callback)) {
                // Отправляем email
                $okay->notify->email_callback_admin($callback_id);
                $message = $okay->design->fetch('form/santa/santa_result.tpl');
            } else {
                $errors = "<span>unknown error</span>";
            }
    
    
    header("Content-type: application/json; charset=UTF-8");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: -1");
    die(json_encode(['errors' => $errors, 'message' => $message]));