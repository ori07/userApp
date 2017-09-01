<?php
declare(strict_types = 1); 

require '../app/init.php';

function parseURL(){
	$controller = "";
	$method = "";
	$method_url = $_SERVER['REQUEST_METHOD'];
	$url_init ="";
	$params = false;

	if ($_SERVER['REQUEST_URI'] != DIRECTORY_SEPARATOR) {
		//Some url like /userApp/public/controller/method
		$url_init = $_SERVER['REQUEST_URI'];
		//to get an array like [userApp, public, controller, method]
		$url_init = explode("/", $url_init);
		$pos = array_search('public', $url_init);
		//Search if the call is from the root 
		//Means array like: [controller, method]
		if ($pos === false) {
			$controller = $url_init[1];
			//Verify if url has params attached 
			$pos_param = verifyParams($url_init[2]);
			if ($pos_param === false) {
				//Methods without params
				$method = $url_init[2];
			}else{
				//Array like [Controller, method?param=value]
				$method = substr($url_init[2], $pos_param);
			}
		}else{
			//Means array like: [some/other/public/controller, method] or [some/other/public]
			if (count($url_init)==3) {
				$controller = "Index";
				$method = "index";
			}else{
				//verify if there is a method for controller
				if (count($url_init)>4) {
					$controller = $url_init[$pos+1];
					//Verify if url has params attached 
					$pos_param = verifyParams($url_init[$pos+2]);
					if ($pos_param === false) {
						//Methods without params
						$method = $url_init[$pos+2];
					}else{
						//Array like [Controller, method?param=value]
						$method = substr($url_init[$pos+2], 0, $pos_param);
					}

				}else{
					$pos_param = verifyParams($url_init[$pos+1]);
					if ($pos_param === false) {
						//Controller without params
						$controller = $url_init[$pos+1];
					}else{
						//Array like [Controller?param=value]
						$controller = substr($url_init[$pos+1], 0, $pos_param);
					}

				}
			}
			
		}
	}else{
		$controller = "Index";
		$method = "index";
	}
	$params = array('controller' => $controller, 'method' => $method, 'method_url' => $method_url);
	return $params;
}

function verifyParams($url){
	$pos = strpos($url, '?');
	if ($pos === false) {
		return false;
	}else{
		return $pos;
	}
}

$url_params = parseURL();
$control_name = $url_params['controller'];
$method_name = $url_params['method'];
$controller_path = '../app/controllers/'.$control_name.'.php';
$method_url = $url_params['method_url'];

if ($control_name != 'User') {
	createControllers($controller_path, $control_name, $method_name);
}else{
	processApi($controller_path, $control_name, $method_name, $method_url);
}

function createControllers($controller_path, $control_name, $method_name){
	if (file_exists($controller_path)) {
		require $controller_path;
		//controller selected
		$controller = new $control_name;
		if (isset($method_name)) {
			if (method_exists($controller, $method_name)) {
				$controller->{$method_name}();
			}else{
				$url_temp = parseURL();
				header("HTTP/1.1 404 Not Found");
				$user_name = Session::getSession('user');
				if ($user_name !== "") {
					$last_page = Session::getSession('lastPage');
					header("Location:".URL.$last_page);
					echo $url_temp;
				}else{
					$login = substr(URL, 0, -1);
					header("Location:".$login);
				}
				
			}
		}

	}else{
		$user_name = Session::getSession('user');
		if ($user_name == "") {
			$login = substr(URL, 0, -1);
			header("Location:".$login);
			echo 'alert("You must login, please")';
		}
	}

}

function processApi($controller_path, $control_name, $method_name, $method_url){
	require $controller_path;
	$controller = new $control_name;
	switch ($method_url) {
		case 'GET':
				if ($method_name != "") {
					$id = (int)$method_name;
					$controller->getUser($id);
				}else{
					$controller->users($method_name);
				}
				
			break;
		case 'POST':
			if ($method_name != "") {
				//UserLogin
				if (method_exists($controller, $method_name)) {
					$controller->{$method_name}();
				}else{
					//Create User
					$controller->create();
				}
			}
			break;
		default:
			# code...
			break;
	}
	
	//controller selected
	
	
	

}





//print($controller_path)
//$app = new App;

//require __DIR__ . '/../src/Bootstrap.php';
/*  require_once('connection.php');


  if (isset($_GET['controller']) && isset($_GET['action'])) {
    $controller = $_GET['controller'];
    $action     = $_GET['action'];
  } else {
    $controller = 'pages';
    $action     = 'login';
  }

  require_once('views/layout.php');
*/
?>