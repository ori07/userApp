<?php 
/**
* 
*/
	class User extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		//Validate the user and password exist in db
		public function userLogin(){
			if (isset($_POST['user_name']) && isset($_POST['password'])){
				$response = $this->model->userLogin("*", "user_name = "."'".$_POST['user_name']."'");
				$response = $response[0];
				if ($response['password']==$_POST['password']) {
					$this->createSession($response['user_name']);
					echo 1;
				}
			}
			 
		}

		//Create a new session for a user
		function createSession($user){
			Session::setSession('user',$user);
		}

		//Destroy the current session and get back to login page
		function destroySession(){
			Session::destroy();
			$login = substr(URL, 0, -1);
			header("Location:".$login);
		}
	}

?>