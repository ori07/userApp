<?php
  //Define a few globally available configuration things
  //Auto-load our files
  //Route our app to the appropriate Controller
  namespace wwwProject\userApp\public\app;
  define('BASE', __DIR__);
  define('BASE_URI', 'http://MyApp.co');
  define('ASSETS_URI', 'http://MyApp.co');
  echo BASE;

  //load all our classes as we instantiate them following the guidance of the name spaces.
  spl_autoload_register(function($class) {
      require_once __DIR__ . str_replace(['wwwProject\\userApp\\public\\app', '\\'], ['', '/'], $class) . '.php';
  });
  
  // include the composer autoloader
  //require 'vendor/autoload.php';

  $req = $_SERVER['REQUEST_URI'];
  $qs = $_SERVER['QUERY_STRING'];

  // include the composer autoloader
  require 'vendor/autoload.php';

  $req = $_SERVER['REQUEST_URI'];
  $qs = $_SERVER['QUERY_STRING'];
  
  // this is our pseudo-router ... we don't have a set of classes that interpret requests so we just rely on the plain old super globals

  if(!empty($qs)) {
      $req = substr($req, 0, strpos($req, '?')); // this is to be expanded by you guys...
  }

  switch ($req) {
      case ('/'):
          $buff = new Controllers\HomeController([ 
              BASE . '/Views/pages/login.php'
          ]);
          break;
      case ('/page_1'):
          $buff = new Controllers\PagesController([ 
              BASE . '/Views/users/page_1.php'
          ]);
          break;
      case ('/page_2'):
          $buff = new Controllers\PagesController([ 
              BASE . '/Views/users/page_2.php'
          ]);
          break;
      case ('/page_3'):
          $buff = new Controllers\PagesController([ 
              BASE . '/Views/users/page_3.php'
          ]);
          break;
      default:
          $buff = new Controllers\DefaultController([ 
              BASE . '/Views/pages/login.php'
          ]);
          break;
  }

  echo $buff->out(); 

  /*function call($controller, $action) {
    // require the file that matches the controller name
    require_once('Controllers/' . $controller . '_controller.php');

    // create a new instance of the needed controller
    switch($controller) {
      case 'pages':
        $controller = new PagesController();
      break;
      case 'users':
        // we need the model to query the database later in the controller
        require_once('models/user.php');
        $controller = new UsersController();
      break;

    }

    // call the action
    $controller->{ $action }();
  }

  // just a list of the controllers we have and their actions
  // we consider those "allowed" values
  $controllers = array('pages' => ['login', 'error'],
                       'users' => ['index', 'show']);

  // check that the requested controller and action are both allowed
  // if someone tries to access something else he will be redirected to the error action of the pages controller
  if (array_key_exists($controller, $controllers)) {
    if (in_array($action, $controllers[$controller])) {
      call($controller, $action);
    } else {
      call('pages', 'error');
    }
  } else {
    call('pages', 'error');
  }*/
?>