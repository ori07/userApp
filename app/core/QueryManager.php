<?php
	/**
	 * 
	 */
	 class QueryManager{

	 	private $link;

	 	function __construct($HOST, $USER, $PASS, $NAME){
	 		$this->link = new mysqli($HOST, $USER, $PASS, $NAME);
	 		//$this->link = new PDO('mysql:host=$HOST;dbname=$NAME;charset=utf8mb4', $USER, $PASS);
	 		if (mysqli_connect_errno()) {
	 			printf("Connect failed: %s\n", mysqli_connect_errno());
	 			exit();
	 		}
	 	}

	 	function selectConditional($attr, $table, $where){
	 		$query = "SELECT ".$attr." FROM ".$table." WHERE ".$where.";";
	 		$result = $this->link->query($query);
	 		if ($result->num_rows > 0) {
	 			while ($row = $result->fetch_assoc()) {
	 				$response[] = $row;
	 			}
	 			return $response;
	 		}
	 	}

	 	function insert($table, $columns){
	 		$cols = null;
	 		$values = null;
	 		//creating the Into closure
	 		foreach ($columns as $key => $value) {
	 			$cols.= $key.',';
	 			$values.= '"'.$value.'",';
	 		}
	 		//Deleting the last character
	 		$cols = substr($cols, 0, -1);
	 		$values = substr($values, 0,-1);

	 		//Creating the insert statement
	 		$stmt = "INSERT INTO ".$table." (".$cols.") VALUES (".$values.");";
	 		$result = $this->link->query($stmt) or die($this->link->error); 
	 	}
	 }

	 function selectAll($table){
	 	$query = "SELECT * FROM ".$table.";";
	 	$result = $this->link->query($query);
 		if ($result->num_rows > 0) {
 			while ($row = $result->fetch_assoc()) {
 				$response[] = $row;
 			}
 			return $response;
 		}

	 }

	 function update($table, $columns, $where){
 		$values = "";
 		//creating the Into closure
 		foreach ($columns as $key => $value) {
 			$values.= $key.'="'.$value.'",';
 		}
 		//Deleting the last character
 		$values = substr($values, 0,-1);

 		//Creating the update statement
 		$stmt = "UPDATE ".$table." SET".$values." WHERE ".$where.";";
 		$result = $this->link->query($stmt) or die($this->link->error); 
 		return true;

	 } 

	 function delete($table, $where){
	 	//Creating the delete statement
 		$stmt = "DELETE FROM ".$table." WHERE ".$where.";";
 		return true;
	 }
?>
