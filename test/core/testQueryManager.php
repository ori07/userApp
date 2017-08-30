<?php
	require_once 'PHPUnit/Autoload.php';
	require_once '../../app/core/QueryManager.php';
	
	/**
	* 
	*/
	class QueryManagerTest extends PHPUnit_Framework_TestCase{
		//use TestCaseTrait;
		
		function __construct(){
			# code...
		}

		function testMySqlDBConnection(){
			$host = "localhost";
			$user = "test_user";
			$pass = "test123";
			$name = "test_db";

			$queryMng = new QueryManager($host, $user,$pass,$name);
			$this->assertEquals(0, (int)(mysqli_connect_errno()));
		}

		function testInsertTableUser(){

		}

		function testInsertTableRole(){

		}
	}

?>