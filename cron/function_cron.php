<?php

namespace cron;

function set_log($message = ''){
   $log = file_get_contents('dropbox.log');
  
    $log .= date('Y-m-d H:i:s').': ' . get_current_user() . ': '.$message."\n";

    file_put_contents('dropbox.log', $log);  
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