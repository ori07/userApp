<?php 
/**
* 
*/
	class Page_1 extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function page_1(){
			$user_name = Session::getSession('user');
			//Logged user
			if ($user_name != ""){
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1) {
					if (in_array('PAGE_1', $role)) { 
						$this->view->render('Page','page_1');
						Session::setSession('lastPage','Page_1/page_1');
					}else{
						//Access denied
						header("HTTP/1.1 401 Unauthorized");
						$last_page = Session::getSession('lastPage');
						header("Location:".URL.$last_page);
						echo 'alert("You do not have permission to acces to this page. You have been redirected")';
					}
				}else{
					//Single role
					if ($role == "PAGE_1") {
						$this->view->render('Page','page_1');
						Session::setSession('lastPage','Page_1/page_1');
					}else{
						//Access denied
						header("HTTP/1.1 401 Unauthorized");
						$last_page = Session::getSession('lastPage');
						header("Location:".URL.$last_page);
						echo 'alert("You do not have permission to acces to this page. You have been redirected")';
					}

				}
			}else{
				$login = substr(URL, 0, -1);
				header("Location:".$login);
			}
			
		}
	}
?>