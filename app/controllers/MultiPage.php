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
						$last_page = Session::getSession('lastPage');
						$last_page = URL.$last_page;
						header("refresh:2; url=".$last_page);
						echo '<center>HTTP/1.1 401 Unauthorized<br><br><br>You do not have permission to acces to this page.You will be redirected</center>';
				}
			}else{
				$login = substr(URL, 0, -1);
				header("Location:".$login);
			}
			
		}
	}
?>