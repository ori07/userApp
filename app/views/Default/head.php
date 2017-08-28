<DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Example web App with PHP</title>
    <!-- Deployment uris-->
    
    <script src="<?php echo URL2.VIEWS_2.DFT;?>Js/jquery-3.2.1.js" type="text/javascript"></script>
    <script src="<?php echo URL2.VIEWS_2.DFT;?>Js/jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo URL2.VIEWS_2.DFT;?>Js/validateFunctions.js" type="text/javascript"></script>
    
  </head>
  <body>
  <?php 
  	error_reporting(E_ALL ^ E_NOTICE);
  	Session::start();
  	$login = substr(URL, 0, -1);
  	$user_name = Session::getSession('user');
  	if ($user_name =="") {
  		if ($_SERVER['REQUEST_URI'] != '/userApp/public') {
  			echo "Please Login again";
  			echo "<a href=".$login.">Click Here to Login</a>";
  		}
  		
  	}else{
  		$now = time(); // Checking the time now when home page starts.
  		$expire = Session::getSession('expire');
  		if ($now > $expire) {
  			session_destroy();
  			echo "Your session has expired! <a href=".$login."'>Login here</a>";
  		}else{
  			?>
  			<nav>
  				<a href="<?php echo URL;?>User/destroySession">Logout</a> 
  			</nav>
  			<h2><?php echo "Hello ".$user_name;?></h2>

 <?php
  		}

  	}

  ?>
