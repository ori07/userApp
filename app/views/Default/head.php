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
  	if (!isset($_SESSION['user'])){

  	}else{
      $user_name = $_SESSION['user'];
  		$now = time(); // Checking the time now when home page starts.
  		$expire = Session::getSession('expire');
  		if ($now > $expire) {
  			Session::destroy();
  			echo "Your session has expired! <a href=".$login.">Login here</a>";
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
