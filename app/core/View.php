<?php
	/**
	* 
	*/
	class View {
		
		function __construct(){
			//echo "Main view controller";
		}

		function render($controller, $view){
			if (is_object($controller)) {
				$controller = get_class($controller);
			}

			require VIEWS.DFT."head.php";
			require VIEWS.$controller.'/'.$view.'.php';
			require VIEWS.DFT."footer.php";

		}
	}
?>