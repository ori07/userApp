<?php 
	/**
	* 
	*/
	class Page extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		function page(){
			if (isset($_SESSION['user'])){
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1) {
					if (!in_array('ADMIN', $role)) { 
						if (isset($_SESSION['lastPage'])) {
							if ($_SESSION['lastPage'] == 'Page/page') {
								$this->view->render($this,'multi_page');
							}else{
								$last_page = Session::getSession('lastPage');
								$last_page = URL.$last_page;
								//updating last page
								Session::setSession('lastPage', 'Page/page');
								//echo "LLamar a la pagina: ".$last_page;
								//exit;
								header("refresh:1; url=".$last_page);
							}
							
						}else{
							$this->view->render($this,'multi_page');
						}
						
					}else{
						if (isset($_SESSION['lastPage'])) {
							$last_page = Session::getSession('lastPage');
							$last_page = URL.$last_page;
							header("refresh:1; url=".$last_page);
						}else{
							$this->view->render($this,'multi_page');
						}
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
				$last_page = Session::setSession('lastPage', 'Page/page');
				$login = substr(URL, 0, -1);
				header("refresh:3; url=".$login);
				echo '<center>HTTP/1.1 401 Unauthorized<br><br><br>You do not have permission to acces to this page.You need to login first</center>';
			}
		}
	}
?>