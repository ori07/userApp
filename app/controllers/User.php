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
						if (in_array('ADMIN', $role)) { 
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
			if (isset($_POST['user_name']) && isset($_POST['password'])){
				$array['user_name'] = $_POST['user_name'];
				$array['password'] = $_POST['password'];
				$result = $this->model->registerUser($array);
				var_dump($result);
				if ($result) {
					$response_array['status']='success';
					$response_array['message']='register successfully.';
					$lastId = $this->model->getLastInserted();
					$user_data = $this->model->userLogin("*", "_id = "."'".$lastId."'");
					$response_array['data']=$user_data;
					//render view
					$this->rest->response($response_array, 200);
					
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
				$this->rest->response($response_array,400);
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

		function delete(){
			// Cross validation if the request method is DELETE else it will return "Not Acceptable" status
			if($this->rest->get_request_method() != "DELETE"){
				$this->rest->response('',406);
			}
			if (isset($_POST['_id'])){
				$where = "_id='".$_POST['_id']."'";
				$result = $this->model->deleteUser($where);
				if($result) {
					$response_array['status']='success';
					$response_array['message']='One record deleted.';
					$response_array['data']=$delete;
					$this->rest->response($this->rest->json($response_array), 200);
				} else {
					$response_array['status']='fail';
					$response_array['message']='no record deleted';
					$response_array['data']='';
					$this->rest->response($this->rest->json($response_array), 200);
				}

			}else{
				$this->rest->response('',204);	// If no records "No Content" status
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

			//Validating if the user is login
			$user_name = Session::getSession('user');

			if ($user_name != "") {
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1){
					if (in_array('ADMIN', $role)) {
						$this->renderAllUsers();
						
					}
				}elseif ($role == "ADMIN") {
					$this->renderAllUsers();
				}
					
			}else{
				//Redirect to the last location
				$last_page = Session::getSession('lastPage');
				header("Location:".URL.$last_page);
			}

		}

		protected function renderAllUsers(){
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

		}

		function getUser($id){
			// Cross validation if the request method is GET else it will return "Not Acceptable" status
			if($this->rest->getRequestMethod() != "GET"){
				$this->rest->response('',406);
			}

			//Validating if the user is login
			$user_name = Session::getSession('user');

			if ($user_name != "") {
				$role = Session::getSession('role');
				$length = count($role);
				if ($length >1){
					if (in_array('ADMIN', $role)) {
						$this->renderUser($id);
						
					}
				}elseif ($role == "ADMIN") {
					$this->renderUser($id);
				}
					
			}else{
				//Redirect to the last location
				$last_page = Session::getSession('lastPage');
				header("Location:".URL.$last_page);
			}

		}

		protected function renderUser($id){
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

		}

	}

?>