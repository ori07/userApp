<?php
	/**
	* 
	*/
	class Index extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$this->view->render($this, 'index');
		}
	}
?>
