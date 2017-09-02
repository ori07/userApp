<?php 
/**
* 
*/
	class Page_1 extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function page_1(){
			//Logged user
			if (isset($_SESSION['user'])){
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1) {
					if (in_array('PAGE_1', $role)) { 
						$this->view->render('Page','page_1');
						Session::setSession('lastPage','Page_1/page_1');
					}else{
						//Access denied
						$last_page = Session::getSession('lastPage');
						$last_page = URL.$last_page;
						header("refresh:2; url=".$last_page);
						echo '<center>HTTP/1.1 401 Unauthorized<br><br><br>You do not have permission to acces to this page.You will be redirected</center>';
					}
				}else{
					//Single role
					if ($role == "PAGE_1") {
						$this->view->render('Page','page_1');
						Session::setSession('lastPage','Page_1/page_1');
					}else{
						//Access denied
						$last_page = Session::getSession('lastPage');
						$last_page = URL.$last_page;
						header("refresh:2; url=".$last_page);
						echo '<center>HTTP/1.1 401 Unauthorized<br><br><br>You do not have permission to acces to this page.You will be redirected</center>';
					}

				}
			}else{
				$last_page = Session::setSession('lastPage', 'Page_1/page_1');
				$login = substr(URL, 0, -1);
				header("refresh:3; url=".$login);
				echo '<center>HTTP/1.1 401 Unauthorized<br><br><br>You do not have permission to acces to this page.You need to login first</center>';
			}
			
		}
	}
?>