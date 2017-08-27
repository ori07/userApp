<?php
declare(strict_types = 1); 
//path from public folder to apps folder
const LBS = '../app/core/';
const VIEWS = '../app/views/';
const VIEWS_2 = 'app/views/';
const CTRL = 'app/controllers/';
const DFT = 'Default/';
const URL = 'http://localhost:8080/userApp/public/';
const URL2 = 'http://localhost:8080/userApp/';
const URL3 = 'http://localhost:8080/';


//Verifying if the classes are created, and load it
spl_autoload_register(function($class){
	if (file_exists(LBS.$class.".php")) {
		require LBS.$class.".php";
	}else{
		echo "Class: ".$class." has not been created";
	}
});

?>