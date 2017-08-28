<?php 
	/**
	* 
	*/
	class Page extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function page(){
			$user_name = Session::getSession('user');

			if ($user_name != "") {
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1) {
					if (!in_array('ADMIN', $role)) { 
						$this->view->render($this,'multi_page');
					}else{
						$this->view->render($this,'page');
					}
					
				}elseif ($role == "PAGE_1"){
					header('Location: '.URL."Page_1/page_1");
				} elseif ($role == "PAGE_2"){
					header('Location: '.URL."Page_2/page_2");
				}elseif ($role == "PAGE_3"){
					header('Location: '.URL."Page_3/page_3");
				}elseif ($role == "ADMIN"){
					$this->view->render($this,'page');
				}
				
			}else{
				$login = substr(URL, 0, -1);
				header("Location:".$login);
			}
		}
	}
?>