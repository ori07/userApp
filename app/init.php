<?php
declare(strict_types = 1); 
//path from public folder to apps folder
const LBS = '../app/core/';
const VIEWS = '../app/views/';

//Verifying if the classes are created, and load it
spl_autoload_register(function($class){
	if (file_exists(LBS.$class.".php")) {
		require_once LBS.$class.".php";
	}else{
		echo "Class: ".$class." has not been created";
	}
});

?>