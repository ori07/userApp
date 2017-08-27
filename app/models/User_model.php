<?php 
	/**
	* 
	*/
	class User_model extends Connection{
		
		function __construct(){
			parent::__construct();
		}

		function userLogin($fields, $where){
			return $this->db->selectConditional($fields, "user", $where);
		}
	}
?>