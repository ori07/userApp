<?php 
	$role = Session::getSession('role');
	foreach ($role as $value) {
		if ($value == "PAGE_1") {
			echo "<a href=".URL."Page_1/page_1>Page 1</a> <br>";
		}elseif ($value == "PAGE_2") {
			echo "<a href=".URL."Page_2/page_2>Page 2</a><br>";
		}elseif ($value == "PAGE_3") {
			echo "<a href=".URL."Page_3/page_3>Page 3</a><br>";
		}elseif ($value == "ADMIN") {
			echo "<a href=".URL."Page/page>ADMIN</a><br>";
		}
	}
	
?>