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
		
		function __construct(argument)
		{
			$this->selectClientRequest();
		}

		public function response($data,$status=200){
			$this->_code = ($status)?$status:200;
			$this->set_headers();
			echo $data;
			exit;
		}

		public function getRequestMethod(){
			return $_SERVER['REQUEST_METHOD'];
		}

		//process the client request
		private function selectClientRequest(){
			switch($this->getRequestMethod()){
		    case 'GET':
		    	getAllUsers();
		    	echo "GET";

		    	break;
		    case 'POST':
		    	$this->_request = $this->cleanInputs($_POST);
		    	echo "POST";
		    	break;
		    case 'PUT':
		    	parse_str(file_get_contents("php://input"),$this->_request);
				$this->_request = $this->cleanInputs($this->_request);
		        echo 'PUT';
		        break;
		    case 'DELETE':
		    	$this->_request = $this->cleanInputs($_GET);
		    	echo "DELETE";
		    	break;
		    default;
		    	$this->response('',406);
		        echo 'Por favor haga una nueva selección...';
		    break;
			}
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
			header("HTTP/1.1 ".$this->_code." ".$this->get_status_message());
			header("Content-Type:".$this->_content_type);
		}

		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['function'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404); // If the method not exist with in this class, response would be "Page not found".
		}

		protected function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
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