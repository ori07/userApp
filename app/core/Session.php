<?php
	/**
	 * 
	 */
	 class Session{
	 	
	 	function __construct(){
	 		
	 	}
	 	
	 	static function start(){
	 		@session_start();
	 		//unset($_SESSION);
	 	}

	 	static function getSession($name){
	 		return $_SESSION[$name]; 
	 	}

	 	static function setSession($name, $data){
	 		$_SESSION[$name] = $data;
	 	}

	 	static function destroy(){
	 		@session_unset();
	 		@session_destroy();
	 	}
	 } 
?>