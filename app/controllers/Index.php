<?php
	/**
	* 
	*/
	error_reporting(E_ALL ^ E_NOTICE);
	class Index extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		public function index(){
			$user_name = Session::getSession('user');
			if ($user_name != "") {
				header("Location:".URL."Page/page");
			}else{
				$this->view->render($this, 'index');
			}
			
		}
	}
?>
