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
	 } 
?>
