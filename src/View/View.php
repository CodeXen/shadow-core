<?php 

namespace Shadow\View;

use Shadow\View\Raze;

class View 
{
	protected static $_outputBuffer, $_layout, $_yields;

	public function render($viewName, $data = array()) {
		// $viewArray = explode('/', $viewName); // Fix for windows
		// $viewString = implode(DS, $viewArray);
		
		if(file_exists('../application/Views/'. $viewName . '.raze.php')) {
			$raze = new Raze;

			$raze->template($viewName, $data);

			if(self::$_layout) {
				$raze->template(self::$_layout);
			}
			
		} else {
			die('The view \"' . $viewName .'\" does not exist.');
		}
	}
	
	public function content($type) {
		return isset(self::$_yields[$type]) ? self::$_yields[$type] : false;
	}

	public function start($type) {
		self::$_outputBuffer = $type;
		
		ob_start();
	}
	
	public function end() {
		self::$_yields[self::$_outputBuffer] = ob_get_clean();
	}

	public function setLayout($path) {
		self::$_layout = $path;
	}
}