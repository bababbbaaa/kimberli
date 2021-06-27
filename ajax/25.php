<?php
if(!empty($_SERVER['HTTP_USER_AGENT'])){
        session_name(md5($_SERVER['HTTP_USER_AGENT']));
    }
    session_start();
    require_once('../api/Okay.php');
    define('IS_CLIENT', true);
    $okay = new Okay();

if(!empty($okay->request->post('url')) && strrpos($okay->request->post('url'), 'obirajte-novorichnu-znizhku')) {
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    
    function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
 
    return $random_string;
}
    
     /*Определяем язык*/
    $language = $okay->languages->get_language($okay->languages->lang_id());
    $lang = $okay->translations->get_translations(array('lang'=>$language->label));
    $okay->design->assign('lang', $lang);
    
    $input = array(5 => '5', 7 => '7', 10 => '10');
    
    $kupon = new stdClass();
    $kupon->code = generate_string($permitted_chars, 10);
    $kupon->type = 'percentage';
    $kupon->expire = null;
    $kupon->value =  array_rand($input, 1);
    $kupon->single = 1;
    
    $okay->coupons->add_coupon($kupon);
    
    $okay->design->assign('procent', $kupon->value);
    $okay->design->assign('kupon', $kupon->code);
    
    $_SESSION['temp_kupon'] = $kupon->code;
    
    
    die(json_encode(['proc' => $kupon->value.' %', 'message' => $okay->design->fetch('form/25/result.tpl')]));
    }
    die();
    
    
    

