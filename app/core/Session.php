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
	 		$_SESSION['time'] = time();
	 		$_SESSION['expire'] = $_SESSION['time'] + (5 * 60);
	 	}

	 	static function getSession($name){
	 		return $_SESSION[$name]; 
	 	}

	 	static function setSession($name, $data){
	 		$_SESSION[$name] = $data;
	 	}

	 	static function destroy(){
	 		@session_destroy();
	 	}
	 } 
?>