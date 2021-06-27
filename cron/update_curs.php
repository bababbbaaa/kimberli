<?php
require_once('function_cron.php');
try {
    $up_curs = [];
    $curs = update_curs();
    if(!empty($curs) && is_array($curs)){
        foreach ($curs as $c) {
            switch ($c->ccy) {
            case 'USD': $up_curs[1]['rate_to'] = round($c->sale, 2);  break;
            case 'EUR': $up_curs[5]['rate_to'] = round($c->sale, 2);  break;
            case 'RUR': $up_curs[2]['rate_to'] = round($c->sale, 2);  break;
            default : break;
            }
        }
        
        if(count($up_curs)){
            $log = '';
            include_once('../api/Okay.php');
            $okay = new Okay();
            foreach ($up_curs as $k => $c) {
                if($c['rate_to'] > 0) {
               $okay->money->update_currency($k, $c);
               $log.= $k.': '.$c['rate_to'].', ';
                }
            } 
            set_log('update_curs('.$log.')');
        }
    }
} catch (Exception $exc) {
  echo $exc->getMessage();
}



