<?php


require_once('api/Okay.php');

class IBAN extends Okay
{	
    private $fop;
    private $ipn;
    private $iban;
    private $banc;
    private $mfo;
    
     
    public function checkout_form($payment_method_id)
        {
        $settings = $this->payment->get_payment_settings($payment_method_id);
        foreach ($settings as $k => $s){
             call_user_func_array(array($this, "set$k"), array($s));
        }
        return $this->getForm();
        }
         private function getForm(){
             return '<ul class="list-group">
  <li class="list-group-item"><b>ФОП: </b><span class="badge">'.$this->fop.'</span></li>
  <li class="list-group-item"><b>ІПН: </b><span class="badge">'.$this->ipn.'</span></li>
  <li class="list-group-item"><b>IBAN: </b><span class="badge">'.$this->iban.'</span></li>
  <li class="list-group-item"><b>БАНК: </b><span class="badge">'.$this->banc.'</span></li>
  <li class="list-group-item"><b>МФО: </b><span class="badge">'.$this->mfo.'</span></li>
</ul>';
         }
         
         
         private function setfop($argument)
    {
        if (!empty($argument)) {
            $this->fop = $argument;
        }
    }
    private function setipn($argument)
    {
        if (!empty($argument)) {
            $this->ipn = $argument;
        }
    }
    private function setiban($argument)
    {
        if (!empty($argument)) {
            $this->iban = $argument;
        }
    }
    private function setbanc($argument)
    {
        if (!empty($argument)) {
            $this->banc = $argument;
        }
    }
    private function setmfo($argument)
    {
        if (!empty($argument)) {
            $this->mfo = $argument;
        }
    }
}
    

