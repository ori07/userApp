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

		function registerUser($array){
			return $this->db->insert('user', $array);
		}

		function addRole($array){
			return $this->db->insert('role', $array);
		}

		function getRoles($where){
			return $this->db->selectConditional('role', 'role', $where);
		}

		function getUsers(){
			return $this->db->selectAll('user');
		}

		function setUser($fields, $where){
			return $this->db->update('user', $fields, $where);
		}

		function setRole($fields, $where){
			return $this->db->update('role', $fields, $where);
		}

		function deleteUser($where){
			return $this->db->delete('user', $where);
		}

		function deleteRole($where){
			return $this->db->delete('role', $where);
		}

		function getLastInserted(){
			return $this->db->lastInserted();
		}
	}
?>