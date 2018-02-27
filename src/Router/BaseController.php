<?php 

namespace Shadow\Router;

use Shadow\Core\Application;
use Shadow\Support\Execute;

class BaseController extends Application
{
	use Execute;
	
	public function view($view, $data = []) {
		return $this->app('View')->make($view, $data);
	}

	public function validate($input, $rules = []) {
		return $this->app('Validate')->check($input, $rules);
	}
}