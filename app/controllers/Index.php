<?php
	/**
	* 
	*/
	class Index extends Controller{

		public $response;
		
		function __construct(){
			$response = "";
			parent::__construct();
		}

		public function index(){
			$this->response = $this->model->datosPersonales();
			$datos = $this->response; 
			require_once VIEWS."index.php";
		}
	}
?>
