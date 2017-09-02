<?php 
/**
* 
*/	
	require_once('../app/rest/Rest.php');

	class User extends Controller{
		
		function __construct(){
			parent::__construct();
			$this->rest = new Rest();
		}

		//Validate the user and password exist in db
		public function userLogin(){
			if (isset($_POST['user_name']) && isset($_POST['password'])){
				$response = $this->model->getUser("*", "user_name = "."'".$_POST['user_name']."'");
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
						if (in_array('ADMIN', $user_rol)) { 
							$_SERVER['PHP_AUTH_USER'] = $_POST['user_name'];
           					$_SERVER['PHP_AUTH_PW'] = $_POST['password'];
           					$_SERVER['AUTH_TYPE'] = "Basic Auth"; 
						}
					}else{
						$user_rol = $response_role[0]['role'];
						if ($user_rol == 'ADMIN') {
							$_SERVER['PHP_AUTH_USER'] = $_POST['user_name'];
           					$_SERVER['PHP_AUTH_PW'] = $_POST['password'];
						}
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
			Session::setSession('time',time());
			$expire = $_SESSION['time'] + (5 * 60);
			Session::setSession('expire',$expire);
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
			if($this->rest->getRequestMethod() != "POST"){
				$this->rest->response('',406);
			}
			//Validate the user
			$validUser = $this->validateUser("admin", "basic");
			if ($validUser) {
				if (isset($_POST['user_name']) && isset($_POST['password'])){
					$array['user_name'] = $_POST['user_name'];
					$array['password'] = $_POST['password'];
					$result = $this->model->registerUser($array);
					if ($result) {
						$response_array['status']='success';
						$response_array['message']='register successfully.';
						$lastId = $this->model->getLastInserted();
						$user_data = $this->model->getUser("*", "_id = "."'".$lastId."'");
						$response_array['data']=$user_data;
						//render view
						$this->rest->response($response_array, 201);
						
					}else{
						$response_array['status']='fail';
						$response_array['message']='invalid username or password.';
						$response_array['data']='';
						//render view
						$this->response($response_array,400);
					}
				}else{
					$response_array['status']='fail';
					$response_array['message']='invalid username or password.';
					$response_array['data']='';
					//render view
					$this->rest->response($response_array,204);
				}

			}else{
				$this->rest->response('Unauthorized Access ',401);	
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
			// Cross validation if the request method is PUT else it will return "Not Acceptable" status
			if($this->rest->getRequestMethod() != "PUT"){
				$this->rest->response('',406);
				exit;
			}
			//Validate the user
			$validUser = $this->validateUser("admin", "basic");
			if ($validUser) {
				if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['_id'])){
					$user_id = $_POST['_id'];
					$array['user_name'] = $_POST['user_name'];
					$array['password'] = $_POST['password'];
					$result = $this->model->setUser($array, "_id='".$user_id."'");
					if($result) {
						$response_array['status']='success';
						$response_array['message']='One record updated.';
						$update = $this->model->getUser('*',"_id = "."'".$user_id."'");
						$response_array['data']=$update;
						$this->rest->response($response_array, 200);
					} else {
						$response_array['status']='fail';
						$response_array['message']='no record updated';
						$response_array['data']='';
						$this->rest->response($response_array, 304);
					}
				}else{
					$this->rest->response('No parameters given',204);	// If no records "No Content" status
				}
			}else{
				$this->rest->response('Unauthorized Access ',401);	
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
			// Cross validation if the request method is DELETE else it will return "Not Acceptable" status
			if($this->rest->getRequestMethod() != "DELETE"){
				$this->rest->response('',406);
			}
			//Validate the user
			$validUser = $this->validateUser("admin", "basic");
			if ($validUser) {
				if (isset($_POST['_id'])){
					$where = "_id='".$_POST['_id']."'";
					$delete = $this->model->getUser('*',$where);
					$result = $this->model->deleteUser($where);
					if($result) {
						$response_array['status']='success';
						$response_array['message']='One record deleted.';
						$response_array['data']=$delete;
						$this->rest->response($response_array, 200);
					} else {
						$response_array['status']='fail';
						$response_array['message']='The record does not exist';
						$data['user_id'] = $_POST['_id'];
						$response_array['data']=$data;
						$this->rest->response($response_array, 404);
					}

				}else{
					$this->rest->response('No parameters given',204);	// If no records "No Content" status
				}

			}else{
				$this->rest->response('Unauthorized Access ',401);
			}
			
		}

		function deleteRole(){
			if (isset($_POST['_id'])){
				$where = "_id='".$_POST['_id']."'";
				$this->model->deleteRole($where);
			}
		}

		function users(){
			// Cross validation if the request method is GET else it will return "Not Acceptable" status
			if($this->rest->getRequestMethod() != "GET"){
				$this->rest->response('',406);
			}

			//Validate the user
			$validUser = $this->validateUser("admin", "basic");
			if ($validUser) {
				$user_data = $this->model->getUsers();
				if(count($user_data)>0) {
					$response_array['status']='success';
					$response_array['message']='Total '.count($user_data).' record(s) found.';
					$response_array['total_record']= count($user_data);
					$response_array['data']=$user_data;
					$this->rest->response($response_array, 200);
				} else {
					$response_array['status']='fail';
					$response_array['message']='Record not found.';
					$response_array['data']='';
					$this->rest->response($response_array, 204);
				}
			}else{
				$this->rest->response('Unauthorized Access ',401);
			}

		}


		function getUser($id){
			// Cross validation if the request method is GET else it will return "Not Acceptable" status
			if($this->rest->getRequestMethod() != "GET"){
				$this->rest->response('',406);
			}

			//Validate the user
			$validUser = $this->validateUser("admin", "basic");
			if ($validUser) {
				$user_data = $this->model->getUser('*',"_id = "."'".$id."'");
				if(count($user_data)>0) {
					$response_array['status']='success';
					$response_array['message']='Total '.count($user_data).' record(s) found.';
					$response_array['total_record']= count($user_data);
					$response_array['data']=$user_data;
					$this->rest->response($response_array, 200);
				} else {
					$response_array['status']='fail';
					$response_array['message']='Record not found.';
					$response_array['data']='';
					$this->rest->response($response_array, 204);
				}
			}else{
				$this->rest->response('Unauthorized Access ',401);
			}

		}

		protected function validateUser($role,$type){
			if ($type == 'basic') {
				if (isset($_SERVER['PHP_AUTH_USER']) && isset($_SERVER['PHP_AUTH_PW'])) {
					if ($_SERVER['PHP_AUTH_USER']==$role) {
						//verify the password
						$user_pass = $this->model->getUser('*',"user_name = "."'".$_SERVER['PHP_AUTH_USER']."'");
						if ($user_pass == $_SERVER['PHP_AUTH_PW']) {
							return true;
						}else{
							return false;
						}
						
					}else{
						return false;
					}
				}
				return false;
			}elseif($type == 'session'){
				//Validating if the user is login
				$user_name = Session::getSession('user');

				if ($user_name != "") {
					$roles = Session::getSession('role');
					$length = count($roles);
					if ($length >1){
						if (in_array($role, $roles)) {
							return true;
							
						}
					}elseif ($roles == $role) {
						return true;
					}
				}
				return false;
			}
			
		}

	}

?>