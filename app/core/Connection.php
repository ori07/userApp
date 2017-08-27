<?php
	/**
	* 
	*/
	class Connection extends Controller{
		
		function __construct(){
			$this->db = new QueryManager("localhost", "admin_app", "admin123", "appWeb_db");
			//parent::__construct();
		}
	}
?>