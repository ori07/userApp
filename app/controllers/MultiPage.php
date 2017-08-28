<?php 
/**
* 
*/
	class Multipage extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function multipage(){
			$user_name = Session::getSession('user');
			//Logged user
			if ($user_name != ""){
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1) {
					$this->view->render('Page','multi_page');
					Session::setSession('lastPage','Multipage/multipage');
					
				}else{
						//Access denied
						header("HTTP/1.1 401 Unauthorized");
						$last_page = Session::getSession('lastPage');
						header("Location:".URL.$last_page);
						echo 'alert("You do not have permission to acces to this page. You have been redirected")';
				}
			}else{
				$login = substr(URL, 0, -1);
				header("Location:".$login);
			}
			
		}
	}
?>