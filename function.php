<?php
//include_once 'api/Bug.php';


 function exception_handler($exception)
{
	//$b = new Bug();
	if ($_SERVER['REMOTE_ADDR'] == '195.38.11.96') {
		//$b->d($exception);
		//throw new $exception;
	} else {
		//$b->add_exception($exception);
	}

 return true;
}

function error_handler($errno, $errstr, $errfile, $errline)
{
	//$b = new Bug();
	if ($_SERVER['REMOTE_ADDR'] == '195.38.11.96') {
		/*$b->d([
			$errstr,
			$errfile,
			$errline,
		]);*/

			$exceptionContent = "FATAL ERROR #" . $errno . ' '
				. " with message: '{$errstr}'\n"
				. "File: {$errfile}, "
				. "line {$errline}\n";

			//throw new Error($exceptionContent);
	} else {
		//$b->bug_add($errno, $errstr, $errfile, $errline);
	}
    return true;
}


