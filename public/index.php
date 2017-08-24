<?php
declare(strict_types = 1); 

require_once '../app/init.php';

//Default url
$url_init = isset($_GET["url"]) ?$_GET['url']:"Index/index"; 
$url_init = explode("/", $url_init);

//Default controller
$controller = "";
$method ="";

//Getting parameters from url
if (isset($url_init[0])) {
	$controller = $url_init[0];
}
if (isset($url_init[1])) {
	if ($url_init[1] != '') {
		$method = $url_init[1];
	}	
}

$controller_path = '../app/controllers/'.$controller.'.php';

if (file_exists($controller_path)) {
	require_once $controller_path;
	//controller for index page
	$controller = new $controller;

	if (isset($method)) {
		if (method_exists($controller, $method)) {
			$controller->{$method}();
		}else{
			echo "Method doesn't exist";
		}
	}

}else{
	echo "Wrong address, the controller doesn't exist";
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