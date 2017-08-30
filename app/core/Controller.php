<?php
	declare(strict_types = 1); 

	/**
	* 
	*/
	class Controller{

		function __construct(){
			Session::start();
			$this->loadClassModel(); 
			$this->view = new View();
		}

		function loadClassModel(){
			$model = get_class($this).'_model';
			$path = '../app/models/'.$model.'.php';
			if (file_exists($path)) {
				require $path;
				$this->model = new $model();
			}
		}
		
	}
?>