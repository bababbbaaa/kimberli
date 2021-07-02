<?php

namespace cron;

function set_log($message = ''){
   $log = file_get_contents('dropbox.log');
  
    $log .= date('Y-m-d H:i:s').': ' . get_current_user() . ': '.$message."\n";

    file_put_contents('dropbox.log', $log);  
}

function get_log(){
    return file_get_contents('dropbox.log');
}

function update_curs(){

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.privatbank.ua/p24api/pubinfo?json=&exchange=&coursid=5",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_POSTFIELDS => "",
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  return json_decode($response);
}
}

function l($var){
    if(is_array($var)){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }elseif(is_object($var)){
         echo '<pre>';
        print_r($var);
        echo '</pre>';
    }else{
        echo '<br>' . $var . '<br>';
    }
}

function proc($price = 0, $compere_price = 0) {
    if($compere_price > 0 && $price > 0){
        
        $pp = 100 - ($price/$compere_price) * 100;
        
        if($pp > 0 && $pp < 105){
            return 10;
        }else if($pp >=10.5 && $pp < 20.5) {
            return 20;
        }else if($pp >=20.5 && $pp < 30.5) {
            return 30;
        }else if($pp >=40.5 && $pp < 50.5) {
            return 40;
        }else if($pp >=50.5 && $pp < 60.5) {
            return 50;
        }else if($pp >=60.5 && $pp < 70.5) {
            return 70;
        }else if($pp >=70.5 && $pp <= 80.5) {
            return 80;
        }else if($pp >=80.5 && $pp <= 90.5) {
            return 90;
        }
    }
    return 0;
}