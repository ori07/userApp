<?php 
	$role = Session::getSession('role');
	if (is_array($role)) {
		echo "Your current roles are: ";
		$var = null;
		foreach ($role as $value) {
			$var.=$value.", ";
		}
		$var = substr($var, 0,-2);
		print_r($var);
	}else{
		echo "Your current role is : ".$role;
	}
	
?>