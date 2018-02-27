<?php 

namespace Shadow\View;

use Dwoo\Core as Dwoo;
use Shadow\Validation\Validate;

class View 
{
	public function __construct($errors = null) {

	}

	public function make($view, $data = []) {
		$views_dir = '../application/Views/';
		if($data) extract($data);
		require_once $views_dir . $view .'.php';
	}
}