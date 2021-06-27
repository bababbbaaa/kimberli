<?php

namespace rest\api;

class BackendTranslations extends Okay {
    
    public function get_translation($var)
    {
        return $this->$var;
    }
}
