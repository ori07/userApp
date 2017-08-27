<?php 
/**
* 
*/
	class User extends Controller{
		
		function __construct(){
			parent::__construct();
		}

		public function userLogin(){
			if (isset($_POST['user_name']) && isset($_POST['password'])){
				$response = $this->model->userLogin("*", "user_name = "."'".$_POST['user_name']."'");
				$response = $response[0];
				if ($response['password']==$_POST['password']) {
					//$this->createSession($response['user_name']);
					echo 1;
				}
				
				
			}
			 
		}

		function createSession($user){
			Session::setSession('user',$user);
		}

		function destroySession(){
			Session::destroy();
			header("Location:".URL);
		}
	}

?>