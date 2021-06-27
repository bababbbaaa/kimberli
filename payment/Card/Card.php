<?php


require_once('api/Okay.php');

class Card extends Okay
{	
    private $number_card;

     
    public function checkout_form($payment_method_id)
        {
        $settings = $this->payment->get_payment_settings($payment_method_id);
        $this->setNumberCardp($settings['number_card']);
        return $this->getForm();
        }
         private function getForm(){
             return '<ul class="list-group">
  <li class="list-group-item"><b>Карта №: </b><span class="badge">'.$this->number_card.'</span></li></ul>';
         }

         private function setNumberCardp($argument)
    {
        if (!empty($argument)) {
            $this->number_card = $argument;
        }
    }
}
    

