<?php
	require_once 'PHPUnit/Autoload.php';
	require '../../app/core/QueryManager.php';
	
	/**
	* 
	*/
	class QueryManagerTest extends PHPUnit_Framework_TestCase{
		//use TestCaseTrait;
		/**
     	* only instantiate PHPUnit_Extensions_Database_DB_IDatabaseConnection once per test
     	* @var type 
     	*/
		private $connection = null;
		
		function __construct(){
			# code...
		}

		function setUp(){
			$this->data_arrayU['user_name'] = "user_1";
			$this->data_arrayU['password'] = "pass_user1";
			$this->table_user = 'user';
			$this->table_role = 'role';
			$this->data_arrayR['role'] = ["role_1", "role_2"];
			$this->data_arrayR['user_id'] = ["1", "1"];
		}

		function testMySqlDBConnection(){
			$queryMng = new QueryManager($GLOBALS['HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
			$this->assertEquals(0, (int)(mysqli_connect_errno()));
			$queryMng = null;
		}

		function getMySqlConnection(){
			if ($this->connection == null) {
				$this->connection = new QueryManager($GLOBALS['HOST'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'], $GLOBALS['DB_DBNAME']);
				return $this->connection;
			}else{
				return null;
			}
		}

		function testInsertTableUser(){
			$this->connection = $this->getMySqlConnection();
			$this->setUp();
			$result = $this->connection->insert($this->table_user, $this->data_arrayU);
			$this->connection->clearDataBase();
			$this->assertTrue($result);

		}

		function testInsertTableRole(){
			$connection = $this->getMySqlConnection();
			$this->setUp();
			$result = $this->connection->insert($this->table_user, $this->data_arrayU);
			$result = $this->connection->insert($this->table_role, $this->data_arrayR);
			$this->connection->clearDataBase();
			$this->assertTrue($result);

		}

		function testUpdateTableUser(){
			$this->connection = $this->getMySqlConnection();
			$this->setUp();
			$result = $this->connection->insert($this->table_user, $this->data_arrayU);	
			$update_array['user_name'] = 'user_new';
			$last_id = 1;
			$where = "_id='".$last_id."'";
			$result = $this->connection->update($this->table_user, $update_array, $where);
			$this->connection->clearDataBase();
			$this->assertTrue($result);
			

		}

		function testUpdateTableRole(){
			$this->connection = $this->getMySqlConnection();
			$this->setUp();
			$result = $this->connection->insert($this->table_user, $this->data_arrayU);
			$result = $this->connection->insert($this->table_role, $this->data_arrayR);	
			$update_array['role'] = 'new_role';
			$last_id = 1;
			$where = "_id='".$last_id."'";
			$result = $this->connection->update($this->table_role, $update_array, $where);
			$this->assertTrue($result);
			$this->connection->clearDataBase();
		}

		function testDeleteTableUser(){
			$this->connection = $this->getMySqlConnection();
			$this->setUp();
			$result = $this->connection->insert($this->table_user, $this->data_arrayU);
			$result = $this->connection->insert($this->table_role, $this->data_arrayR);	
			$last_id = 1;
			$where = "_id='".$last_id."'";
			$result = $this->connection->delete($this->table_user, $where);
			$this->connection->clearDataBase();
			$this->assertTrue($result);
		}

		function testDeleteTableRole(){
			$this->connection = $this->getMySqlConnection();
			$this->setUp();
			$result = $this->connection->insert($this->table_user, $this->data_arrayU);
			$result = $this->connection->insert($this->table_role, $this->data_arrayR);	
			$last_id = 1;
			$where = "_id='".$last_id."'";
			$result = $this->connection->delete($this->table_user, $where);
			$this->connection->clearDataBase();
			$this->assertTrue($result);
		}
		
	}

?>