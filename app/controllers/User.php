<?php 
/**
* 
*/	
	require "../rest/Rest.php";

	class User extends Controller{
		
		function __construct(){
			parent::__construct();
			$this->rest = new Rest();
		}

		//Validate the user and password exist in db
		public function userLogin(){
			if (isset($_POST['user_name']) && isset($_POST['password'])){
				$response = $this->model->userLogin("*", "user_name = "."'".$_POST['user_name']."'");
				$response = $response[0];
				$user_rol = null;
				//The user is valid
				if ($response['password']==$_POST['password']) {
					//Verify the roles
					$response_role = $this->model->getRoles("user_id = '".$response['_id']."'");
					if (count($response_role)>1) {
						//Multipage user
						$user_rol = array();
						foreach ($response_role as $value) {
							array_push($user_rol, $value['role']);
						}
					}else{
						$user_rol = $response_role[0]['role'];
					}
					$this->createSession($response['user_name'], $user_rol);
					echo 1;
				}
			 
			}
		}

		//Create a new session for a user
		function createSession($user, $role){
			Session::setSession('user',$user);
			Session::setSession('role',$role);
		}

		//Destroy the current session and get back to login page
		function destroySession(){
			Session::destroy();
			$login = substr(URL, 0, -1);
			header("Location:".$login);
		}

		//Create User
		function create(){
			// Cross validation if the request method is POST else it will return "Not Acceptable" status
			if($this->rest->get_request_method() != "POST"){
				$this->rest->response('',406);
			}
			if (isset($_POST['user_name']) && isset($_POST['password'])){
				$array['user_name'] = $_POST['user_name'];
				$array['password'] = $_POST['password'];
				$result = $this->model->registerUser($array);
				if ($result) {
					$response_array['status']='success';
					$response_array['message']='register successfully.';
					$response_array['data']=$this->model->getLastInserted();
					$this->rest->response($this->rest->json($response_array), 200);
				}else{
					$response_array['status']='fail';
					$response_array['message']='invalid username or password.';
					$response_array['data']='';
					$this->response($this->json($response_array),400);
				}
			}else{
				$response_array['status']='fail';
				$response_array['message']='invalid username or password.';
				$response_array['data']='';
				$this->rest->response($this->rest->json($response_array),400);
			}

		}

		//Create Role
		function addRole($user, $role){
			//TODO: consider many roles
			if (isset($_POST['user_id']) && isset($_POST['role'])){
				$array['user_id'] = $_POST['user_id'];
				$array['role'] = $_POST['role'];
				$this->model->addRole($array);
			}

		}

		function updateUser(){
			if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['_id'])){
				$user_id = $_POST['_id'];
				$array['user_name'] = $_POST['user_name'];
				$array['password'] = $_POST['password'];
				$this->model->setUser($array, "_id='".$user_id."'");
			}

		}

		function updateRole(){
			if (isset($_POST['role']) && isset($_POST['user_id']) && isset($_POST['_id'])){
				$role_id = $_POST['_id'];
				$array['role'] = $_POST['role'];
				$array['user_id'] = $_POST['user_id'];
				$this->model->setRole($array, "_id='".$role_id."'");
			}

		}

		function deleteUser(){
			if (isset($_POST['_id'])){
				$where = "_id='".$_POST['_id']."'";
				$this->model->deleteUser($where);
			}
		}

		function deleteRole(){
			if (isset($_POST['_id'])){
				$where = "_id='".$_POST['_id']."'";
				$this->model->deleteRole($where);
			}
		}

		
	}

?>