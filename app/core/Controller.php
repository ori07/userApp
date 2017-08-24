<?php
	declare(strict_types = 1); 

	//require_once '../init.php';

	/**
	* 
	*/
	class Controller{

		function __construct(){
			$this->loadClassModel(); 
			echo "Soy el controlador de controladores ;";
		}

		function loadClassModel(){
			$model = get_class($this).'_model';
			$path = '../app/models/'.$model.'.php';
			if (file_exists($path)) {
				require_once $path;
				$this->model = new $model();
			}
		}
		
	}
?>