<?php
	/**
	* 
	*/
	class View {
		
		function __construct(){
			//echo "Soy la clase controladora de las vistas ";
		}

		function render($controller, $view){
			$controller = get_class($controller);

			require VIEWS.DFT."head.php";
			require VIEWS.$controller.'/'.$view.'.php';
			require VIEWS.DFT."footer.php";

		}
	}
?>