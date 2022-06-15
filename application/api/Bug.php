<?php

namespace rest\api;

class Bug extends Okay {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @param $e
	 * @return bool
	 */
	public static function addException($e): bool
	{
		$b = new self();
		return $b->add_exception($e);
	}

    
    public function bug_add($errno, $errstr, $errfile, $errline) {
        if(!$this->config->bug_track) return false;

       $query  =  "SELECT b.`id`, b.`count` FROM __bug b
            WHERE 
                code = $errno
                and line = $errline
                    and type like '".self::error($errno)."'
                    and message like '$errstr'
            LIMIT 1";

         $this->db->query($query);
         $results = $this->db->results();
         $id = isset($results[0]->id) ? $results[0]->id : 0;
         $count = isset($results[0]->count) ? $results[0]->count : 0;
        if($id){
            $bug = (object)[];
             $bug->count = ($count+1);
             $bug->fix = 0;
             $bug->utime = date("Y-m-d H:i:s");
             $query = $this->db->placehold("UPDATE __bug SET ?% WHERE id=? LIMIT 1", $bug, intval($id));
                $this->db->query($query);
        }else{
        $bug = (object)[];
        $bug->utime = date("Y-m-d H:i:s");
            $bug->class = get_class();
            $bug->message = $errstr;
            $bug->code = $errno;
            $bug->file = (string)$errfile;
            $bug->line = (int)$errline;
           // $bug->trace = serialize($e->getTrace());
            $bug->type = self::error($errno);
            $bug->count = 1;
            $bug->get = serialize($_GET);
            $bug->post = serialize($_POST);
            $bug->session = serialize($_SESSION);
            $bug->files = serialize($_FILES);
            $bug->server = serialize($_SERVER);
            $bug->request = serialize($_REQUEST);
            $this->db->query("INSERT INTO __bug SET ?%", $bug);
        }
 
    }

    public function add_exception($e): bool
	{
         if(!$this->config->bug_track) {
			 return false;
		 }
        
         $query  =  "SELECT b.`id`, b.`count` FROM __bug b
            WHERE 
                code = {$e->getCode()}
                and line = {$e->getLine()}
                    and type = '".self::error('EXCEPTION')."'
                    and message like '{$e->getMessage()}'
            LIMIT 1";

         $this->db->query($query);
         $results = $this->db->results();
         $id = isset($results[0]->id) ? $results[0]->id : 0;
         $count = isset($results[0]->count) ? $results[0]->count : 0;

        if($id){
            $bug = (object)[];
             $bug->count = ($count+1);
             $bug->fix = 0;
             $bug->utime = date("Y-m-d H:i:s");
             $query = $this->db->placehold("UPDATE __bug SET ?% WHERE id=? LIMIT 1", $bug, intval($id));
                $this->db->query($query);
        } else {

       		$bug = new \stdClass();
            $bug->class = get_class($e);
            $bug->message = $e->getMessage();
            $bug->code = $e->getCode();
            $bug->file = (string) $e->getFile();
            $bug->line = (int) $e->getLine();
            //$bug->trace = $e->getTrace();
            $bug->type = 'EXCEPTION';
            $bug->count = 1;
            $bug->get = serialize($_GET);
            $bug->post = serialize($_POST);
            $bug->session = serialize($_SESSION);
            $bug->files = serialize($_FILES);
            $bug->server = serialize($_SERVER);
            $bug->request = serialize($_REQUEST);

           $this->db->query("INSERT INTO __bug SET ?%", $bug);
        }

		@file_get_contents('https://api.telegram.org/bot539849731:AAH9t4G2hWBv5tFpACwfFg3RqsPhK4NrvKI/sendMessage?chat_id=' . 404070580 . '&text=' . urlencode($e->getMessage())).'&parse_mode=HTML';

        return true;
    }
    
    public function add_log(array $e) {

         if(!$this->config->bug_track) return false;

        $e = (object)$e;
         $bug = (object)[];
       $bug->utime = date("Y-m-d H:i:s");
            //$bug->class = get_class($e);
            $bug->message = $e->getMessage();
            $bug->code = $e->code;
            $bug->file = (string)$e->getFile();
            $bug->line = (int)$e->getLine();
            $bug->trace = serialize($e->getTrace());
            $bug->type = 'EXCEPTION';
            $bug->count = 1;
            $bug->get = serialize($_GET);
            $bug->post = serialize($_POST);
            $bug->session = serialize($_SESSION);
            $bug->files = serialize($_FILES);
            $bug->server = serialize($_SERVER);
            $bug->request = serialize($_REQUEST);
           $this->db->query("INSERT INTO __bug SET ?%", $bug);
    }
    
    static private function error($errno){
             switch ($errno) {
        case E_ERROR: // 1 //
            return 'E_ERROR';
        case E_WARNING: // 2 //
            return 'E_WARNING';
        case E_PARSE: // 4 //
            return 'E_PARSE';
        case E_NOTICE: // 8 //
            return 'E_NOTICE';
        case E_CORE_ERROR: // 16 //
            return 'E_CORE_ERROR';
        case E_CORE_WARNING: // 32 //
            return 'E_CORE_WARNING';
        case E_COMPILE_ERROR: // 64 //
            return 'E_COMPILE_ERROR';
        case E_COMPILE_WARNING: // 128 //
            return 'E_COMPILE_WARNING';
        case E_USER_ERROR: // 256 //
            return 'E_USER_ERROR';
        case E_USER_WARNING: // 512 //
            return 'E_USER_WARNING';
        case E_USER_NOTICE: // 1024 //
            return 'E_USER_NOTICE';
        case E_STRICT: // 2048 //
            return 'E_STRICT';
        case E_RECOVERABLE_ERROR: // 4096 //
            return 'E_RECOVERABLE_ERROR';
        case E_DEPRECATED: // 8192 //
            return 'E_DEPRECATED';
        case E_USER_DEPRECATED: // 16384 //
            return 'E_USER_DEPRECATED';
        case 'EXCEPTION': return  'EXCEPTION'; // исключение
       
    default: return $errno;
    }
        }
    
}
