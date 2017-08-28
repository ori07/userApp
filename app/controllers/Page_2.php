<?php 
/**
* 
*/
	class Page_2 extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function page_2(){
			$user_name = Session::getSession('user');
			//Logged user
			if ($user_name != ""){
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1) {
					if (in_array('PAGE_2', $role)) { 
						$this->view->render('Page','page_2');
						Session::setSession('lastPage','Page_2/page_2');
					}else{
						//Access denied
						header("HTTP/1.1 401 Unauthorized");
						$last_page = Session::getSession('lastPage');
						header("Location:".URL.$last_page);
						echo 'alert("You do not have permission to acces to this page. You have been redirected")';
					}
				}else{
					//Single role
					if ($role == "PAGE_2") {
						$this->view->render('Page','page_2');
						Session::setSession('lastPage','Page_2/page_2');
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