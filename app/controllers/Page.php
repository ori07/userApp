<?php 
	/**
	* 
	*/
	class Page extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function page(){
			// $user_name = Session::getSession('user');

			// if ($user_name != "") {
			//this->view->render($this,'page');
			// }else{
			// 	header("Location:".URL);
			// }
			//phpinfo();
			//echo "Inicio sesion de usuario";
			$this->view->render($this, 'page');
		}
	}
?>