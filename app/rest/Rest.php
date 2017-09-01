<?php 
	/**
	* Class to process the user request
	*/
	class Rest{

		public $_allow = array();
		public $_content_type = "application/json";
		public $_request = array();
		
		private $_method = "";		
		private $_code = 200;
		
		function __construct(){

		}

		public function response($data,$status=200){
			$data = $this->json($data);
			$this->_code = ($status)?$status:200;
			$this->setHeaders();
			echo $data;
			exit;

		}

		public function getRequestMethod(){
			return $_SERVER['REQUEST_METHOD'];
		}		

		//Delete special characters for the input url
		private function cleanInputs($data){
			$clean_input = array();
			if(is_array($data)){
				foreach($data as $k => $v){
					$clean_input[$k] = $this->cleanInputs($v);
				}
			}else{
				if(get_magic_quotes_gpc()){
					$data = trim(stripslashes($data));
				}
				$data = strip_tags($data);
				$clean_input = trim($data);
			}
			return $clean_input;
		}		
		
		private function setHeaders(){
			header("HTTP/1.1 ".$this->_code." ".$this->getStatusMessage());
			header("Content-Type:".$this->_content_type);
		}

		private function getStatusMessage(){
			$status = array(
						100 => 'Continue',  
						101 => 'Switching Protocols',  
						200 => 'OK',
						201 => 'Created',  
						202 => 'Accepted',  
						203 => 'Non-Authoritative Information',  
						204 => 'No Content',  
						205 => 'Reset Content',  
						206 => 'Partial Content',  
						300 => 'Multiple Choices',  
						301 => 'Moved Permanently',  
						302 => 'Found',  
						303 => 'See Other',  
						304 => 'Not Modified',  
						305 => 'Use Proxy',  
						306 => '(Unused)',  
						307 => 'Temporary Redirect',  
						400 => 'Bad Request',  
						401 => 'Unauthorized',  
						402 => 'Payment Required',  
						403 => 'Forbidden',  
						404 => 'Not Found',  
						405 => 'Method Not Allowed',  
						406 => 'Not Acceptable',  
						407 => 'Proxy Authentication Required',  
						408 => 'Request Timeout',  
						409 => 'Conflict',  
						410 => 'Gone',  
						411 => 'Length Required',  
						412 => 'Precondition Failed',  
						413 => 'Request Entity Too Large',  
						414 => 'Request-URI Too Long',  
						415 => 'Unsupported Media Type',  
						416 => 'Requested Range Not Satisfiable',  
						417 => 'Expectation Failed',  
						500 => 'Internal Server Error',  
						501 => 'Not Implemented',  
						502 => 'Bad Gateway',  
						503 => 'Service Unavailable',  
						504 => 'Gateway Timeout',  
						505 => 'HTTP Version Not Supported');
			return ($status[$this->_code])?$status[$this->_code]:$status[500];
		}

		
		protected function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}

		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['function'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class, response would be "Page not found".
		}

		

		public function validate($value,$function="require"){
			$response = false;
			/*REQUIRE VALIDATION */
			if($function=="require" && trim($value)!=""){
				$response = true;
			}
			/*NUMBER VALIDATION */
			if(trim($value)!="" && $function=="numeric" && is_numeric($value)){
				$response = true;
			}	
			/* STRING VALIDATION */
			if(trim($value)!="" && $function=="alpha" && preg_match("/^[a-zA-Z ]*$/",$value)){
				$response = true;
			}	
			/*ALPHA-NUMERIC VALIDAITON */
			if(trim($value)!="" && $function=="alphanumeric" && preg_match("/^[a-zA-Z0-9 ]*$/",$value)){
				$response = true;
			}	
					
			/*WEBSITE URL VALIDAITON */
			if(trim($value)!="" && preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$value)){
					$response = true;
			}	
			return $response;
			
		}
}
	
?>