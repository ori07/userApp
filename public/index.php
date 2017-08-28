<?php
declare(strict_types = 1); 

require '../app/init.php';

//Default url
$url_init ="";
//if for dev
if ($_SERVER['REQUEST_URI'] != '/userApp/public') {
//if for deploy
//if ($_SERVER['REQUEST_URI'] != DIRECTORY_SEPARATOR) {
	$url_init = $_SERVER['REQUEST_URI'];
}else{
	$url_init = "Index/index";
}
//$url_init = isset($_GET["url"]) ?$_GET['url']: 
$url_init = explode("/", $url_init);

//controller and method selected by GET method
//controller and method selected by GET method
$length = count($url_init);
$controller = $url_init[$length-2];
$method = $url_init[$length-1];

$control_name = $controller;
$method_name = $method;
$controller_path = '../app/controllers/'.$controller.'.php';

if (file_exists($controller_path)) {
	require $controller_path;
	//controller selected
	$controller = new $controller;

	if (isset($method)) {
		if (method_exists($controller, $method)) {
			$controller->{$method}();
		}else{
			header("HTTP/1.1 404 Not Found");
			$user_name = Session::getSession('user');
			if ($user_name !== "") {
				$last_page = Session::getSession('lastPage');
				header("Location:".URL.$last_page);
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